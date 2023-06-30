<?php

namespace Database\Seeders;

use App\Models\Leave;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public $status = ['awaiting approval', 'accepted', 'denied'];
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            Leave::create([
                'user_id' => 1,
                'message' => $faker->sentence(3),
                'status' => $this->status[array_rand($this->status)]
            ]);
        }
    }
}