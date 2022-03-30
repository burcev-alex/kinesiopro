<?php

namespace App\Domains\User\Http\Controllers\Web;

use App\Domains\Product\Services\FavoritesService;
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
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $user = $request->user();
        // if (!$user->hasVerifiedEmail()) {
        //     // Log out and send email
        //     $this->verificationIsRequired($request, $user);
        // }

        $user->last_login_at = Carbon::now();
        $user->last_login_ip = $request->ip();
        $user->save();


        $request->session()->regenerate();

        FavoritesService::synchronize($user->id);

        $path = app('Illuminate\Routing\UrlGenerator')->previous();

        if ($user->language) {

            // убрать доменное имя
            $exp = explode(config('app.url'), $path);
            $path = $exp[1];

            if ($user->language != 'uk') {
                if (substr_count($path, "/" . $user->language . "/") == 0) {
                    $path = '/' . $user->language . $path;
                }
            } else if ($user->language == 'uk' && substr_count($path, "/ru/") > 0) {
                // если на странице RU тогда переход на UK версию
                $path = str_replace("/ru/", "/", $path);
            }
        }

        return response()->json([
            'url' => $path
        ]);
    }

    /**
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
            'email' => 'Пожалуйста подтвердите email'
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
