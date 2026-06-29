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
        Schema::create('zoho_sales', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('zoho_id')->unique();
            $table->foreignUuid('employee_id')->nullable()->constrained()->nullOnDelete();
            $table->string('deal_name');
            $table->bigInteger('amount')->default(0);
            $table->string('stage')->nullable();
            $table->date('closing_date')->nullable();
            $table->timestamp('zoho_created_at')->nullable();
            $table->timestamp('zoho_updated_at')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoho_sales');
    }
};
