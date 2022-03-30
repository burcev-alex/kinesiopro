<?php

namespace App\Domains\User\Http\Controllers\Web;

use App\Domains\Product\Services\FavoritesService;
use App\Domains\User\Models\User;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController
{
    /**
     * Redirect to driver
     * @param string $driver
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function index(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Google callback
     * @return \Illuminate\Http\RedirectResponse
     */
    public function google()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('index');
        }

        // check if they're an existing user
        $email = strtolower($user->email);
        $existingUser = User::where('email', $email)
            ->first();

        if ($existingUser) {
            $existingUser->last_login_at = Carbon::now();
            $existingUser->last_login_ip = request()->ip();
            $existingUser->save();
            $userId = $existingUser->id;
            // log them in
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser = User::create([
                'name' => $user->name,
                'firstname' => $user->user['given_name'] ?? '',
                'surname' => $user->user['family_name'] ?? '',
                'email' => $email,
                'email_verified_at' => Carbon::now(),
                'google_id' => $user->id,
                'last_login_at' => Carbon::now(),
                'last_login_ip' => request()->ip(),
                'receive_emails' => true
            ]);
            $userId = $newUser->id;
            auth()->login($newUser, true);
        }
        
        FavoritesService::synchronize($userId);

        return redirect()->route('index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function facebook()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect()->route('index');
        }

        $email = strtolower($user->email);
        // check if they're an existing user
        $existingUser = User::where('email', $email)
            ->first();

        if ($existingUser) {
            $existingUser->last_login_at = Carbon::now();
            $existingUser->last_login_ip = request()->ip();
            $existingUser->save();
            $userId = $existingUser->id;
            // log them in
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser = User::create([
                'name' => $user->name,
                'email' => $email,
                'facebook_id' => $user->id,
                'last_login_at' => Carbon::now(),
                'last_login_ip' => request()->ip(),
                'receive_emails' => true
            ]);
            $userId = $newUser->id;
            auth()->login($newUser, true);
        }
        
        FavoritesService::synchronize($userId);

        return redirect()->route('index');
    }
}
