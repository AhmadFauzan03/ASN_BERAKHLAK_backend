<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Form_Opd;
use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Pemeriksaan;
use App\Models\TotalPoin;
use App\Http\Resources\Form_OpdResource;
use Carbon\Carbon;

class Form_OpdController extends Controller
{
    public function index() {
        return Form_OpdResource::collection(Form_Opd::with(['kriteria','user','status'])->get());
    }

     public function indexByBulan(Request $request) {
        $query = Form_Opd::with(['kriteria','user','status']);

        // Ambil bulan dari request
        $bulan = $request->input('bulan');

        if ($bulan === 'bulan_ini') {
            $bulan = Carbon::now()->format('Y-m');
        } elseif ($bulan === 'bulan_lalu') {
            $bulan = Carbon::now()->subMonth()->format('Y-m');
        } else {
            $bulan = $bulan ?? Carbon::now()->format('Y-m'); // default bulan ini
        }

        $query->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $bulan);

        return Form_OpdResource::collection($query->get());
    }

    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'id_kriteria' => 'required|string|exists:kriterias,id',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'link_video'  => 'nullable|url',
            'id_user'     => 'required|string|exists:users,id',
            'bulan'       => 'nullable|string',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('from_opd', 'public');
        }

        // Tentukan created_at sesuai input bulan
        $createdAt = now();
        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            if ($bulan === 'bulan_ini') {
                $createdAt = \Carbon\Carbon::now();
            } elseif ($bulan === 'bulan_lalu') {
                $createdAt = \Carbon\Carbon::now()->subMonth();
            } else {
                $createdAt = \Carbon\Carbon::createFromFormat('Y-m-d', $bulan.'-01');
            }
        }

        // Buat instance baru
        $form_opd = new Form_Opd([
            'id'          => Form_Opd::generateCustomId(),
            'id_kriteria' => $request->id_kriteria,
            'gambar'      => $gambarPath,
            'link_video'  => $request->link_video,
            'id_user'     => $request->id_user,
            'id_status'   => 'ST-002',
        ]);

        // Override timestamps manual
        $form_opd->timestamps = false; // matikan auto timestamps
        $form_opd->created_at = $createdAt;
        $form_opd->updated_at = now();
        $form_opd->save();
        $form_opd->timestamps = true; // nyalakan lagi

        return new Form_OpdResource($form_opd->load(['kriteria','user','status']));

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors'  => $e->errors(),
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat menyimpan data.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}


    //untuk pemeriksa
public function updateStatus(Request $request, $id)
{
    try {
        $validated = $request->validate([
            'id_status'   => 'required|string|exists:statuses,id',
            'keterangan'  => 'nullable|string',
        ]);

        $form = Form_Opd::with('kriteria.poin')->findOrFail($id);
        $status = $request->id_status;

        // Jika gagal (ST-003), wajib isi keterangan
        if ($status === 'ST-003' && empty($request->keterangan)) {
            return response()->json([
                'message' => 'Keterangan wajib diisi jika status gagal.'
            ], 422);
        }
        $form_opd_created_at = $form->created_at;
        // Update status & keterangan
        $form->update([
            'id_status'  => $status,
            'keterangan' => $request->keterangan,
        ]);

        $nilai_poin = 0;

        if ($status === 'ST-001') {
            $nilai_poin = $form->kriteria->poin->nilai_poin ?? 0;

            // Ambil bulan dari created_at form_opd
            $targetDate   = \Carbon\Carbon::parse($form->created_at);
            $targetPeriod = $targetDate->format('Y-m'); // contoh: 2025-09

            // Cari total poin user pada bulan tersebut
            $totalPoin = TotalPoin::where('id_user', $form->id_user)
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$targetPeriod])
                ->first();

            if ($totalPoin) {
                $totalPoin->total_poin += $nilai_poin;
                $totalPoin->updated_at = now();
                $totalPoin->save();
            } else {
            DB::table('total_poins')->insert([
                'id'         => TotalPoin::generateCustomId(),
                'id_user'    => $form->id_user,
                'total_poin' => $nilai_poin,
                'created_at' => $form_opd_created_at,
                'updated_at' => now(),
            ]);
            }
        }

        return response()->json([
            'message'    => 'Status berhasil diperbarui',
            'nilai_poin' => $nilai_poin,
            'data'       => new Form_OpdResource($form->fresh(['kriteria.poin', 'user']))
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors'  => $e->errors(),
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat update status.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}




    //untuk user opd
 public function updateByUserPerBulan(Request $request, $id_user)
{
    try {
        $validated = $request->validate([
            'id_kriteria' => 'nullable|string|exists:kriterias,id',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'link_video'  => 'nullable|url',
            'bulan'       => 'required|string', // bulan: '2025-08' atau 'bulan_ini' / 'bulan_lalu'
            'id_status'   => 'nullable|string|exists:statuses,id',
            'keterangan'  => 'nullable|string',
        ]);

        // Tentukan bulan target
        $bulan = $request->bulan;
        if ($bulan === 'bulan_ini') {
            $bulan = Carbon::now()->format('Y-m');
        } elseif ($bulan === 'bulan_lalu') {
            $bulan = Carbon::now()->subMonth()->format('Y-m');
        }

        // Cari Form_Opd sesuai user + bulan
        $forms = Form_Opd::where('id_user', $id_user)
            ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $bulan)
            ->get();

        if ($forms->isEmpty()) {
            return response()->json([
                'message' => "Tidak ada Form_Opd untuk user ini di bulan $bulan"
            ], 404);
        }

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('form_opd', 'public');
        }

        $nilai_poin_total = 0;

        foreach ($forms as $form) {
            if ($gambarPath) $form->gambar = $gambarPath;
            if ($request->id_kriteria) $form->id_kriteria = $request->id_kriteria;
            if ($request->link_video) $form->link_video = $request->link_video;
            if ($request->id_status) {
                $form->id_status = $request->id_status;

                // Jika gagal, cek keterangan
                if ($request->id_status === 'ST-003' && empty($request->keterangan)) {
                    return response()->json([
                        'message' => 'Keterangan wajib diisi jika status gagal.'
                    ], 422);
                }

                $form->keterangan = $request->keterangan ?? $form->keterangan;
            }

            $form->updated_at = now();
            $form->save();

            // Kalau status disetujui (ST-001) → hitung poin
            if ($form->id_status === 'ST-001') {
                $nilai_poin = $form->kriteria->poin->nilai_poin ?? 0;
                $nilai_poin_total += $nilai_poin;

                // Tambahkan/Update total poin
                $targetPeriod = Carbon::parse($form->created_at)->format('Y-m');

                $totalPoin = TotalPoin::where('id_user', $id_user)
                    ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$targetPeriod])
                    ->first();

                if ($totalPoin) {
                    $totalPoin->total_poin += $nilai_poin;
                    $totalPoin->updated_at = now();
                    $totalPoin->save();
                } else {
                    TotalPoin::create([
                        'id'         => TotalPoin::generateCustomId(),
                        'id_user'    => $id_user,
                        'total_poin' => $nilai_poin,
                        'created_at' => $form->created_at, // ikut bulan form
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return response()->json([
            'message'    => "Form_Opd user berhasil diperbarui untuk bulan $bulan",
            'nilai_poin' => $nilai_poin_total,
            'data'       => Form_OpdResource::collection(
                $forms->fresh(['kriteria.poin', 'user', 'status'])
            )
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors'  => $e->errors(),
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat update Form_Opd per user per bulan.',
            'error'   => $e->getMessage(),
        ], 500);
    }
}

}
