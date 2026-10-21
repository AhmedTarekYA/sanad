<?php

namespace App\Http\Requests\Nami\Authentication;

use App\Http\Requests\MainRequest;
use App\Rules\MatchOldPassword;


class CahngePasswordRequest extends MainRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => ['required'],
            'new_password' => ['required','min:8'],
            'new_confirm_password' => ['same:new_password'],
        ];
    }

    public function messages()
    {
        return [
            'new_password.min' => __('auth.Password must be at least 8 characters'),
            'current_password.required' => __('auth.Current Password is required'),
            'new_password.required' => __('auth.New Password is required'),
            'new_confirm_password.same' => __('auth.New Password and Confirm Password must be same'),
        ];
    }
}
