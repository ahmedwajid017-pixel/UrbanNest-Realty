<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role?->name, ['Owner', 'Agent', 'Staff']);
    }

    public function view(User $user, Property $property): bool
    {
        if ($user->role?->name === 'Owner' ||
            $user->role?->name === 'Staff') {
            return true;
        }

        return $user->role?->name === 'Agent'
            && $user->agent_id === $property->agent_id;
    }

    public function create(User $user): bool
{
    return $user->role?->name === 'Owner'
        || (
            $user->role?->name === 'Agent'
            && $user->agent_id !== null
        );
}

    public function update(User $user, Property $property): bool
    {
        return $user->role?->name === 'Owner'
            || (
                $user->role?->name === 'Agent'
                && $user->agent_id === $property->agent_id
            );
    }

    public function delete(User $user, Property $property): bool
    {
        return $this->update($user, $property);
    }
}