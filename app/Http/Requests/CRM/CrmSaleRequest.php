<?php

namespace App\Http\Requests\CRM;

use App\Http\Requests\MainRequest;

class CrmSaleRequest extends MainRequest
{
    public function rules(): array
    {
        return [
            'customer_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'request_text' => ['nullable', 'string', 'max:5000'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
