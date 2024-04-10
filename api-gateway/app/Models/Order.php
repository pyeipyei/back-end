<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'project_type_id',
        'ses_project_leader',
        'ses_estimate_number',
        'ses_approval_number',
        'ses_order_number',
        'ses_delivery_date',
        "ses_pm_man_month",
        "ses_pm_average_unit_price",
        "ses_pl_man_month",
        "ses_pl_average_unit_price",
        "ses_se_man_month",
        "ses_se_average_unit_price",
        "ses_pg_man_month",
        "ses_pg_average_unit_price",
        "ses_oh_man_month",
        "ses_oh_average_unit_price",
        'ses_order_amount',
        'ses_acceptance_billing_date',
        'ses_payment_date',
        'jp_project_leader',
        'jp_estimate_number',
        'jp_approval_number',
        'jp_order_number',
        'jp_delivery_date',
        "jp_pm_man_month",
        "jp_pm_average_unit_price",
        "jp_pl_man_month",
        "jp_pl_average_unit_price",
        "jp_se_man_month",
        "jp_se_average_unit_price",
        "jp_pg_man_month",
        "jp_pg_average_unit_price",
        "jp_oh_man_month",
        "jp_oh_average_unit_price",
        'jp_order_amount',
        'jp_acceptance_billing_date',
        'jp_payment_date',
        'mm_project_leader',
        'mm_estimate_number',
        "mm_approval_number",
        "mm_order_number",
        'mm_delivery_date',
        "mm_pm_man_month",
        "mm_pm_average_unit_price",
        "mm_pl_man_month",
        "mm_pl_average_unit_price",
        "mm_se_man_month",
        "mm_se_average_unit_price",
        "mm_pg_man_month",
        "mm_pg_average_unit_price",
        "mm_oh_man_month",
        "mm_oh_average_unit_price",
        'mm_gicj_fee',
        'mm_order_amount',
        'mm_billing_amount',
        'mm_acceptance_billing_date',
        'mm_payment_date',
        'project_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function assign()
    {
        return $this->belongsTo(Assign::class);
    }
}
