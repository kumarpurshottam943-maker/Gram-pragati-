<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. आपका पुराना असली एडमिन डेटा (यह बिल्कुल वैसा ही सुरक्षित है)
        DB::table('users')->insert([
            'name' => 'Purshottam Kumar',
            'email' => 'purushottamkumar22238@gmail.com',
            'phone' => '6299822734',
            'role' => 'admin', 
            'location' => 'Satna', 
            'profile_image' => 'images/pur.jpg', 
            'password' => Hash::make('Rail@$12345'), // आपका पासवर्ड
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. 🔥 नया अपडेट: सतना और भागलपुर के लिए विस्तृत मंडी रेट्स (बहुत सारी फसलों के साथ)
        DB::table('mandi_rates')->insert([
            // 🌾 मध्य प्रदेश (सतna मंडी - आपके वर्तमान स्थान के लिए)
            ['state' => 'Madhya Pradesh', 'district' => 'Satna', 'crop_name' => 'गेहूँ', 'rate' => 2250, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Madhya Pradesh', 'district' => 'Satna', 'crop_name' => 'धान (Basmati)', 'rate' => 3450, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Madhya Pradesh', 'district' => 'Satna', 'crop_name' => 'चना', 'rate' => 5300, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Madhya Pradesh', 'district' => 'Satna', 'crop_name' => 'सरसों', 'rate' => 5450, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Madhya Pradesh', 'district' => 'Satna', 'crop_name' => 'मक्का', 'rate' => 2050, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Madhya Pradesh', 'district' => 'Satna', 'crop_name' => 'सोयाबीन', 'rate' => 4600, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Madhya Pradesh', 'district' => 'Satna', 'crop_name' => 'आलू', 'rate' => 1200, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Madhya Pradesh', 'district' => 'Satna', 'crop_name' => 'प्याज', 'rate' => 1500, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],

            // 🌾 बिहार (भागलपुर मंडी - आपके गृह जिले के लिए)
            ['state' => 'Bihar', 'district' => 'Bhagalpur', 'crop_name' => 'गेहूँ', 'rate' => 2300, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Bihar', 'district' => 'Bhagalpur', 'crop_name' => 'धान (मंसूरी)', 'rate' => 2180, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Bihar', 'district' => 'Bhagalpur', 'crop_name' => 'मक्का', 'rate' => 2100, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Bihar', 'district' => 'Bhagalpur', 'crop_name' => 'सरसों', 'rate' => 5600, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Bihar', 'district' => 'Bhagalpur', 'crop_name' => 'चना', 'rate' => 5400, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Bihar', 'district' => 'Bhagalpur', 'crop_name' => 'जूट', 'rate' => 6100, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Bihar', 'district' => 'Bhagalpur', 'crop_name' => 'आलू', 'rate' => 1350, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
            ['state' => 'Bihar', 'district' => 'Bhagalpur', 'crop_name' => 'प्याज', 'rate' => 1650, 'mode' => 'auto', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}