<?php

namespace App\Policies;

use App\Models\AuditLog;
use App\Models\User;

class AuditLogPolicy
{
    /**
     * Determine whether the user can view any audit logs
     */
    public function viewAny(User $user): bool
    {
        // Only super_admin can view audit logs
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can view an audit log
     */
    public function view(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can delete an audit log
     */
    public function delete(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine whether the user can delete all audit logs
     */
    public function deleteAll(User $user): bool
    {
        return $user->hasRole('super_admin');
    }
}
