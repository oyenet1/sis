<?php

namespace Database\Seeders;

use App\Models\Clas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasSeeder extends Seeder
{
    public $school = array(
        ['name' => 'reception', 'user_id' => null, 'school_id' => 1],
        ['name' => 'nursery 1', 'user_id' => null, 'school_id' => 1],
        ['name' => 'nursery 2', 'user_id' => null, 'school_id' => 1],
        ['name' => 'year 1', 'user_id' => null, 'school_id' => 2],
        ['name' => 'year 2', 'user_id' => null, 'school_id' => 2],
        ['name' => 'year 3', 'user_id' => null, 'school_id' => 2],
        ['name' => 'year 4', 'user_id' => null, 'school_id' => 2],
        ['name' => 'year 5', 'user_id' => null, 'school_id' => 2],
        ['name' => 'year 6', 'user_id' => null, 'school_id' => 2],
        ['name' => 'year 7', 'user_id' => null, 'school_id' => 3],
        ['name' => 'year 8', 'user_id' => null, 'school_id' => 3],
        ['name' => 'year 9', 'user_id' => null, 'school_id' => 3],
        ['name' => 'year 10', 'user_id' => null, 'school_id' => 4, 'high' => 'science', 'section' => 'a'],
        ['name' => 'year 10', 'user_id' => null, 'school_id' => 4, 'high' => 'commercial', 'section' => 'b'],
        ['name' => 'year 10', 'user_id' => null, 'school_id' => 4, 'high' => 'art', 'section' => 'c'],
        ['name' => 'year 11', 'user_id' => null, 'school_id' => 4, 'high' => 'science', 'section' => 'a'],
        ['name' => 'year 11', 'user_id' => null, 'school_id' => 4, 'high' => 'commercial', 'section' => 'b'],
        ['name' => 'year 11', 'user_id' => null, 'school_id' => 4, 'high' => 'art', 'section' => 'c'],
    );


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->school as $school) {
            Clas::create($school);
        }
    }
}