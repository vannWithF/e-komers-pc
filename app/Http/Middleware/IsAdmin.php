<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        // 2. Cek apakah kolom 'role' pada user bernilai 'admin'
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            // Jika bukan admin, gagalkan akses dengan error 403 (Forbidden)
            abort(403, 'Akses ditolak. Anda bukan admin.');
        }

        // Jika lolos pengecekan, lanjutkan request ke proses berikutnya
        return $next($request);
    }

}
