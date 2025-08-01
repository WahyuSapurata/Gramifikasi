<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (Auth::user()->role == 'admin') {
                    return redirect()->route('admin.dashboard-admin');
                } elseif (Auth::user()->role == 'guru') {
                    return redirect()->route('guru.dashboard-guru');
                } elseif (Auth::user()->role == 'siswa') {
                    return redirect()->route('siswa.dashboard-siswa');
                }
            }
        }

        return $next($request);
    }
}
