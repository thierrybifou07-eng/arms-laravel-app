<?php

namespace App\Policies;

use App\Models\Audit;
use App\Models\Role;
use App\Models\User;

class AuditPolicy
{
    use BasePolicy;

    /**
     * Determine whether the user can view any audits.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine whether the user can view the audit.
     */
    public function view(User $user, Audit $audit): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine whether the user can delete the audit.
     */
    public function delete(User $user, Audit $audit): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine whether the user can delete multiple audits.
     */
    public function deleteMultiple(User $user): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine whether the user can export audits.
     */
    public function export(User $user): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine whether the user can restore an audit.
     */
    public function restore(User $user, Audit $audit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete an audit.
     */
    public function forceDelete(User $user, Audit $audit): bool
    {
        return false;
    }
}
