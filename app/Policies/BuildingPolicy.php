<?php

namespace App\Policies;

use App\Models\Building;
use App\Models\Role;
use App\Models\User;

class BuildingPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any buildings
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific building
     */
    public function view(User $user, Building $model): bool
    {
        // Super Admin, Admin, Staff can view all buildings
        if ($this->isStaff($user)) {
            return true;
        }

        // Teller can view buildings
        if ($this->isTeller($user)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can create a building
     */
    public function create(User $user): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can update a building
     */
    public function update(User $user, Building $model): bool
    {
        // Super Admin, Admin can update
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Staff can update buildings
        if ($user->hasRole(Role::STAFF)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can delete a building
     */
    public function delete(User $user, Building $model): bool
    {
        // Only admin can delete (not super_admin)
        if (!$user->hasRole(Role::ADMIN)) {
            return false;
        }

        // Cannot delete building with floors/rooms that have active contracts
        $activeContractId = \App\Models\ContractStatus::where('code', 'active')->value('id');
        $hasActiveContracts = $model->floors()
            ->whereHas('rooms.contracts', function ($q) use ($activeContractId) {
                $q->where('contract_status_id', $activeContractId);
            })
            ->exists();

        return !$hasActiveContracts;
    }

    /**
     * Determine if user can restore a soft deleted building
     */
    public function restore(User $user, Building $model): bool
    {
        return $user->hasRole(Role::ADMIN);
    }

    /**
     * Determine if user can permanently delete a building
     */
    public function forceDelete(User $user, Building $model): bool
    {
        // Only admin can permanently delete (not super_admin)
        if (!$user->hasRole(Role::ADMIN)) {
            return false;
        }

        // Cannot delete building with floors/rooms that have active contracts
        $activeContractId = \App\Models\ContractStatus::where('code', 'active')->value('id');
        $hasActiveContracts = $model->floors()
            ->whereHas('rooms.contracts', function ($q) use ($activeContractId) {
                $q->where('contract_status_id', $activeContractId);
            })
            ->exists();

        return !$hasActiveContracts;
    }

    /**
     * Determine if user can manage building status
     */
    public function manageStatus(User $user, Building $model): bool
    {
        return $this->isSuperAdmin($user) || $user->hasRole(Role::STAFF);
    }
}
