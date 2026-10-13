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
        Schema::create('mandi_rates', function (Blueprint $table) {
            $table->id();
            $table->string('state');      // राज्य (जैसे: Madhya Pradesh, Bihar)
            $table->string('district');   // जिला (जैसे: Satna, Bhagalpur)
            $table->string('crop_name');  // फसल का नाम (जैसे: गेहूँ, धान)
            $table->integer('rate');      // भाव (₹ प्रति क्विंटल)
            $table->string('mode')->default('auto'); // auto या manual
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mandi_rates');
    }
};