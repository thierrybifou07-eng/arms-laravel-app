<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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

        // Disable foreign key checks for MySQL
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            // Recreate the table with new primary key structure
            // user_id is PRIMARY KEY: each user can have only ONE role
            // NO unique constraint on role_id: multiple users can have the same role
            DB::statement('
                CREATE TABLE role_user_new (
                    role_id BIGINT UNSIGNED NOT NULL,
                    user_id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
                    created_at TIMESTAMP NULL DEFAULT NULL,
                    updated_at TIMESTAMP NULL DEFAULT NULL,
                    CONSTRAINT fk_role_user_role_id FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
                    CONSTRAINT fk_role_user_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ');

            // Copy data from old table
            DB::statement('INSERT INTO role_user_new SELECT role_id, user_id, created_at, updated_at FROM role_user');

            // Drop old table
            DB::statement('DROP TABLE IF EXISTS role_user');

            // Rename new table to old name
            DB::statement('RENAME TABLE role_user_new TO role_user');
        } finally {
            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            // Recreate the original table structure
            DB::statement('
                CREATE TABLE role_user_old (
                    role_id BIGINT UNSIGNED NOT NULL,
                    user_id BIGINT UNSIGNED NOT NULL,
                    created_at TIMESTAMP NULL DEFAULT NULL,
                    updated_at TIMESTAMP NULL DEFAULT NULL,
                    PRIMARY KEY (role_id, user_id),
                    CONSTRAINT fk_role_user_role_id_old FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
                    CONSTRAINT fk_role_user_user_id_old FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ');

            // Copy data
            DB::statement('INSERT INTO role_user_old SELECT role_id, user_id, created_at, updated_at FROM role_user');

            // Drop and rename
            DB::statement('DROP TABLE IF EXISTS role_user');
            DB::statement('RENAME TABLE role_user_old TO role_user');
        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
};
