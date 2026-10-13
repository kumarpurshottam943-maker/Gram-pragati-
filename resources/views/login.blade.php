<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>लॉगिन - Gram Pragati</title>
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
        .login-card { 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 12px 35px rgba(0,0,0,0.15); 
            width: 100%; 
            max-width: 450px; 
            padding: 35px; 
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
            width: 34px; 
            height: 34px; 
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
        .form-control { 
            border-radius: 8px; 
            padding: 12px; 
            font-size: 15px; 
            border: 1px solid #cbd5e1;
        }
        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }
    </style>
</head>
<body>

<div class="login-card">
    <!-- ब्रांड नाम और लोगो (मिश्रित भाषा में) -->
    <div class="text-center mb-4">
        <h3 class="fw-bold text-success mb-1"><i class="fa-solid fa-leaf"></i> ग्राम प्रगति <span style="font-size: 20px; font-weight: 600; color: #2c3e50;">(Gram Pragati)</span></h3>
        <div class="text-muted fw-semibold" style="font-size: 13px;">Sashakt Kisan, Digital Gaon</div>
        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-bold mt-3" style="font-size: 13px;">🔐 यूज़र लॉगिन पोर्टल | User Login 🔐</span>
    </div>

    <!-- अगर कोई एरर मैसेज आता है -->
    @if(session('error'))
        <div class="alert alert-danger text-center py-2" style="font-size:14px; font-weight:600;">
            <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ session('error') }}
        </div>
    @endif

    <!-- अगर रजिस्ट्रेशन सफल होने का मैसेज आता है -->
    @if(session('success'))
        <div class="alert alert-success text-center py-2" style="font-size:14px; font-weight:600;">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
        </div>
    @endif

    <!-- लॉगिन फॉर्म -->
    <form action="/farmer-login" method="POST">
        @csrf

        <!-- 1. मोबाइल नंबर (Mobile Number) इनपुट बॉक्स -->
        <div class="mb-3">
            <label class="form-label">
                <span><i class="fa-solid fa-phone text-success me-2"></i> मोबाइल नंबर / Mobile Number</span>
                <button type="button" class="speaker-btn" onclick="speakText('यहाँ अपना दस अंकों का मोबाइल नंबर डालें जो आपने पंजीकरण करते समय दिया था')">
                    <i class="fa-solid fa-volume-high"></i>
                </button>
            </label>
            <input type="tel" class="form-control mt-1" name="phone" placeholder="যেমন: 9876543210" pattern="[0-9]{10}" required>
        </div>

        <!-- 2. पासवर्ड (Password) इनपुट बॉक्स -->
        <div class="mb-4">
            <label class="form-label">
                <span><i class="fa-solid fa-lock text-success me-2"></i> गुप्त पासवर्ड / Password</span>
                <button type="button" class="speaker-btn" onclick="speakText('यहाँ अपना सुरक्षित गुप्त पासवर्ड डालें')">
                    <i class="fa-solid fa-volume-high"></i>
                </button>
            </label>
            <input type="password" class="form-control mt-1" name="password" placeholder="अपना पासवर्ड यहाँ लिखें..." required>
        </div>

        <!-- लॉगिन सबमिट बटन -->
        <button type="submit" class="btn btn-success w-100 py-2.5 rounded-3 fw-bold fs-5 mb-3 shadow-sm">
            <i class="fa-solid fa-right-to-bracket me-2"></i> लॉगिन करें (Login)
        </button>
        
        <hr class="text-muted">
        
        <!-- नीचे के लिंक्स -->
        <div class="d-flex justify-content-between" style="font-size: 13.5px;">
            <a href="/register-form" class="text-success text-decoration-none fw-bold">🆕 नया पंजीकरण (Register)</a>
            <a href="/" class="text-secondary text-decoration-none fw-semibold"><i class="fa-solid fa-house me-1"></i> होमपेज (Home)</a>
        </div>
    </form>
</div>

<!-- स्पीच एपीआई जावास्क्रिप्ट (Speech API - आवाज बिल्कुल साफ़ हिंदी में ही रहेगी) -->
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