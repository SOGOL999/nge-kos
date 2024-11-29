<?php

namespace Database\Seeders;

use App\Models\Rekening;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Rekening::create([
            'rekening' => 
            "
            BRI : 001237612768,
            BNI : 001298623406,
            MANDIRI : 001976142906,
            GOPAY : 0857871524128,
            DANA : 08578719843,
            OVO : 0857563240912,
            ",
        ]);
    }
}
