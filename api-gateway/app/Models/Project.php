<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projects';
    
    protected $fillable = [
        'year',
        'project_name',
        'contract_number',
        'customer_id',
        'payment_status',
        'marketing_name',
        'start_date',
        'end_date',
        'contract_status',
        'department_id',
        'user_id'
    ];

    protected $casts = [
        'payment_status'    => 'string',
        'contract_status'   => 'string',
    ];

    public function getPaymentStatusAttribute($value)
    {
        return $value == 0 ? 'waiting' : 'paid';
    }

    public function getContractStatusAttribute($value)
    {
        return $value == 0 ? 'waiting' : 'contracted';
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function assign()
    {
        return $this->hasMany(Assign::class);
    }

    public function cost()
    {
        return $this->hasOne(Cost::class);
    }
}
