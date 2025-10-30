<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && is_null(Auth::user()->email_verified_at)) {
            return redirect()->route('verification.form')->withErrors(['code' => 'Debes verificar tu correo electrónico.']);
        }

        return $next($request);
    }
}
