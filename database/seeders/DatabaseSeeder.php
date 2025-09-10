<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OpdSeeder::class,
            PeranSeeder::class,
            UserSeeder::class,
            PoinSeeder::class,
            SubKriteriaSeeder::class,
            KriteriaSeeder::class,
            StatusBeritaSeeder::class,
            StatusSeeder::class,
        ]);
    }
}