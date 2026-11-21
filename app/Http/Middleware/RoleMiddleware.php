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

        // Request API memakai token (user di-set via setUserResolver),
        // bukan session guard.
        if ($activeGuard === null && $request->user()) {
            return $this->authorize($request, $next, $roles);
        }

        if ($activeGuard === null) {
            return $this->deny($request);
        }

        auth()->shouldUse($activeGuard);

        return $this->authorize($request, $next, $roles);
    }

    private function authorize(Request $request, Closure $next, array $roles): Response
    {
        if (!in_array($request->user()?->role, $roles, true)) {
            return $this->deny($request);
        }

        return $next($request);
    }

    private function deny(Request $request): Response
    {
        // RoleMiddleware dipakai di web (session) dan api (token).
        // Web: redirect ke login bila belum login, 403 bila sudah login
        // tapi rolenya tidak cocok. API: selalu JSON 403.
        if ($request->is('api/*')) {
            abort(403, 'Anda tidak memiliki akses ke resource ini.');
        }

        if (!$request->user()) {
            return redirect()->route('login');
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}