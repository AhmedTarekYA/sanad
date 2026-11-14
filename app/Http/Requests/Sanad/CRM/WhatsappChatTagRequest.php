<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;

class WhatsappChatTagRequest extends MainRequest
{
    /** @return array<string, array<int, mixed>|string> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:80'],
            'color' => ['nullable', 'string', 'max:30'],
        ];
    }
}
