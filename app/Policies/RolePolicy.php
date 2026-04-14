<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any roles
     * Only super admin can manage roles
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can view a specific role
     */
    public function view(User $user, Role $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can create a role
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can update a role
     */
    public function update(User $user, Role $model): bool
    {
        // Prevent modification of core system roles
        $systemRoles = [Role::SUPER_ADMIN, Role::ADMIN, Role::STAFF, Role::STUDENT];
        
        if (in_array($model->name, $systemRoles)) {
            return false;
        }

        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can delete a role
     */
    public function delete(User $user, Role $model): bool
    {
        // Prevent deletion of core system roles
        $systemRoles = [Role::SUPER_ADMIN, Role::ADMIN, Role::STAFF, Role::STUDENT];
        
        if (in_array($model->name, $systemRoles)) {
            return false;
        }

        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can restore a soft deleted role
     */
    public function restore(User $user, Role $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can permanently delete a role
     */
    public function forceDelete(User $user, Role $model): bool
    {
        $systemRoles = [Role::SUPER_ADMIN, Role::ADMIN, Role::STAFF, Role::STUDENT];
        
        if (in_array($model->name, $systemRoles)) {
            return false;
        }

        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can manage permissions for a role
     */
    public function managePermissions(User $user, Role $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can assign role to users
     */
    public function assignToUsers(User $user, Role $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }
}
