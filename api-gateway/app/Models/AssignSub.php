<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignSub extends Model
{
    protected $table = 'assigns';
    // define primary key
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'employee_id',
        'january',
        'february',
    ];
}
