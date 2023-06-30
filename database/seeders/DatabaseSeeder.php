<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LaratrustSeeder::class,
            UserSeeder::class,
                // GuardianSeeder::class,
                // VisitorSeeder::class,
            MethodSeeder::class, //not tobe remove in production
            DaySeeder::class, //not tobe remove in production
            SchoolSeeder::class, //not tobe remove in production
                // DepartmentSeeder::class, //not tobe remove in production
                // ConversationSeeder::class,
                // ChatSeeder::class,
                // LeaveSeeder::class,
            ClasSeeder::class,
            // SesionSeeder::class,
            // TermSeeder::class,
            // FeeSeeder::class,
            // StudentSeeder::class,
        ]);
    }
}