<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "employeemaster";
    protected $fillable = [
        'emp_cd',
        'emp_name', 
        'position',
        'group_cd',
        'gl_flag',
        'activation_code',
        'emp_email',
    ]; 
}
