<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LeaveRequestController extends Controller
{
 
   public function generateLeaveReport()
{
    $employees = Employee::with(['leaveRequests', 'leaveRequests.leaveType'])->get();

    $reportData = $employees->map(function ($employee) {
        $lastLeaveRequest = $employee->leaveRequests->sortByDesc('created_at')->first();

        return [
            'employee_name' => $this->fixArabic($employee->employee_name),
            'employee_number' => $employee->employee_number,
            'mobile_number' => $employee->mobile_number,
            'leave_requests_count' => $employee->leaveRequests->count(),
            'last_leave_request_date' => $lastLeaveRequest ? $lastLeaveRequest->created_at->format('Y-m-d') : 'غير متوفر',
            'last_leave_type' => $lastLeaveRequest ? $this->fixArabic($lastLeaveRequest->leaveType->name) : 'غير متوفر'
        ];
    });

    $pdf = Pdf::loadView('reports.leave_report', compact('reportData'))
              ->setOption('defaultFont', 'DejaVu Sans')
              ->setOption('fontDir', storage_path('fonts'))
              ->setOption('fontCache', storage_path('fonts'))
              ->setOption('isHtml5ParserEnabled', true)
              ->setOption('isRemoteEnabled', true)
              ->setOption('isPhpEnabled', true)
              ->setPaper('a4', 'landscape');

    return $pdf->download('تقرير_الإجازات.pdf');
}

private function fixArabic($text)
{
    return iconv('utf-8', 'utf-8//TRANSLIT', $text);
}


}
