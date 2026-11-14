<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;

class WhatsappContactImportRequest extends MainRequest
{
    /** @return array<string, array<int, mixed>|string> */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:5120'],
        ];
    }
}
