<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Room;
use App\Models\User;

class RoomPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any rooms
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific room
     */
    public function view(User $user, Room $model): bool
    {
        // Super Admin, Admin, Staff can view all rooms
        if ($this->isStaff($user)) {
            return true;
        }

        // Teller can view rooms
        if ($this->isTeller($user)) {
            return true;
        }

        // Students can view rooms they're interested in
        if ($user->hasRole(Role::STUDENT)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can create a room
     */
    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can update a room
     */
    public function update(User $user, Room $model): bool
    {
        // Super Admin, Admin can update
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Staff can update rooms
        if ($user->hasRole(Role::STAFF)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can delete a room
     */
    public function delete(User $user, Room $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can restore a soft deleted room
     */
    public function restore(User $user, Room $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can permanently delete a room
     */
    public function forceDelete(User $user, Room $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can manage room status
     */
    public function manageStatus(User $user, Room $model): bool
    {
        return $this->isSuperAdmin($user) || $user->hasRole(Role::STAFF);
    }
}
