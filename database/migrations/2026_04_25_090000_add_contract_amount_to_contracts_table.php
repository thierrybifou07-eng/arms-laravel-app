<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->decimal('contract_amount', 12, 2)->default(0)->after('rent_amount');
        });

        DB::table('contracts')
            ->orderBy('id')
            ->chunkById(100, function ($contracts): void {
                $totals = DB::table('payments')
                    ->select('contract_id', DB::raw('COALESCE(SUM(expected_amount), 0) as total'))
                    ->whereIn('contract_id', $contracts->pluck('id'))
                    ->groupBy('contract_id')
                    ->pluck('total', 'contract_id');

                foreach ($contracts as $contract) {
                    DB::table('contracts')
                        ->where('id', $contract->id)
                        ->update([
                            'contract_amount' => $totals[$contract->id] ?? 0,
                        ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('contract_amount');
        });
    }
};
