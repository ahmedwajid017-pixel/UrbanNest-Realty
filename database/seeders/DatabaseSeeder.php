<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Document;
use App\Models\Property;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 property categories
        $categories = Category::factory()->count(5)->create();

        // Create 5 real estate agents
        $agents = Agent::factory()->count(5)->create();

        // Create 20 properties using existing categories and agents
        $properties = Property::factory()
            ->count(20)
            ->state(fn () => [
                'category_id' => $categories->random()->id,
                'agent_id' => $agents->random()->id,
            ])
            ->create();

        // Create 30 documents for existing properties
        Document::factory()
            ->count(30)
            ->state(fn () => [
                'property_id' => $properties->random()->id,
            ])
            ->create();
    }
}