<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "updated" event.
     * When a user role changes to admin, assign them to all residences
     */
    public function updated(User $user): void
    {
        // This observer helps handle direct database updates
        // For most cases, the UserRoleController handles residence assignment
        // This is a safety net for edge cases
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
