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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id')->index();
            $table->string('position');
            $table->string('monthly_period');
            $table->string('year_period');
            $table->date('payday');
            $table->unsignedBigInteger('salary');
            $table->unsignedBigInteger('total');
            $table->string('status')->default('pending');
            $table->unique(['employee_id', 'monthly_period', 'year_period']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
