<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public ?array $schools = ['ely' => 'early years', 'pry' => 'primary', 'jss' => 'junior secondary', 'sss' => 'senior secondary'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->schools as $key => $value) {
            School::create([
                'name' => $value,
                'short' => $key
            ]);
        }
    }
}