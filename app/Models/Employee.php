<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{

    use HasFactory;

    protected $fillable = [
        'employee_name', 
        'employee_number',
        'email',
        'password', 
        'mobile_number',
        'address',
        'notes'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

     protected static function booted()
    {
        static::creating(function ($staff) {
            $lastNumber = self::max('id') + 1;
            $staff->employee_number = 'EMP-' . str_pad($lastNumber, 5, '0', STR_PAD_LEFT);
        });
    }
}
