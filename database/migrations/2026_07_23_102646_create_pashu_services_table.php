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
        // 🔥 यहाँ से आपको अपना कोड रखना है (पुराना खाली ढांचा हटाकर इसे डालें)
        Schema::create('pashu_services', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'doctor', 'ambulance', 'scheme', 'certificate'
            $table->string('title'); // डॉक्टर का नाम या एंबुलेंस का नाम
            $table->string('phone')->nullable(); // फोन नंबर
            $table->text('description')->nullable(); // पता या अन्य विवरण
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pashu_services');
    }
};