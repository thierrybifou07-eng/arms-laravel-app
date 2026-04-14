<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::where('name', 'super_admin')->first();
        $admin = Role::where('name', 'admin')->first();
        $staff = Role::where('name', 'staff')->first();
        $student = Role::where('name', 'student')->first();
        $allPermissions = Permission::all();

        // Assign all permissions to Super Admin

        $superAdmin->permissions()->sync($allPermissions->pluck('id'));

        // Assign specific permissions to Admin

        $admin->permissions()->sync(
            Permission::whereIn('name',
                [
                    // Administration
                    'manage_users',
                    'assign_role',
                    // Residences
                    'view_residences',
                    'update_residence',
                    // Buildings
                    'view_buidingss',
                    'create_buidings',
                    'update_buidings',
                    // Rooms
                    'view_rooms',
                    'create_room',
                    'update_room',
                    'assign_room',
                    // Contracts
                    'view_contracts',
                    'create_contract',
                    'update_contract',
                    'terminate_contract',
                    // Payments
                    'record_payments',
                    'validate_payment',
                    'cancel_payment',
                    // Reports
                    'view_reports',
                    'view_residence_report',
                    'view_building_report',

                ])->pluck('id')
        );

        // Assign specific permissions to Staff

        $staff->permissions()->sync(
            Permission::whereIn('name',
                [
                    'view_residences',
                    'view_buidingss',
                    'view_rooms',
                    'update_room',
                    'assign_room',
                    'view_contracts',
                    'create_contract',
                    'update_contract',
                    'terminate_contract',
                    'record_payments',
                    'validate_payment',
                    'cancel_payment',
                    ])->pluck('id')
        );

        // Assign specific permissions to Staff

        $student->permissions()->sync(
            Permission::whereIn('name',
                [
                    'view_rooms',
                ])->pluck('id')
        );
    }
}
