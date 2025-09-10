<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
  

public function login(Request $request)
{
    try {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::with('peran')->where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Username atau password salah',
            ], 401);
        }

        // Hapus token lama (opsional)
        $user->tokens()->delete();

        // Buat token baru
        $token = $user->createToken('auth_token')->plainTextToken;

        // Tentukan rute dashboard berdasarkan peran
        $role = $user->peran->peran_user ?? 'user';
        $redirect_url = match ($role) {
            'admin' => '/dashboard/admin',
            'super admin' => '/dashboard/superadmin',
            'pengguna opd' => '/dashboard/pengguna opd',
            'tim verifikasi' => '/dashboard/tim verifikasi',
            default => '/dashboard',
        };

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'nama_peran' => $role,
            ],
            'redirect' => $redirect_url
        ]);

    } catch (ValidationException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat login.',
            'error' => $e->getMessage()
        ], 500);
    }
}
}