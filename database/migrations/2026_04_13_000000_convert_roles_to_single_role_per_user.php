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
        // First, clean up duplicates - keep only one role per user
        // For any user with multiple roles, keep the most recent/first one
        $duplicates = DB::select("
            SELECT user_id
            FROM role_user
            GROUP BY user_id
            HAVING COUNT(*) > 1
        ");

        foreach ($duplicates as $record) {
            $userId = $record->user_id;
            // Keep the first role (by created_at ascending)
            $firstRole = DB::table('role_user')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'asc')
                ->first();

            if ($firstRole) {
                // Delete all roles for this user except the first one
                DB::table('role_user')
                    ->where('user_id', $userId)
                    ->where('role_id', '!=', $firstRole->role_id)
                    ->delete();
            }
        }

        // For super_admin role, ensure only one user has it
        $superAdminRoleId = DB::table('roles')
            ->where('name', 'super_admin')
            ->value('id');

        if ($superAdminRoleId) {
            $superAdminUsers = DB::table('role_user')
                ->where('role_id', $superAdminRoleId)
                ->orderBy('created_at', 'asc')
                ->get();

            if ($superAdminUsers->count() > 1) {
                $idsToDelete = $superAdminUsers->slice(1)->pluck('user_id')->toArray();
                DB::table('role_user')
                    ->whereIn('user_id', $idsToDelete)
                    ->where('role_id', $superAdminRoleId)
                    ->delete();
            }
        }

        Schema::disableForeignKeyConstraints();

        try {
            Schema::create('role_user_new', function (Blueprint $table) {
                $table->foreignId('role_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->foreignId('user_id')
                    ->primary()
                    ->constrained()
                    ->cascadeOnDelete();
                $table->timestamps();
            });

            DB::table('role_user_new')->insertUsing(
                ['role_id', 'user_id', 'created_at', 'updated_at'],
                DB::table('role_user')->select('role_id', 'user_id', 'created_at', 'updated_at')
            );

            Schema::drop('role_user');
            Schema::rename('role_user_new', 'role_user');
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        try {
            Schema::create('role_user_old', function (Blueprint $table) {
                $table->foreignId('role_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->primary(['role_id', 'user_id']);
                $table->timestamps();
            });

            DB::table('role_user_old')->insertUsing(
                ['role_id', 'user_id', 'created_at', 'updated_at'],
                DB::table('role_user')->select('role_id', 'user_id', 'created_at', 'updated_at')
            );

            Schema::drop('role_user');
            Schema::rename('role_user_old', 'role_user');
        } finally {
            Schema::enableForeignKeyConstraints();
        }
    }
};
