<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function edit(User $user)
    {
        $roles = Role::query()
            ->whereNot('name', Role::SUPER_ADMIN)
            ->orderBy('label')
            ->get();
        $user->load('roles');

        return view('super_admin.users.roles', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $superAdminId = Role::where('name', Role::SUPER_ADMIN)->value('id');

        // Prevent user from modifying their own roles
        if (auth()->id() === $user->id) {
            abort(403, 'You cannot modify your own roles.');
        }

        // Prevent modification of another super admin
        if ($user->hasRole(Role::SUPER_ADMIN)) {
            abort(403, 'Cannot modify the roles of another super admin.');
        }

        // Prevent assigning super admin role
        $validated = $request->validate([
            'role' => ['required', 'exists:roles,id'],
        ]);

        if ($validated['role'] == $superAdminId) {
            abort(403, 'You cannot assign super admin role.');
        }

        // Assign single role (removes previous role if any)
        $user->roles()->sync([$validated['role']]);

        // Update user status based on role assignment
        $activeId = UserStatus::where('code', UserStatus::ACTIVE)->value('id');

        if (!$activeId) {
            abort(500, 'User status "active" missing in database.');
        }

        $user->update([
            'user_status_id' => $activeId,
        ]);

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'User role successfully updated');
    }
}
