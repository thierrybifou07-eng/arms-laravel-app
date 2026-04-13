<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles', 'userStatus');

        // Filtre by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filtre by status
        if ($request->filled('status')) {
            $query->whereHas('userStatus', function ($q) use ($request) {
                $q->where('code', $request->status);
            });
        }

        // (multi-column groups search)
        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Pagination avec conservation des paramètres GET
        $users = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::all();

        return view('super_admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['roles', 'userStatus', 'contracts']);
        return view('super_admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, User $user) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, User $user)
    {
        // Prevent user from modifying themselves
        if (auth()->id() === $user->id) {
            throw ValidationException::withMessages([
                'security' => 'You cannot modify your own profile from this section.',
            ]);
        }

        $validated = $request->validate([
            'firstname' => ['string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['required', 'string', 'max:25', 'unique:users,phone,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('users.show', $user)->with('success', 'User successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if (auth()->id() === $user->id) {
            throw ValidationException::withMessages([
                'security' => 'You cannot delete your own account.',
            ]);
        }

        // Prevent deletion of active users
        if ($user->userStatus?->code === UserStatus::ACTIVE) {
            throw ValidationException::withMessages([
                'status' => 'Cannot delete users with active status. Change their status to pending or disabled first.',
            ]);
        }

        // Prevent deletion of super admins
        if ($user->hasRole(Role::SUPER_ADMIN)) {
            throw ValidationException::withMessages([
                'role' => 'Cannot delete super admin users.',
            ]);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User successfully deleted');
    }

    /**
     * Change user status (for admin only)
     */
    public function changeStatus(Request $request, User $user)
    {
        // Prevent user from changing their own status
        if (auth()->id() === $user->id) {
            throw ValidationException::withMessages([
                'security' => 'You cannot change your own status.',
            ]);
        }

        $validated = $request->validate([
            'user_status_id' => ['required', 'exists:user_statuses,id'],
        ]);

        // Prevent changing super admin status
        if ($user->hasRole(Role::SUPER_ADMIN)) {
            throw ValidationException::withMessages([
                'role' => 'Cannot change super admin user status.',
            ]);
        }

        $user->update([
            'user_status_id' => $validated['user_status_id'],
        ]);

        $statusLabel = UserStatus::find($validated['user_status_id'])?->label ?? 'Unknown';

        return redirect()->route('users.show', $user)->with('success', "User status changed to {$statusLabel}");
    }
}
