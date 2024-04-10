<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    use HasFactory;
    // define table name
    protected $table = 'assigns';
    // define primary key
    protected $primaryKey = 'id';
    protected $fillable = [
        'employee_code',
        'january',
        'february',
        'march',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
        'proposal_status',
        'marketing_status',
        'careersheet_status',
        'careersheet_link',
        'man_month',
        'unit_price',
        'year',
        'user_id'
    ];
}
