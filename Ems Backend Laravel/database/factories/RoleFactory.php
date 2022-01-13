<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role' => $this->faker->randomElement(['supervisor', 'member']),
            'designation' => $this->faker->jobTitle(),
            'department' => $this->faker->randomElement(['technology', 'business team', 'scm', 'store house']),
        ];
    }
}
