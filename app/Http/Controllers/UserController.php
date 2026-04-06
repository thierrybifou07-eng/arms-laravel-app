<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function show(user $user)
    {
        return view('super_admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, user $user) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, user $user)
    {
        $validated = $request->validate([
            'firstname' => ['string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:25', 'unique:'.User::class],
        ]);
        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'L\'utilisateur à bien été mise à jour');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'L\'utilisateur à bien été supprimée');

    }
}
