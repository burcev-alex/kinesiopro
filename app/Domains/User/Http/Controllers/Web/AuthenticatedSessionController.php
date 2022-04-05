<?php

namespace App\Domains\User\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Domains\User\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }


    /**
     * Авторизация
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $user = $request->user();

        $user->last_login_at = Carbon::now();
        $user->last_login_ip = $request->ip();
        $user->save();


        $request->session()->regenerate();

        $path = app('Illuminate\Routing\UrlGenerator')->previous();

        return response()->json([
            'url' => $path,
        ]);
    }

    /**
     * Verification Is Required
     *
     * @param $request
     * @param $user
     * @throws ValidationException
     */
    public function verificationIsRequired($request, $user)
    {
        Auth::guard('web')->logout();
        $request->session()->regenerateToken();
        event(new Registered($user));
        throw ValidationException::withMessages([
            'email' => 'Пожалуйста подтвердите email',
        ]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('index'));
    }
}
