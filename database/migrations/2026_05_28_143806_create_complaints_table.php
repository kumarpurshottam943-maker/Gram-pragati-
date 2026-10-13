<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // शिकायत करने वाले की ID (लॉगिन यूज़र)
            $table->string('complaint_id')->unique();        // यूनिक आईडी जैसे CMP123456
            $table->string('title');                         // समस्या का शीर्षक
            $table->string('category');                      // श्रेणी (सड़क, पानी, बिजली, सफाई, अन्य)
            $table->string('ward');                          // वार्ड नंबर या स्थान
            $table->text('description');                     // समस्या की पूरी जानकारी
            $table->string('image')->nullable();             // शिकायत की फोटो का रास्ता
            $table->string('status')->default('Pending');    // Pending, In Progress, Resolved
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};