<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormOpd;
use App\Models\FormOpdKriteria;
use App\Models\FormOpdKriteriaDetail;
use App\Models\TotalPoin;
use App\Http\Resources\FormOpdResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class FormOpdController extends Controller
{
    private $poinMap = [
        'KR-001' => ['max' => 5, 'per' => 2],
        'KR-002' => ['max' => 2, 'per' => 5],
        'KR-003' => ['max' => 5, 'per' => 2],
        'KR-004' => ['max' => 4, 'per' => 5],
        'KR-005' => ['max' => 1, 'per' => 5],
        'KR-006' => ['max' => 4, 'per' => 5],
    ];

public function store(Request $request)
{
    try {
        $request->validate([
            'id_kriteria' => 'required|string|in:KR-001,KR-002,KR-003,KR-004,KR-005,KR-006',
            'bulan'       => 'required|integer|min:1|max:12',
            'tahun'       => 'required|integer|min:2000',
            'gambar1'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gambar2'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gambar3'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gambar4'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gambar5'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'link_vid1'   => 'nullable|string|max:255',
            'link_vid2'   => 'nullable|string|max:255',
            'link_vid3'   => 'nullable|string|max:255',
            'link_vid4'   => 'nullable|string|max:255',
            'link_vid5'   => 'nullable|string|max:255',
        ]);

        $user  = $request->user();
        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;

        // Cari record existing di bulan & tahun target
       $form = FormOpd::where('id_user', $user->id)
        ->where('id_kriteria', $request->id_kriteria)
        ->where('periode_bulan', $bulan)
        ->where('periode_tahun', $tahun)
        ->first();

        if (!$form) {
            $form = new FormOpd([
                'id_user'       => $user->id,
                'id_status'     => 'ST-002',
                'id_kriteria'   => $request->id_kriteria,
                'periode_bulan' => $bulan,
                'periode_tahun' => $tahun,
            ]);
        }

        // Upload file gambar (hanya kalau dikirim)
        for ($i = 1; $i <= 5; $i++) { 
            if ($request->hasFile("gambar$i")) {
                // kalau ada file lama, hapus dulu
                if ($form->{"gambar$i"}) {
                    \Storage::disk('public')->delete($form->{"gambar$i"});
                }
                $form->{"gambar$i"} = $request->file("gambar$i")
                    ->store("uploads/gambar", "public");
            }
        }

        // Update link video (kalau dikirim)
        for ($i = 1; $i <= 5; $i++) {
            if ($request->filled("link_vid$i")) {
                $form->{"link_vid$i"} = $request->input("link_vid$i");
            }
        }

        $form->save();

        // Kalau form sudah disetujui (ST-001), poin baru langsung ditambah
        if ($form->id_status === 'ST-001') {
            $map = $this->poinMap[$form->id_kriteria] ?? null;

            if ($map) {
                // Ambil semua field gambar + video
                $fields = [
                    'gambar1', 'gambar2', 'gambar3', 'gambar4', 'gambar5',
                    'link_vid1', 'link_vid2', 'link_vid3', 'link_vid4', 'link_vid5'
                ];

                $delta = 0;
                foreach ($fields as $field) {
                    // Kalau field baru aja terisi (dan sebelumnya kosong), hitung poinnya
                    if ($form->wasChanged($field) && !empty($form->$field)) {
                        $delta += $map['per'];
                    }
                }

                if ($delta > 0) {
                    // Tambahin delta ke TotalPoin user
                    $totalPoinRecord = TotalPoin::where('id_user', $form->id_user)
                        ->where('periode_bulan', $form->periode_bulan)
                        ->where('periode_tahun', $form->periode_tahun)
                        ->first();

                    if ($totalPoinRecord) {
                        $totalPoinRecord->increment('total_poin', $delta);
                    } else {
                        // Kalau belum ada record, bikin baru
                        TotalPoin::create([
                            'id_user'       => $form->id_user,
                            'periode_bulan' => $form->periode_bulan,
                            'periode_tahun' => $form->periode_tahun,
                            'total_poin'    => $delta
                        ]);
                    }
                }
            }
        }

        return new FormOpdResource($form->load('user','status','kriterias'));

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors'  => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan server',
            'error'   => $e->getMessage()
        ], 500);
    }
}



    public function index(Request $request)
{
    $user = $request->user();

    // Ambil semua form OPD berdasarkan user yang login
    $forms = FormOpd::where('id_user', $user->id)->get();

    return FormOpdResource::collection($forms);
}

  public function updateStatus(Request $request, $id)
{
    try {
        $request->validate([
            'id_status'   => 'required|string|in:ST-001,ST-002,ST-003',
            'keterangan'  => 'nullable|string'
        ]);

        $form = FormOpd::findOrFail($id);
        $periodeBulan = $form->periode_bulan ?? $form->created_at->format('m');
        $periodeTahun = $form->periode_tahun ?? $form->created_at->format('Y');
        $bulan = (int) $periodeBulan;
        $tahun = (int) $periodeTahun;

        if ($request->id_status === 'ST-003' && !$request->keterangan) {
            return response()->json(['message' => 'Keterangan wajib diisi jika gagal'], 422);
        }

        $form->update([
            'id_status'  => $request->id_status,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->id_status === 'ST-001') {
            $map = $this->poinMap[$form->id_kriteria] ?? null;

            if ($map) {
                $filled = collect([
                    $form->gambar1, $form->gambar2, $form->gambar3, $form->gambar4, $form->gambar5,
                    $form->link_vid1, $form->link_vid2, $form->link_vid3, $form->link_vid4, $form->link_vid5,
                ])->filter()->count();

                $validCount = min($map['max'], $filled);
                $totalPoin  = $validCount * $map['per'];

                // Update or Create dengan scope user + periode
                $totalPoinRecord = TotalPoin::where('id_user', $form->id_user)
                    ->where('periode_bulan', $periodeBulan)
                    ->where('periode_tahun', $periodeTahun)
                    ->first();

                if ($totalPoinRecord) {
                    // Update total poin
                    $totalPoinRecord->update([
                        'total_poin' => $totalPoinRecord->total_poin + $totalPoin
                    ]);
                } else {
                    // Buat record baru
                    TotalPoin::create([
                        'id'            => TotalPoin::generateCustomId(),
                        'id_user'       => $form->id_user,
                        'periode_bulan' => $periodeBulan,
                        'periode_tahun' => $periodeTahun,
                        'total_poin'    => $totalPoin
                    ]);
                }
            }
        }
        return response()->json([ 'success' => true, 'message' => 'Status berhasil diupdate', 'data' => $form->fresh() ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Form tidak ditemukan'
        ], 404);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors'  => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan pada server',
            'error'   => $e->getMessage()
        ], 500);
    }
}


    public function get_all_data()
    {
     // Ambil data dengan pagination (misal 10 per halaman)
    $forms = FormOpd::paginate(10);

    return FormOpdResource::collection($forms)
        ->additional([
            'success' => true,
            'message' => 'Data berhasil diambil'
        ]);
    }
}
















































?>