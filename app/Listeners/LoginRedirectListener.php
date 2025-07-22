<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class LoginRedirectListener
{
    public function handle(Login $event): void
    {
        $user = $event->user;

        if ($user->hasRole('trainer')) {
            Session::put('url.intended', '/trainer/dashboard');
        } elseif ($user->hasRole('client')) {
            Session::put('url.intended', '/dashboard');
        } else {
            Session::put('url.intended', '/dashboard');
        }
    }
}
