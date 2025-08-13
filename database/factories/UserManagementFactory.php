<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserManagement>
 */
class UserManagementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstNames = ['Budi', 'Siti', 'Ahmad', 'Dewi', 'Rizki', 'Maya', 'Andi', 'Rina', 'Dedi', 'Lina', 'Agus', 'Sri', 'Hendra', 'Wati', 'Joko'];
        $lastNames = ['Santoso', 'Wijaya', 'Lestari', 'Pratama', 'Sari', 'Putra', 'Indah', 'Kusuma', 'Handoko', 'Rahayu', 'Setiawan', 'Maharani', 'Gunawan', 'Permata'];
        
        $firstName = $this->faker->randomElement($firstNames);
        $lastName = $this->faker->randomElement($lastNames);
        $fullName = $firstName . ' ' . $lastName;
        $email = strtolower($firstName . '.' . $lastName) . '@perusahaan.com';
        
        return [
            'name' => $fullName,
            'email' => $email,
            'phone_number' => '081' . $this->faker->numerify('#########'),
            'is_active' => $this->faker->boolean(85),
            'department' => $this->faker->randomElement(['IT', 'Marketing', 'Finance', 'HR', 'Operations', 'Sales', 'Customer Service'])
        ];
    }
}
