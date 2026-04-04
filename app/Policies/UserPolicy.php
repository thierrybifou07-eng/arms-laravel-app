<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class UserPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any users
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific user
     */
    public function view(User $user, User $model): bool
    {
        // Super Admin and Admin can view anyone
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Staff can view any user
        if ($user->hasRole(Role::STAFF)) {
            return true;
        }

        // Users can view themselves
        return $user->id === $model->id;
    }

    /**
     * Determine if user can create a user
     */
    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can update a user
     */
    public function update(User $user, User $model): bool
    {
        // Super Admin and Admin can update anyone
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Users can only update their own profile
        return $user->id === $model->id;
    }

    /**
     * Determine if user can delete a user
     */
    public function delete(User $user, User $model): bool
    {
        // Only Super Admin can delete users
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can restore a soft deleted user
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can permanently delete a user
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can manage roles/permissions
     */
    public function manageRoles(User $user, User $model): bool
    {
        // Only Super Admin can manage user roles
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can manage user status
     */
    public function manageStatus(User $user, User $model): bool
    {
        return $this->isSuperAdmin($user);
    }
}
