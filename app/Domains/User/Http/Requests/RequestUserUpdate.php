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
            'firstname' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', Rule::unique('users')->ignore($userId)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password' => ['required:string', 'min:6'],
            'work' => ['required', 'string'],
            'country' => ['required', 'string'],
            'position' => ['required', 'string'],
            'birthday' => '',
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
