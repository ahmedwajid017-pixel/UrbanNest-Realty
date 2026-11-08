<?php

namespace Database\Factories;

use App\Models\Agent;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'agent_id' => Agent::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 50000, 2000000),
            'location' => fake()->city(),
            'status' => fake()->randomElement([
                'available',
                'sold',
                'rented',
            ]),
        ];
    }
}