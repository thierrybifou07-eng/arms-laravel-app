<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('residences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('residence_status_id')
                ->constrained('residence_statuses')
                ->restrictOnDelete();
            $table->string('name',191);
            $table->string('city');
            $table->string('address');
            $table->string('capacity',50);
            $table->timestamps();

        });
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('residence_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('building_status_id')
                ->constrained('building_statuses')
                ->restrictOnDelete();
            $table->string('name', 191);
            $table->string('address')->nullable();
            $table->string('capacity',50);
            $table->unique(['residence_id', 'name']);
            $table->timestamps();
        });
        Schema::create('floors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('floor_status_id')
                ->constrained('floor_statuses')->restrictOnDelete();
            $table->string('number',191);
            $table->string('capacity',50);
            $table->unique(['building_id', 'number']);
            $table->timestamps();
        });
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('room_status_id')
                ->constrained('room_statuses')
                ->restrictOnDelete();
            $table->string('number', 191);
            $table->decimal('rent', 10, 2);
            $table->unique(['floor_id', 'number']);
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
        Schema::dropIfExists('residences');
    }
};
