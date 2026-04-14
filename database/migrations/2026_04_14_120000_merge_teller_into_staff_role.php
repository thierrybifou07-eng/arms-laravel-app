<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $staffRole = DB::table('roles')->where('name', Role::STAFF)->first();
        $tellerRole = DB::table('roles')->where('name', 'teller')->first();

        if (! $tellerRole) {
            return;
        }

        if (! $staffRole) {
            DB::table('roles')
                ->where('id', $tellerRole->id)
                ->update([
                    'name' => Role::STAFF,
                    'label' => 'Staff Member',
                    'updated_at' => now(),
                ]);

            return;
        }

        $tellerPermissionIds = DB::table('permission_role')
            ->where('role_id', $tellerRole->id)
            ->pluck('permission_id');

        foreach ($tellerPermissionIds as $permissionId) {
            $exists = DB::table('permission_role')
                ->where('role_id', $staffRole->id)
                ->where('permission_id', $permissionId)
                ->exists();

            if (! $exists) {
                DB::table('permission_role')->insert([
                    'role_id' => $staffRole->id,
                    'permission_id' => $permissionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $userIds = DB::table('role_user')
            ->where('role_id', $tellerRole->id)
            ->pluck('user_id');

        foreach ($userIds as $userId) {
            $alreadyStaff = DB::table('role_user')
                ->where('role_id', $staffRole->id)
                ->where('user_id', $userId)
                ->exists();

            if ($alreadyStaff) {
                DB::table('role_user')
                    ->where('role_id', $tellerRole->id)
                    ->where('user_id', $userId)
                    ->delete();

                continue;
            }

            DB::table('role_user')
                ->where('role_id', $tellerRole->id)
                ->where('user_id', $userId)
                ->update([
                    'role_id' => $staffRole->id,
                    'updated_at' => now(),
                ]);
        }

        DB::table('permission_role')->where('role_id', $tellerRole->id)->delete();
        DB::table('role_user')->where('role_id', $tellerRole->id)->delete();
        DB::table('roles')->where('id', $tellerRole->id)->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('roles')->updateOrInsert(
            ['name' => 'teller'],
            ['label' => 'Teller', 'created_at' => now(), 'updated_at' => now()]
        );
    }
};
