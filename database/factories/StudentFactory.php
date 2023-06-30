<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    public $sex = ['male', 'female'];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'guardian_id' => random_int(1, 3),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'clas_id' => random_int(1, 18),
            'dob' =>     fake()->date(),
            'gender' => $this->sex[array_rand($this->sex)]
        ];
    }
}