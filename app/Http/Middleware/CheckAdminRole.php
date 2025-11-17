<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika route saat ini adalah route logout, langsung lanjutkan saja.
        if ($request->routeIs('filament.admin.auth.logout')) {
            return $next($request);
        }

        // Cek apakah pengguna sudah login dan memiliki role 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Jika admin, izinkan untuk melanjutkan ke request berikutnya (ke dashboard admin)
            return $next($request);
        }

        // Jika bukan admin (misal: role 'pengguna'), redirect ke route 'dashboardPages'
        if (Auth::check() && Auth::user()->role === 'pengguna') {
             return redirect()->route('dashboard');
        }

        // Jika tidak memenuhi keduanya (misal: belum login), kembalikan ke halaman login
        return redirect('/admin/login');
    }
}