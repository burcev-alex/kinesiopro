<?php

namespace App\Domains\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestUserRegister extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string'],
            'work' => ['required', 'string'],
            'country' => ['required', 'string'],
            'position' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'min:6'],
            'scan_id' => '',
            'avatar_id' => '',
            'birthday_year' => '',
            'birthday_month' => '',
            'birthday_day' => '',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.regex' => __('auth.registration.invalid_format'),
            'surname.regex' => __('auth.registration.invalid_format'),
        ];
    }
}
