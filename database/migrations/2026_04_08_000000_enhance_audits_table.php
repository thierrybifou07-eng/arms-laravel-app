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
        Schema::table('audits', function (Blueprint $table) {
            // Ajouter les colonnes manquantes si elles n'existent pas
            if (!Schema::hasColumn('audits', 'model_type')) {
                $table->string('model_type')->after('auditable_type')->default('')->nullable();
            }
            if (!Schema::hasColumn('audits', 'model_id')) {
                $table->unsignedBigInteger('model_id')->after('model_type')->nullable();
            }
            if (!Schema::hasColumn('audits', 'action')) {
                $table->string('action')->after('audit_type_id'); // create, update, delete, etc.
            }
            if (!Schema::hasColumn('audits', 'old_values')) {
                $table->json('old_values')->after('details')->nullable();
            }
            if (!Schema::hasColumn('audits', 'new_values')) {
                $table->json('new_values')->after('old_values')->nullable();
            }
            if (!Schema::hasColumn('audits', 'ip_address')) {
                $table->string('ip_address')->after('new_values')->nullable();
            }
            if (!Schema::hasColumn('audits', 'user_agent')) {
                $table->text('user_agent')->after('ip_address')->nullable();
            }
            if (!Schema::hasColumn('audits', 'method')) {
                $table->string('method')->after('user_agent')->nullable(); // GET, POST, PUT, DELETE
            }
            if (!Schema::hasColumn('audits', 'url')) {
                $table->text('url')->after('method')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->dropColumnIfExists(['model_type', 'model_id', 'action', 'old_values', 'new_values', 'ip_address', 'user_agent', 'method', 'url']);
        });
    }
};
