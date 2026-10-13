<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // (जैसे: Medical, Police, Fire, Disaster)
            $table->string('title');    // (जैसे: जिला अस्पताल सतना, पुलिस कंट्रोल रूम)
            $table->string('phone');    // (जैसे: 112, 07672-xxxxxx)
            $table->text('description')->nullable(); // (जैसे: 24 घंटे उपलब्ध)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_contacts');
    }
};