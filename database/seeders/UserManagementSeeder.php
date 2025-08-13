<?php

namespace Database\Seeders;

use App\Models\UserManagement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@perusahaan.com',
                'phone_number' => '08123456789',
                'is_active' => true,
                'department' => 'IT'
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@perusahaan.com',
                'phone_number' => '08987654321',
                'is_active' => true,
                'department' => 'Marketing'
            ],
            [
                'name' => 'Ahmad Wijaya',
                'email' => 'ahmad.wijaya@perusahaan.com',
                'phone_number' => '08111222333',
                'is_active' => true,
                'department' => 'Finance'
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@perusahaan.com',
                'phone_number' => '08555666777',
                'is_active' => false,
                'department' => 'HR'
            ],
            [
                'name' => 'Rizki Pratama',
                'email' => 'rizki.pratama@perusahaan.com',
                'phone_number' => '08777888999',
                'is_active' => true,
                'department' => 'Operations'
            ],
            [
                'name' => 'Wildan Miladji',
                'email' => 'wildan.miladji@perusahaan.com',
                'phone_number' => '08123987654',
                'is_active' => true,
                'department' => 'Backend Developer'
            ]
        ];

        foreach ($users as $user) {
            UserManagement::create($user);
        }
    }
}
