<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LeaveEmployeeRequestForm extends Component
{
    public $employee_id;
    public $leave_type_id;
    public $reason;
    public $start_date;
    public $end_date;
    public $notes;

    public $employees;
    public $leaveTypes;

    public function mount()
    {
        $this->employees = Employee::all();
        $this->leaveTypes = LeaveType::all();
    }

    public function submit()
    {
        $this->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'reason' => 'required|string|min:3',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $overlap = LeaveRequest::where('employee_id', $this->employee_id)
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                      ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                      ->orWhere(function($query) {
                          $query->where('start_date', '<=', $this->start_date)
                                ->where('end_date', '>=', $this->end_date);
                      });
            })
            ->exists();

        if ($overlap) {
            $this->addError('start_date', 'يوجد طلب إجازة متداخل لهذا الموظف في نفس الفترة.');
            return;
        }

        LeaveRequest::create([
            'employee_id' => $this->employee_id,
            'leave_type_id' => $this->leave_type_id,
            'reason' => $this->reason,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'notes' => $this->notes,
        ]);

        session()->flash('message', 'تم تقديم طلب الإجازة بنجاح.');
        $this->reset(['reason', 'start_date', 'end_date', 'notes']);
    }

    public function render()
    {
    return view('livewire.leave-employee-request-form');
    }
}
