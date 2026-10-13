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
        Schema::create('experts', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // विशेषज्ञ / डॉक्टर का नाम
            $table->string('designation');          // पद / विशेषज्ञता (जैसे: वरिष्ठ कृषि वैज्ञानिक)
            $table->text('description');            // विवरण / काम की जानकारी
            $table->string('availability');         // कब उपलब्ध हैं (जैसे: कल सुबह 11:00 AM)
            $table->string('image')->nullable();    // विशेषज्ञ की फोटो का पाथ
            $table->string('status')->default('Active'); // स्थिति (Active / Inactive)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experts');
    }
};