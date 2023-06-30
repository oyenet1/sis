<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TermSeeder extends Seeder
{
    public ?array $terms = ['first', 'second', 'third'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Term::create([
                'sesion_id' => random_int(1, 6),
                'name' => $this->terms[(array_rand($this->terms))],
                'start' => now(),
                'end' => now(),
            ]);
        }
    }
}