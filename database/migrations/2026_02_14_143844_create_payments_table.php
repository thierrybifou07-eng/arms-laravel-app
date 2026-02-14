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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('payment_method_id')
                ->constrained()
                ->restrictOnDelete();
            $table->foreignId('payment_status_id')
                ->constrained()
                ->restrictOnDelete();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->timestamps();
        });
        Schema::create('payments_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_event_type_id')
                ->constrained()
                ->restrictOnDelete();
            $table->foreignId('payment_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->text('comment')->nullable();
            $table->dateTime('event_date');
            $table->timestamps();
        });

        Schema::create('payment_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('number')->unique();
            $table->dateTime('issue_date');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_receipts');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payments_histories');
    }
};
