<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use Illuminate\Database\Seeder;

class AuditLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 100+ test audit logs with various actions
        AuditLog::factory()->count(50)->forCreation()->create();
        AuditLog::factory()->count(40)->forUpdate()->create();
        AuditLog::factory()->count(20)->forDeletion()->create();
        AuditLog::factory()->count(30)->forLogin()->create();
        AuditLog::factory()->count(10)->forLogout()->create();
        AuditLog::factory()->count(15)->forExport()->create();

        // Add some recent logs (today)
        AuditLog::factory()->count(15)->today()->forCreation()->create();
        AuditLog::factory()->count(10)->today()->forUpdate()->create();
        AuditLog::factory()->count(5)->today()->forLogin()->create();

        // Add some this week
        AuditLog::factory()->count(20)->thisWeek()->forCreation()->create();
        AuditLog::factory()->count(15)->thisWeek()->forUpdate()->create();
    }
}
