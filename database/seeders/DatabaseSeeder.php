<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with all demo data.
     * Run: php artisan db:seed
     */
    public function run()
    {
        $this->call([
            FullDemoSeeder::class,
        ]);
    }
}
