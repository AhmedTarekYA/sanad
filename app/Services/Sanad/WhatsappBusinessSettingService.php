<?php

namespace App\Services\Sanad;

use App\Models\CRM\CrmUser;
use App\Models\CRM\WhatsappBusinessSetting;
use App\Services\MainService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class WhatsappBusinessSettingService extends MainService
{
    public function __construct(WhatsappBusinessSetting $model)
    {
        $this->model = $model;
        $this->fileFolder = null;
        $this->files = [];
    }

    public function allForUser(CrmUser $user): Collection
    {
        return $this->model->query()
            ->where('crm_user_id', $user->id)
            ->orderByDesc('is_active')
            ->orderBy('id')
            ->get();
    }

    public function getPrimaryForUser(CrmUser $user): ?WhatsappBusinessSetting
    {
        return $this->model->query()
            ->where('crm_user_id', $user->id)
            ->orderByDesc('is_active')
            ->orderBy('id')
            ->first();
    }

    /**
     * Replace the given CRM user's WhatsApp accounts with the submitted set.
     * Only rows owned by the user are ever touched.
     *
     * @param  array<int, mixed>  $accounts
     */
    public function syncAccountsForUser(CrmUser $user, array $accounts): Collection
    {
        $normalizedAccounts = collect($accounts)
            ->map(fn ($account) => $this->normalizeAccountPayload((array) $account))
            ->filter(fn (array $account) => ! $this->isEmptyAccountPayload($account))
            ->values();

        return DB::transaction(function () use ($user, $normalizedAccounts) {
            $existingIds = $this->model->query()
                ->where('crm_user_id', $user->id)
                ->pluck('id')
                ->all();

            $retainedIds = [];

            foreach ($normalizedAccounts as $account) {
                $accountId = $account['id'] ?? null;
                unset($account['id']);
                $account['crm_user_id'] = $user->id;

                if ($accountId && in_array((int) $accountId, array_map('intval', $existingIds), true)) {
                    $setting = $this->model->query()
                        ->where('crm_user_id', $user->id)
                        ->find($accountId);

                    if ($setting) {
                        $setting->fill($account);
                        $setting->save();
                    } else {
                        $setting = $this->model->query()->create($account);
                    }
                } else {
                    $setting = $this->model->query()->create($account);
                }

                $retainedIds[] = $setting->id;
            }

            $deleteIds = array_values(array_diff($existingIds, $retainedIds));
            if (! empty($deleteIds)) {
                $this->model->query()
                    ->where('crm_user_id', $user->id)
                    ->whereIn('id', $deleteIds)
                    ->delete();
            }

            return $this->allForUser($user);
        });
    }

    public function updateAccountForUser(CrmUser $user, WhatsappBusinessSetting $setting, array $account): WhatsappBusinessSetting
    {
        $normalized = $this->normalizeAccountPayload(array_merge(['id' => $setting->getKey()], $account));
        unset($normalized['id']);
        $normalized['crm_user_id'] = $user->id;

        $setting->fill($normalized);
        $setting->save();

        return $setting;
    }

    public function deleteForUser(CrmUser $user, int $id): bool
    {
        $setting = $this->model->query()
            ->where('crm_user_id', $user->id)
            ->find($id);

        if (! $setting) {
            return false;
        }

        return (bool) $setting->delete();
    }

    /**
     * @param  array<string, mixed>  $account
     * @return array<string, mixed>
     */
    protected function normalizeAccountPayload(array $account): array
    {
        $accountId = isset($account['id']) && $account['id'] !== '' ? (int) $account['id'] : null;

        $payload = [
            'id' => $accountId,
            'name' => $this->normalizeString($account['name'] ?? null),
            'is_active' => filter_var($account['is_active'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'api_version' => $this->normalizeString($account['api_version'] ?? null) ?: 'v20.0',
            'phone_number_id' => $this->normalizeString($account['phone_number_id'] ?? null),
            'business_account_id' => $this->normalizeString($account['business_account_id'] ?? null),
            'access_token' => $this->normalizeString($account['access_token'] ?? null),
            'webhook_verify_token' => $this->normalizeString($account['webhook_verify_token'] ?? null),
            'app_secret' => $this->normalizeString($account['app_secret'] ?? null),
        ];

        if ($accountId) {
            foreach (['access_token', 'webhook_verify_token', 'app_secret'] as $secretField) {
                if ($payload[$secretField] === null) {
                    unset($payload[$secretField]);
                }
            }
        }

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $account
     */
    protected function isEmptyAccountPayload(array $account): bool
    {
        foreach ([
            'name',
            'phone_number_id',
            'business_account_id',
            'access_token',
            'webhook_verify_token',
            'app_secret',
        ] as $field) {
            if (($account[$field] ?? null) !== null) {
                return false;
            }
        }

        return true;
    }

    protected function normalizeString(mixed $value): ?string
    {
        if ($value === null || ! is_scalar($value)) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
