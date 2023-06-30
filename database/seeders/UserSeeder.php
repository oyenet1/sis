<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    // public $admin = [
    //     'title' => 'Mr',
    //     'first_name' => 'IMRAN',
    //     'last_name' => 'UMAR ABDULLAHI',
    //     'email' => 'amimra2k6@yahoo.com',
    //     'phone' => '8062528580',
    //     'password' => bcrypt('accekano')
    // ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superadmin = User::create([
            'title' => 'Mr',
            'first_name' => 'Bowofade',
            'last_name' => 'Oyerinde',
            'email' => 'contact@bowofade.com',
            'phone' => '7065720177',
            'password' => bcrypt('JOS/eph/96')
        ]);
        $admin = User::create([
            'title' => 'Mr',
            'first_name' => 'IMRAN',
            'last_name' => 'UMAR ABDULLAHI',
            'email' => 'amimra2k6@yahoo.com',
            'phone' => '8062528580',
            'password' => bcrypt('accekano')
        ]);

        $superadmin->attachRole(1);
        $admin->attachRole(2);
    }
}