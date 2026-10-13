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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('title');                // कोर्स का नाम (जैसे: ड्रिप इरिगेशन)
            $table->string('category');             // श्रेणी (जैसे: आधुनिक कृषि)
            $table->string('duration');             // अवधि (जैसे: 2 सप्ताह)
            $table->text('description');            // कोर्स का विवरण
            $table->string('status')->default('Active'); // स्थिति (Active / Inactive)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};