<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table="customermaster";
    protected $fillable = [
        'customer_cd',
        'customer_name',
        'email',
        'phone',
        'address',
        'modified_date',
    ];
   
}
