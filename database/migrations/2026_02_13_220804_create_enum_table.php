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
        // User Status
        Schema::create('user_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });

        // Building Status
        Schema::create('building_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });
        // Floor Status
        Schema::create('floor_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });

        // Room Status
        Schema::create('room_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });

        // Residence Status
        Schema::create('residence_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });

        // Contract Status
        Schema::create('contract_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });

        // Payment Status
        Schema::create('payment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });

        // Payment Methods
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });

        // Payment Event Type
        Schema::create('payment_event_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });

        // Audit Action Type
        Schema::create('audit_action_types', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });

        // Billing Period
        Schema::create('billing_periods', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('label', 100);
            $table->timestamps();
        });

        // Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('billing_periods');
        Schema::dropIfExists('audit_action_types');
        Schema::dropIfExists('payment_event_types');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('payment_statuses');
        Schema::dropIfExists('contract_statuses');
        Schema::dropIfExists('residence_statuses');
        Schema::dropIfExists('room_statuses');
        Schema::dropIfExists('floor_statuses');
        Schema::dropIfExists('building_statuses');
        Schema::dropIfExists('user_statuses');
    }
};
