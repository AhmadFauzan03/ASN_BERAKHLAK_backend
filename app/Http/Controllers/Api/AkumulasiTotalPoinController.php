<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AkumulasiTotalPoinController extends Controller
{
    public function index()
    {
        // Ambil semua data total poin (tanpa filter user)
        $rows = DB::table('total_poins as tp')
            ->join('users as u', 'tp.id_user', '=', 'u.id')
            ->join('opds as o', 'u.id_opd', '=', 'o.id')
            ->select(
                'o.nama_opd as opd', // ✅ perbaikan kolom
                'tp.id_user',
                DB::raw("DATE_FORMAT(tp.created_at, '%Y-%m') as bulan"),
                DB::raw("SUM(tp.total_poin) as total_poin")
            )
            ->groupBy('o.nama_opd', 'tp.id_user', 'bulan')
            ->orderBy('o.nama_opd')
            ->orderBy('bulan')
            ->get();

        // Kelompokkan berdasarkan user/OPD
        $grouped = $rows->groupBy('id_user')->map(function ($items) {
            return [
                'opd' => $items->first()->opd,
                'id_user' => $items->first()->id_user,
                'total_semua_bulan' => $items->sum('total_poin'),
                'per_bulan' => $items->map(function ($item) {
                    return [
                        'bulan' => $item->bulan,
                        'total_poin' => $item->total_poin,
                    ];
                })->values()
            ];
        });

        // Return dalam bentuk array of object
        return response()->json($grouped->values()->all());
    }
}
