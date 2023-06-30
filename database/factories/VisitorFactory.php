<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'purpose' => 'This is a test visits form parent',
            'entered_at' => Carbon::now()->subHours(random_int(1, 100)),
            'left_at' => Carbon::now()->subMinutes(random_int(2, 50)),
            'created_at' => Carbon::now()->subDays(random_int(1, 100)),
        ];
    }
}