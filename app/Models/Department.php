<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'jefe_id',
        'num_empleados',
    ];

    public function jefe()
    {
        return $this->belongsTo(User::class, 'jefe_id');
    }
}
