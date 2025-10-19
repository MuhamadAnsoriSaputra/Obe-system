<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Cek apakah role user termasuk dalam daftar roles
        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
