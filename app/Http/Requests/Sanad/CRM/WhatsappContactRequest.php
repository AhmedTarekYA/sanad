<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WhatsappContactRequest extends MainRequest
{
    /** @return array<string, array<int, mixed>|string> */
    public function rules(): array
    {
        $userId = Auth::guard('crm')->id();
        $id = $this->route('id');

        return [
            'wa_id' => [
                'required',
                'string',
                'max:30',
                Rule::unique('whatsapp_contacts', 'wa_id')
                    ->where(fn ($query) => $query->where('crm_user_id', $userId))
                    ->ignore($id),
            ],
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'source' => ['nullable', 'string', 'max:60'],
            'note' => ['nullable', 'string', 'max:5000'],
            'profile_pic' => ['nullable', 'string', 'max:2048'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer'],
            'custom_fields' => ['nullable', 'array'],
        ];
    }
}
