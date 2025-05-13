<?php

use App\Filament\Resources\LeaveTypeResource;
use App\Models\LeaveType;
use App\Models\User;
use function Pest\Livewire\livewire;

it('can validate leave type creation input', function () {
    livewire(LeaveTypeResource\Pages\CreateLeaveType::class)
        ->fillForm([
            'name' => null,
        ])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required']);
});

it('can render leave type edit page', function () {
    $this->get(LeaveTypeResource::getUrl('edit', [
        'record' => LeaveType::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve leave type data for editing', function () {
    $leaveType = LeaveType::factory()->create();

    livewire(LeaveTypeResource\Pages\EditLeaveType::class, [
        'record' => $leaveType->getKey(),
    ])
        ->assertFormSet([
            'name' => $leaveType->name,
        ]);
});

it('can update leave type', function () {
    $leaveType = LeaveType::factory()->create();
    $newData = LeaveType::factory()->make();

    livewire(LeaveTypeResource\Pages\EditLeaveType::class, [
        'record' => $leaveType->getKey(),
    ])
        ->fillForm([
            'name' => $newData->name,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($leaveType->refresh())
        ->name->toBe($newData->name);
});

it('can validate leave type update input', function () {
    $leaveType = LeaveType::factory()->create();

    livewire(LeaveTypeResource\Pages\EditLeaveType::class, [
        'record' => $leaveType->getKey(),
    ])
        ->fillForm([
            'name' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['name' => 'required']);
});

it('can delete leave type', function () {
    $leaveType = LeaveType::factory()->create();

    livewire(LeaveTypeResource\Pages\EditLeaveType::class, [
        'record' => $leaveType->getKey(),
    ])
        ->callAction(\Filament\Actions\DeleteAction::class);

    $this->assertModelMissing($leaveType);
});