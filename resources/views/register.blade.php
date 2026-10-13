<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>पंजीकरण - Gram Pragati</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), url("{{ asset('images/village.jpg') }}");
            background-size: cover;
            background-position: center;
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-family: 'Segoe UI', Arial, sans-serif;
            padding: 20px;
        }
        .register-card { 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 12px 35px rgba(0,0,0,0.15); 
            width: 100%; 
            max-width: 500px; 
            padding: 30px; 
            border: 2px solid #198754; 
        }
        .form-label { 
            font-weight: 700; 
            color: #2c3e50; 
            font-size: 15px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            width: 100%;
        }
        /* स्पीकर बटन डिज़ाइन */
        .speaker-btn { 
            background: #e8f5e9; 
            border: none; 
            color: #198754; 
            border-radius: 50%; 
            width: 32px; 
            height: 32px; 
            cursor: pointer; 
            transition: all 0.2s; 
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .speaker-btn:hover { 
            background: #198754; 
            color: white; 
            transform: scale(1.1); 
        }
        .form-control, .form-select { 
            border-radius: 8px; 
            padding: 10px; 
            font-size: 15px; 
            border: 1px solid #cbd5e1;
        }
        .form-control:focus, .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }
    </style>
</head>
<body>

<div class="register-card">
    <!-- ब्रांड नाम और लोगो -->
    <div class="text-center mb-3">
        <h3 class="fw-bold text-success mb-1"><i class="fa-solid fa-leaf"></i> ग्राम प्रगति <span style="font-size: 19px; font-weight: 600; color: #2c3e50;">(Gram Pragati)</span></h3>
        <div class="text-muted fw-semibold" style="font-size: 13px;">Sashakt Kisan, Digital Gaon</div>
        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold mt-2" style="font-size: 13px;">📝 नया पंजीकरण | New Registration 📝</span>
    </div>

    <!-- रजिस्ट्रेशन फॉर्म ऐक्शन (फाइल अपलोड के लिए enctype ज़रूरी है) -->
    <form action="/farmer-register" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 1. पूरा नाम (Full Name) -->
        <div class="mb-3">
            <label class="form-label">
                <span><i class="fa-solid fa-user text-success me-2"></i> आपका पूरा नाम / Full Name</span>
                <button type="button" class="speaker-btn" onclick="speakText('यहाँ अपना पूरा नाम डालें')">
                    <i class="fa-solid fa-volume-high"></i>
                </button>
            </label>
            <input type="text" class="form-control mt-1" name="name" placeholder="जैसे: Purshottam Kumar" required>
        </div>

        <!-- 2. मोबाइल नंबर (Mobile Number) -->
        <div class="mb-3">
            <label class="form-label">
                <span><i class="fa-solid fa-phone text-success me-2"></i> मोबाइल नंबर / Mobile Number</span>
                <button type="button" class="speaker-btn" onclick="speakText('यहाँ अपना दस अंकों का मोबाइल नंबर डालें')">
                    <i class="fa-solid fa-volume-high"></i>
                </button>
            </label>
            <input type="tel" class="form-control mt-1" name="phone" placeholder="जैसे: 9876543210" pattern="[0-9]{10}" required>
        </div>

        <!-- 3. यूज़र रोल ड्रॉपडाउन (User Role Select) -->
        <div class="mb-3">
            <label class="form-label">
                <span><i class="fa-solid fa-user-tag text-success me-2"></i> आप कौन हैं? / Select Role</span>
                <button type="button" class="speaker-btn" onclick="speakText('यहाँ चुनें कि आप किसान हैं, युवा छात्र हैं, या गाँव के नागरिक हैं')">
                    <i class="fa-solid fa-volume-high"></i>
                </button>
            </label>
            <select class="form-select mt-1" name="role" required>
                <option value="farmer">🌾 मैं एक किसान हूँ (Farmer)</option>
                <option value="student">🎓 मैं एक युवा / छात्र हूँ (Youth / Student - Skill-Up)</option>
                <option value="citizen">🏡 मैं गाँव का नागरिक हूँ (Citizen / Buyer-Seller)</option>
            </select>
        </div>

        <!-- 4. क्षेत्र / लोकेशन (Location) -->
        <div class="mb-3">
            <label class="form-label">
                <span><i class="fa-solid fa-location-dot text-success me-2"></i> आपका क्षेत्र / Location</span>
                <button type="button" class="speaker-btn" onclick="speakText('यहाँ अपने गाँव, शहर या जिले का नाम डालें')">
                    <i class="fa-solid fa-volume-high"></i>
                </button>
            </label>
            <input type="text" class="form-control mt-1" name="location" placeholder="जैसे: Satna, Madhya Pradesh" required>
        </div>

        <!-- 5. प्रोफाइल फोटो अपलोड (Profile Image) -->
        <div class="mb-3">
            <label class="form-label">
                <span><i class="fa-solid fa-camera text-success me-2"></i> अपनी फोटो चुनें / Upload Photo</span>
                <button type="button" class="speaker-btn" onclick="speakText('यहाँ बटन दबाकर अपनी एक साफ़ प्रोफाइल फोटो चुनें')">
                    <i class="fa-solid fa-volume-high"></i>
                </button>
            </label>
            <input type="file" class="form-control mt-1" name="profile_image" accept="image/*" required>
        </div>

        <!-- 6. नया पासवर्ड (New Password) -->
        <div class="mb-4">
            <label class="form-label">
                <span><i class="fa-solid fa-lock text-success me-2"></i> नया पासवर्ड बनाएँ / New Password</span>
                <button type="button" class="speaker-btn" onclick="speakText('याद रखने के लिए कोई भी मजबूत गुप्त पासवर्ड बनाएँ')">
                    <i class="fa-solid fa-volume-high"></i>
                </button>
            </label>
            <input type="password" class="form-control mt-1" name="password" placeholder="अपना गुप्त पासवर्ड यहाँ डालें" required>
        </div>

        <!-- सबमिट बटन -->
        <button type="submit" class="btn btn-success w-100 py-2.5 rounded-3 fw-bold fs-5 mb-3 shadow-sm">
            <i class="fa-solid fa-check-double me-2"></i> पंजीकरण सुरक्षित करें (Register)
        </button>
        
        <hr class="text-muted">
        
        <!-- नीचे के लिंक्स -->
        <div class="d-flex justify-content-between" style="font-size: 13.5px;">
            <a href="/login-form" class="text-success text-decoration-none fw-bold">🔐 पहले से खाता है? लॉगिन (Login)</a>
            <a href="/" class="text-secondary text-decoration-none fw-semibold"><i class="fa-solid fa-house me-1"></i> होमपेज (Home)</a>
        </div>
    </form>
</div>

<!-- वॉयस गाइड स्क्रिप्ट (साफ़ हिंदी आवाज़ में सहायता के लिए) -->
<script>
    let voices = [];
    function loadVoices() { 
        voices = window.speechSynthesis.getVoices(); 
    }
    loadVoices();
    if (window.speechSynthesis.onvoiceschanged !== undefined) { 
        window.speechSynthesis.onvoiceschanged = loadVoices; 
    }

    function speakText(message) {
        window.speechSynthesis.cancel();
        
        let speech = new SpeechSynthesisUtterance(message);
        speech.lang = "hi-IN"; 
        speech.rate = 0.85;    
        
        let hindiVoice = voices.find(v => v.lang.includes('hi-IN'));
        if (hindiVoice) {
            speech.voice = hindiVoice;
        }
        
        window.speechSynthesis.speak(speech);
    }
</script>
</body>
</html>