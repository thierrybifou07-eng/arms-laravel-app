<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // Administration
            ['name' => 'manage_users', 'label' => 'Manage users'],
            ['name' => 'create_role', 'label' => 'Create role'],
            ['name' => 'update_role', 'label' => 'Update role'],
            ['name' => 'delete_role', 'label' => 'Delete role'],
            ['name' => 'assign_permission', 'label' => 'assign permission'],
            ['name' => 'assign_role', 'label' => 'assign role'],

            // Residences
            ['name' => 'view_residences', 'label' => 'View residences'],
            ['name' => 'assign_residences', 'label' => 'Assign residences'],
            ['name' => 'create_residence', 'label' => 'Create residence'],
            ['name' => 'update_residence', 'label' => 'Update residence'],
            ['name' => 'delete_residence', 'label' => 'Delete residence'],

            // Buidings
            ['name' => 'view_buidings', 'label' => 'View buidings'],
            ['name' => 'create_buidings', 'label' => 'Create buidings'],
            ['name' => 'update_buidings', 'label' => 'Update buidings'],
            ['name' => 'delete_buidings', 'label' => 'Delete buidings'],

            // Rooms
            ['name' => 'view_rooms', 'label' => 'View rooms'],
            ['name' => 'create_room', 'label' => 'Create room'],
            ['name' => 'update_room', 'label' => 'Update room'],
            ['name' => 'assign_room', 'label' => 'Assign room'],
            ['name' => 'delete_room', 'label' => 'Delete room'],

            // Contracts
            ['name' => 'view_contracts', 'label' => 'View Contracts'],
            ['name' => 'create_contract', 'label' => 'Create contract'],
            ['name' => 'update_contract', 'label' => 'Update contract'],
            ['name' => 'terminate_contract', 'label' => 'Terminate contract'],

            // Payments
            ['name' => 'record_payments', 'label' => 'Record payments'],
            ['name' => 'validate_payment', 'label' => 'validate payment'],
            ['name' => 'cancel_payment', 'label' => 'Cancel payment'],

            // Reports
            ['name' => 'view_reports', 'label' => 'View reports'],
            ['name' => 'view_residence_report', 'label' => 'View residence report'],
            ['name' => 'view_building_report', 'label' => 'View building report']
        ];
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                ['label' => $permission['label']]
            );
        }
    }
}
