<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin', 'label' => 'Residences Administrator',
                'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'admin', 'label' => 'Residence Manager',
                'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'staff', 'label' => 'Staff Member',
                'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'payment_validator', 'label' => 'Payment Validator',
                'created_at' => now(),
                'updated_at' => now()],
            ['name' => 'student', 'label' => 'Student',
                'created_at' => now(),
                'updated_at' => now()],
        ];
        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                ['label' => $role['label']]
            );
        }
    }
}
