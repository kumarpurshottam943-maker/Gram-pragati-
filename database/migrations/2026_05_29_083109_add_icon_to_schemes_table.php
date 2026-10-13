<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. सरकारी योजनाओं के लिए टेबल (तस्वीर 62741.jpg के आइकॉन सपोर्ट के साथ)
        if (!Schema::hasTable('schemes')) {
            Schema::create('schemes', function (Blueprint $table) {
                $table->id();
                $table->string('title');          // योजना का नाम
                $table->string('category');       // केन्द्र सरकार, राज्य सरकार, अन्य योजनाएँ
                $table->string('scheme_icon')->default('fa-seedling'); // 🔥 नया आइकॉन कॉलम यहीं जोड़ दिया
                $table->text('eligibility');      // पात्रता
                $table->text('description');      // पूरा विवरण और लाभ
                $table->string('status')->default('Active');
                $table->timestamps();
            });
        }

        // 2. प्रमाणपत्र ट्रैकिंग के लिए टेबल
        if (!Schema::hasTable('certificate_tracks')) {
            Schema::create('certificate_tracks', function (Blueprint $table) {
                $table->id();
                $table->string('application_no')->unique(); // आवेदन संख्या
                $table->string('user_name');                // आवेदक का नाम
                $table->string('service_name');             // सेवा का नाम
                $table->string('status')->default('प्रक्रिया में है'); 
                $table->string('next_step')->nullable();    
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('schemes');
        Schema::dropIfExists('certificate_tracks');
    }
};