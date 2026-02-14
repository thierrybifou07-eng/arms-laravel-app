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
        Schema::create('university_residences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('residence_status_id')
                ->constrained('residence_statuses')
                ->restrictOnDelete();
            $table->string('name');
            $table->string('address');
            $table->integer('capacity');
            $table->timestamps();

        });
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('university_residence_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('building_status_id')
                ->constrained('building_statuses')
                ->restrictOnDelete();
            $table->string('name');
            $table->string('address')->nullable();
            $table->integer('capacity');
            $table->timestamps();
        });
        Schema::create('floors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')
                ->constrained()
                ->cascadeOnDelete(); 
            $table->foreignId('floor_status_id')
                ->constrained('floor_statuses');
            $table->string('number');
            $table->integer('capacity');
        });
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('room_status_id')
                ->constrained('room_statuses')
                ->restrictOnDelete();
            $table->string('name');
            $table->string('number');
            $table->integer('capacity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('floors');
        Schema::dropIfExists('buildings');
        Schema::dropIfExists('university_residences');
    }
};
