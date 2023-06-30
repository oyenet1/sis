<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Visitor::factory()->count(48)->create();
    }
}