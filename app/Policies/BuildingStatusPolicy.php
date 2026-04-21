<?php

namespace App\Policies;

use App\Models\BuildingStatus;
use App\Models\User;

class BuildingStatusPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any building statuses
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific building status
     */
    public function view(User $user, BuildingStatus $model): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Status creation is typically system-managed, but admin can create
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Status updates should be restricted
     */
    public function update(User $user, BuildingStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Status deletion should be restricted
     */
    public function delete(User $user, BuildingStatus $model): bool
    {
        return false; // Prevent deletion of status types
    }

    /**
     * Determine if user can restore a soft deleted building status
     */
    public function restore(User $user, BuildingStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can permanently delete a building status
     */
    public function forceDelete(User $user, BuildingStatus $model): bool
    {
        return false; // Prevent permanent deletion of status types
    }
}
