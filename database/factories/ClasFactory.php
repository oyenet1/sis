<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clas>
 */
class ClasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public $names = ['1', '2', '3', '4', '5'];
    public $type = ['nusery', 'primary', 'creche'];
    public $high = ['', '', '', '', ''];
    public $section = ['a', 'b', 'c', 'd', 'e'];


    public function definition()
    {
        return [
            'name' => $this->names[array_rand($this->names)],
            'user_id' => random_int(1, 10),
            'school_id' => random_int(1, 5),
            'high' => $this->high[array_rand($this->high)],
            'section' => $this->section[array_rand($this->section)],
        ];
    }
}