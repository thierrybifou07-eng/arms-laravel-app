<?php

namespace App\Policies;

use App\Models\ResidenceStatus;
use App\Models\User;

class ResidenceStatusPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any residence statuses
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific residence status
     */
    public function view(User $user, ResidenceStatus $model): bool
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
    public function update(User $user, ResidenceStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Status deletion should be restricted
     */
    public function delete(User $user, ResidenceStatus $model): bool
    {
        return false; // Prevent deletion of status types
    }

    /**
     * Determine if user can restore a soft deleted residence status
     */
    public function restore(User $user, ResidenceStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can permanently delete a residence status
     */
    public function forceDelete(User $user, ResidenceStatus $model): bool
    {
        return false; // Prevent permanent deletion of status types
    }
}
