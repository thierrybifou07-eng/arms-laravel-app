<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions=[
            ['name'=>'manage_residences','label'=>'Manage residences'],
            ['name'=>'manage_buildings','label'=>'Manage buildings'],
            ['name'=>'manage_rooms','label'=>'Manage rooms'],
            ['name'=>'assign_rooms','label'=>'Assign rooms'],
            ['name'=>'validate_payments','label'=>'Validate payments'],
            ['name'=>'view_reports','label'=>'View reports'],
        ];
        foreach($permissions as $permission){
            Permission::updateOrCreate(
                ['name'=>$permission['name']],
                ['label'=>$permission['label']]
            );
        }
    }
}
