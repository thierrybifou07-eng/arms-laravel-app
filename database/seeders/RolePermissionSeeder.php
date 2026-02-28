<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin=Role::where('name','super_admin')->first();
        $admin=Role::where('name','admin')->first();
        $staff=Role::where('name','staff')->first();
        $allPermissions=Permission::all();

        // Assign all permissions to Super Admin

        $superAdmin->permissions()->sync($allPermissions->pluck('id'));

        // Assign specific permissions to Admin

        $admin->permissions()->sync(
            Permission::whereIn('name',
            [
            'manage_buildings',
            'manage_rooms',
            'assign_rooms',
            'view_reports',
            'validate_payments'
            ])->pluck('id')
        );

        // Assign specific permissions to Staff

        $staff->permissions()->sync(
            Permission::whereIn('name',
            [
            'validate_payments'
            ])->pluck('id')
        );
    }
}
