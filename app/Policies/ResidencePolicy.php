<?php

namespace App\Policies;

use App\Models\Residence;
use App\Models\Role;
use App\Models\User;

class ResidencePolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any residences
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific residence
     */
    public function view(User $user, Residence $model): bool
    {
        // Super Admin, Admin, Staff can view all residences
        return $this->isStaff($user);
    }

    /**
     * Determine if user can create a residence
     */
    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can update a residence
     */
    public function update(User $user, Residence $model): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can delete a residence
     */
    public function delete(User $user, Residence $model): bool
    {
        // Only admin can delete (not super_admin)
        if (!$user->hasRole(Role::ADMIN)) {
            return false;
        }

        // Cannot delete residence with buildings/floors/rooms that have active contracts
        $activeContractId = \App\Models\ContractStatus::where('code', 'active')->value('id');
        $hasActiveContracts = $model->buildings()
            ->whereHas('floors.rooms.contracts', function ($q) use ($activeContractId) {
                $q->where('contract_status_id', $activeContractId);
            })
            ->exists();

        return !$hasActiveContracts;
    }

    /**
     * Determine if user can restore a soft deleted residence
     */
    public function restore(User $user, Residence $model): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if user can permanently delete a residence
     */
    public function forceDelete(User $user, Residence $model): bool
    {
        // Only admin can permanently delete (not super_admin)
        if (!$user->hasRole(Role::ADMIN)) {
            return false;
        }

        // Cannot delete residence with buildings/floors/rooms that have active contracts
        $activeContractId = \App\Models\ContractStatus::where('code', 'active')->value('id');
        $hasActiveContracts = $model->buildings()
            ->whereHas('floors.rooms.contracts', function ($q) use ($activeContractId) {
                $q->where('contract_status_id', $activeContractId);
            })
            ->exists();

        return !$hasActiveContracts;
    }

    /**
     * Determine if user can manage residence status
     */
    public function manageStatus(User $user, Residence $model): bool
    {
        return $this->isSuperAdmin($user);
    }
}
