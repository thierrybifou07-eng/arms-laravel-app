<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::where('name',Role::SUPER_ADMIN)->first();
        if (!$superAdmin) {
            return;
        }
        $permissionIds=Permission::pluck('id')->toArray();
        $superAdmin->permissions()->sync($permissionIds);
    }
}
