<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. टूल रेंटल (खेती का OLX) टेबल - तस्वीर 62766.jpg के अनुसार
        if (!Schema::hasTable('rental_tools')) {
            Schema::create('rental_tools', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->nullable(); // टूल डालने वाले यूज़र की आईडी
                $table->string('owner_name');          // मालिक/किसान का नाम
                $table->string('tool_type');           // ट्रैक्टर, थ्रेशर, पंप, स्प्रेयर
                $table->string('tool_name');           // जैसे: John Deere 5310
                $table->string('location');            // जैसे: Satna, MP / Kanpur, UP
                $table->decimal('price_per_day', 10, 2); // किराया प्रति दिन (तस्वीर के अनुसार)
                $table->string('phone');               // संपर्क नंबर (व्हाट्सएप/कॉल के लिए)
                $table->string('image_path')->nullable(); // ट्रैक्टर या मशीन की फोटो का रास्ता
                $table->text('description')->nullable(); // अन्य विवरण
                $table->string('status')->default('Available'); // Available या Booked
                $table->timestamps();
            });
        }

        // 2. गाँव का बाज़ार (Direct Sell) टेबल - तस्वीर 62769.jpg के उत्पाद कार्ड अनुसार
        if (!Schema::hasTable('village_products')) {
            Schema::create('village_products', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->nullable();
                $table->string('seller_name');         // बेचने वाले का नाम
                $table->string('product_category');    // अनाज, शहद, घी, हस्तशिल्प, अन्य
                $table->string('product_name');        // जैसे: शुद्ध गाय का घी (1kg)
                $table->decimal('price', 10, 2);       // उत्पाद का दाम
                $table->string('location');            // स्थान
                $table->string('phone');               // संपर्क नंबर
                $table->string('image_path')->nullable(); // उत्पाद की सुंदर फोटो
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_tools');
        Schema::dropIfExists('village_products');
    }
};