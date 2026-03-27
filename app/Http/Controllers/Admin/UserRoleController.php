<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
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

        // Critic protection
        if ($user->hasRole(Role::SUPER_ADMIN) && auth()->id() !== $user->id) {
            abort(403, 'Impossible to modify the role of another super admin');
        }

        $user->roles()->sync($validated['roles'] ?? []);

        return redirect()
            ->route('users.index')
            ->with('success', 'The user\' s role has been successfully modified');
    }
}