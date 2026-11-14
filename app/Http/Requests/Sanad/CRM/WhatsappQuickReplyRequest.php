<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;

class WhatsappQuickReplyRequest extends MainRequest
{
    /** @return array<string, array<int, mixed>|string> */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:160'],
            'shortcut' => ['nullable', 'string', 'max:60'],
            'body' => ['required', 'string', 'max:10000'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
