<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. लागत गणना के फॉर्मूले स्टोर करने के लिए टेबल
        if (!Schema::hasTable('krishi_formulas')) {
            Schema::create('krishi_formulas', function (Blueprint $table) {
                $table->id();
                $table->string('crop_name');       // गेहूँ, धान, मक्का, चरी
                $table->integer('seed_per_acre');   // प्रति एकड़ बीज
                $table->integer('fertilizer_per_acre'); // प्रति एकड़ खाद
                $table->text('admin_suggestion');   // वैज्ञानिक सुझाव
                $table->timestamps();
            });
        }

        // 2. आपातकालीन मौसम अलर्ट्स जारी करने के लिए टेबल
        if (!Schema::hasTable('krishi_alerts')) {
            Schema::create('krishi_alerts', function (Blueprint $table) {
                $table->id();
                $table->string('location')->default('Satna');
                $table->string('alert_level')->default('Warning'); 
                $table->text('message');            // चेतावनी का संदेश
                $table->string('status')->default('Active');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('krishi_formulas');
        Schema::dropIfExists('krishi_alerts');
    }
};