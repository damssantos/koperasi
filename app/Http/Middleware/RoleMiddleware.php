<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {
        // Deteksi guard aktif (admin/pengawas = web, customer = customer)
        // supaya admin & customer bisa login bersamaan di browser yang sama.
        $activeGuard = null;
        foreach (['web', 'customer'] as $guardName) {
            if (auth()->guard($guardName)->check()) {
                $activeGuard = $guardName;
                break;
            }
        }

        if ($activeGuard === null) {
            return redirect()->route('login');
        }

        auth()->shouldUse($activeGuard);

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}