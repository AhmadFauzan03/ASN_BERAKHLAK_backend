<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormOpd;
use App\Models\FormOpdDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormOpdController extends Controller
{
    private $maxUploads = [
        'KR-001' => 5,
        'KR-002' => 2,
        'KR-003' => 5,
        'KR-004' => 4,
        'KR-005' => 1,
        'KR-006' => 4,
    ];

    public function store(Request $request)
    {
        $request->validate([
            'bulan'       => 'required|integer|min:1|max:12',
            'tahun'       => 'required|integer|min:2000',
            'id_kriteria' => 'required|string|in:KR-001,KR-002,KR-003,KR-004,KR-005,KR-006',
            'file'        => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'link'        => 'nullable|string'
        ]);

        $user = $request->user();

        // cek / buat form_opd
        $form = FormOpd::firstOrCreate(
            [
                'id_user'       => $user->id,
                'periode_bulan' => $request->bulan,
                'periode_tahun' => $request->tahun,
            ],
            [
                'id'        => "FOPD-" . Str::uuid(),
                'id_status' => 'ST-002',
            ]
        );

        // cek batas maksimal upload per kriteria
        $maxAllowed = $this->maxUploads[$request->id_kriteria] ?? 0;

        $existingCount = FormOpdDetail::where('form_opd_id', $form->id)
            ->where('id_kriteria', $request->id_kriteria)
            ->count();

        if ($existingCount >= $maxAllowed) {
            return response()->json([
                'success' => false,
                'message' => "Upload gagal: kriteria {$request->id_kriteria} sudah mencapai batas maksimal ($maxAllowed file)."
            ], 422);
        }

        // simpan file
        $path = $request->file('file')->store('uploads/opd', 'public');

        // insert detail baru
        $detail = FormOpdDetail::create([
            'id'          => "FD-" . Str::uuid(),
            'form_opd_id' => $form->id,
            'id_kriteria' => $request->id_kriteria,
            'file'        => $path,
            'link'        => $request->link,
            'nilai_poin'  => 0,
            'id_status'   => 'ST-002',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Upload berhasil disimpan (status pending)',
            'data'    => $detail
        ], 201);
    }
}
