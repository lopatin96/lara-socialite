<?php

namespace Lopatin96\LaraSocialite\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Event;
use Illuminate\Auth\Events\Registered;

class LaraSocialiteController extends Controller
{
    public function socialLogin(string $social): RedirectResponse
    {
        return Socialite::driver($social)->redirect();
    }

    public function handleProviderCallback(string $social): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver($social)->stateless()->user();
        } catch (Exception) {
            return redirect('/login');
        }

        $user = User::firstOrNew([
            'social_provider_user_id' => $socialUser->getId(),
            'social_provider' => $social,
        ]);

        if (! $user->exists) {
            $user->forceFill([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'email_verified_at' => $socialUser->getEmail() ? now() : null,
                'social_provider_user_id' => $socialUser->getId(),
                'social_provider' => $social,
            ])->save();

            event(new Registered($user));
        }

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}