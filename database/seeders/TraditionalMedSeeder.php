<?php

namespace Database\Seeders;

use App\Models\TraditionalMed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TraditionalMedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TraditionalMed::factory()->count(20)->create();
    }
}
