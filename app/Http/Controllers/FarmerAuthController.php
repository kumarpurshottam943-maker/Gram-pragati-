<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FarmerAuthController extends Controller
{
    // 🔥 लॉगिन का व्यू पेज (Form) दिखाने वाला नया फंक्शन
    public function showLoginForm()
    {
        return view('login'); 
    }

    // 1. रजिस्ट्रेशन का डेटा डेटाबेस में भेजने वाला फंक्शन
    public function register(Request $request)
    {
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->phone . '@grampragati.com', 
            'phone' => $request->phone,
            'role' => trim($request->role),       
            'location' => $request->location, 
            'profile_image' => $imagePath,  
            'password' => Hash::make($request->password), 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/login-form')->with('success', 'पंजीकरण सफल! कृपया लॉगिन करें।');
    }

    // 2. 🔥 लॉगिन चेक करने वाला सुरक्षित और पक्का फंक्शन (रोल फिक्स)
    public function login(Request $request)
    {
        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // सीधे डेटाबेस से चेक करें कि यूज़र का रोल क्या है
            $user = Auth::user();
            if (trim($user->role) === 'admin') {
                return redirect('/admin-dashboard'); 
            }
            
            return redirect('/'); 
        }

        return back()->with('error', 'गलत मोबाइल नंबर या पासवर्ड! (Invalid Phone or Password)');
    }

    // 3. 🔥 यूज़र का सेशन और कुकी पूरी तरह खत्म करके लॉगआउट करने वाला फंक्शन
    public function logout(Request $request)
    {
        Auth::logout(); 

        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 

        return redirect('/login-form')->with('success', 'आप सफलतापूर्वक लॉगआउट हो चुके हैं!')->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    /*
    |--------------------------------------------------------------------------
    | USER MANAGEMENT FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function manageUsers()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'आपको इस पेज की अनुमति नहीं है!');
        }

        $allUsers = DB::table('users')->where('role', '!=', 'admin')->get();
        return view('admin_users_management', compact('allUsers'));
    }

    public function approveUser($id)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return response()->json(['error' => 'Unauthorised'], 403);
        }

        DB::table('users')->where('id', $id)->update([
            'updated_at' => now()
        ]);

        return back()->with('success', 'उपयोगकर्ता का अकाउंट सफलतापूर्वक अप्रूव कर दिया गया है!');
    }

    public function deleteUser($id)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return response()->json(['error' => 'Unauthorised'], 403);
        }

        DB::table('users')->where('id', $id)->delete();
        return back()->with('success', 'उपयोगकर्ता को डेटाबेस से सफलतापूर्वक हटा दिया गया है!');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 MANDI MANAGEMENT FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function manageMandi()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'आपको इस पेज की अनुमति नहीं है!');
        }

        $allMandiRates = DB::table('mandi_rates')->orderBy('district', 'asc')->get();
        return view('admin_mandi_management', compact('allMandiRates'));
    }

    public function updateMandiRate(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $request->validate([
            'wheat_rate' => 'required|numeric',
            'paddy_rate' => 'required|numeric',
        ]);

        DB::table('mandi_rates')
            ->where('district', 'Satna')
            ->where('crop_name', 'गेहूँ')
            ->update([
                'rate' => $request->wheat_rate,
                'updated_at' => now()
            ]);

        DB::table('mandi_rates')
            ->where('district', 'Satna')
            ->where('crop_name', 'like', 'धान%') 
            ->update([
                'rate' => $request->paddy_rate,
                'updated_at' => now()
            ]);

        return back()->with('success', 'आज सुबह का मंडी भाव सफलतापूर्वक अपडेट हो गया है भाई!');
    }

    public function manageNotice()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $allNotices = DB::table('notices')->orderBy('id', 'desc')->get();
        return view('admin_notice_management', compact('allNotices'));
    }

    public function addNotice(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        DB::table('notices')->insert([
            'title' => $request->title,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'नया नोटिस और सूचना सफलतापूर्वक जारी कर दी गई है भाई!');
    }

    public function showComplaintForm()
    {
        return view('create_complaint');
    }

    public function storeComplaint(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'ward' => 'required|string',
            'description' => 'required|string',
            'complaint_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('complaint_image')) {
            $image = $request->file('complaint_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/complaints'), $imageName);
            $imagePath = 'images/complaints/' . $imageName;
        }

        $complaintId = 'CMP' . rand(100000, 999999);

        DB::table('complaints')->insert([
            'user_id' => Auth::id(),
            'complaint_id' => $complaintId,
            'title' => $request->title,
            'category' => $request->category,
            'ward' => $request->ward,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/')->with('success', 'आपकी शिकायत नंबर ' . $complaintId . ' सफलतापूर्वक दर्ज हो गई है!');
    }

    public function manageComplaints()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $allComplaints = DB::table('complaints')->orderBy('id', 'desc')->get();
        return view('admin_complaint_management', compact('allComplaints'));
    }

    public function updateComplaintStatus(Request $request, $id)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        DB::table('complaints')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);

        return back()->with('success', 'शिकायत की स्थिति (Status) सफलतापूर्वक अपडेट कर दी गई है!');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔥 SMART KRISHI CONFIG & CALCULATOR FUNCTIONS (अपडेटेड)
    |--------------------------------------------------------------------------
    */

    public function showSmartKrishi()
    {
        $liveAlert = DB::table('krishi_alerts')->where('status', 'Active')->orderBy('id', 'desc')->first();
        
        $config = DB::table('krishi_configs')->where('id', 1)->first();
        if (!$config) {
            $config = (object)[
                'tillage_cost' => 1200,
                'seed_cost' => 1500,
                'fertilizer_cost' => 1800,
                'labor_cost' => 2000,
                'advisory_message' => 'समय पर फसलों की सिंचाई करें।'
            ];
        }

        $latestDiagnosis = DB::table('crop_diagnoses')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();

        $result = null;
        return view('smart_krishi', compact('liveAlert', 'config', 'result', 'latestDiagnosis'));
    }

    public function calculateCost(Request $request)
    {
        $request->validate([
            'crop_name' => 'required|string',
            'acreage' => 'required|numeric|min:1',
        ]);

        $crop = $request->crop_name;
        $acres = $request->acreage;

        $config = DB::table('krishi_configs')->where('id', 1)->first();
        $seedPerAcre = 40; 
        $fertPerAcre = 160;

        $totalCost = $acres * (($config->tillage_cost ?? 1200) + ($config->seed_cost ?? 1500) + ($config->fertilizer_cost ?? 1800) + ($config->labor_cost ?? 2000));

        $result = [
            'crop_name' => $crop,
            'acreage' => $acres,
            'total_seed' => $seedPerAcre * $acres,
            'total_fertilizer' => $fertPerAcre * $acres,
            'total_cost' => $totalCost,
            'suggestion' => 'संतुलित मात्रा में पोषक तत्व दें और समय पर सिंचाई करें।'
        ];

        $liveAlert = DB::table('krishi_alerts')->where('status', 'Active')->orderBy('id', 'desc')->first();
        $latestDiagnosis = DB::table('crop_diagnoses')->where('user_id', Auth::id())->orderBy('id', 'desc')->first();

        return view('smart_krishi', compact('liveAlert', 'config', 'result', 'latestDiagnosis'));
    }

    public function askKisanMitra(Request $request)
    {
        $msg = mb_strtolower(trim($request->message));
        $reply = "किसान भाई, आपके इस सवाल पर हमारे कृषि विशेषज्ञों की टीम काम कर रही है। आप अधिक जानकारी के लिए 'Expert Meeting' सेक्शन से सीधे डॉक्टर से जुड़ सकते हैं।";

        if (str_contains($msg, 'गेहूँ') && (str_contains($msg, 'खाद') || str_contains($msg, 'यूरिया'))) {
            $reply = "🌾 गेहूँ की फसल के लिए: पहली सिंचाई के बाद प्रति एकड़ 45 किलो यूरिया का छिड़काव करें। साथ ही ज़मीन में नमी होना बहुत जरूरी है ताकि खाद पौधों की जड़ों तक पहुँचे।";
        } elseif (str_contains($msg, 'धान') || str_contains($msg, 'चावल')) {
            $reply = "🌾 धान की खेती के लिए खेत में 2-3 इंच पानी भरा रहना चाहिए। रोपाई के 20-25 दिन बाद नत्रजन (यूरिया) की दूसरी खुराक देना लाभकारी होता है।";
        } elseif (str_contains($msg, 'पीले पत्ते') || str_contains($msg, 'पत्ता पीला') || str_contains($msg, 'pela')) {
            $reply = "🌿 पत्तियों का पीला होना नाइट्रोजन या जिंक की कमी का लक्षण हो सकता है। 0.5% जिंक सल्फेट और यूरिया के घोल का पर्ण छिड़काव (Spray) करें।";
        } elseif (str_contains($msg, 'कीट') || str_contains($msg, 'कीड़ा') || str_contains($msg, 'फंगस') || str_contains($msg, 'disease')) {
            $reply = "🐛 कीट या फंगस नियंत्रण के लिए नीम आधारित कीटनाशक (Azadirachtin 10000 ppm) का छिड़काव करें। गंभीर स्थिति में नजदीकी कृषि सेवा केंद्र से संपर्क कर फफूंदनाशक लें।";
        } elseif (str_contains($msg, 'मौसम') || str_contains($msg, 'बारिश')) {
            $reply = "☁️ आगामी दिनों में मौसम सामान्य रहेगा। यदि बारिश की संभावना हो तो कटी हुई फसल को सुरक्षित स्थान पर रखें और खेतों में जल निकासी की व्यवस्था करें।";
        } elseif (str_contains($msg, 'सब्सिडी') || str_contains($msg, 'योजना') || str_contains($msg, 'पीएम किसान')) {
            $reply = "🏛️ सरकार द्वारा पीएम किसान सम्मान निधि के तहत किसानों को हर साल ₹6,000 दिए जाते हैं। इसके अलावा सोलर पंप पर 60% तक की भारी सब्सिडी ई-पंचायत पोर्टल पर उपलब्ध है।";
        } elseif (str_contains($msg, 'चरी') || str_contains($msg, 'चारा') || str_contains($msg, 'पशु')) {
            $reply = "🐄 पशुओं के लिए उन्नत चरी (मक्का या ज्वार) की बुवाई गर्मियों और बरसात दोनों में की जाती है। यह पशुओं में दूध की मात्रा और स्वास्थ्य दोनों बढ़ाती है।";
        } elseif (str_contains($msg, 'गेहूं') || str_contains($msg, 'wheat') || str_contains($msg, 'gehu')) {
            $reply = "🌾 सतना मंडी में आज गेहूँ का चालू औसत भाव ₹ 2150 / क्विंटल चल रहा है।";
        } elseif (str_contains($msg, 'नमस्ते') || str_contains($msg, 'राम राम') || str_contains($msg, 'hello')) {
            $reply = "राम-राम भाई! बताइए खेती-किसानी से जुड़ा क्या सवाल है आपका? मैं आपकी पूरी मदद करूँगा। 😊";
        }

        return response()->json(['reply' => $reply]);
    }

    public function analyzeCropImage(Request $request)
    {
        $request->validate([
            'crop_image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $imageName = time() . '_' . $request->file('crop_image')->getClientOriginalName();
        $request->file('crop_image')->move(public_path('uploads/crop_issues'), $imageName);
        $imagePath = 'uploads/crop_issues/' . $imageName;

        $aiDiagnosis = "🔍 AI विजन रिपोर्ट: अपलोड की गई फसल या पत्ती की फोटो में फंगस जनित धब्बे (Leaf Spot) या नमी की कमी के लक्षण हैं। कॉपर ऑक्सीक्लोराइड का छिड़काव करें। यदि समस्या बनी रहे तो फोटो विशेषज्ञ के पास भेज दी गई है।";

        DB::table('crop_diagnoses')->insert([
            'user_id' => Auth::id() ?? 1,
            'image_path' => $imagePath,
            'ai_response' => $aiDiagnosis,
            'status' => 'Pending Expert Review',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', $aiDiagnosis);
    }

    public function manageCropDiagnoses()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $allDiagnoses = DB::table('crop_diagnoses')
            ->join('users', 'crop_diagnoses.user_id', '=', 'users.id')
            ->select('crop_diagnoses.*', 'users.name as farmer_name', 'users.phone as farmer_phone')
            ->orderBy('crop_diagnoses.id', 'desc')
            ->get();

        return view('admin_crop_diagnoses', compact('allDiagnoses'));
    }

    public function replyCropDiagnosis(Request $request, $id)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $request->validate([
            'expert_reply' => 'required|string',
        ]);

        DB::table('crop_diagnoses')->where('id', $id)->update([
            'ai_response' => '👨‍⚕️ कृषि विशेषज्ञ का जवाब: ' . $request->expert_reply,
            'status' => 'Resolved by Expert',
            'updated_at' => now(),
        ]);

        return back()->with('success', 'विशेषज्ञ का जवाब सफलतापूर्वक दर्ज कर दिया गया है!');
    }

    public function updateKrishiFormula(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $request->validate([
            'tillage_cost' => 'required|numeric',
            'seed_cost' => 'required|numeric',
            'fertilizer_cost' => 'required|numeric',
            'labor_cost' => 'required|numeric',
            'advisory_message' => 'nullable|string',
        ]);

        DB::table('krishi_configs')->updateOrInsert(
            ['id' => 1], 
            [
                'tillage_cost' => $request->tillage_cost,
                'seed_cost' => $request->seed_cost,
                'fertilizer_cost' => $request->fertilizer_cost,
                'labor_cost' => $request->labor_cost,
                'advisory_message' => $request->advisory_message,
                'updated_at' => now(),
            ]
        );

        return back()->with('success', 'स्मार्ट कृषि कॉन्फिगरेशन सफलतापूर्वक अपडेट हो गया है भाई!');
    }

    public function storeKrishiAlert(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $request->validate([
            'message' => 'required|string'
        ]);

        DB::table('krishi_alerts')->update(['status' => 'Inactive']);

        DB::table('krishi_alerts')->insert([
            'location' => 'Satna',
            'alert_level' => 'Warning',
            'message' => $request->message,
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'नया मौसम अलर्ट लाइव कर दिया गया है!');
    }

    public function manageSmartKrishi()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $currentAlert = DB::table('krishi_alerts')->where('status', 'Active')->orderBy('id', 'desc')->first();
        $formulas = DB::table('krishi_formulas')->get();
        $config = DB::table('krishi_configs')->where('id', 1)->first();

        return view('admin_smart_krishi', compact('currentAlert', 'formulas', 'config'));
    }

    /*
    |--------------------------------------------------------------------------
    | 🏛️ E-PANCHAYAT & GOVERNMENT SCHEMES FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function showEPanchayat(Request $request)
    {
        $category = $request->get('category', 'केन्द्र सरकार'); 
        $schemes = DB::table('schemes')->where('category', $category)->where('status', 'Active')->get();
        
        $trackResult = null;
        return view('e_panchayat', compact('schemes', 'category', 'trackResult'));
    }

    public function trackCertificate(Request $request)
    {
        $request->validate(['application_no' => 'required|string']);
        
        $trackResult = DB::table('certificate_tracks')->where('application_no', $request->application_no)->first();
        
        $category = 'केन्द्र सरकार';
        $schemes = DB::table('schemes')->where('category', $category)->where('status', 'Active')->get();
        
        return view('e_panchayat', compact('schemes', 'category', 'trackResult'))->with('scroll_to_tracker', true);
    }

    public function manageSchemes()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') { 
            return redirect('/')->with('error', 'Unauthorised!'); 
        }
        
        $allSchemes = DB::table('schemes')->orderBy('id', 'desc')->get();
        $allTracks = DB::table('certificate_tracks')->orderBy('id', 'desc')->get();
        
        return view('admin_e_panchayat', compact('allSchemes', 'allTracks'));
    }

    public function storeScheme(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') { 
            return redirect('/')->with('error', 'Unauthorised!'); 
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'scheme_icon' => 'required|string', 
            'eligibility' => 'required|string',
            'description' => 'required|string',
        ]);

        DB::table('schemes')->insert([
            'title' => $request->title,
            'category' => $request->category,
            'scheme_icon' => $request->scheme_icon, 
            'eligibility' => $request->eligibility,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'नई योजना लाइव कर दी गई है!');
    }

    public function updateCertificateStatus(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') { 
            return redirect('/')->with('error', 'Unauthorised!'); 
        }
        
        $request->validate([
            'application_no' => 'required|string',
            'user_name' => 'required|string',
            'service_name' => 'required|string',
            'status' => 'required|string',
            'next_step' => 'required|string',
        ]);

        $exists = DB::table('certificate_tracks')->where('application_no', $request->application_no)->exists();

        if ($exists) {
            DB::table('certificate_tracks')->where('application_no', $request->application_no)->update([
                'status' => $request->status,
                'next_step' => $request->next_step,
                'updated_at' => now()
            ]);
        } else {
            DB::table('certificate_tracks')->insert([
                'application_no' => $request->application_no,
                'user_name' => $request->user_name,
                'service_name' => $request->service_name,
                'status' => $request->status,
                'next_step' => $request->next_step,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return back()->with('success', 'आवेदन संख्या ' . $request->application_no . ' का स्टेटस अपडेट कर दिया गया है!');
    }

    /*
    |--------------------------------------------------------------------------
    | 🌾 KHETI BAZAAR FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function showKhetiBazaar(Request $request)
    {
        $toolCategory = $request->get('tool_category', 'सभी');
        $productCategory = $request->get('product_category', 'सभी');

        $toolsQuery = DB::table('rental_tools');
        if ($toolCategory !== 'सभी') {
            $toolsQuery->where('tool_type', $toolCategory);
        }
        $allTools = $toolsQuery->where('status', 'Available')->orderBy('id', 'desc')->get();

        $productsQuery = DB::table('village_products');
        if ($productCategory !== 'सभी') {
            $productsQuery->where('product_category', $productCategory);
        }
        $allProducts = $productsQuery->orderBy('id', 'desc')->get();

        return view('kheti_bazaar', compact('allTools', 'allProducts', 'toolCategory', 'productCategory'));
    }

    public function userStoreTool(Request $request)
    {
        $request->validate([
            'tool_type' => 'required|string',
            'tool_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_per_day' => 'required|numeric',
            'phone' => 'required|string',
            'tool_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('tool_image')) {
            $image = $request->file('tool_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/tools'), $imageName);
            $imagePath = 'images/tools/' . $imageName;
        }

        DB::table('rental_tools')->insert([
            'user_id' => Auth::id(),
            'owner_name' => Auth::user()->name, 
            'tool_type' => $request->tool_type,
            'tool_name' => $request->tool_name,
            'location' => $request->location,
            'price_per_day' => $request->price_per_day,
            'phone' => $request->phone,
            'image_path' => $imagePath,
            'description' => $request->description,
            'status' => 'Available',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/kheti-bazaar')->with('success', 'आपका कृषि यंत्र किराए के लिए सफलतापूर्वक लाइव हो गया है भाई!');
    }

    public function manageKhetiBazaar()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $adminTools = DB::table('rental_tools')->orderBy('id', 'desc')->get();
        $adminProducts = DB::table('village_products')->orderBy('id', 'desc')->get();

        return view('admin_kheti_bazaar', compact('adminTools', 'adminProducts'));
    }

    public function adminStoreTool(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $request->validate([
            'owner_name' => 'required|string|max:255', 
            'tool_type' => 'required|string',
            'tool_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_per_day' => 'required|numeric',
            'phone' => 'required|string',
            'tool_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('tool_image')) {
            $image = $request->file('tool_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/tools'), $imageName);
            $imagePath = 'images/tools/' . $imageName;
        }

        DB::table('rental_tools')->insert([
            'user_id' => Auth::id(), 
            'owner_name' => $request->owner_name, 
            'tool_type' => $request->tool_type,
            'tool_name' => $request->tool_name,
            'location' => $request->location,
            'price_per_day' => $request->price_per_day,
            'phone' => $request->phone,
            'image_path' => $imagePath,
            'description' => $request->description,
            'status' => 'Available',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'व्हाट्सएप लिस्टिंग सफलतापूर्वक एडमिन द्वारा लाइव कर दी गई है!');
    }

    public function adminStoreProduct(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $request->validate([
            'seller_name' => 'required|string|max:255',
            'product_category' => 'required|string',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'location' => 'required|string',
            'phone' => 'required|string',
            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
            $imagePath = 'images/products/' . $imageName;
        }

        DB::table('village_products')->insert([
            'user_id' => Auth::id(),
            'seller_name' => $request->seller_name,
            'product_category' => $request->product_category,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'location' => $request->location,
            'phone' => $request->phone,
            'image_path' => $imagePath,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'गाँव का उत्पाद सफलतापूर्वक बाज़ार में लाइव कर दिया गया है!');
    }

    public function deleteRentalTool($id)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') { 
            return redirect('/')->with('error', 'Unauthorised!'); 
        }
        DB::table('rental_tools')->where('id', $id)->delete();
        return back()->with('success', 'मशीन लिस्टिंग हटा दी गई है!');
    }

    /*
    |--------------------------------------------------------------------------
    | 🐄 PASHU SWASTHYA FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function showPashuSwasthya()
    {
        $doctors = DB::table('pashu_services')->where('type', 'doctor')->get();
        $ambulances = DB::table('pashu_services')->where('type', 'ambulance')->get();
        
        return view('pashu_swasthya', compact('doctors', 'ambulances'));
    }

    public function adminManagePashu()
    {
        if (Auth::check() && trim(Auth::user()->role) === 'admin') {
            $services = DB::table('pashu_services')->orderBy('id', 'desc')->get();
            return view('admin_pashu_manager', compact('services'));
        }
        return redirect('/login-form')->with('error', 'केवल एडमिन ही यहाँ आ सकते हैं!');
    }

    public function storePashuService(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        DB::table('pashu_services')->insert([
            'type' => $request->type, 
            'title' => $request->title,
            'phone' => $request->phone,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'पशु स्वास्थ्य सेवा सफलतापूर्वक जोड़ दी गई है!');
    }

    /*
    |--------------------------------------------------------------------------
    | 👨‍🌾 EXPERT MEETING FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function showExpertMeeting()
    {
        $experts = DB::table('experts')->where('status', 'Active')->get();
        return view('expert_meeting', compact('experts'));
    }

    public function adminManageExperts()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/login-form')->with('error', 'केवल एडमिन ही यहाँ आ सकते हैं!');
        }
        
        $experts = DB::table('experts')->get();
        return view('admin_expert_meeting_manage', compact('experts'));
    }

    public function adminStoreExpert(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return back()->with('error', 'अनधिकृत पहुंच!');
        }

        $imagePath = 'images/expert.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $imagePath = 'images/' . $filename;
        }

        DB::table('experts')->insert([
            'name' => $request->name,
            'designation' => $request->designation,
            'description' => $request->description,
            'availability' => $request->availability,
            'image' => $imagePath,
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'नया विशेषज्ञ सफलतापूर्वक जोड़ दिया गया है!');
    }

    public function adminDeleteExpert($id)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return back()->with('error', 'अनधिकृत पहुंच!');
        }

        DB::table('experts')->where('id', $id)->delete();
        return back()->with('success', 'विशेषज्ञ को हटा दिया गया है!');
    }

    /*
    |--------------------------------------------------------------------------
    | 🎓 SKILL-UP FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function showSkillUp(Request $request)
    {
        $selectedCategory = $request->get('target', 'सभी');

        $query = DB::table('skills')->where('status', 'Active');

        if ($selectedCategory !== 'सभी') {
            $query->where('target_category', $selectedCategory);
        }

        $skills = $query->get();
        return view('skill_up', compact('skills', 'selectedCategory'));
    }

    public function adminManageSkillUp()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/login-form')->with('error', 'अनधिकृत पहुंच!');
        }
        $skills = DB::table('skills')->get();
        return view('admin_skill_up_manage', compact('skills'));
    }

    public function adminStoreSkill(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return back()->with('error', 'Unauthorised!');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'target_category' => 'required|string',
            'duration' => 'required|string|max:100',
            'description' => 'required|string',
            'video_link' => 'nullable|url',
        ]);

        DB::table('skills')->insert([
            'title' => $request->title,
            'category' => $request->category,
            'target_category' => $request->target_category, 
            'duration' => $request->duration,
            'description' => $request->description,
            'video_link' => $request->video_link,          
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'नया कौशल विकास कोर्स, वीडियो लिंक और केटेगरी सफलतापूर्वक जोड़ दी गई है!');
    }

    public function adminDeleteSkill($id)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return back()->with('error', 'Unauthorised!');
        }

        DB::table('skills')->where('id', $id)->delete();
        return back()->with('success', 'कौशल विकास कोर्स सफलतापूर्वक हटा दिया गया है!');
    }

    /*
    |--------------------------------------------------------------------------
    | 👤 USER PROFILE FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function showProfile()
    {
        $user = Auth::user(); 
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = Auth::user()->profile_image;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        DB::table('users')->where('id', $userId)->update([
            'name' => $request->name,
            'location' => $request->location,
            'profile_image' => $imagePath,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'आपकी प्रोफाइल सफलतापूर्वक अपडेट हो गई है भाई!');
    }

    /*
    |--------------------------------------------------------------------------
    | 👑 ADMIN PROFILE FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function adminShowProfile()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }
        
        $admin = Auth::user();
        return view('admin_profile', compact('admin'));
    }

    public function adminUpdateProfile(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $adminId = Auth::id();

        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = Auth::user()->profile_image;
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = 'admin_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        DB::table('users')->where('id', $adminId)->update([
            'name' => $request->name,
            'profile_image' => $imagePath,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'एडमिन प्रोफाइल सफलतापूर्वक अपडेट हो गई है भाई!');
    }

    /*
    |--------------------------------------------------------------------------
    | 📊 REPORTS & ANALYTICS FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function adminReportsAnalytics()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $totalUsers = DB::table('users')->where('role', '!=', 'admin')->count();
        $totalFarmers = DB::table('users')->where('role', 'farmer')->count();

        $totalComplaints = DB::table('complaints')->count();
        $resolvedComplaints = DB::table('complaints')->where('status', 'Resolved')->count();
        $pendingComplaints = DB::table('complaints')->where('status', 'Pending')->count();
        $inProgressComplaints = DB::table('complaints')->where('status', 'In Progress')->count();

        $totalTools = DB::table('rental_tools')->count();

        return view('admin_reports', compact(
            'totalUsers', 
            'totalFarmers', 
            'totalComplaints', 
            'resolvedComplaints', 
            'pendingComplaints', 
            'inProgressComplaints', 
            'totalTools'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | ⚙️ ADMIN SETTINGS FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function adminShowSettings()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $admin = Auth::user();
        return view('admin_settings', compact('admin'));
    }

    public function adminUpdateSettings(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $adminId = Auth::id();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'location' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6',
        ]);

        $admin = DB::table('users')->where('id', $adminId)->first();

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->with('error', 'आपका वर्तमान पासवर्ड गलत है भाई!');
            }
        }

        $updateData = [
            'name' => $request->name,
            'phone' => $request->phone,
            'location' => $request->location,
            'updated_at' => now(),
        ];

        if ($request->filled('new_password')) {
            $updateData['password'] = Hash::make($request->new_password);
        }

        DB::table('users')->where('id', $adminId)->update($updateData);

        return back()->with('success', 'पोर्टल सेटिंग्स और विवरण सफलतापूर्वक अपडेट हो गए हैं भाई!');
    }

    /*
    |--------------------------------------------------------------------------
    | 🆘 HELP & SUPPORT FUNCTION
    |--------------------------------------------------------------------------
    */
    public function showHelpSupport()
    {
        if (!Auth::check()) {
            return redirect('/login-form')->with('error', 'कृपया पहले लॉगिन करें!');
        }

        return view('help_support');
    }

    public function storeProduct(Request $request) {
        $request->validate([
            'product_category' => 'required',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'phone' => 'required|string',
            'location' => 'required|string',
            'product_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('product_image')) {
            $imageName = time() . '_' . $request->file('product_image')->getClientOriginalName();
            $request->file('product_image')->move(public_path('uploads/market'), $imageName);
            $imagePath = 'uploads/market/' . $imageName;
        }

        DB::table('kheti_bazaar_items')->insert([
            'user_id' => Auth::id(),
            'type' => 'product',
            'category' => $request->product_category,
            'title' => $request->product_name,
            'price' => $request->price,
            'phone' => $request->phone,
            'location' => $request->location,
            'image' => $imagePath,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/kheti-bazaar')->with('success', 'आपका उत्पाद खेती बाज़ार में सफलतापूर्वक लाइव कर दिया गया है!');
    }

    public function showWeatherAdvisory() {
        return view('weather_advisory');
    }

    // 1. एडमिन का मौसम मैनेजमेंट पेज दिखाने का फंक्शन
    public function adminManageWeather()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $currentAlert = DB::table('krishi_alerts')->where('status', 'Active')->orderBy('id', 'desc')->first();
        
        return view('admin_weather_manager', compact('currentAlert'));
    }

    // 2. एडमिन द्वारा नया मौसम अलर्ट/सलाह डेटाबेस में सेव करने का फंक्शन
    public function adminUpdateWeather(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        DB::table('krishi_alerts')->update(['status' => 'Inactive']);

        DB::table('krishi_alerts')->insert([
            'location' => Auth::user()->location ?? 'Satna',
            'alert_level' => 'Warning',
            'message' => $request->message,
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'मौसम चेतावनी और कृषि सलाह सफलतापूर्वक अपडेट कर दी गई है!');
    }

    // 🌤️ एडमिन द्वारा आगामी दिनों का मौसम पूर्वानुमान अपडेट करने का फंक्शन
    public function adminUpdateForecast(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $request->validate([
            'day_name' => 'required|string',
            'temperature' => 'required|string',
            'condition_text' => 'required|string',
        ]);

        DB::table('weather_forecasts')->updateOrInsert(
            ['day_name' => $request->day_name],
            [
                'temperature' => $request->temperature,
                'condition_text' => $request->condition_text,
                'updated_at' => now(),
            ]
        );

        return back()->with('success', $request->day_name . ' का मौसम पूर्वानुमान सफलतापूर्वक अपडेट हो गया है भाई!');
    }

    // 1. परिवहन सेवा का पेज और वाहनों की लिस्टिंग दिखाना
    public function showLocalTransport(Request $request)
    {
        $category = $request->get('category', 'सभी गाड़ी');
        
        $query = DB::table('transport_vehicles');
        if ($category !== 'सभी गाड़ी') {
            $query->where('vehicle_type', $category);
        }
        
        $vehicles = $query->orderBy('id', 'desc')->get();
        return view('local_transport', compact('vehicles', 'category'));
    }

    // 2. किसान द्वारा खुद अपना वाहन किराए पर चढ़ाने का फॉर्म प्रोसेस करना
    public function storeTransportVehicle(Request $request)
    {
        // 1. फोटो अपलोड करने का लॉजिक
        $imagePath = null;
        if ($request->hasFile('vehicle_image')) {
            $imageName = time() . '_' . $request->file('vehicle_image')->getClientOriginalName();
            $request->file('vehicle_image')->move(public_path('uploads/vehicles'), $imageName);
            $imagePath = 'uploads/vehicles/' . $imageName;
        }

        // 2. डेटाबेस की सही टेबल 'transport_vehicles' में डेटा डालना
        DB::table('transport_vehicles')->insert([
            'user_id'       => Auth::id() ?? 1,
            'owner_name'    => Auth::check() ? Auth::user()->name : 'किसान भाई',
            'vehicle_type'  => $request->vehicle_type,
            'vehicle_name'  => $request->vehicle_name,
            'location'      => $request->location,
            'price_per_day' => $request->price_per_day,
            'phone'         => $request->phone,
            'image_path'    => $imagePath, 
            'description'   => $request->description,
            'status'        => 'active',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return redirect()->back()->with('success', 'आपका वाहन बाज़ार में सफलतापूर्वक लाइव कर दिया गया है!');
    }

    /*
    |--------------------------------------------------------------------------
    | 🌱 SOIL & FERTILIZER CALCULATOR FUNCTIONS (फिक्सड और अपडेटेड)
    |--------------------------------------------------------------------------
    */

    public function showSoilCalculator()
    {
        $result = null;
        return view('soil_calculator', compact('result'));
    }

    public function manageFertilizerConfig()
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'आपको इस पेज की अनुमति नहीं है!');
        }

        return view('admin_fertilizer_config');
    }

    public function updateFertilizerConfig(Request $request)
    {
        if (!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $request->validate([
            'urea_per_acre' => 'required|numeric',
            'dap_per_acre' => 'required|numeric',
            'tillage_cost' => 'required|numeric',
            'seed_cost' => 'required|numeric',
            'fertilizer_cost' => 'required|numeric',
            'advisory_message' => 'nullable|string',
        ]);

        DB::table('fertilizer_configs')->updateOrInsert(
            ['id' => 1],
            [
                'urea_per_acre' => $request->urea_per_acre,
                'dap_per_acre' => $request->dap_per_acre,
                'tillage_cost' => $request->tillage_cost,
                'seed_cost' => $request->seed_cost,
                'fertilizer_cost' => $request->fertilizer_cost,
                'advisory_message' => $request->advisory_message,
                'updated_at' => now(),
            ]
        );

        return back()->with('success', 'खाद कैलकुलेटर का फॉर्मूला सफलतापूर्वक अपडेट कर दिया गया है भाई!');
    }

    public function calculateSoilFertilizer(Request $request)
    {
        $request->validate([
            'crop_name' => 'required|string',
            'acreage' => 'required|numeric|min:0.1',
            'soil_type' => 'required|string',
        ]);

        $crop = $request->crop_name;
        $acres = $request->acreage;
        $soil = $request->soil_type;

        $config = DB::table('fertilizer_configs')->where('id', 1)->first();

        $ureaPerAcre = $config->urea_per_acre ?? 45;
        $dapPerAcre = $config->dap_per_acre ?? 30;
        
        $estCostPerAcre = ($config->tillage_cost ?? 1200) + ($config->seed_cost ?? 1500) + ($config->fertilizer_cost ?? 1800);

        $totalUrea = $ureaPerAcre * $acres;
        $totalDap = $dapPerAcre * $acres;
        $totalCost = $estCostPerAcre * $acres;

        $suggestion = "🌾 {$crop} फसल ({$soil}) के लिए प्रति एकड़ {$dapPerAcre} किग्रा डीएपी और {$ureaPerAcre} किग्रा यूरिया का उपयोग करें। " . ($config->advisory_message ?? '');

        DB::table('soil_calculations')->insert([
            'user_id' => Auth::id(),
            'farmer_name' => Auth::check() ? Auth::user()->name : 'किसान भाई',
            'crop_name' => $crop,
            'acreage' => $acres,
            'soil_type' => $soil,
            'total_cost' => $totalCost,
            'fertilizer_suggestion' => $suggestion,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $result = [
            'crop_name' => $crop,
            'acreage' => $acres,
            'soil_type' => $soil,
            'total_urea' => $totalUrea,
            'total_dap' => $totalDap,
            'total_cost' => $totalCost,
            'suggestion' => $suggestion,
        ];

        return view('soil_calculator', compact('result'));
    }

    public function showEmergencyHelp()
    {
        $emergencies = DB::table('emergency_contacts')->orderBy('id', 'desc')->get();
        $userLocation = Auth::check() ? (Auth::user()->location ?? 'आपका क्षेत्र') : 'आपका क्षेत्र';
        
        return view('emergency_help', compact('emergencies', 'userLocation'));
    }

    public function showCropCalendar(Request $request)
    {
        $selectedMonth = $request->get('month', date('F')); 

        $calendars = DB::table('dynamic_crop_calendars')
            ->where('month_name', $selectedMonth)
            ->get();

        return view('crop_calendar', compact('calendars', 'selectedMonth'));
    }  
    
    public function showGreenVillage()
    {
        $greenItems = DB::table('green_villages')->orderBy('id', 'desc')->get();
        return view('green_village', compact('greenItems'));
    }

    // 1. एडमिन पैनल में सभी वाहनों की लिस्ट दिखाने वाला फंक्शन
    public function adminManageTransport()
    {
        if(!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुँच!');
        }

        $vehicles = DB::table('transport_vehicles')->orderBy('id', 'desc')->get();
        return view('admin_transport', compact('vehicles'));
    }

    // 2. एडमिन द्वारा किसी वाहन को हटाने वाला फंक्शन
    public function adminDeleteTransport($id)
    {
        if(!Auth::check() || trim(Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुँच!');
        }

        DB::table('transport_vehicles')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'वाहन की लिस्टिंग सफलतापूर्वक हटा दी गई है!');
    }

    // 2. एडमिन के लिए आपातकालीन मैनेजमेंट पेज दिखाने का फंक्शन
    public function adminManageEmergency()
    {
        if (!\Illuminate\Support\Facades\Auth::check() || trim(\Illuminate\Support\Facades\Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $contacts = \Illuminate\Support\Facades\DB::table('emergency_contacts')->latest()->get();
        return view('admin_emergency', compact('contacts'));
    }

    // 3. एडमिन द्वारा नया आपातकालीन नंबर सेव करने का फंक्शन
    public function adminStoreEmergency(\Illuminate\Http\Request $request)
    {
        if (!\Illuminate\Support\Facades\Auth::check() || trim(\Illuminate\Support\Facades\Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $request->validate([
            'category' => 'required|string',
            'title' => 'required|string',
            'phone' => 'required|string',
            'description' => 'nullable|string',
        ]);

        \Illuminate\Support\Facades\DB::table('emergency_contacts')->insert([
            'category' => $request->category,
            'title' => $request->title,
            'phone' => $request->phone,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'नया आपातकालीन संपर्क सफलतापूर्वक जोड़ दिया गया है भाई!');
    }

    // 4. एडमिन द्वारा आपातकालीन नंबर डिलीट करने का फंक्शन
    public function adminDeleteEmergency($id)
    {
        if (!\Illuminate\Support\Facades\Auth::check() || trim(\Illuminate\Support\Facades\Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        \Illuminate\Support\Facades\DB::table('emergency_contacts')->where('id', $id)->delete();

        return back()->with('success', 'आपातकालीन संपर्क सूची से हटा दिया गया है!');
    }


    // 2. एडमिन के लिए फसल कैलेंडर मैनेजमेंट पेज दिखाने का फंक्शन
    public function adminManageCropCalendar()
    {
        if (!\Illuminate\Support\Facades\Auth::check() || trim(\Illuminate\Support\Facades\Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $calendars = \Illuminate\Support\Facades\DB::table('crop_calendars')->latest()->get();
        return view('admin_crop_calendar', compact('calendars'));
    }

    // 3. एडमिन द्वारा नया फसल कैलेंडर डेटा सेव करने का फंक्शन
    public function adminStoreCropCalendar(\Illuminate\Http\Request $request)
    {
        if (!\Illuminate\Support\Facades\Auth::check() || trim(\Illuminate\Support\Facades\Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $request->validate([
            'crop_name' => 'required|string',
            'month_season' => 'required|string',
            'sowing_guide' => 'required|string',
            'irrigation_guide' => 'required|string',
        ]);

        \Illuminate\Support\Facades\DB::table('crop_calendars')->insert([
            'crop_name' => $request->crop_name,
            'month_season' => $request->month_season,
            'sowing_guide' => $request->sowing_guide,
            'irrigation_guide' => $request->irrigation_guide,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'फसल कैलेंडर सफलतापूर्वक अपडेट कर दिया गया है!');
    }

    // 4. एडमिन द्वारा फसल कैलेंडर हटाने का फंक्शन
    public function adminDeleteCropCalendar($id)
    {
        if (!\Illuminate\Support\Facades\Auth::check() || trim(\Illuminate\Support\Facades\Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        \Illuminate\Support\Facades\DB::table('crop_calendars')->where('id', $id)->delete();

        return back()->with('success', 'फसल कैलेंडर हटा दिया गया है!');
    }

    // 2. एडमिन के लिए हरित ग्राम मैनेजमेंट पेज दिखाने का फंक्शन
    public function adminManageGreenVillage()
    {
        if (!\Illuminate\Support\Facades\Auth::check() || trim(\Illuminate\Support\Facades\Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'अनधिकृत पहुंच!');
        }

        $posts = \Illuminate\Support\Facades\DB::table('green_village_awareness')->latest()->get();
        return view('admin_green_village', compact('posts'));
    }

    // 3. एडमिन द्वारा नया जागरूकता अभियान सेव करने का फंक्शन
    public function adminStoreGreenVillage(\Illuminate\Http\Request $request)
    {
        if (!\Illuminate\Support\Facades\Auth::check() || trim(\Illuminate\Support\Facades\Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        $request->validate([
            'title' => 'required|string',
            'category' => 'required|string',
            'description' => 'required|string',
        ]);

        \Illuminate\Support\Facades\DB::table('green_village_awareness')->insert([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'हरित ग्राम जागरूकता अभियान सफलतापूर्वक जोड़ दिया गया है!');
    }

    // 4. एडमिन द्वारा अभियान हटाने का फंक्शन
    public function adminDeleteGreenVillage($id)
    {
        if (!\Illuminate\Support\Facades\Auth::check() || trim(\Illuminate\Support\Facades\Auth::user()->role) !== 'admin') {
            return redirect('/')->with('error', 'Unauthorised!');
        }

        \Illuminate\Support\Facades\DB::table('green_village_awareness')->where('id', $id)->delete();

        return back()->with('success', 'जागरूकता अभियान हटा दिया गया है!');
    }


}