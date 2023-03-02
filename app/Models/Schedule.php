<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'day_of_week',
        'department_id',
        'department'
    ];

    protected $table = 'fixed_schedule';

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}