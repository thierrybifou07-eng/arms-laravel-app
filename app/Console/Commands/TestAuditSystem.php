<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use Illuminate\Console\Command;

class TestAuditSystem extends Command
{
    protected $signature = 'audit:test';

    protected $description = 'Test the audit system by creating a test entry';

    public function handle()
    {
        $this->info('Testing Audit System...');
        $this->newLine();

        try {
            // Count before
            $countBefore = AuditLog::count();
            $this->line("Logs avant: <info>{$countBefore}</info>");

            // Create test entry
            AuditLog::log(
                action: 'TEST',
                userId: auth()->id() ?? 1,
                modelType: 'App\Models\AuditLog',
                modelId: 1,
                details: 'Audit log test entry created by TestAuditSystem command',
            );

            // Count after
            $countAfter = AuditLog::count();
            $this->line("Logs after: <info>{$countAfter}</info>");

            $this->newLine();
            $this->info('Test audit created successfully!');
            $this->line('Access audit logs at: <comment>/audit-logs</comment>');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Erreur: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
