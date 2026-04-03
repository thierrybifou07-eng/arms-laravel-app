<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PendingUserController extends Controller
{
    public function index(): View
    {
        $pendingUsers = User::with(['userStatus', 'roles'])
            ->whereHas('userStatus', function ($query) {
                $query->where('code', UserStatus::PENDING);
            })
            ->latest()
            ->get();

        return view('super_admin.users.pending.index', compact('pendingUsers'));
    }

    public function show(User $user): View
    {
        $user->load(['userStatus', 'roles']);

        return view('super_admin.users.pending.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $user->load(['userStatus', 'roles']);

        $roles = Role::where('name', '!=', Role::SUPER_ADMIN)
            ->orderBy('label')
            ->get();

        return view('super_admin.users.pending.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => [
                'integer',
                Rule::exists('roles', 'id')->where(function ($query) {
                    $query->where('name', '!=', Role::SUPER_ADMIN);
                }),
            ],
        ]);

        $user->roles()->sync($validated['roles']);

        $activeId = UserStatus::where('code', UserStatus::ACTIVE)->value('id');
        if (! $activeId) {
            abort(500, 'User status active missing in database');
        }

        $user->update([
            'user_status_id' => $activeId,
        ]);

        return redirect()
            ->route('activate_accountpending_users.index')
            ->with('success', 'The user has been successfully activated.');
    }
}
