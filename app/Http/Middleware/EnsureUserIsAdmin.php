<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('filament.admin.auth.login');
        }

        // Check if user has admin role
        $user = Auth::user();
        if (!$user->hasAnyRole(['admin', 'super-admin'])) {
            Auth::logout();
            return redirect()->route('filament.admin.auth.login')
                ->withErrors(['email' => 'Access denied. Admin privileges required.']);
        }

        return $next($request);
    }
}
