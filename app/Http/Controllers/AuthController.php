<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes([
                'https://www.googleapis.com/auth/calendar.events',
                'https://www.googleapis.com/auth/calendar.readonly'
            ])
            ->with([
                'access_type' => 'offline',
                'prompt' => 'consent'
            ])
            ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch(InvalidStateException) {
            return redirect()->route('auth.redirect');
        }

        $user = User::updateOrCreate([
            'email' => $googleUser->email
        ], [
            'name' => $googleUser->name,
            'google_refresh_token' => $googleUser->refreshToken,
            'google_access_token' => $googleUser->token,
            'google_access_token_expires' => now()->addSeconds($googleUser->expiresIn)->subSeconds(10)
        ]);

        auth()->login($user, true);

        return redirect()->route('dash');
    }
}
