<?php

namespace App\Http\Requests\Sanad\Settings;

use App\Http\Requests\MainRequest;

class StoreSettingRequest extends MainRequest
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
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'*.website_name'] = 'nullable|string|max:255';
            $rules[$locale.'*.location'] = 'nullable|string|max:255';
            $rules[$locale.'*.copyright'] = 'nullable|string|max:255';
            $rules[$locale.'*.footer_text'] = 'nullable|string|max:255';
            $rules[$locale.'*.privacy'] = 'nullable|string|max:255';
        }

        return array_merge($rules, [
            'logo_header' => 'nullable',
            'logo_footer' => 'nullable',
            'favicon' => 'nullable',
            'twitter' => 'nullable',
            'facebook' => 'nullable',
            'instagram' => 'nullable',
            'snapchat' => 'nullable',
            'linkedin' => 'nullable',
            'youtube' => 'nullable',
            'whatsapp' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'other_phone' => 'nullable',
            'tiktok' => 'nullable',
        ]);
    }
}
