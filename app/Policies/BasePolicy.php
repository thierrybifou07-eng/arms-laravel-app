<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

/**
 * Base Policy Trait - Contains common authorization logic for all policies
 * Organizes authorization methods by role hierarchy:
 * - super_admin: Full access to all actions
 * - admin: Full access to all actions
 * - staff: Can manage most resources (view, create, update)
 * - teller: Limited to payment-related operations
 * - student: View-only/limited to personal resources
 */
trait BasePolicy
{
    /**
     * Check if user is Super Admin or Admin
     */
    public function isSuperAdmin(User $user): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN) || $user->hasRole(Role::ADMIN);
    }

    /**
     * Check if user is Staff or above
     */
    public function isStaff(User $user): bool
    {
        return $user->hasRole(Role::STAFF) || $this->isSuperAdmin($user);
    }

    /**
     * Check if user is Teller or above
     */
    public function isTeller(User $user): bool
    {
        return $user->hasRole(Role::TELLER) || $this->isStaff($user);
    }

    /**
     * Check if user is a Student
     */
    public function isStudent(User $user): bool
    {
        return $user->hasRole(Role::STUDENT);
    }

    /**
     * Permission check via hasPermission method
     */
    public function hasPermission(User $user, string $permission): bool
    {
        return $user->hasPermission($permission);
    }
}
