<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendance';

    protected $fillable = [
        'employee_id',
        'attendance_id',
        'department_id',
        'check_in',
        'check_out',
        'late',
        'overtime'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
