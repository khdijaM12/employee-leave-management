<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveRequestFactory extends Factory
{
    protected $model = LeaveRequest::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'leave_type_id' => LeaveType::factory(),
            'reason' => $this->faker->sentence(),
            'start_date' => $this->faker->dateTimeBetween('+1 day', '+1 week'),
            'end_date' => $this->faker->dateTimeBetween('+2 week', '+3 week'),
            'notes' => $this->faker->optional()->sentence(),
            'status' => 'pending',
        ];
    }
}