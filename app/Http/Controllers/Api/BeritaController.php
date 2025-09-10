<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Resources\BeritaResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class BeritaController extends Controller
{
    // 🔓 GET semua berita (publik)
    public function index()
    {
        $berita = Berita::with('status_berita')->get();
        return response()->json($berita);
    }

    // 🔓 GET detail berita (publik)
    public function show($id)
    {
        $berita = Berita::with('status_berita')->findOrFail($id);
        return response()->json($berita);
    }

    // 🔒 POST buat berita baru (admin)
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'tanggal' => 'required|date',
                'penulis' => 'required|string',
                'artikel' => 'required|string',
                'gambar1' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'gambar2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'gambar3' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Default status berita = draft (STBT-002)
            $validated['id_status_berita'] = 'STBT-002';

            // Upload gambar
            $validated['gambar1'] = $request->file('gambar1')->store('berita', 'public');
            $validated['gambar2'] = $request->file('gambar2')?->store('berita', 'public');
            $validated['gambar3'] = $request->file('gambar3')?->store('berita', 'public');
            $validated['id'] = Berita::generateCustomId();

            $berita = Berita::create($validated);

            return new BeritaResource($berita);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error saat membuat berita: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal membuat berita'], 500);
        }
    }

    // 🔒 PUT update berita
  // 🔒 POST edit berita (hanya status draft)
public function edit(Request $request, $id)
{
    $berita = Berita::findOrFail($id);

    // cek kalau status berita bukan draft
    if ($berita->id_status_berita !== 'STBT-002') {
        return response()->json([
            'message' => 'Berita sudah publish, tidak bisa diubah lagi'
        ], 403);
    }

    // validasi input
    $validated = $request->validate([
        'judul' => 'nullable|string|max:255',
        'tanggal' => 'nullable|date',
        'penulis' => 'nullable|string',
        'artikel' => 'nullable|string',
        'gambar1' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'gambar2' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'gambar3' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // update field teks
    if ($request->filled('judul')) $berita->judul = $request->judul;
    if ($request->filled('tanggal')) $berita->tanggal = $request->tanggal;
    if ($request->filled('penulis')) $berita->penulis = $request->penulis;
    if ($request->filled('artikel')) $berita->artikel = $request->artikel;

    // update gambar1
    if ($request->hasFile('gambar1')) {
        if ($berita->gambar1) Storage::disk('public')->delete($berita->gambar1);
        $berita->gambar1 = $request->file('gambar1')->store('berita', 'public');
    }

    // update gambar2
    if ($request->hasFile('gambar2')) {
        if ($berita->gambar2) Storage::disk('public')->delete($berita->gambar2);
        $berita->gambar2 = $request->file('gambar2')->store('berita', 'public');
    }

    // update gambar3
    if ($request->hasFile('gambar3')) {
        if ($berita->gambar3) Storage::disk('public')->delete($berita->gambar3);
        $berita->gambar3 = $request->file('gambar3')->store('berita', 'public');
    }

    $berita->save();

    return response()->json([
        'message' => 'Berita draft berhasil diupdate',
        'data' => $berita
    ]);
}


    // 🔒 DELETE hapus berita
    public function destroy($id)
    {
        try {
            $berita = Berita::findOrFail($id);

            // Hapus gambar jika ada
            if ($berita->gambar1) Storage::disk('public')->delete($berita->gambar1);
            if ($berita->gambar2) Storage::disk('public')->delete($berita->gambar2);
            if ($berita->gambar3) Storage::disk('public')->delete($berita->gambar3);

            $berita->delete();

            return response()->json(['message' => 'Berita berhasil dihapus']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        } catch (\Exception $e) {
            Log::error('Error saat menghapus berita: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus berita'], 500);
        }
    }

    // 🔒 PUT update status berita
    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'id_status_berita' => 'required|string|exists:status_beritas,id',
            ]);

            $berita = Berita::findOrFail($id);
            $berita->update($validated);

            return new BeritaResource($berita->load('status_berita'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Gagal mengupdate status berita',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
