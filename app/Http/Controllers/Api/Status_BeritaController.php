<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StatusBerita;
use Illuminate\Http\Request;

class Status_BeritaController extends Controller
{
    public function index() {
        return Status_Berita::all();
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'status_berita' => 'required|string|max:255',
    ]);

    $status = Status_Berita::create([
        'id' => Status_Berita::generateCustomId(),
        'status_berita' => $validated['status_berita'],
    ]);

    return response()->json($status, 201);
}

    public function show($id) {
        return Status_Berita::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $data = Status_Berita::findOrFail($id);
        $data->update($request->all());
        return $data;
    }

    public function destroy($id) {
        return Status_Berita::destroy($id);
    }
}
