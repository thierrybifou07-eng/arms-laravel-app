<?php

namespace App\Policies;

use App\Models\ContractStatus;
use App\Models\User;

class ContractStatusPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any contract statuses
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific contract status
     */
    public function view(User $user, ContractStatus $model): bool
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
    public function update(User $user, ContractStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Status deletion should be restricted
     */
    public function delete(User $user, ContractStatus $model): bool
    {
        return false; // Prevent deletion of status types
    }

    /**
     * Determine if user can restore a soft deleted contract status
     */
    public function restore(User $user, ContractStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can permanently delete a contract status
     */
    public function forceDelete(User $user, ContractStatus $model): bool
    {
        return false; // Prevent permanent deletion of status types
    }
}
