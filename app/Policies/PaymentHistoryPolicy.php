<?php

namespace App\Policies;

use App\Models\PaymentHistory;
use App\Models\Role;
use App\Models\User;

class PaymentHistoryPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any payment histories
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user) || $this->isTeller($user);
    }

    /**
     * Determine if user can view a specific payment history
     */
    public function view(User $user, PaymentHistory $model): bool
    {
        // Super Admin, Admin, Staff, Teller can view all payment histories
        if ($this->isStaff($user) || $this->isTeller($user)) {
            return true;
        }

        // Student can view their own payment histories
        if ($user->hasRole(Role::STUDENT)) {
            return $user->id === $model->payment->contract->user_id;
        }

        return false;
    }

    /**
     * Determine if user can create a payment history record
     * (Typically auto-created, but might be needed for manual logs)
     */
    public function create(User $user): bool
    {
        return $this->isTeller($user) || $this->isStaff($user);
    }

    /**
     * Determine if user can update payment history
     * (Typically not allowed, but provided for admin override)
     */
    public function update(User $user, PaymentHistory $model): bool
    {
        // Only Super Admin can update payment history
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can delete payment history
     */
    public function delete(User $user, PaymentHistory $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can restore a soft deleted payment history
     */
    public function restore(User $user, PaymentHistory $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can permanently delete payment history
     */
    public function forceDelete(User $user, PaymentHistory $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can export payment history
     */
    public function export(User $user): bool
    {
        return $this->isStaff($user);
    }
}
