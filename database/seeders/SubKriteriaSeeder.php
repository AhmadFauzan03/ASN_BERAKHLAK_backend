<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_kriterias')->insert([
            [
                'id' => 'SUB-001',
                'sub_kriteria' => 'kriteria 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'SUB-002',
                'sub_kriteria' => 'kriteria 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'SUB-003',
                'sub_kriteria' => 'kriteria 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'SUB-004',
                'sub_kriteria' => 'kriteria 4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'SUB-005',
                'sub_kriteria' => 'kriteria 5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'SUB-006',
                'sub_kriteria' => 'kriteria 6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
