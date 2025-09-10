<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubKriteriaResource;
use Illuminate\Http\Request;
use App\Models\SubKriteria;

class SubKriteriaController extends Controller
{
    public function index()
    {
        return response()->json(SubKriteria::all());
    }

   public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'sub_kriteria' => 'required|string',
            ]);

            
            $sub = SubKriteria::create([
                'id'          => SubKriteria::generateCustomId(),
                'sub_kriteria'=> $request->sub_kriteria,
            ]);

            return response()->json([
                'message' => 'Sub kriteria berhasil ditambahkan',
                'data'    => $sub
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan sub kriteria',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    // ambil detail sub kriteria by ID
    public function show($id)
    {
        $sub = SubKriteria::findOrFail($id);
        return response()->json($sub);
    }

    // update sub kriteria
    public function update(Request $request, $id)
    {
        try {
            $sub = SubKriteria::findOrFail($id);

            $validated = $request->validate([
                'sub_kriteria'  => 'required|string',
            ]);

            $sub->update($validated);

            return response()->json([
                'message' => 'Sub kriteria berhasil diupdate',
                'data'    => $sub
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat update sub kriteria',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $sub = SubKriteria::findOrFail($id);
        $sub->delete();

        return response()->json([
            'message' => 'Sub kriteria berhasil dihapus'
        ]);
    }
}
