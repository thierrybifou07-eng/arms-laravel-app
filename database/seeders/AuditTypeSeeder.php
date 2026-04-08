<?php

namespace Database\Seeders;

use App\Models\AuditType;
use Illuminate\Database\Seeder;

class AuditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $auditTypes = [
            ['code' => 'create', 'label' => 'Create'],
            ['code' => 'update', 'label' => 'Update'],
            ['code' => 'delete', 'label' => 'Delete'],
            ['code' => 'read', 'label' => 'Read'],
            ['code' => 'login', 'label' => 'Login'],
            ['code' => 'logout', 'label' => 'Logout'],
            ['code' => 'download', 'label' => 'Download'],
            ['code' => 'export', 'label' => 'Export'],
            ['code' => 'import', 'label' => 'Import'],
            ['code' => 'other', 'label' => 'Other'],
        ];

        foreach ($auditTypes as $type) {
            AuditType::firstOrCreate(
                ['code' => $type['code']],
                ['label' => $type['label']]
            );
        }
    }
}
