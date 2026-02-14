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

        Schema::table('buildings', function (Blueprint $table) {
            $table->foreignId('manager_id')
                ->after('university_residence_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
        Schema::create('residence_user', function (Blueprint $table) {
            $table->foreignId('university_residence_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->primary(['university_residence_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residence_user');
        Schema::table('buildings', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn('manager_id');
        });

    }
};
