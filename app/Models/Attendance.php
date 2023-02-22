<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendance';

    protected $fillable = [
        'user_id',
        'attendance_id',
        'check_in',
        'check_out',
        'late',
        'overtime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
