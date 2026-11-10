<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            // Arahkan sesuai role masing-masing jika coba akses rute role lain
            return match (Auth::user()->role) {
                'superadmin' => redirect()->route('users.index'),
                'admin'      => redirect()->route('admin.dashboard'),
                default      => redirect()->route('buyer.dashboard'),
            };
        }

        return $next($request);
    }
}