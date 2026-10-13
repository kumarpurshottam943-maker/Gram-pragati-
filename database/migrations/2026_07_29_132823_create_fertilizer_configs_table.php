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
        Schema::create('fertilizer_configs', function (Blueprint $table) {
            $table->id();
            $table->decimal('urea_per_acre', 8, 2)->default(45.00);
            $table->decimal('dap_per_acre', 8, 2)->default(30.00);
            $table->decimal('tillage_cost', 10, 2)->default(1200.00);
            $table->decimal('seed_cost', 10, 2)->default(1500.00);
            $table->decimal('fertilizer_cost', 10, 2)->default(1800.00);
            $table->text('advisory_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fertilizer_configs');
    }
};