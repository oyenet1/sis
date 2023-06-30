<?php

namespace Database\Seeders;

use App\Models\Sesion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SesionSeeder extends Seeder
{
    use WithoutModelEvents;
    public $year = 2010;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 25; $i++) {
            if ($this->year == date('Y')) {
                break;
            }
            Sesion::create([
                'name' => $this->year . '/' . $this->year + $i,
                'start' => Carbon::now(),
                'end' => Carbon::now(),
            ]);
            $this->year += $i;
        }
    }
}