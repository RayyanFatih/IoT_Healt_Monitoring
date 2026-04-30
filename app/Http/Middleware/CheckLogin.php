<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Pastikan user sudah login (session 'logged_in' = true).
     * Jika belum, redirect ke halaman login.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::get('logged_in')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
