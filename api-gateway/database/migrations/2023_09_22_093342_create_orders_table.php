<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('ses_project_leader')->nullable();
            $table->string('ses_estimate_number')->nullable();
            $table->string('ses_approval_number')->nullable();
            $table->string('ses_order_number')->nullable();
            $table->date('ses_delivery_date')->nullable();
            $table->double('ses_pm_man_month')->nullable();
            $table->double('ses_pm_average_unit_price')->nullable();
            $table->double('ses_pl_man_month')->nullable();
            $table->double('ses_pl_average_unit_price')->nullable();
            $table->double('ses_se_man_month')->nullable();
            $table->double('ses_se_average_unit_price')->nullable();
            $table->double('ses_pg_man_month')->nullable();
            $table->double('ses_pg_average_unit_price')->nullable();
            $table->double('ses_oh_man_month')->nullable();
            $table->double('ses_oh_average_unit_price')->nullable();
            $table->double('ses_order_amount')->nullable();
            $table->date('ses_acceptance_billing_date')->nullable();
            $table->date('ses_payment_date')->nullable();
            $table->string('jp_project_leader')->nullable();
            $table->string('jp_estimate_number')->nullable();
            $table->string('jp_approval_number')->nullable();
            $table->string('jp_order_number')->nullable();
            $table->date('jp_delivery_date')->nullable();
            $table->double('jp_pm_man_month')->nullable();
            $table->double('jp_pm_average_unit_price')->nullable();
            $table->double('jp_pl_man_month')->nullable();
            $table->double('jp_pl_average_unit_price')->nullable();
            $table->double('jp_se_man_month')->nullable();
            $table->double('jp_se_average_unit_price')->nullable();
            $table->double('jp_pg_man_month')->nullable();
            $table->double('jp_pg_average_unit_price')->nullable();
            $table->double('jp_oh_man_month')->nullable();
            $table->double('jp_oh_average_unit_price')->nullable();
            $table->double('jp_order_amount')->nullable();
            $table->date('jp_acceptance_billing_date')->nullable();
            $table->date('jp_payment_date')->nullable();
            $table->string('mm_project_leader')->nullable();
            $table->string('mm_estimate_number')->nullable();
            $table->string('mm_approval_number')->nullable();
            $table->string('mm_order_number')->nullable();
            $table->date('mm_delivery_date')->nullable();
            $table->double('mm_pm_man_month')->nullable();
            $table->double('mm_pm_average_unit_price')->nullable();
            $table->double('mm_pl_man_month')->nullable();
            $table->double('mm_pl_average_unit_price')->nullable();
            $table->double('mm_se_man_month')->nullable();
            $table->double('mm_se_average_unit_price')->nullable();
            $table->double('mm_pg_man_month')->nullable();
            $table->double('mm_pg_average_unit_price')->nullable();
            $table->double('mm_oh_man_month')->nullable();
            $table->double('mm_oh_average_unit_price')->nullable();
            $table->integer('mm_gicj_fee')->nullable();
            $table->double('mm_order_amount')->nullable();
            $table->double('mm_billing_amount')->nullable();
            $table->date('mm_acceptance_billing_date')->nullable();
            $table->date('mm_payment_date')->nullable();
            $table->foreignId('project_type_id')->constrained(
                table: 'project_types'
            );
            $table->foreignId('project_id')->constrained(
                table: 'projects'
            );
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
