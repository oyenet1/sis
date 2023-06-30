<?php

namespace Database\Seeders;

use App\Models\Guardian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guardian::create([
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
        ]);
    }
}