<?php

namespace App\Observers;

use App\Models\Residence;
use App\Models\Role;

class ResidenceObserver
{
    /**
     * Handle the Residence "created" event.
     * Automatically assign all admins to the new residence
     */
    public function created(Residence $residence): void
    {
        // Get all users with admin role
        $adminRole = Role::where('name', Role::ADMIN)->first();

        if (!$adminRole) {
            return;
        }

        $admins = $adminRole->users()->get();

        // Assign each admin to this residence
        foreach ($admins as $admin) {
            $residence->users()->attach($admin->id);
        }
    }
}
