<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Agent;
use App\Models\Category;
use App\Models\Document;
use App\Models\Property;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        // Create 5 property categories
       $categories = collect([
    'House',
    'Apartment',
    'Commercial',
    'Villa',
    'Land',
])->map(fn ($name) => Category::firstOrCreate(
    ['name' => $name],
    ['description' => fake()->sentence()]
));

        // Create 5 real estate agents
        $agents = Agent::factory()->count(5)->create();
        // Create demo users and assign roles
$owner = User::firstOrCreate(
    ['email' => 'owner@urbannest.test'],
    [
        'name' => 'Demo Owner',
        'password' => 'password',
    ]
);

$owner->role()->associate(Role::where('name', 'Owner')->firstOrFail());
$owner->save();

$agentUser = User::firstOrCreate(
    ['email' => 'agent@urbannest.test'],
    [
        'name' => 'Demo Agent',
        'password' => 'password',
    ]
);

$agentUser->role()->associate(Role::where('name', 'Agent')->firstOrFail());
$agentUser->agent()->associate($agents->first());
$agentUser->save();

$staff = User::firstOrCreate(
    ['email' => 'staff@urbannest.test'],
    [
        'name' => 'Demo Staff',
        'password' => 'password',
    ]
);

$staff->role()->associate(Role::where('name', 'Staff')->firstOrFail());
$staff->save();

        // Create 20 properties using existing categories and agents
        $properties = Property::factory()
            ->count(20)
            ->state(fn () => [
                'category_id' => $categories->random()->id,
                'agent_id' => $agents->random()->id,
            ])
            ->create();

        // Create 30 documents for existing properties
       // Create 30 documents for existing properties
Document::factory()
    ->count(30)
    ->state(fn () => [
        'property_id' => $properties->random()->id,
    ])
    ->create();
            }
}