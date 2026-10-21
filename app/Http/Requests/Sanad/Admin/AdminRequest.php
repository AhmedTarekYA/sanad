<?php

namespace App\Http\Requests\Sanad\Admin;

use App\Http\Requests\MainRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT', 'PATCH' => $this->update(),
            'DELETE' => $this->destroy(),
            default => $this->view()
        };

    }

    protected function store(): array
    {
        return [
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email', 'unique:admins'],
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:6',
            'image' => ['nullable', 'image'],
            'department_id' => 'nullable',
            'employee_id' => 'nullable',
        ];
    }

    protected function update(): array
    {
        return [
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['required', Rule::unique('admins')->ignore($this->admin)],
            'password' => 'nullable|min:6',
            'role_id' => 'required|exists:roles,id',
            'image' => ['nullable', 'image'],
        ];
    }

    protected function destroy(): array
    {
        return [];
    }

    protected function view(): array
    {
        return [];
    }
}
