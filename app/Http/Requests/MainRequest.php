<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class MainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $prefix = $this->route()->getPrefix(); // Get the prefix from the route
        if ( strpos($prefix, 'api')  !== false) {
            $response = jsonApiValid($validator->errors());
        }else{
            $response = jsonValid($validator->errors());
        }

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
