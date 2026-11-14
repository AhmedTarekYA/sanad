<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WhatsappChatMediaRequest extends MainRequest
{
    /** @return array<string, array<int, mixed>|string> */
    public function rules(): array
    {
        $userId = Auth::guard('crm')->id();

        return [
            'account_id' => [
                'nullable',
                'integer',
                Rule::exists('whatsapp_business_settings', 'id')
                    ->where(fn ($query) => $query->where('crm_user_id', $userId)),
            ],
            'to' => ['required', 'string', 'max:25'],
            'file' => ['required', 'file', 'max:51200'],
            'caption' => ['nullable', 'string', 'max:1024'],
            'force_type' => ['nullable', 'string', 'in:document,image,video,audio'],
            'reply_to_wamid' => ['nullable', 'string', 'max:255'],
        ];
    }
}
