<?php

namespace App\Services\Sanad;

use App\Models\CRM\CrmUser;
use App\Models\CRM\WhatsappBusinessHoursSetting;
use App\Services\MainService;

class WhatsappBusinessHoursService extends MainService
{
    /** @var array<int, string> */
    protected array $days = ['sat', 'sun', 'mon', 'tue', 'wed', 'thu', 'fri'];

    public function __construct(protected WhatsappBusinessHoursSetting $setting)
    {
        $this->model = $setting;
        $this->fileFolder = null;
        $this->files = [];
    }

    public function getForUser(CrmUser $user): WhatsappBusinessHoursSetting
    {
        $settings = $this->setting->query()->firstOrCreate(
            ['crm_user_id' => $user->id],
            [
                'timezone' => config('app.timezone'),
                'business_hours_enabled' => false,
                'hours' => $this->defaultHours(),
                'away_message_enabled' => false,
                'away_message' => null,
            ]
        );

        if (empty($settings->hours)) {
            $settings->hours = $this->defaultHours();
        }

        return $settings;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function updateForUser(CrmUser $user, array $data): WhatsappBusinessHoursSetting
    {
        $settings = $this->setting->query()->firstOrCreate(
            ['crm_user_id' => $user->id],
            ['hours' => $this->defaultHours()]
        );

        $settings->timezone = $this->normalizeString($data['timezone'] ?? null);
        $settings->business_hours_enabled = (bool) ($data['business_hours_enabled'] ?? false);
        $settings->away_message_enabled = (bool) ($data['away_message_enabled'] ?? false);
        $settings->away_message = $this->normalizeString($data['away_message'] ?? null);
        $settings->hours = $this->normalizeHours(is_array($data['hours'] ?? null) ? $data['hours'] : []);
        $settings->save();

        return $settings;
    }

    /**
     * @return array<string, array{enabled: bool, from: string, to: string}>
     */
    public function defaultHours(): array
    {
        $hours = [];

        foreach ($this->days as $day) {
            $hours[$day] = [
                'enabled' => false,
                'from' => '09:00',
                'to' => '17:00',
            ];
        }

        return $hours;
    }

    /**
     * @param  array<string, mixed>  $hours
     * @return array<string, array{enabled: bool, from: string, to: string}>
     */
    protected function normalizeHours(array $hours): array
    {
        $normalized = [];

        foreach ($this->days as $day) {
            $row = is_array($hours[$day] ?? null) ? $hours[$day] : [];
            $from = $this->normalizeString($row['from'] ?? null) ?: '09:00';
            $to = $this->normalizeString($row['to'] ?? null) ?: '17:00';

            $normalized[$day] = [
                'enabled' => (bool) ($row['enabled'] ?? false),
                'from' => $from,
                'to' => $to,
            ];
        }

        return $normalized;
    }

    protected function normalizeString(mixed $value): ?string
    {
        $normalized = trim((string) $value);

        return $normalized === '' ? null : $normalized;
    }
}
