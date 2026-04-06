<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payment_history', function (Blueprint $table) {
            $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->decimal('old_balance', 10, 2);
            $table->decimal('new_balance', 10, 2);
            $table->foreignId('recorded_by')->constrained('users')->restrictOnDelete();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_history', function (Blueprint $table) {
            $table->dropForeignKeyIfExists('payment_history_payment_id_foreign');
            $table->dropForeignKeyIfExists('payment_history_recorded_by_foreign');
            $table->dropColumn(['payment_id', 'amount', 'old_balance', 'new_balance', 'recorded_by', 'notes']);
        });
    }
};
