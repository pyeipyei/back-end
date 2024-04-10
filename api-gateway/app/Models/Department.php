<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory, SoftDeletes;  

    protected $table = "departments";

    protected $fillable = [
        'department_name',
        'marketing_name',
        'department_head',
        'user_id',
    ];

    public function projects() {
        return $this->hasMany(Project::class, 'department_id', 'id');
    }
}
