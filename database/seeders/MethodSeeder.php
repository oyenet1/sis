<?php

namespace Database\Seeders;

use App\Models\Method;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MethodSeeder extends Seeder
{
    public ?array $methods = ['cash', 'bank deposit', 'card payment', 'transfer', 'cryptocurrency'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->methods as $value) {
            Method::create([
                'name' => $value
            ]);
        }
    }
}