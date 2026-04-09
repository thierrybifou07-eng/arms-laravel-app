<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

/**
 * User Service - Handles user management and authentication
 */
class UserService
{
    /**
     * Create a new user
     */
    public function createUser(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    /**
     * Update a user
     */
    public function updateUser(User $user, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user;
    }

    /**
     * Assign role to user
     */
    public function assignRole(User $user, string $role): void
    {
        $user->roles()->sync([\App\Models\Role::where('name', $role)->value('id')]);
    }

    /**
     * Assign multiple roles to user
     */
    public function assignRoles(User $user, array $roles): void
    {
        $roleIds = \App\Models\Role::whereIn('name', $roles)->pluck('id')->toArray();
        $user->roles()->sync($roleIds);
    }

    /**
     * Remove role from user
     */
    public function removeRole(User $user, string $role): void
    {
        $roleId = \App\Models\Role::where('name', $role)->value('id');
        $user->roles()->detach($roleId);
    }

    /**
     * Check if user has role
     */
    public function hasRole(User $user, string $role): bool
    {
        return $user->hasRole($role);
    }

    /**
     * Get all users with a specific role
     */
    public function getUsersByRole(string $role): Collection
    {
        return User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();
    }

    /**
     * Get active users (verified)
     */
    public function getActiveUsers(): Collection
    {
        return User::where('email_verified_at', '!=', null)->get();
    }

    /**
     * Get pending users (not verified)
     */
    public function getPendingUsers(): Collection
    {
        return User::where('email_verified_at', '=', null)->get();
    }

    /**
     * Deactivate user
     */
    public function deactivateUser(User $user): User
    {
        $inactiveStatus = \App\Models\UserStatus::where('code', 'disabled')->first();
        $user->update(['user_status_id' => $inactiveStatus->id]);
        return $user;
    }

    /**
     * Activate user
     */
    public function activateUser(User $user): User
    {
        $activeStatus = \App\Models\UserStatus::where('code', 'active')->first();
        $user->update([
            'user_status_id' => $activeStatus->id,
            'email_verified_at' => now(),
        ]);
        return $user;
    }

    /**
     * Get user statistics
     */
    public function getUserStats(): array
    {
        return [
            'total_users' => User::count(),
            'active_users' => $this->getActiveUsers()->count(),
            'pending_users' => $this->getPendingUsers()->count(),
            'admins' => $this->getUsersByRole('admin')->count(),
            'staff' => $this->getUsersByRole('staff')->count(),
            'tellers' => $this->getUsersByRole('teller')->count(),
            'students' => $this->getUsersByRole('student')->count(),
        ];
    }

    /**
     * Reset user password
     */
    public function resetPassword(User $user): string
    {
        $tempPassword = str()->random(12);
        $user->update(['password' => Hash::make($tempPassword)]);
        return $tempPassword;
    }
}
