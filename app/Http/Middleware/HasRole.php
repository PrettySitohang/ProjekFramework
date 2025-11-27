<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasRole // Nama kelas sekarang HasRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error',
            'Silakan login terlebih dahulu.');
        }
        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        Auth::logout();
        return  abort('403');
    }
}
