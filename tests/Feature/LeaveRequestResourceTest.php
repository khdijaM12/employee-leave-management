<?php

use App\Filament\Resources\LeaveRequestResource;
use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use function Pest\Livewire\livewire;

it('can list leave requests', function () {
    $leaveRequests = LeaveRequest::factory()->count(5)->create();
    
    livewire(LeaveRequestResource\Pages\ListLeaveRequests::class)
        ->assertCanSeeTableRecords($leaveRequests)
        ->assertCountTableRecords(5);
});

it('can create leave request', function () {
    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();
    
    $newData = LeaveRequest::factory()->make([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
    ]);
    
    livewire(LeaveRequestResource\Pages\CreateLeaveRequest::class)
        ->fillForm([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'reason' => $newData->reason,
            'start_date' => $newData->start_date->format('Y-m-d'),
            'end_date' => $newData->end_date->format('Y-m-d'),
            'notes' => $newData->notes,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(LeaveRequest::class, [
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'reason' => $newData->reason,
    ]);
});

it('can validate leave request creation input', function () {
    livewire(LeaveRequestResource\Pages\CreateLeaveRequest::class)
        ->fillForm([
            'employee_id' => null,
            'leave_type_id' => null,
            'reason' => null,
            'start_date' => null,
            'end_date' => null,
        ])
        ->call('create')
        ->assertHasFormErrors([
            'employee_id' => 'required',
            'leave_type_id' => 'required',
            'reason' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
});

it('can retrieve leave request data for editing', function () {
    $leaveRequest = LeaveRequest::factory()->create();
    
    livewire(LeaveRequestResource\Pages\EditLeaveRequest::class, [
        'record' => $leaveRequest->getKey(),
    ])
        ->assertFormSet([
            'status' => $leaveRequest->status,
        ]);
});

it('can update leave request status to approve', function () {
    $leaveRequest = LeaveRequest::factory()->create(['status' => 'pending']);
    
    livewire(LeaveRequestResource\Pages\EditLeaveRequest::class, [
        'record' => $leaveRequest->getKey(),
    ])
        ->fillForm([
            'status' => 'approved',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($leaveRequest->refresh())
        ->status->toBe('approved');
});

it('can update leave request status to rejected', function () {
    $leaveRequest = LeaveRequest::factory()->create(['status' => 'pending']);
    
    livewire(LeaveRequestResource\Pages\EditLeaveRequest::class, [
        'record' => $leaveRequest->getKey(),
    ])
        ->fillForm([
            'status' => 'rejected',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($leaveRequest->refresh())
        ->status->toBe('rejected');
});

it('can validate leave request update input', function () {
    $leaveRequest = LeaveRequest::factory()->create();
    
    livewire(LeaveRequestResource\Pages\EditLeaveRequest::class, [
        'record' => $leaveRequest->getKey(),
    ])
        ->fillForm([
            'status' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['status' => 'required']);
});

it('can delete leave request', function () {
    $leaveRequest = LeaveRequest::factory()->create();
    
    livewire(LeaveRequestResource\Pages\EditLeaveRequest::class, [
        'record' => $leaveRequest->getKey(),
    ])
        ->callAction(\Filament\Actions\DeleteAction::class);

    $this->assertModelMissing($leaveRequest);
});

it('prevents overlapping leave requests for same employee', function () {
    $employee = Employee::factory()->create();
    $leaveType = LeaveType::factory()->create();
    
    $existingRequest = LeaveRequest::factory()->create([
        'employee_id' => $employee->id,
        'leave_type_id' => $leaveType->id,
        'start_date' => '2023-01-10',
        'end_date' => '2023-01-15',
    ]);
    
    livewire(LeaveRequestResource\Pages\CreateLeaveRequest::class)
        ->fillForm([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'reason' => 'Test reason',
            'start_date' => '2023-01-12', 
            'end_date' => '2023-01-16', 
        ])
        ->call('create')
        ->assertHasFormErrors(['end_date']);
});