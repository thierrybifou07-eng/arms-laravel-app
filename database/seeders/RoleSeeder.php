<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $roles=[
            ['name'=>'super_admin','label'=>'Residences Administrator'],
            ['name'=>'admin','label'=>'Residence Manager'],
            ['name'=>'staff','label'=>'Staff Member'],
            ['name'=>'payment_validator','label'=>'Payment Validator'],
            ['name'=>'student','label'=>'Student'],
        ];
        foreach($roles as $role){
            Role::updateOrCreate(
                ['name'=>$role['name']],
                ['label'=>$role['label']]
            );
        }
    }
}
