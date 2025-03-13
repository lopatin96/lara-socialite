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
            $user = Socialite::driver($social)->stateless()->user();
        } catch (Exception) {
            return redirect('/login');
        }

        $user = User::firstOrCreate(
            [
                'social_provider_user_id' => $user->getId(),
                'social_provider' => $social,
            ],
            [
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'email_verified_at' => $user->getEmail() ? now() : null,
            ]
        );

        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}