<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('poins')->insert([
            [
                'id' => 'PN-001',
                'nilai_poin' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'PN-002',
                'nilai_poin' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'PN-003',
                'nilai_poin' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
