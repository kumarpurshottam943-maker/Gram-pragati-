<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('green_villages', function (Blueprint $table) {
            $table->id();
            $table->string('title');              // (जैसे: वर्मीकंपोस्ट खाद बनाने की विधि)
            $table->string('category');           // (जैसे: जैविक खेती, जल संरक्षण, गोबर गैस)
            $table->text('description');          // (विस्तृत जानकारी या विवरण)
            $table->string('benefit_tag');        // (जैसे: मिट्टी की उपजाऊ शक्ति बढ़ाए)
            $table->string('video_type');         // (यानी 'youtube' या 'local')
            $table->text('video_path');           // (YouTube का एम्बेड लिंक या लोकल/AI वीडियो का पाथ)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('green_villages');
    }
};