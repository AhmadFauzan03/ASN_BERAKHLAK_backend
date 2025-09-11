<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FormOpdKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriterias = [
            [
                'id'   => 'KR-001',
                'nama_kriteria' => 'Kriteria 1',
                'poin' => 2, // per item, ada 5 item
            ],
            [
                'id'   => 'KR-002',
                'nama_kriteria' => 'Kriteria 2',
                'poin' => 5, // per item, ada 2 item
            ],
            [
                'id'   => 'KR-003',
                'nama_kriteria' => 'Kriteria 3',
                'poin' => 2, // per item, ada 5 item
            ],
            [
                'id'   => 'KR-004',
                'nama_kriteria' => 'Kriteria 4',
                'poin' => 5, // per item, ada 4 item
            ],
            [
                'id'   => 'KR-005',
                'nama_kriteria' => 'Kriteria 5',
                'poin' => 30, // langsung 30 poin
            ],
            [
                'id'   => 'KR-006',
                'nama_kriteria' => 'Kriteria 6',
                'poin' => 5, // per item, ada 4 item
            ],
        ];

        foreach ($kriterias as $kriteria) {
            DB::table('form_opd_kriterias')->insert([
                'id'            => $kriteria['id'],
                'nama_kriteria' => $kriteria['nama_kriteria'],
                'poin'          => $kriteria['poin'],
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
