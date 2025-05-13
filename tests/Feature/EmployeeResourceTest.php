<?php

use App\Models\Employee;
use App\Filament\Resources\EmployeeResource;
use App\Filament\Resources\EmployeeResource\Pages\ListEmployees;
use App\Filament\Resources\EmployeeResource\Pages\CreateEmployee;
use App\Filament\Resources\EmployeeResource\Pages\EditEmployee;

use function Pest\Livewire\livewire;


it('can list employees', function () {
    $employees = Employee::factory()->count(5)->create();
    livewire(ListEmployees::class)
        ->assertCanSeeTableRecords($employees)
        ->assertCountTableRecords(5);
});

it('can create employee', function () {
    $newData = Employee::factory()->make();
    
    livewire(CreateEmployee::class)
        ->fillForm([
            'employee_name' => $newData->employee_name,
            'email' => $newData->email,
            'password' => 'Password123!',
            'mobile_number' => $newData->mobile_number,
            'address' => $newData->address,
            'notes' => $newData->notes,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Employee::class, [
        'employee_name' => $newData->employee_name,
        'email' => $newData->email,
    ]);
});

it('can update employee', function () {
    $employee = Employee::factory()->create();
    $newData = Employee::factory()->make();

    livewire(EditEmployee::class, [
        'record' => $employee->getKey(),
    ])
        ->fillForm([
            'employee_name' => $newData->employee_name,
            'email' => $newData->email,
            'mobile_number' => $newData->mobile_number,
            'address' => $newData->address,
            'notes' => $newData->notes,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Employee::class, [
        'id' => $employee->id,
        'employee_name' => $newData->employee_name,
    ]);
});

it('can delete employee', function () {
    $employee = Employee::factory()->create();
    
    livewire(EditEmployee::class, [
        'record' => $employee->getKey(),
    ])->callAction(\Filament\Actions\DeleteAction::class);

    $this->assertModelMissing($employee);
});