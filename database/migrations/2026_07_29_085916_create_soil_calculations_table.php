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
        Schema::create('soil_calculations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // कैलकुलेशन करने वाले यूजर की आईडी
            $table->string('farmer_name')->nullable(); // किसान का नाम
            $table->string('crop_name'); // फसल का नाम (गेहूँ, धान, आदि)
            $table->decimal('acreage', 5, 2); // खेत का क्षेत्रफल (एकड़ में)
            $table->string('soil_type'); // मिट्टी का प्रकार (दोमट, काली, आदि)
            $table->decimal('total_cost', 10, 2); // अनुमानित कुल लागत
            $table->text('fertilizer_suggestion')->nullable(); // खाद और उर्वरक का सुझाव
            $table->timestamps(); // created_at और updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soil_calculations');
    }
};