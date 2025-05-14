<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveRequestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/generate-leave-report', [LeaveRequestController::class, 'generateLeaveReport'])->name('generate-leave-report');;

Route::get('/leave-request', function () {
    return view('leave-request');
});