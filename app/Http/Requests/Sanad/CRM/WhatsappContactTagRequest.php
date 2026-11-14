<?php

namespace App\Http\Requests\Sanad\CRM;

use App\Http\Requests\MainRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WhatsappContactTagRequest extends MainRequest
{
    /** @return array<string, array<int, mixed>|string> */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('whatsapp_contact_tags', 'name')
                    ->where(fn ($query) => $query->where('crm_user_id', Auth::guard('crm')->id()))
                    ->ignore($this->route('id')),
            ],
            'color' => ['nullable', 'string', 'max:30'],
        ];
    }
}
