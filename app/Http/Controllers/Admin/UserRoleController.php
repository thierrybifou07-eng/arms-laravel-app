<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Residence;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserRoleController extends Controller
{
    public function edit(User $user)
    {
        $roles = Role::query()
            ->whereNot('name', Role::SUPER_ADMIN)
            ->orderBy('label')
            ->get();
        $residences = Residence::query()->orderBy('name')->get();
        $user->load(['roles', 'residences']);

        return view('super_admin.users.roles', compact('user', 'roles', 'residences'));
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
            'residence_id' => ['nullable', 'exists:residences,id'],
        ]);

        if ($validated['role'] == $superAdminId) {
            abort(403, 'You cannot assign super admin role.');
        }

        $role = Role::query()->findOrFail($validated['role']);

        if ($role->name === Role::STAFF && empty($validated['residence_id'])) {
            throw ValidationException::withMessages([
                'residence_id' => 'A residence is required when assigning the staff role.',
            ]);
        }

        // Assign single role (removes previous role if any)
        $user->roles()->sync([$role->id]);

        if ($role->name === Role::STAFF) {
            $user->residences()->sync([$validated['residence_id']]);
        } elseif ($role->name === Role::STUDENT) {
            $user->residences()->detach();
        }

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
