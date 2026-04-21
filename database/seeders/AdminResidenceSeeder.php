<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Residence;
use Illuminate\Database\Seeder;

class AdminResidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all residences
        $residences = Residence::all();

        // Get all users with admin role
        $adminRole = Role::where('name', Role::ADMIN)->first();

        if (!$adminRole) {
            $this->command->info('❌ Admin role not found');
            return;
        }

        $admins = $adminRole->users()->get();

        if ($admins->isEmpty()) {
            $this->command->info('⚠️ No admin users found');
            return;
        }

        $totalAssignments = 0;

        // Assign each admin to all residences
        foreach ($admins as $admin) {
            foreach ($residences as $residence) {
                // Check if already assigned
                if (!$admin->residences()->where('residence_id', $residence->id)->exists()) {
                    $admin->residences()->attach($residence->id);
                    $totalAssignments++;
                }
            }
        }

        $this->command->info("✓ $totalAssignments admin-residence assignments created");
    }
}
