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
            'name' => ['required', 'string', 'regex:/^[а-яА-ЯёЁА-Яа-яёЁЇїІіЄєҐґ\s]+$/iu', 'max:255'],
            'surname' => ['required', 'string', 'regex:/^[а-яА-ЯёЁА-Яа-яёЁЇїІіЄєҐґ\s]+$/iu', 'max:255'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'min:6']
            // 'public_offer' => 'required',
            // 'privacy_policy' => 'required'
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
