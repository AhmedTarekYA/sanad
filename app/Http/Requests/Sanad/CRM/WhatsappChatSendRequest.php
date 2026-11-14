<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WhatsappChatSendRequest extends MainRequest
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
            'message' => ['required', 'string', 'max:4096'],
            'reply_to_wamid' => ['nullable', 'string', 'max:255'],
        ];
    }
}
