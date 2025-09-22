<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormOpd;
use App\Models\FormOpdDetail;
use App\Models\TotalPoin;
use Illuminate\Http\Request;

class FormOpdDetailController extends Controller
{
    private $poinMap = [
        'KR-001' => ['per' => 2],
        'KR-002' => ['per' => 5],
        'KR-003' => ['per' => 2],
        'KR-004' => ['per' => 5],
        'KR-005' => ['per' => 5],
        'KR-006' => ['per' => 5],
    ];

    /**
     * Update status detail (approve / reject)
     */
   public function updateStatus(Request $request, $id)
{
    try {
        $request->validate([
            'status'     => 'required|string|in:ST-001,ST-002,ST-003',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $detail = FormOpdDetail::findOrFail($id);
        $form   = $detail->formOpd;

        $oldStatus = $detail->id_status;
        $newStatus = $request->status;

        $detail->id_status  = $newStatus;
        $detail->keterangan = $request->keterangan ?? null;

        // hitung poin berdasarkan kriteria
        $poinPer = $this->poinMap[$detail->id_kriteria]['per'] ?? 0;

        // case: approve baru → tambah poin
        if ($oldStatus !== 'ST-001' && $newStatus === 'ST-001' && $poinPer > 0) {
            $this->adjustPoints($form, $poinPer);
            $detail->nilai_poin = $poinPer;
        }

        // case: dari approve → turun status → kurangi poin
        if ($oldStatus === 'ST-001' && $newStatus !== 'ST-001' && $poinPer > 0) {
            $this->adjustPoints($form, -$poinPer);
            $detail->nilai_poin = 0;
        }

        $detail->save();

        return response()->json([
            'success' => true,
            'message' => 'Status detail berhasil diperbarui',
            'data'    => $detail->fresh()
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors'  => $e->errors(),
        ], 422);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Detail tidak ditemukan',
        ], 404);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        ], 500);
    }
}


    /**
     * Update total poin di tabel TotalPoin
     */
    private function adjustPoints($form, $delta)
{
    if ($delta === 0) return;

    $record = TotalPoin::firstOrNew([
        'id_user'       => $form->id_user,
        'periode_bulan' => $form->periode_bulan,
        'periode_tahun' => $form->periode_tahun,
    ]);

    // kalau record baru → kasih custom id
    if (!$record->exists) {
        $record->id = TotalPoin::generateCustomId();
        $record->total_poin = 0;
    }

    $record->total_poin = max(0, ($record->total_poin ?? 0) + $delta);
    $record->save();
}
}
