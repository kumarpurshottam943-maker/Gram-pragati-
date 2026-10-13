<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fertilizer_configs', function (Blueprint $table) {
            $table->id();
            $table->decimal('urea_per_acre', 8, 2)->default(45.00); // प्रति एकड़ यूरिया (किग्रा)
            $table->decimal('dap_per_acre', 8, 2)->default(30.00);  // प्रति एकड़ डीएपी (किग्रा)
            $table->decimal('tillage_cost', 10, 2)->default(1200.00); // जुताई खर्च
            $table->decimal('seed_cost', 10, 2)->default(1500.00);    // बीज खर्च
            $table->decimal('fertilizer_cost', 10, 2)->default(1800.00); // उर्वरक खर्च
            $table->text('advisory_message')->nullable(); // विशेष सलाह
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fertilizer_configs');
    }
};