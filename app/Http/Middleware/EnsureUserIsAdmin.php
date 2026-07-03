<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Hanya user login dengan flag is_admin yang boleh mengakses panel admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('admin.login');
        }

        abort_unless($request->user()->is_admin, 403, 'Akun Anda tidak memiliki akses admin.');

        return $next($request);
    }
}
