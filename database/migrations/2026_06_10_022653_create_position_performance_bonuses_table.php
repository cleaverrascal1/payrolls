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
        Schema::create('position_performance_bonuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('position_id')->index()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedBigInteger('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_performance_bonuses');
    }
};
