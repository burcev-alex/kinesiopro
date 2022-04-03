<?php

namespace App\Domains\User\Http\Controllers\Web;

use App\Domains\User\Models\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // $this->middleware('guest', [
        //     'except' => [
        //         'logout',
        //         'switchLogout',
        //     ],
        // ]);
    }
    
    /**
     * Display the password reset view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request, $token)
    {
        return view('auth.passwords.reset', ['request' => $request, 'token' => $token]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'min:6']
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                if (Hash::check($request->password, $request->password_confirmation)) {
                    throw ValidationException::withMessages([
                        'password' => __('passwords.password_equal_to_old')
                    ]);
                }
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'password_changed_at' => Carbon::now(),
                    'remember_token' => Str::random(60),
                ])->save();

                //login the user immediately they change password successfully
                Auth::login($user);

                //Delete the token
                DB::table('password_resets')->where('email', $user->email)
                ->delete();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            return response()->json([
                'url' => route('index'),
                'message' => __('auth.reset_password.success')
            ]);
        }

        throw ValidationException::withMessages([
            'email' => __($status)
        ]);
    }
}
