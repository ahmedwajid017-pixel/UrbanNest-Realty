<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'original_name' => fake()->word() . '.pdf',
            'file_path' => 'documents/' . fake()->uuid() . '.pdf',
            'file_type' => 'application/pdf',
        ];
    }
}