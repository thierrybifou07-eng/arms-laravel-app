<?php

namespace App\Http\Controllers;

use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with(['permissions', 'users'])
            ->orderBy('name')
            ->paginate(15);

        return view('super_admin.roles.index', compact('roles'));
    }

    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);

        return view('super_admin.roles.show', compact('role'));
    }
}
