<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('perans')->insert([
            [
                'id' => 'PRN-001',
                'peran_user' => 'super admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'PRN-002',
                'peran_user' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'PRN-003',
                'peran_user' => 'tim verifikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'PRN-004',
                'peran_user' => 'pengguna opd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
