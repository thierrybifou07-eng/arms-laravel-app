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
        $roles = Role::orderBy('label')->get();
        $user->load('roles');

        return view('super_admin.users.roles', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);
        // Active account when a role is assigned
        $user->roles()->sync($validated['roles'] ?? []);
        $pendingId = UserStatus::where('code', UserStatus::PENDING)->value('id');
        $activeId = UserStatus::where('code', UserStatus::ACTIVE)->value('id');
        if ($pendingId||$activeId) {
            abort(500, 'User statuses missing in database.');
        }
        $user->update([
            'user_status_id'=>empty($validated['roles'])?$pendingId:$activeId,
        ]);
        // Critic protection
        if ($user->hasRole(Role::SUPER_ADMIN) && auth()->id() !== $user->id) {
            abort(403, 'Impossible to modify the role of another super admin');
        }
        // Critic protection
        if ($user->hasRole(Role::SUPER_ADMIN) && auth()->id() === $user->id) {
            abort(403, 'Impossible to modify yourself');
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'The user\' s role has been successfully updated');
    }
}
