<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DaySeeder extends Seeder
{
    public $days = ['mon' => 'monday', 'tue' => 'tuesday', 'wed' => 'wednesday', 'thur' => 'thursday', 'fri' => 'friday', 'sat' => 'saturday', 'sun' => 'sunday'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->days as $short => $day) {
            Day::create(['name' => $day, 'short' => $short]);
        }
    }
}