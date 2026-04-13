<?php

namespace App\Policies;

use App\Models\PaymentMethod;
use App\Models\User;

class PaymentMethodPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any payment methods
     */
    public function viewAny(User $user): bool
    {
        return $this->isTeller($user);
    }

    /**
     * Determine if user can view a specific payment method
     */
    public function view(User $user, PaymentMethod $model): bool
    {
        return $this->isTeller($user);
    }

    /**
     * Payment method creation restricted to admin
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Payment method updates restricted to admin
     */
    public function update(User $user, PaymentMethod $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Payment method deletion restricted
     */
    public function delete(User $user, PaymentMethod $model): bool
    {
        return false; // Prevent deletion of payment methods
    }

    /**
     * Determine if user can restore a soft deleted payment method
     */
    public function restore(User $user, PaymentMethod $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can permanently delete a payment method
     */
    public function forceDelete(User $user, PaymentMethod $model): bool
    {
        return false; // Prevent permanent deletion of payment methods
    }
}
