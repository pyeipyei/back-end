<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assigns', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code');
            $table->string('january', 900)->nullable();
            $table->string('february', 900)->nullable();
            $table->string('march', 900)->nullable();
            $table->string('april', 900)->nullable();
            $table->string('may', 900)->nullable();
            $table->string('june', 900)->nullable();
            $table->string('july', 900)->nullable();
            $table->string('august', 900)->nullable();
            $table->string('september', 900)->nullable();
            $table->string('october', 900)->nullable();
            $table->string('november', 900)->nullable();
            $table->string('december', 900)->nullable();
            $table->string('marketing_status');
            $table->string('proposal_status')->nullable();
            $table->boolean('careersheet_status')->nullable();
            $table->string('careersheet_link')->nullable();
            $table->double('man_month')->nullable();
            $table->double('unit_price')->nullable();
            $table->integer('year');
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigns');
    }
};
