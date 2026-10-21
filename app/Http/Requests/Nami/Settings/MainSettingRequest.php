<?php

namespace App\Http\Requests\Nami\Settings;

use App\Http\Requests\MainRequest;

class MainSettingRequest extends MainRequest
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
        $rules = [];

        foreach(config('translatable.locales') as $locale){
            $rules[$locale.'*.sidebar_text'] = 'nullable|string';
            $rules[$locale.'*.copyright_text'] = 'nullable|string';
            $rules[$locale.'*.company_name'] = 'nullable|string';
        }

        return array_merge($rules, [
            'loading_background_color' => 'required',
            'footer_logo' => ($this->method() == 'PUT') ? 'nullable' : 'required',
            'copyright_link' => 'required',
            'link' => 'required',
        ]);
    }
}
