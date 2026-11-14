<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class WhatsappBroadcastRequest extends MainRequest
{
    /** @return array<string, array<int, mixed>|string> */
    public function rules(): array
    {
        $userId = auth('crm')->id();

        return [
            'account_id' => [
                'nullable',
                'integer',
                Rule::exists('whatsapp_business_settings', 'id')->where('crm_user_id', $userId),
            ],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:immediate,scheduled,template'],
            'message_body' => ['required_unless:type,template', 'nullable', 'string', 'max:5000'],
            'template_name' => ['required_if:type,template', 'nullable', 'string', 'max:512'],
            'template_language' => ['nullable', 'string', 'max:10'],
            'scheduled_at' => ['required_if:type,scheduled', 'nullable', 'date', 'after:now'],
            'button_quick_reply_ids' => ['nullable', 'array'],
            'button_quick_reply_ids.*' => ['integer'],
        ];
    }
}
