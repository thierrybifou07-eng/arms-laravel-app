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
        $allPermissions = Permission::all();

        // Assign all permissions to Super Admin

        $superAdmin->permissions()->sync($allPermissions->pluck('id'));

        // Assign specific permissions to Admin

        $admin->permissions()->sync(
            Permission::whereIn('name',
                [
                    // Administration
                    'manage_users',
                    'create_role',
                    'update_role',
                    'delete_role',
                    'assign_permission',
                    'assign_role',
                    // Residences
                    'view_residences',
                    'create_residence',
                    'update_residence',
                    'delete_residence',
                    // Buildings
                    'view_buidingss',
                    'create_buidings',
                    'update_buidings',
                    'delete_buidings',
                    // Rooms
                    'view_rooms',
                    'create_room',
                    'update_room',
                    'assign_room',
                    'delete_room',
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
                    'view_building_report'

                ])->pluck('id')
        );

        // Assign specific permissions to Staff

        $staff->permissions()->sync(
            Permission::whereIn('name',
                [
                    'validate_payment',
                ])->pluck('id')
        );
    }
}
