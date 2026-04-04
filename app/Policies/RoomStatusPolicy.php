<?php

namespace App\Policies;

use App\Models\RoomStatus;
use App\Models\User;

class RoomStatusPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any room statuses
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific room status
     */
    public function view(User $user, RoomStatus $model): bool
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
    public function update(User $user, RoomStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Status deletion should be restricted
     */
    public function delete(User $user, RoomStatus $model): bool
    {
        return false; // Prevent deletion of status types
    }

    /**
     * Determine if user can restore a soft deleted room status
     */
    public function restore(User $user, RoomStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can permanently delete a room status
     */
    public function forceDelete(User $user, RoomStatus $model): bool
    {
        return false; // Prevent permanent deletion of status types
    }
}
