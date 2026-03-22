<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students =
            ['surname' => 'Surname',
                'given_name' => 'Given name',
                'middlename' => 'middle name',
                'email' => 'student@gmail.com',
                'phone' => '697 147 114',
                'identification_number' =>'12345678',
            ];
        Student::create(
            [
                'surname' => $students['surname'],
                'given_name' => $students['given_name'],
                'middlename' => $students['middlename'],
                'email' => $students['email'],
                'phone' => $students['phone'],
                'identification_number' => $students['identification_number'],
            ]
        );
    }
}
