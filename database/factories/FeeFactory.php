<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fee>
 */
class FeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public $types = ['tuition', 'development fees', 'sport fees'];
    public function definition()
    {
        return [
            'clas_id' => random_int(1, 3),
            'term_id' => random_int(1, 3),
            'type' => $this->types[array_rand($this->types)],
            'amount' => doubleval(random_int(10000, 300000)),
        ];
    }
}