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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('surname');
            $table->string('given_name');
            $table->string('middlename')->nullable();
            $table->string('identification_number')->unique();
            $table->string('phone')->unique();
            $table->timestamps();
        });
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('contract_status_id')
                ->constrained('contract_statuses')
                ->restrictOnDelete();
            $table->foreignId('billing_period_id')
                ->constrained('billing_periods')
                ->restrictOnDelete();
            $table->foreignId('room_id')
                ->constrained()
                ->restrictOnDelete();
            $table->decimal('amount', 10, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('students');
    }
};
