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
        $this->info('🧪 Testing Audit System...');
        $this->newLine();

        try {
            // Count before
            $countBefore = AuditLog::count();
            $this->line("📊 Logs avant: <info>{$countBefore}</info>");

            // Create test entry
            AuditLog::log(
                action: 'TEST',
                userId: auth()->id() ?? 1,
                modelType: 'App\Models\AuditLog',
                modelId: 1,
                details: 'Test du système d\'audit effectué via commande Artisan',
            );

            // Count after
            $countAfter = AuditLog::count();
            $this->line("📊 Logs après: <info>{$countAfter}</info>");

            $this->newLine();
            $this->info('✅ Test réussi! Un log a été créé.');
            $this->line('🔗 Accédez aux logs à: <comment>/audit-logs</comment>');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Erreur: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
