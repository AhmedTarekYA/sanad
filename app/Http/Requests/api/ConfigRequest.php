<?php

namespace App\Http\Requests\api;

use App\Http\Requests\MainRequest;
use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends MainRequest
{
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->store(),
            'PUT', 'PATCH' => $this->update(),
            'DELETE' => $this->destroy(),
            default => $this->view()
        };

    }
    public function view(): array
    {
        return [
            'name' => 'required|string',
        ];
    }
}
