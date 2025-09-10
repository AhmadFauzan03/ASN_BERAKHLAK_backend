<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Ambil role dari relasi ke tabel perans
        $userRole = $user->peran ? $user->peran->peran_user : null;

        if (!$userRole || !in_array($userRole, $roles)) {
            return response()->json(['message' => 'Unauthorized. Role tidak sesuai'], 403);
        }

        return $next($request);
    }
}
