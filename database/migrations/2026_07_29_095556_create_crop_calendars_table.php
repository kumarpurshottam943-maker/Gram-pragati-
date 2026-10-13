<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crop_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('crop_name');       // (जैसे: गेहूँ, धान, चना)
            $table->string('season');          // (जैसे: रबी, खरीफ, जायद)
            $table->string('sowing_time');     // (जैसे: अक्टूबर - नवंबर)
            $table->string('irrigation_stage');// (जैसे: ताज मूल अवस्था, कल्ले फूटते समय)
            $table->string('fertilizer_info'); // (जैसे: यूरिया और डीएपी की मात्रा)
            $table->text('cultural_tips');     // (जैसे: पारंपरिक पर्व या विशेष कृषि सलाह)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crop_calendars');
    }
};