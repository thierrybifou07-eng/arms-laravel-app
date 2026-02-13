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
            $table->id('user_status_id');
            $table->string('code', 30)->unique();
            $table->string('libelle', 100);
            $table->timestamps();
        });

        // Building Status
        Schema::create('building_statuses', function (Blueprint $table) {
            $table->id('building_status_id');
            $table->string('code', 30)->unique();
            $table->string('libelle', 100);
            $table->timestamps();
        });

        // Room Status
        Schema::create('room_statuses', function (Blueprint $table) {
            $table->id('room_status_id');
            $table->string('code', 30)->unique();
            $table->string('libelle', 100);
            $table->timestamps();
        });

        // Residence Status
        Schema::create('residence_statuses', function (Blueprint $table) {
            $table->id('residence_status_id');
            $table->string('code', 30)->unique();
            $table->string('libelle', 100);
            $table->timestamps();
        });

        // Contract Status
        Schema::create('contract_statuses', function (Blueprint $table) {
            $table->id('contract_status_id');
            $table->string('code', 30)->unique();
            $table->string('libelle', 100);
            $table->timestamps();
        });

        // Payment Status
        Schema::create('payment_statuses', function (Blueprint $table) {
            $table->id('payment_status_id');
            $table->string('code', 30)->unique();
            $table->string('libelle', 100);
            $table->timestamps();
        });

        // Payment Methods
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id('payment_method_id');
            $table->string('code', 30)->unique();
            $table->string('libelle', 100);
            $table->timestamps();
        });

        // Payment Event Type
        Schema::create('payment_event_types', function (Blueprint $table) {
            $table->id('payment_event_type_id');
            $table->string('code', 30)->unique();
            $table->string('libelle', 100);
            $table->timestamps();
        });

        // Audit Action Type
        Schema::create('audit_action_types', function (Blueprint $table) {
            $table->id('audit_action_type_id');
            $table->string('code', 30)->unique();
            $table->string('libelle', 100);
            $table->timestamps();
        });

        // Billing Period
        Schema::create('billing_periods', function (Blueprint $table) {
            $table->id('billing_period_id');
            $table->string('code', 30)->unique();
            $table->string('libelle', 100);
            $table->timestamps();
        });

        // Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id('role_id');
            $table->string('role_name', 50);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id('permission_id');
            $table->string('permission_name', 100);
            $table->string('description');
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
        Schema::dropIfExists('billing_period');
        Schema::dropIfExists('audit_action_type');
        Schema::dropIfExists('payment_event_type');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('payment_status');
        Schema::dropIfExists('contract_status');
        Schema::dropIfExists('residence_status');
        Schema::dropIfExists('room_status');
        Schema::dropIfExists('building_status');
        Schema::dropIfExists('user_status');
    }
};