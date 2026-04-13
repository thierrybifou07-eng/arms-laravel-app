<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;

class PermissionPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any permissions
     * Only super admin can manage permissions
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can view a specific permission
     */
    public function view(User $user, Permission $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can create a permission
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can update a permission
     */
    public function update(User $user, Permission $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can delete a permission
     */
    public function delete(User $user, Permission $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can restore a soft deleted permission
     */
    public function restore(User $user, Permission $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can permanently delete a permission
     */
    public function forceDelete(User $user, Permission $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can assign permission to roles
     */
    public function assignToRoles(User $user, Permission $model): bool
    {
        return $user->hasRole('super_admin');
    }
}
