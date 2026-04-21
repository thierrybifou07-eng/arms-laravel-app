<?php

namespace App\Policies;

use App\Models\UserStatus;
use App\Models\User;

class UserStatusPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any user statuses
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific user status
     */
    public function view(User $user, UserStatus $model): bool
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
    public function update(User $user, UserStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Status deletion should be restricted
     */
    public function delete(User $user, UserStatus $model): bool
    {
        return false; // Prevent deletion of user status types
    }

    /**
     * Determine if user can restore a soft deleted user status
     */
    public function restore(User $user, UserStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can permanently delete a user status
     */
    public function forceDelete(User $user, UserStatus $model): bool
    {
        return false; // Prevent permanent deletion of user status types
    }
}
