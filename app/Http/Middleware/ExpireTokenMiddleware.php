<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ExpireTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);

            if ($accessToken) {
                $lastUsed = $accessToken->last_used_at ?? $accessToken->created_at;
                $now = Carbon::now();

                if ($now->diffInMinutes($lastUsed) > 2) {
                    // Token sudah kadaluarsa
                    $accessToken->delete(); // Hapus token
                    return response()->json([
                        'message' => 'Token kadaluarsa. Silakan login ulang.',
                    ], 401);
                }

                // Update waktu terakhir digunakan
                $accessToken->forceFill([
                    'last_used_at' => now()
                ])->save();
            }
        }

        return $next($request);
    }
}
