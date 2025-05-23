<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'employee_name' =>  $this->faker->unique()->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'mobile_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'notes' => $this->faker->sentence(),
        ];
    }
}