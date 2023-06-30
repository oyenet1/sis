<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    public $status = [false, true];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => random_int(1, 10),
            'conversation_id' => random_int(1, 100),
            'message' => $this->faker->realText(random_int(10, 100)),
            'is_seen' => $this->status[array_rand($this->status)],
        ];
    }
}