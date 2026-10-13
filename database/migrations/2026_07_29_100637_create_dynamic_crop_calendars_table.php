<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dynamic_crop_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('month_name');          // (जैसे: January, February, June, October आदि)
            $table->string('season');              // (जैसे: रबी, खरीफ, जायद, बारहमासी)
            $table->string('crop_category');       // (जैसे: अनाज, दलहन, तिलहन, सब्जी, फल)
            $table->string('crop_name');           // (जैसे: गेहूँ, धान, चना, सरसों, टमाटर, आम)
            $table->string('stage_title');         // (जैसे: बुवाई, निराई-गुड़ाई, सिंचाई, कटाई)
            $table->text('agricultural_tips');     // (उचित खाद, बीज की मात्रा और विशेष कृषि सलाह)
            $table->string('festival_name')->nullable(); // (संबंधित सांस्कृतिक या कृषि पर्व)
            $table->text('festival_desc')->nullable();   // (पर्व का महत्व और परंपरा)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dynamic_crop_calendars');
    }
};