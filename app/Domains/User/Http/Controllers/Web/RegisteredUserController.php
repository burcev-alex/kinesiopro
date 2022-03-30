<?php

namespace App\Domains\User\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domains\User\Models\User;
use App\Domains\User\Http\Requests\RequestUserRegister;
use Illuminate\Auth\Events\Registered;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * @param RequestUserRegister $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(RequestUserRegister $request)
    {
        $data = $request->validated();

        $email = strtolower($data['email']);
        $user = User::query()
            ->where('email', $email)
            ->first();

        $phone = User::query()
            ->where('phone', $data['phone'])
            ->exists();

        if ($phone) {
            throw ValidationException::withMessages([
                'phone' => __('auth.registration.phone_exists')
            ]);
        }

        if ($user) {
            if (empty($user->password)) {
                $user->update([
                    'name' => $data['surname']." ".$data['firstname'],
                    'firstname' => $data['firstname'],
                    'surname' => $data['surname'],
                    'work' => $data['work'],
                    'position' => $data['position'],
                    'country' => $data['country'],
                    'phone' => $data['phone'],
                    'password' => $data['password']
                ]);
            } else {
                throw ValidationException::withMessages([
                    'email' => __('auth.registration.email_exists')
                ]);
            }
        } else {
            try {
                DB::beginTransaction();
                $user = User::create([
                    'name' => $data['surname']." ".$data['firstname'],
                    'firstname' => $data['firstname'],
                    'surname' => $data['surname'],
                    'email' => $email,
                    'phone' => $data['phone'],
                    'work' => $data['work'],
                    'position' => $data['position'],
                    'country' => $data['country'],
                    'password' => $data['password'],
                ]);
                event(new Registered($user));
                Auth::login($user);
                DB::commit();
            } catch (\Exception $exception) {
                DB::rollBack();
                throw $exception;
            }
        }

        return response()->json([
            'message' => __('auth.registration.success')
        ]);
    }

    public function create(){
        return view('pages.registration');
    }
}
