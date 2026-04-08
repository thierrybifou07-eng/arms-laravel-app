<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Residence;
use Illuminate\Database\Seeder;

class AdminResidenceAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all admin users
        $admins = User::whereHas('roles', function ($q) {
            $q->where('code', 'admin');
        })->get();

        // Get all residences
        $residences = Residence::all();

        $assignmentCount = 0;

        foreach ($admins as $admin) {
            // Each admin manages 1-3 residences
            $residenceCount = fake()->numberBetween(1, 3);
            $selectedResidences = $residences->random(min($residenceCount, $residences->count()));
            
            foreach ($selectedResidences as $residence) {
                $admin->residences()->syncWithoutDetaching([$residence->id]);
                $assignmentCount++;
            }
        }

        $this->command->info("✓ $assignmentCount admin-residence assignments created");
        $this->command->info("✓ Each admin manages multiple residences");
    }
}
