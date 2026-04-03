<?php

namespace App\Policies;

use App\Models\BillingPeriod;
use App\Models\Role;
use App\Models\User;

class BillingPeriodPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any billing periods
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user) || $this->isTeller($user);
    }

    /**
     * Determine if user can view a specific billing period
     */
    public function view(User $user, BillingPeriod $model): bool
    {
        // Super Admin, Admin, Staff, Teller can view all billing periods
        if ($this->isStaff($user) || $this->isTeller($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can create a billing period
     */
    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can update a billing period
     */
    public function update(User $user, BillingPeriod $model): bool
    {
        // Super Admin, Admin can update
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Staff can update billing periods
        if ($user->hasRole(Role::STAFF)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can delete a billing period
     */
    public function delete(User $user, BillingPeriod $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can restore a soft deleted billing period
     */
    public function restore(User $user, BillingPeriod $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can permanently delete a billing period
     */
    public function forceDelete(User $user, BillingPeriod $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can activate a billing period
     */
    public function activate(User $user, BillingPeriod $model): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can close/deactivate a billing period
     */
    public function close(User $user, BillingPeriod $model): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can generate billing for a period
     */
    public function generateBilling(User $user, BillingPeriod $model): bool
    {
        return $this->isStaff($user);
    }
}
