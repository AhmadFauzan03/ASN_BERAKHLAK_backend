<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\Poin;
use App\Http\Resources\KriteriaResource;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KriteriaController extends Controller
{
    public function index() {
        return KriteriaResource::collection(Kriteria::with('poin')->get());
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'kriteria'   => 'required|string',
                'id_poin'    => 'required|string|exists:poins,id',
                'deskripsi'  => 'required|string',
                'id_sub_kriteria'  => 'required|string|exists:sub_kriterias,id',
            ]);

            $kriteria = Kriteria::create([
                'id'              => Kriteria::generateCustomId(),
                'kriteria'        => $request->kriteria,
                'id_poin'         => $request->id_poin,
                'deskripsi'       => $request->deskripsi,
                'id_sub_kriteria' => $request->id_sub_kriteria,
            ]);

            return new KriteriaResource($kriteria->load('poin'));

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan kriteria',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id) {
        try {
            $kriteria = Kriteria::with('poin')->findOrFail($id);
            return new KriteriaResource($kriteria);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data kriteria tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, $id) {
        try {
            $data = Kriteria::findOrFail($id);
            $data->update($request->all());
            return new KriteriaResource($data->load('poin'));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data kriteria tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengupdate kriteria',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id) {
        try {
            $deleted = Kriteria::destroy($id);
            if ($deleted) {
                return response()->json(['message' => 'Data berhasil dihapus']);
            } else {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus kriteria',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
