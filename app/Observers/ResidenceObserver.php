<?php

namespace App\Observers;

use App\Models\Residence;
use App\Models\Role;
use App\Models\User;

class ResidenceObserver
{
    /**
     * Handle the Residence "created" event.
     * Automatically assign all admins to the new residence
     */
    public function created(Residence $residence): void
    {
        User::query()
            ->whereHas('roles', fn ($query) => $query->where('name', Role::ADMIN))
            ->each(fn (User $admin) => $admin->residences()->syncWithoutDetaching([$residence->id]));
    }
}
