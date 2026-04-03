<?php

namespace App\Policies;

use App\Models\PaymentStatus;
use App\Models\User;

class PaymentStatusPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any payment statuses
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user) || $this->isTeller($user);
    }

    /**
     * Determine if user can view a specific payment status
     */
    public function view(User $user, PaymentStatus $model): bool
    {
        return $this->isStaff($user) || $this->isTeller($user);
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
    public function update(User $user, PaymentStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Status deletion should be restricted
     */
    public function delete(User $user, PaymentStatus $model): bool
    {
        return false; // Prevent deletion of status types
    }

    /**
     * Determine if user can restore a soft deleted payment status
     */
    public function restore(User $user, PaymentStatus $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can permanently delete a payment status
     */
    public function forceDelete(User $user, PaymentStatus $model): bool
    {
        return false; // Prevent permanent deletion of status types
    }
}
