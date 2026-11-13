<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\Category;
use App\Models\Property;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithRole(string $roleName): User
    {
        $role = Role::firstOrCreate(['name' => $roleName]);

        $user = User::factory()->create();

        $user->role()->associate($role);

        if ($roleName === 'Agent') {
            $agent = Agent::factory()->create();
            $user->agent()->associate($agent);
        }

        $user->save();

        return $user;
    }

    private function createProperty(Agent $agent): Property
    {
        return Property::factory()->create([
            'agent_id' => $agent->id,
        ]);
    }

    private function propertyData(Agent $agent): array
    {
        return [
            'category_id' => Category::factory()->create()->id,
            'agent_id' => $agent->id,
            'title' => 'Test Property',
            'description' => 'Test property description',
            'price' => 500000,
            'location' => 'Islamabad',
            'status' => 'available',
        ];
    }

    public function test_owner_can_update_and_delete_another_agents_property(): void
    {
        $owner = $this->createUserWithRole('Owner');

        $agent = Agent::factory()->create();
        $property = $this->createProperty($agent);

        $this->actingAs($owner);

        $this->put(
            route('admin.properties.update', $property),
            $this->propertyData($agent)
        )->assertRedirect(route('admin.properties.show', $property));

        $this->delete(
            route('admin.properties.destroy', $property)
        )->assertRedirect(route('admin.properties.index'));

        $this->assertDatabaseMissing('properties', [
            'id' => $property->id,
        ]);
    }

    public function test_agent_can_update_own_property(): void
    {
        $agentUser = $this->createUserWithRole('Agent');
        $property = $this->createProperty($agentUser->agent);

        $this->actingAs($agentUser);

        $this->put(
            route('admin.properties.update', $property),
            $this->propertyData($agentUser->agent)
        )->assertRedirect(route('admin.properties.show', $property));

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'agent_id' => $agentUser->agent_id,
        ]);
    }

    public function test_agent_cannot_update_or_delete_another_agents_property(): void
    {
        $agentUser = $this->createUserWithRole('Agent');

        $otherAgent = Agent::factory()->create();
        $property = $this->createProperty($otherAgent);

        $this->actingAs($agentUser);

        $this->put(
            route('admin.properties.update', $property),
            $this->propertyData($otherAgent)
        )->assertForbidden();

        $this->delete(
            route('admin.properties.destroy', $property)
        )->assertForbidden();

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
        ]);
    }

    public function test_agent_cannot_assign_another_agents_id_when_creating_property(): void
    {
        $agentUser = $this->createUserWithRole('Agent');

        $otherAgent = Agent::factory()->create();

        $data = $this->propertyData($otherAgent);

        $this->actingAs($agentUser);

        $this->post(route('admin.properties.store'), $data)
            ->assertRedirect();

        $this->assertDatabaseHas('properties', [
            'title' => 'Test Property',
            'agent_id' => $agentUser->agent_id,
        ]);
    }

    public function test_agent_can_only_see_own_properties_in_listing(): void
    {
        $agentUser = $this->createUserWithRole('Agent');

        $ownProperty = $this->createProperty($agentUser->agent);

        $otherAgent = Agent::factory()->create();
        $otherProperty = $this->createProperty($otherAgent);

        $this->actingAs($agentUser);

        $response = $this->get(route('admin.properties.index'));

        $response->assertOk();
        $response->assertSee($ownProperty->title);
        $response->assertDontSee($otherProperty->title);
    }

    public function test_staff_can_view_properties_but_cannot_manage_them(): void
    {
        $staff = $this->createUserWithRole('Staff');

        $agent = Agent::factory()->create();
        $property = $this->createProperty($agent);

        $this->actingAs($staff);

        $this->get(route('admin.properties.index'))->assertOk();

        $this->get(route('admin.properties.show', $property))->assertOk();

        $this->get(route('admin.properties.create'))->assertForbidden();

        $this->put(
            route('admin.properties.update', $property),
            $this->propertyData($agent)
        )->assertForbidden();

        $this->delete(
            route('admin.properties.destroy', $property)
        )->assertForbidden();
    }

    public function test_owner_can_create_property(): void
    {
        $owner = $this->createUserWithRole('Owner');

        $agent = Agent::factory()->create();

        $this->actingAs($owner);

        $this->post(
            route('admin.properties.store'),
            $this->propertyData($agent)
        )->assertRedirect();

        $this->assertDatabaseHas('properties', [
            'title' => 'Test Property',
            'agent_id' => $agent->id,
        ]);
    }
}