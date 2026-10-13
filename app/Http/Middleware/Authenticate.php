<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pengganti middleware 'auth' bawaan agar mengenali guard 'customer'
 * selain 'web'. Tanpa ini, customer yang hanya login via guard 'customer'
 * dianggap belum login oleh middleware auth default (yang hanya cek 'web').
 */
class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        foreach (['web', 'customer'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::shouldUse($guard);

                return $next($request);
            }
        }

        return redirect()->route('login');
    }
}