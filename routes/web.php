<?php

// लारावेल को Route का बिल्कुल सही रास्ता बताने के लिए यह लाइन:
use Illuminate\Support\Facades\Route;
// आपके बैकएंड कंट्रोलर को राउट्स से जोड़ने के लिए यह लाइन:
use App\Http\Controllers\FarmerAuthController;

/*
|--------------------------------------------------------------------------
| GET Routes (पेज खोलने वाले रास्ते)
|--------------------------------------------------------------------------
*/

// मुख्य होमपेज का रास्ता
Route::get('/', function () {
    return view('welcome');
});

// लॉगइन पेज का रास्ता (🔥 एरर फिक्स: यहाँ नाम सेट कर दिया है ताकि मिडलवेयर पहचान सके)
Route::get('/login-form', function () {
    return view('login');
})->name('login');

// नए किसान रजिस्ट्रेशन पेज का रास्ता
Route::get('/register-form', function () {
    return view('register');
});

// 4. एडमिन डैशबोर्ड पेज खोलने का नया रास्ता (New Admin Route)
Route::get('/admin-dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return view('admin_dashboard');
    }
    return redirect('/login-form')->with('error', 'केवल एडमिन ही यहाँ आ सकते हैं!');
})->middleware('auth'); // केवल लॉगिन एडमिन ही इसे देख पाएँगे

// 🔥 यूज़र मैनेजमेंट के लिए नए लाइव राउट्स (User Management Live Routes)
// A. पंजीकृत यूज़र्स की लिस्ट देखने का रास्ता
Route::get('/admin/users', [FarmerAuthController::class, 'manageUsers'])->middleware('auth');

// B. एडमिन द्वारा यूज़र का अकाउंट सफलतापूर्वक अप्रूव करने का रास्ता
Route::post('/admin/users/{id}/approve', [FarmerAuthController::class, 'approveUser'])->middleware('auth');

// 🔥 C. एडमिन पैनल में मंडी मैनेजमेंट का नया पेज खोलने का रास्ता (Mandi Page Route)
Route::get('/admin/mandi', [FarmerAuthController::class, 'manageMandi'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| POST Routes (डेटाबेस में डेटा भेजने और प्रोसेस करने वाले नए रास्ते)
|--------------------------------------------------------------------------
*/

// 1. जब कोई रजिस्ट्रेशन फॉर्म सबमिट करेगा, तो डेटा यहाँ प्रोसेस होगा (404 Error Fix)
Route::post('/farmer-register', [FarmerAuthController::class, 'register']);

// 2. जब कोई लॉगिन फॉर्म सबमिट करेगा, तो डेटा यहाँ चेक होगा
Route::post('/farmer-login', [FarmerAuthController::class, 'login']);

// 3. जब कोई लॉगआउट बटन दबाएगा, तो उसका सेशन यहाँ बंद होगा (New Route)
Route::post('/farmer-logout', [FarmerAuthController::class, 'logout']);

// C. एडमिन द्वारा किसी यूज़र को डेटाबेस से डिलीट करने का रास्ता (POST/DELETE Form support के लिए)
Route::post('/admin/users/{id}/delete', [FarmerAuthController::class, 'deleteUser'])->middleware('auth');

// D. रोज़ सुबह सिंपल मंडी भाव अपडेट करने का फॉर्म प्रोसेस करने का रास्ता
Route::post('/admin/update-mandi', [FarmerAuthController::class, 'updateMandiRate'])->middleware('auth');

// 🔥 नोटिस व सूचनाओं के नए राउट्स
Route::get('/admin/notice', [FarmerAuthController::class, 'manageNotice'])->middleware('auth');
Route::post('/admin/add-notice', [FarmerAuthController::class, 'addNotice'])->middleware('auth');

// 🔥 सिटीजन वॉइस (शिकायत निवारण) के लाइव राउट्स
Route::get('/complaint/create', [FarmerAuthController::class, 'showComplaintForm'])->middleware('auth');
Route::post('/complaint/store', [FarmerAuthController::class, 'storeComplaint'])->middleware('auth');
Route::get('/admin/complaints', [FarmerAuthController::class, 'manageComplaints'])->middleware('auth');
Route::post('/admin/complaints/{id}/status', [FarmerAuthController::class, 'updateComplaintStatus'])->middleware('auth');

// 🔥 स्मार्ट कृषि, लागत कैलकुलेटर और एआई चैटबॉट के राउट्स
Route::get('/smart-krishi', [FarmerAuthController::class, 'showSmartKrishi'])->middleware('auth');
Route::post('/smart-krishi/calculate', [FarmerAuthController::class, 'calculateCost'])->middleware('auth');
Route::post('/smart-krishi/chatbot', [FarmerAuthController::class, 'askKisanMitra'])->middleware('auth');

// 🔥 स्मार्ट कृषि को एडमिन द्वारा कंट्रोल करने के राउट्स
Route::post('/admin/krishi/formula-update', [FarmerAuthController::class, 'updateKrishiFormula'])->middleware('auth');
Route::post('/admin/krishi/alert-store', [FarmerAuthController::class, 'storeKrishiAlert'])->middleware('auth');

// ई-पंचायत के राउट्स
Route::get('/e-panchayat', [FarmerAuthController::class, 'showEPanchayat'])->middleware('auth');
Route::post('/e-panchayat/track', [FarmerAuthController::class, 'trackCertificate'])->middleware('auth');

Route::get('/admin/schemes', [FarmerAuthController::class, 'manageSchemes'])->middleware('auth');
Route::post('/admin/schemes/store', [FarmerAuthController::class, 'storeScheme'])->middleware('auth');
Route::post('/admin/certificate/update', [FarmerAuthController::class, 'updateCertificateStatus'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 🐄 पशु स्वास्थ्य, कौशल विकास, विशेषज्ञ मीटिंग और प्रोफाइल के राउट्स (अपडेटेड)
|--------------------------------------------------------------------------
*/

// 1. पशु एवं स्वास्थ्य पेज (डेटाबेस आधारित कंट्रोलर से कनेक्टेड)
Route::get('/pashu-swasthya', [FarmerAuthController::class, 'showPashuSwasthya'])->middleware('auth');

// 🔥 एडमिन पैनल द्वारा पशु स्वास्थ्य मैनेजमेंट पेज खोलने और डॉक्टर/एम्बुलेंस डेटा स्टोर करने का रास्ता
Route::get('/admin/pashu-swasthya', [FarmerAuthController::class, 'adminManagePashu'])->middleware('auth');
Route::post('/admin/pashu-service/store', [FarmerAuthController::class, 'storePashuService'])->middleware('auth');

// 2. कौशल विकास (Skill-Up) पेज का रास्ता (डेटाबेस से कनेक्टेड)
Route::get('/skill-up', [FarmerAuthController::class, 'showSkillUp'])->middleware('auth');

// 3. विशेषज्ञ मीटिंग (Expert Meeting) पेज का रास्ता (डेटाबेस से कनेक्टेड)
Route::get('/expert-meeting', [FarmerAuthController::class, 'showExpertMeeting'])->middleware('auth');

// 4. यूज़र प्रोफाइल (Profile) पेज का रास्ता (🔥 कंट्रोलर से कनेक्टेड)
Route::get('/profile', [FarmerAuthController::class, 'showProfile'])->middleware('auth');
Route::post('/profile/update', [FarmerAuthController::class, 'updateProfile'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 🌾 खेती बाज़ार (KHETI BAZAAR) के नए लाइव राउट्स
|--------------------------------------------------------------------------
*/

// 1. खेती बाज़ार का मुख्य पेज खोलने का रास्ता (Our Services और साइडबार दोनों के लिए)
Route::get('/kheti-bazaar', [FarmerAuthController::class, 'showKhetiBazaar'])->middleware('auth');

// 2. त्वरित कार्य (Quick Actions) से किसान द्वारा खुद टूल किराए पर चढ़ाने का फ़ॉर्म प्रोसेस करने का रास्ता
Route::post('/kheti-bazaar/user-store-tool', [FarmerAuthController::class, 'userStoreTool'])->middleware('auth');

// 🔥 नया जोड़ा गया रूट: होमपेज के 'सामान बेचें' पॉप-अप फॉर्म से डेटा हैंडल करने के लिए
Route::post('/kheti-bazaar/user-store-product', [FarmerAuthController::class, 'userStoreProduct'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 👑 एडमिन कंट्रोल पैनल (ADMIN KHETI BAZAAR) के राउट्स
|--------------------------------------------------------------------------
*/

// 3. एडमिन पैनल में खेती बाज़ार का मैनेजमेंट पेज खोलने का रास्ता
Route::get('/admin/kheti-bazaar', [FarmerAuthController::class, 'manageKhetiBazaar'])->middleware('auth');

// 4. व्हाट्सएप पर आए विवरण को एडमिन द्वारा खुद अपलोड (Optional Form) करने का रास्ता
Route::post('/admin/kheti-bazaar/store-tool', [FarmerAuthController::class, 'adminStoreTool'])->middleware('auth');

// 5. एडमिन द्वारा गाँव का उत्पाद (घी, शहद आदि) सीधे बाज़ार में लाइव करने का रास्ता
Route::post('/admin/kheti-bazaar/store-product', [FarmerAuthController::class, 'adminStoreProduct'])->middleware('auth');

// 6. एडमिन द्वारा किसी भी पुरानी या फर्जी लिस्टिंग को डिलीट करने का रास्ता
Route::post('/admin/kheti-bazaar/delete-tool/{id}', [FarmerAuthController::class, 'deleteRentalTool'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 👑 एडमिन विशेषज्ञ मीटिंग मैनेजमेंट (ADMIN EXPERT MEETING) के नए राउट्स
|--------------------------------------------------------------------------
*/

// A. एडमिन पैनल में विशेषज्ञ मीटिंग मैनेजमेंट पेज खोलने का रास्ता
Route::get('/admin/expert-meeting', [FarmerAuthController::class, 'adminManageExperts'])->middleware('auth');

// B. एडमिन द्वारा नया विशेषज्ञ डेटाबेस में सेव करने का रास्ता
Route::post('/admin/expert-meeting/store', [FarmerAuthController::class, 'adminStoreExpert'])->middleware('auth');

// C. एडमिन द्वारा किसी विशेषज्ञ को डिलीट करने का रास्ता
Route::post('/admin/expert-meeting/delete/{id}', [FarmerAuthController::class, 'adminDeleteExpert'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 👑 एडमिन कौशल विकास मैनेजमेंट (ADMIN SKILL-UP MANAGEMENT) के नए राउट्स
|--------------------------------------------------------------------------
*/

// A. एडमिन पैनल में कौशल विकास (Skill-Up) मैनेजमेंट पेज खोलने का रास्ता
Route::get('/admin/skill-up', [FarmerAuthController::class, 'adminManageSkillUp'])->middleware('auth');

// B. एडमिन द्वारा नया स्किल कोर्स डेटाबेस में सेव करने का रास्ता
Route::post('/admin/skill-up/store', [FarmerAuthController::class, 'adminStoreSkill'])->middleware('auth');

// C. एडमिन द्वारा किसी स्किल कोर्स को डिलीट करने का रास्ता
Route::post('/admin/skill-up/delete/{id}', [FarmerAuthController::class, 'adminDeleteSkill'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 👑 एडमिन प्रोफाइल (ADMIN PROFILE) के नए राउट्स
|--------------------------------------------------------------------------
*/

// A. एडमिन प्रोफाइल पेज देखने का रास्ता
Route::get('/admin/profile', [FarmerAuthController::class, 'adminShowProfile'])->middleware('auth');

// B. एडमिन प्रोफाइल अपडेट करने का रास्ता
Route::post('/admin/profile/update', [FarmerAuthController::class, 'adminUpdateProfile'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 📊 एडमिन रिपोर्ट्स एंड एनालिटिक्स (ADMIN REPORTS & ANALYTICS) के राउट्स
|--------------------------------------------------------------------------
*/

Route::get('/admin/reports', [FarmerAuthController::class, 'adminReportsAnalytics'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| ⚙️ एडमिन सेटिंग्स (ADMIN SETTINGS) के नए राउट्स
|--------------------------------------------------------------------------
*/

// A. एडमिन सेटिंग्स पेज देखने का रास्ता
Route::get('/admin/settings', [FarmerAuthController::class, 'adminShowSettings'])->middleware('auth');

// B. एडमिन सेटिंग्स अपडेट करने का रास्ता
Route::post('/admin/settings/update', [FarmerAuthController::class, 'adminUpdateSettings'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 🌾 एडमिन स्मार्ट कृषि कॉन्फिगरेशन (ADMIN SMART KRISHI CONFIG) का नया राउट 🔥
|--------------------------------------------------------------------------
*/

// एडमिन पैनल से स्मार्ट कृषि कॉन्फिगरेशन (फार्मूला और सलाह) पेज खोलने का रास्ता
Route::get('/admin/krishi', [FarmerAuthController::class, 'manageSmartKrishi'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 🆘 हेल्प एंड सपोर्ट (HELP & SUPPORT) का नया राउट 🔥
|--------------------------------------------------------------------------
*/

// यूज़र के लिए हेल्प एंड सपोर्ट पेज खोलने का रास्ता
Route::get('/help-support', [FarmerAuthController::class, 'showHelpSupport'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 🔥 स्मार्ट कृषि - चैटबॉट और क्रॉप डॉक्टर एआई के नए लाइव राउट्स (नवीनतम अपडेट)
|--------------------------------------------------------------------------
*/

// 1. स्मार्ट कृषि चैटबॉट (KisanMitra AI) के लिए मैसेज हैंडल करने का रूट
Route::post('/smart-krishi/chatbot', [FarmerAuthController::class, 'askKisanMitra'])->middleware('auth');

// 2. फसल डॉक्टर एआई (Crop Doctor AI) के लिए फसल की फोटो अपलोड और एनालाइज करने का रूट
Route::post('/smart-krishi/analyze-crop', [FarmerAuthController::class, 'analyzeCropImage'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| 🔥 फसल डॉक्टर एआई (Expert Review) एडमिन रूट्स (नया जोड़ा गया)
|--------------------------------------------------------------------------
*/
Route::get('/admin/crop-diagnoses', [FarmerAuthController::class, 'manageCropDiagnoses'])->middleware('auth');
Route::post('/admin/crop-diagnoses/{id}/reply', [FarmerAuthController::class, 'replyCropDiagnosis'])->middleware('auth');


/*
|--------------------------------------------------------------------------
| 🌾 विशेष ग्रामीण सेवाएँ (Special Rural Services Routes)
|--------------------------------------------------------------------------
*/
Route::get('/weather-advisory', [FarmerAuthController::class, 'showWeatherAdvisory'])->middleware('auth');
Route::get('/soil-calculator', [FarmerAuthController::class, 'showSoilCalculator'])->middleware('auth');
Route::get('/emergency-help', [FarmerAuthController::class, 'showEmergencyHelp'])->middleware('auth');
Route::get('/crop-calendar', [FarmerAuthController::class, 'showCropCalendar'])->middleware('auth');
Route::get('/green-village', [FarmerAuthController::class, 'showGreenVillage'])->middleware('auth');

// 🔥 एडमिन वेदर मैनेजमेंट राउट्स (नया जोड़ा गया)
Route::get('/admin/weather-advisory', [FarmerAuthController::class, 'adminManageWeather'])->middleware('auth');
Route::post('/admin/weather-advisory/update', [FarmerAuthController::class, 'adminUpdateWeather'])->middleware('auth');

// 🚜 परिवहन एवं वाहन किराए पर लेने और स्टोर करने के राउट्स (व्यवस्थित)
Route::get('/local-transport', [FarmerAuthController::class, 'showLocalTransport'])->middleware('auth');
Route::post('/local-transport/store', [FarmerAuthController::class, 'storeTransportVehicle'])->middleware('auth');

// 🌱 मिट्टी एवं खाद कैलकुलेटर के राउट्स
Route::get('/soil-calculator', [FarmerAuthController::class, 'showSoilCalculator'])->middleware('auth');
Route::post('/soil-calculator/calculate', [FarmerAuthController::class, 'calculateSoilFertilizer'])->middleware('auth');

// ⚙️ एडमिन के लिए खाद कैलकुलेटर फॉर्मूला मैनेज करने के राउट्स
Route::get('/admin/fertilizer-config', [FarmerAuthController::class, 'manageFertilizerConfig'])->middleware('auth');
Route::post('/admin/fertilizer-config/update', [FarmerAuthController::class, 'updateFertilizerConfig'])->middleware('auth');

// 🚨 आपातकालीन हेल्प डेस्क (Emergency Help Desk) का राउट
Route::get('/emergency-help', [FarmerAuthController::class, 'showEmergencyHelp'])->middleware('auth');

// 🌾 फसल एवं कृषि कैलेंडर का राउट
Route::get('/crop-calendar', [FarmerAuthController::class, 'showCropCalendar'])->middleware('auth');

// 🌱 हरित ग्राम जागरूकता और जैविक खेती का राउट
Route::get('/green-village', [FarmerAuthController::class, 'showGreenVillage'])->middleware('auth');

// 🚜 एडमिन द्वारा परिवहन/वाहन लिस्टिंग देखने और मैनेज करने का रास्ता
Route::get('/admin/transport-manage', [FarmerAuthController::class, 'adminManageTransport'])->middleware('auth');

// एडमिन द्वारा किसी वाहन को हटाने (Delete) करने का रास्ता
Route::post('/admin/transport-delete/{id}', [FarmerAuthController::class, 'adminDeleteTransport'])->middleware('auth');

/*
|--------------------------------------------------------------------------
| 🚨 आपातकालीन हेल्प डेस्क (Emergency Help Desk Routes)
|--------------------------------------------------------------------------
*/

// किसानों के लिए आपातकालीन नंबर देखने का पेज
Route::get('/emergency-help', [FarmerAuthController::class, 'showEmergencyHelp'])->middleware('auth');

// एडमिन के लिए आपातकालीन नंबर मैनेज करने का पेज
Route::get('/admin/emergency-help', [FarmerAuthController::class, 'adminManageEmergency'])->middleware('auth');

// एडमिन द्वारा नया नंबर सेव करने का राउट
Route::post('/admin/emergency-help/store', [FarmerAuthController::class, 'adminStoreEmergency'])->middleware('auth');

// एडमिन द्वारा नंबर डिलीट करने का राउट
Route::post('/admin/emergency-help/delete/{id}', [FarmerAuthController::class, 'adminDeleteEmergency'])->middleware('auth');

Route::get('/admin/crop-calendar', [FarmerAuthController::class, 'adminManageCropCalendar'])->middleware('auth');

// 🌱 हरित ग्राम जागरूकता (Green Village Awareness Routes)
Route::get('/green-village', [FarmerAuthController::class, 'showGreenVillage'])->middleware('auth');
Route::get('/admin/green-village', [FarmerAuthController::class, 'adminManageGreenVillage'])->middleware('auth');
Route::post('/admin/green-village/store', [FarmerAuthController::class, 'adminStoreGreenVillage'])->middleware('auth');
Route::post('/admin/green-village/delete/{id}', [FarmerAuthController::class, 'adminDeleteGreenVillage'])->middleware('auth');
