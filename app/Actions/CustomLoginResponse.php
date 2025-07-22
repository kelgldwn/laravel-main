<?php

namespace App\Actions;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        dd('CustomLoginResponse is being used');
        $user = auth()->user();

        $redirect = match (true) {
            $user->hasRole('trainer') => '/trainer/dashboard',
            $user->hasRole('client') => '/client/dashboard',
            default => '/dashboard',
        };

        // ✅ Don't use intended — force redirect
        return redirect($redirect);
    }
}
