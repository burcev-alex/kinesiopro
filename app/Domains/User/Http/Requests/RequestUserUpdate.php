<?php

namespace App\Domains\User\Http\Requests;

use App\Domains\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestUserUpdate extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId = request()->user()->id;
        return [
            'firstname' => ['required', 'string', 'regex:/^[а-яА-ЯёЁА-Яа-яёЁЇїІіЄєҐґ\s]+$/iu', 'max:255'],
            'surname' => ['required', 'string', 'regex:/^[а-яА-ЯёЁА-Яа-яёЁЇїІіЄєҐґ\s]+$/iu', 'max:255'],
            'phone' => ['required', 'string', Rule::unique('users')->ignore($userId)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password' => ['required_with:new_password', 'min:6'],
            'new_password' => ['sometimes', 'min:6'],
            'activity' => []
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => __('auth.registration.email_exists'),
            'phone.unique' => __('auth.registration.phone_exists'),
            'firstname.regex' => __('auth.registration.invalid_format'),
            'surname.regex' => __('auth.registration.invalid_format'),
        ];
    }
}
