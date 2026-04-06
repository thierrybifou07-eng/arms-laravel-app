<?php

namespace App\Http\Controllers;

use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('roles')
            ->orderBy('name')
            ->paginate(15);

        return view('super_admin.permissions.index', compact('permissions'));
    }
}
