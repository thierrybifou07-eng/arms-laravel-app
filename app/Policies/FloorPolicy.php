<?php

namespace App\Policies;

use App\Models\Floor;
use App\Models\Role;
use App\Models\User;

class FloorPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any floors
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific floor
     */
    public function view(User $user, Floor $model): bool
    {
        // Super Admin, Admin, Staff can view all floors
        if ($this->isStaff($user)) {
            return true;
        }

        // Teller can view floors
        if ($this->isTeller($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can create a floor
     */
    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can update a floor
     */
    public function update(User $user, Floor $model): bool
    {
        // Super Admin, Admin can update
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Staff can update floors
        if ($user->hasRole(Role::STAFF)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can delete a floor
     */
    public function delete(User $user, Floor $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can restore a soft deleted floor
     */
    public function restore(User $user, Floor $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can permanently delete a floor
     */
    public function forceDelete(User $user, Floor $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can manage floor status
     */
    public function manageStatus(User $user, Floor $model): bool
    {
        return $this->isSuperAdmin($user) || $user->hasRole(Role::STAFF);
    }
}
