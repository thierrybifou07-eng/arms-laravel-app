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

        if (isset($validated['roles']) && in_array($superAdminId, $validated['roles'])) {
            abort(403, 'You cannot assign super admin role.');
        }
        // Prevent user from modifying their own roles
        if (auth()->id() === $user->id) {
            abort(403, 'You cannot modify your own roles.');
        }

        // Prevent modification of another super admin
        if ($user->hasRole(Role::SUPER_ADMIN)) {
            abort(403, 'Cannot modify the roles of another super admin.');
        }

        $validated = $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        // Sync roles
        $user->roles()->sync($validated['roles'] ?? []);

        // Update user status based on role assignment
        $pendingId = UserStatus::where('code', UserStatus::PENDING)->value('id');
        $activeId = UserStatus::where('code', UserStatus::ACTIVE)->value('id');

        if (! $pendingId || ! $activeId) {
            abort(500, 'User statuses missing in database.');
        }

        $user->update([
            'user_status_id' => empty($validated['roles']) ? $pendingId : $activeId,
        ]);

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'User roles successfully updated');
    }
}
