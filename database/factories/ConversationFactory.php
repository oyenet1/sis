<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conversation>
 */
class ConversationFactory extends Factory
{
    public $status = [true, false];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sender_id' => random_int(1, 10),
            'user_two'  => 1,
            'status' => $this->status[array_rand($this->status)],
        ];
    }
}