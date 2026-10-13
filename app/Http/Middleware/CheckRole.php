<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Contoh: 'role:admin' (role persis), 'role:admin,guru' (salah satu role),
     * 'role:bk' (user dengan penugasan bk, biasanya role guru).
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user) {
            foreach ($roles as $role) {
                if ($user->role === $role) {
                    return $next($request);
                }

                // 'bk' bukan role, melainkan penugasan pada user (mis. role guru + penugasan bk).
                if ($role === 'bk' && $user->bertugasSebagai('bk')) {
                    return $next($request);
                }
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
