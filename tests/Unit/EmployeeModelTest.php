<?php

namespace Tests\Unit;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EmployeeModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_hashes_the_password_when_setting_it()
    {
        $plainPassword = 'MySecret123';

        $employee = Employee::factory()->create([
            'password' => $plainPassword,
        ]);

        $this->assertNotEquals($plainPassword, $employee->password);
        $this->assertTrue(Hash::check($plainPassword, $employee->password));
    }

    /** @test */
    public function it_generates_employee_number_on_creation()
    {
        $firstEmployee = Employee::factory()->create();
        $secondEmployee = Employee::factory()->create();

        $this->assertStringStartsWith('EMP-', $firstEmployee->employee_number);
        $this->assertEquals('EMP-00001', $firstEmployee->employee_number);

        $this->assertEquals('EMP-00002', $secondEmployee->employee_number);
    }
}
