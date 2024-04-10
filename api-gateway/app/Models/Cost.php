<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cost extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'costs';
    
    protected $fillable = [
        'estimate_cost',
        'actual_cost',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
