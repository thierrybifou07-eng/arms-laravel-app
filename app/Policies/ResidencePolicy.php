<?php

namespace App\Policies;

use App\Models\Residence;
use App\Models\Role;
use App\Models\User;

class ResidencePolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any residences
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific residence
     */
    public function view(User $user, Residence $model): bool
    {
        // Super Admin, Admin, Staff can view all residences
        if ($this->isStaff($user)) {
            return true;
        }

        // Teller can view residences
        if ($this->isTeller($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can create a residence
     */
    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can update a residence
     */
    public function update(User $user, Residence $model): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can delete a residence
     */
    public function delete(User $user, Residence $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can restore a soft deleted residence
     */
    public function restore(User $user, Residence $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can permanently delete a residence
     */
    public function forceDelete(User $user, Residence $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can manage residence status
     */
    public function manageStatus(User $user, Residence $model): bool
    {
        return $this->isSuperAdmin($user);
    }
}
