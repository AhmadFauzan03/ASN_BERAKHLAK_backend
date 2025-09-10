<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return User::all();
    }

  public function store(Request $request)
{
    try {
        $request->validate([
            'nama' => 'required|string',
            'id_peran' => 'required|string|exists:perans,id',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'id_opd' => 'nullable|string|exists:opds,id',
        ]);

        $user = User::create([
            'id' => User::generateCustomId(),
            'nama' => $request->nama,
            'id_peran' => $request->id_peran,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_opd' => $request->id_opd,
        ]);

        return new UserResource($user->load(['peran', 'opd']));

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validasi gagal',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan saat menyimpan data.',
            'error' => $e->getMessage()
        ], 500);
    }
}


    public function show($id) {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->update($request->except(['password'])); // optional
        return $user;
    }

    public function destroy($id) {
        return User::destroy($id);
    }

    public function updatePassword(Request $request)
    {
        try {
            $user = $request->user(); // ambil user dari token Sanctum

            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6|confirmed',
            ]);

            // cek apakah current_password benar
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password lama tidak sesuai'
                ], 400);
            }

            // Update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            // hapus semua token biar login ulang
            $user->tokens()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diperbarui, silakan login ulang.'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat update password.',
                'error' => $e->getMessage()
            ], 500);
        }
}
    public function logout(Request $request)
    {
        try {
            // Hapus token yang sedang dipakai (logout dari device ini saja)
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Logout berhasil.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat logout.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
