<?php

namespace App\Domains\User\Services;

use App\Domains\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserService
{
    /**
     * Обновление данных пользователя
     *
     * @param User $user
     * @param array $data
     * @return User
     * @throws ValidationException
     */
    public function update(User $user, array $data)
    {
        $email = strtolower($data['email']);
        $exist = User::query()
            ->where(DB::raw('LOWER(email)'), $email)
            ->first();

        if ($exist && $exist->id !== $user->id) {
            throw ValidationException::withMessages([
                'email' => __('auth.registration.email_exists'),
            ]);
        }

        $user->name = $data['surname']." ".$data['firstname'];
        $user->firstname = $data['firstname'];
        $user->surname = $data['surname'];
        $user->email = $email;
        $user->phone = $data['phone'];
        $user->work = $data['work'];
        $user->position = $data['position'];
        $user->country = $data['country'];
        $user->birthday = $data['birthday'];

        $user->password = $data['password'];

        $user->save();
        return $user;
    }
}
