<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WhatsappLabelRequest extends MainRequest
{
    /** @return array<string, array<int, mixed>|string> */
    public function rules(): array
    {
        $userId = Auth::guard('crm')->id();
        $id = $this->route('id');

        $table = $this->input('scope') === 'chat'
            ? 'whatsapp_chat_tags'
            : 'whatsapp_contact_tags';

        return [
            'scope' => ['required', 'string', 'in:contact,chat'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, 'name')
                    ->where(fn ($query) => $query->where('crm_user_id', $userId))
                    ->ignore($id),
            ],
            'color' => ['nullable', 'string', 'max:30'],
        ];
    }
}
