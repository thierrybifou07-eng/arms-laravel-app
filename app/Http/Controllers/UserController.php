<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserStatus;

class UserController extends Controller
{
     public function index()
    {
        $users = User::all();

        return view('super_admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, user $user)
    {
        return view('super_admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, user $user)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, user $user)
    {
        $validated=$request->validate([
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
    public function destroy(string $id, user $user)
    {
        $user->delete();
                return redirect()->route('users.index')->with('success', 'L\'utilisateur à bien été supprimée');

    }
}
