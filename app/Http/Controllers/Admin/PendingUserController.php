<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PendingUserController extends Controller
{
    public function index(): View
    {
        $pendingUsers = User::with('userStatus')
            ->whereHas('userStatus', function ($query) {
                $query->where('code', UserStatus::PENDING);
            })
            ->latest()
            ->paginate(10);

        return view('super_admin.users.pending.index', compact('pendingUsers'));
    }

    public function show(User $user): View
    {
        $user->load(['userStatus', 'roles']);

        return view('super_admin.users.pending.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $roles = Role::query()
            ->whereNot('name', Role::SUPER_ADMIN)
            ->orderBy('label')
            ->get();
        $user->load('roles');

        return view('super_admin.users.pending.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        // Validate that the user is pending
        if ($user->userStatus->code !== UserStatus::PENDING) {
            return redirect()
                ->route('activate_accountpending_users.index')
                ->with('error', 'This user is not a pending user.');
        }

        // Validate role input
        $validated = $request->validate([
            'role' => ['required', 'exists:roles,id'],
        ]);

        // Prevent assigning super admin role
        $superAdminId = Role::where('name', Role::SUPER_ADMIN)->value('id');
        if ($validated['role'] == $superAdminId) {
            return redirect()
                ->back()
                ->with('error', 'You cannot assign the super admin role.');
        }

        // Assign single role
        $user->roles()->sync([$validated['role']]);

        // Mark user as active
        $activeStatus = UserStatus::where('code', UserStatus::ACTIVE)->first();
        $user->update([
            'user_status_id' => $activeStatus->id,
        ]);

        return redirect()
            ->route('activate_accountpending_users.index')
            ->with('success', 'User activated successfully with role assigned.');
    }
}
