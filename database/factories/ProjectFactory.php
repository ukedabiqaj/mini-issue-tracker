<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-3 months', 'now');
        $deadline = fake()->dateTimeBetween($startDate, '+6 months');

        return [
            'user_id' => User::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'start_date' => $startDate,
            'deadline' => $deadline,
        ];
    }
}
