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
        Schema::create('transport_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // वाहन जोड़ने वाले यूजर की आईडी
            $table->string('owner_name')->default('किसान भाई'); // वाहन मालिक का नाम
            $table->string('vehicle_type'); // वाहन की श्रेणी (पिकअप, ट्रैक्टर, आदि)
            $table->string('vehicle_name'); // वाहन का नाम और मॉडल
            $table->string('location'); // स्थान / क्षेत्र
            $table->decimal('price_per_day', 10, 2); // किराया प्रतिदिन
            $table->string('phone'); // मोबाइल / व्हाट्सएप नंबर
            $table->string('image_path')->nullable(); // वाहन की फोटो का पाथ
            $table->text('description')->nullable(); // विशेष विवरण
            $table->string('status')->default('Available'); // उपलब्धता स्थिति
            $table->timestamps(); // created_at और updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_vehicles');
    }
};