<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notes>
 */
class NotesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'   => $this->faker->numberBetween(1, 2),
            'body'      => $this->faker->sentence(10), 
            'priority'  => $this->faker->randomElement(['low', 'medium', 'high'])
        ];
    }
}
