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
        Schema::create('position_bonus_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('position_id')->index()->constrained()->cascadeOnDelete();
            $table->decimal('min_percentage', 5, 2 );
            $table->decimal('max_percentage', 5, 2)->nullable();
            $table->unsignedBigInteger('bonus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('position_bonus_rules');
    }
};
