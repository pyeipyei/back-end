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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->string('project_name');
            $table->string('contract_number')->nullable();
            $table->integer('customer_id')->unsigned();
            $table->integer('payment_status');
            $table->string('marketing_name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('contract_status');
            $table->foreignId('department_id')->constrained(
                table: 'departments'
            );
            $table->integer('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
