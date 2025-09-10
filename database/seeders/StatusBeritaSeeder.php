<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatusBeritaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('status_beritas')->insert([
            [
                'id'             => 'STBT-001',
                'status_berita'  => 'Publish',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 'STBT-002',
                'status_berita'  => 'Draft',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 'STBT-003',
                'status_berita'  => 'Dibatalkan',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);
    }
}
