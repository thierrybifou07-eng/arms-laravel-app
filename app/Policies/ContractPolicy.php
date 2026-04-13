<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\Role;
use App\Models\User;

class ContractPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any contracts
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user) || $this->isTeller($user);
    }

    /**
     * Determine if user can view a specific contract
     */
    public function view(User $user, Contract $model): bool
    {
        // Super Admin, Admin, Staff, Teller can view all contracts
        if ($this->isStaff($user) || $this->isTeller($user)) {
            return true;
        }

        // Student can view their own contracts
        if ($user->hasRole(Role::STUDENT)) {
            return $user->id === $model->user_id;
        }

        return false;
    }

    /**
     * Determine if user can create a contract
     */
    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can update a contract
     */
    public function update(User $user, Contract $model): bool
    {
        // Cannot update expired or archived contracts
        if (in_array($model->status->code, ['expired', 'archived'])) {
            return false;
        }

        // Super Admin, Admin can update any contract
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Staff can update contracts
        if ($user->hasRole(Role::STAFF)) {
            return true;
        }

        // Student can only update their own contract
        if ($user->hasRole(Role::STUDENT)) {
            return $user->id === $model->user_id;
        }

        return false;
    }

    /**
     * Determine if user can delete a contract
     */
    public function delete(User $user, Contract $model): bool
    {
        return false; // Contracts are archived instead of deleted
    }

    /**
     * Determine if user can archive a contract
     */
    public function archive(User $user, Contract $model): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can restore a soft deleted contract
     */
    public function restore(User $user, Contract $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can permanently delete a contract
     */
    public function forceDelete(User $user, Contract $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can manage contract status
     */
    public function manageStatus(User $user, Contract $model): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view payment history for a contract
     */
    public function viewPaymentHistory(User $user, Contract $model): bool
    {
        // Staff, Teller can view payment history
        if ($this->isStaff($user) || $this->isTeller($user)) {
            return true;
        }

        // Student can view their own contract's payment history
        if ($user->hasRole(Role::STUDENT)) {
            return $user->id === $model->user_id;
        }

        return false;
    }
}
