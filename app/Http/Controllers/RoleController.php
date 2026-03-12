<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
     public function index()
    {
        $roles = Role::all();

        return view('roles.index', compact('roles'));
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
    public function show(string $id, role $role)
    {
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, role $role)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, role $role)
    {
        $validated=$request->validate([
            'name' => ['requireding', 'max:50'],
            'label' => ['required', 'string', 'max:255'],

        ]);
        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'Le role à bien été mise à jour');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, role $role)
    {
        $role->delete();
                return redirect()->route('roles.index')->with('success', 'Le role à bien été supprimée');

    }
}
