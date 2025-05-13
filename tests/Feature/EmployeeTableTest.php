<?php

use App\Models\Employee;
use App\Filament\Resources\EmployeeResource\Pages\ListEmployees;
use function Pest\Livewire\livewire;

it('can list employees', function () {
    $employees = Employee::factory()->count(5)->create();
    
    livewire(ListEmployees::class)
        ->assertCanSeeTableRecords($employees)
        ->assertCountTableRecords(5);
});

// it('can search employees by name', function () {
//     $employees = Employee::factory()->count(5)->create();
//     $firstEmployee = $employees->first();

//     livewire(ListEmployees::class)
//         ->searchTable($firstEmployee->employee_name)
//         ->assertCanSeeTableRecords($employees->where('employee_name', $firstEmployee->employee_name))
//         ->assertCanNotSeeTableRecords($employees->where('employee_name', '!=', $firstEmployee->employee_name));
// });

// it('can filter employees by email', function () {
//     $employees = Employee::factory()->count(5)->create();
//     $firstEmployee = $employees->first();

//     livewire(ListEmployees::class)
//         ->filterTable('email', $firstEmployee->email)
//         ->assertCanSeeTableRecords([$firstEmployee])
//         ->assertCanNotSeeTableRecords($employees->where('email', '!=', $firstEmployee->email));
// });

// it('can sort employees by name', function () {
//     $employees = Employee::factory()->count(5)->create();

//     livewire(ListEmployees::class)
//         ->sortTable('employee_name')
//         ->assertCanSeeTableRecords($employees->sortBy('employee_name'), inOrder: true)
//         ->sortTable('employee_name', 'desc')
//         ->assertCanSeeTableRecords($employees->sortByDesc('employee_name'), inOrder: true);
// });