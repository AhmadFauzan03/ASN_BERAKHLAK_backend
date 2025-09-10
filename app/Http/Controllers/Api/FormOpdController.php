<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormOpd;
use App\Models\FormOpdKriteria;
use App\Models\FormOpdKriteriaDetail;
use App\Http\Resources\FormOpdResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormOpdController extends Controller
{
    public function index() {
        return FormOpdResource::collection(FormOpd::with('kriterias.details')->get());
    }

    public function store(Request $request) {
        $request->validate([
            'id_user' => 'required|string',
            'id_status' => 'required|string',
            'kriterias' => 'required|array',
        ]);

        $formOpd = DB::transaction(function () use ($request) {
            $formOpd = FormOpd::create($request->only(['id_user','id_status','keterangan']));

            foreach ($request->kriterias as $kriteriaReq) {
                $kriteria = FormOpdKriteria::create([
                    'form_opd_id' => $formOpd->id,
                    'nama_kriteria' => $kriteriaReq['nama_kriteria'],
                ]);

                foreach ($kriteriaReq['details'] as $detailReq) {
                    FormOpdKriteriaDetail::create([
                        'form_opd_kriteria_id' => $kriteria->id,
                        'nilai_poin' => $detailReq['nilai_poin'] ?? 0,
                        'gambar' => $detailReq['gambar'] ?? null,
                        'link_video' => $detailReq['link_video'] ?? null,
                    ]);
                }
            }

            return $formOpd;
        });

        return new FormOpdResource($formOpd->load('kriterias.details'));
    }

    public function update(Request $request, $id) {
        $formOpd = FormOpd::with('kriterias.details')->findOrFail($id);

        $formOpd->update($request->only(['id_user','id_status','keterangan']));

        foreach ($request->kriterias as $kriteriaReq) {
            $kriteria = $formOpd->kriterias()->updateOrCreate(
                ['id' => $kriteriaReq['id'] ?? null],
                ['nama_kriteria' => $kriteriaReq['nama_kriteria']]
            );

            foreach ($kriteriaReq['details'] as $detailReq) {
                $kriteria->details()->updateOrCreate(
                    ['id' => $detailReq['id'] ?? null],
                    [
                        'nilai_poin' => $detailReq['nilai_poin'],
                        'gambar' => $detailReq['gambar'] ?? null,
                        'link_video' => $detailReq['link_video'] ?? null,
                    ]
                );
            }
        }

        return new FormOpdResource($formOpd->fresh('kriterias.details'));
    }

    public function destroy($id) {
        $formOpd = FormOpd::findOrFail($id);
        $formOpd->delete();

        return response()->json(['message' => 'Form OPD deleted']);
    }
}















































?>