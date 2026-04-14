<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\Role;
use App\Models\User;

class PaymentPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any payments
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific payment
     */
    public function view(User $user, Payment $model): bool
    {
        // Super Admin, Admin, Staff can view all payments
        if ($this->isStaff($user)) {
            return true;
        }

        // Student can view their own payments
        if ($user->hasRole(Role::STUDENT)) {
            return $user->id === $model->contract->user_id;
        }

        return false;
    }

    /**
     * Determine if user can create a payment
     */
    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can update a payment
     */
    public function update(User $user, Payment $model): bool
    {
        // Super Admin, Admin can update any payment
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Staff can update payments
        if ($this->isStaff($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can delete a payment
     */
    public function delete(User $user, Payment $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can restore a soft deleted payment
     */
    public function restore(User $user, Payment $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can permanently delete a payment
     */
    public function forceDelete(User $user, Payment $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }

    /**
     * Determine if user can validate/confirm a payment
     */
    public function validatePayment(User $user, Payment $model): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can cancel a payment
     */
    public function cancelPayment(User $user, Payment $model): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can process a payment (record payment made)
     */
    public function processPayment(User $user, Payment $model): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can manage payment status
     */
    public function manageStatus(User $user, Payment $model): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can check if payment is overdue
     */
    public function checkOverdue(User $user, Payment $model): bool
    {
        return $this->isStaff($user);
    }
}
