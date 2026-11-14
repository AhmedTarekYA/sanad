<?php

namespace App\Services\CRM;

use App\Models\CRM\CrmSale;
use App\Services\MainService;
use Illuminate\Database\Eloquent\Collection;

class CrmSaleService extends MainService
{
    public function __construct(CrmSale $model)
    {
        $this->model = $model;
    }

    public function listSales(?int $crmUserId = null): Collection
    {
        return $this->model->query()
            ->with('crmUser:id,name')
            ->when($crmUserId, fn ($query) => $query->where('crm_user_id', $crmUserId))
            ->latest()
            ->get();
    }

    public function storeForUser(int $crmUserId, array $data): CrmSale
    {
        $data = $this->normalize($data);
        $data['crm_user_id'] = $crmUserId;

        return $this->model->create($data);
    }

    public function updateForUser(int $id, array $data): CrmSale
    {
        $sale = $this->find($id);
        abort_if($sale === null, 404);

        $data = $this->normalize($data);
        unset($data['crm_user_id']);

        $sale->update($data);

        return $sale->refresh()->load('crmUser:id,name');
    }

    /** @param array<string, mixed> $data */
    protected function normalize(array $data): array
    {
        $data = $this->clearRequest($data);

        foreach (['customer_name', 'phone', 'request_text', 'price'] as $key) {
            $data[$key] = $data[$key] ?? null;
        }

        return $data;
    }
}
