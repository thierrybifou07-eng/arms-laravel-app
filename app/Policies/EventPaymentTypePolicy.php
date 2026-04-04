<?php

namespace App\Policies;

use App\Models\EventPaymentType;
use App\Models\User;

class EventPaymentTypePolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any event payment types
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific event payment type
     */
    public function view(User $user, EventPaymentType $model): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Event payment type creation restricted to admin
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Event payment type updates restricted to admin
     */
    public function update(User $user, EventPaymentType $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Event payment type deletion restricted
     */
    public function delete(User $user, EventPaymentType $model): bool
    {
        return false; // Prevent deletion of event payment types
    }

    /**
     * Determine if user can restore a soft deleted event payment type
     */
    public function restore(User $user, EventPaymentType $model): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Determine if user can permanently delete an event payment type
     */
    public function forceDelete(User $user, EventPaymentType $model): bool
    {
        return false; // Prevent permanent deletion of event payment types
    }
}
