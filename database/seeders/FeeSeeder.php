<?php

namespace Database\Seeders;

use App\Models\Fee;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fee::factory()->count(5)->create();
    }
}