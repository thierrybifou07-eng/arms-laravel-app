<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;

class StudentPolicy
{
    use BasePolicy;

    /**
     * Determine if user can view any students
     */
    public function viewAny(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can view a specific student
     */
    public function view(User $user, Student $model): bool
    {
        // Super Admin and Admin can view any student
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Staff can view any student
        if ($user->hasRole(Role::STAFF)) {
            return true;
        }

        // Teller can view any student
        if ($this->isTeller($user)) {
            return true;
        }

        // Student can only view themselves
        if ($user->hasRole(Role::STUDENT)) {
            return $user->id === $model->user_id;
        }

        return false;
    }

    /**
     * Determine if user can create students
     */
    public function create(User $user): bool
    {
        return $this->isStaff($user);
    }

    /**
     * Determine if user can update a student
     */
    public function update(User $user, Student $model): bool
    {
        // Super Admin and Admin can update any student
        if ($this->isSuperAdmin($user)) {
            return true;
        }

        // Staff can update any student
        if ($user->hasRole(Role::STAFF)) {
            return true;
        }

        // Student can only update their own record
        if ($user->hasRole(Role::STUDENT)) {
            return $user->id === $model->user_id;
        }

        return false;
    }

    /**
     * Determine if user can delete a student
     */
    public function delete(User $user, Student $model): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can restore a soft deleted student
     */
    public function restore(User $user, Student $model): bool
    {
        return $this->isSuperAdmin($user);
    }

    /**
     * Determine if user can permanently delete a student
     */
    public function forceDelete(User $user, Student $model): bool
    {
        return $user->hasRole(Role::SUPER_ADMIN);
    }
}
