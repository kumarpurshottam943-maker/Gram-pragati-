<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>कौशल विकास (Skill-Up) - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .navbar-custom { background-color: #198754; color: white; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); background: white; transition: transform 0.2s; }
        .card-custom:hover { transform: translateY(-3px); }
        .hero-section { background: linear-gradient(135deg, #198754, #157347); color: white; padding: 40px 20px; border-radius: 0 0 20px 20px; margin-bottom: 30px; }
    </style>
</head>
<body>

    <!-- टॉप नेविगेशन बार -->
    <nav class="navbar navbar-expand-lg navbar-custom px-4 py-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="/">
                <i class="fa-solid fa-seedling me-2"></i> ग्राम प्रगति - कौशल विकास
            </a>
            <a href="/" class="btn btn-light btn-sm fw-bold rounded-pill px-3 text-success">
                <i class="fa-solid fa-house me-1"></i> होमपेज पर जाएं
            </a>
        </div>
    </nav>

    <div class="container pb-5">
        <!-- हीरो बैनर -->
        <div class="hero-section text-center">
            <h1 class="fw-bold mb-2">हुनर है तो भविष्य है!</h1>
            <p class="lead mb-0">सतना और आसपास के युवाओं, किसानों व महिलाओं के लिए आधुनिक तकनीकी व कृषि कौशल प्रशिक्षण।</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- 🔥 केटेगरी फ़िल्टर टैब (महिला, युवा, किसान के हिसाब से देखने के लिए) -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <div class="btn-group flex-wrap shadow-sm rounded-pill p-1 bg-white" role="group">
                    <a href="/skill-up?target=सभी" class="btn btn-sm rounded-pill px-3 py-2 fw-bold {{ ($selectedCategory ?? 'सभी') == 'सभी' ? 'btn-success' : 'btn-light text-success' }}">
                        <i class="fa-solid fa-border-all me-1"></i> सभी कोर्स
                    </a>
                    <a href="/skill-up?target=गाँव की महिलाएँ" class="btn btn-sm rounded-pill px-3 py-2 fw-bold {{ ($selectedCategory ?? '') == 'गाँव की महिलाएँ' ? 'btn-success' : 'btn-light text-success' }}">
                        <i class="fa-solid fa-person-dress me-1"></i> गाँव की महिलाएँ
                    </a>
                    <a href="/skill-up?target=युवा और छात्र" class="btn btn-sm rounded-pill px-3 py-2 fw-bold {{ ($selectedCategory ?? '') == 'युवा और छात्र' ? 'btn-success' : 'btn-light text-success' }}">
                        <i class="fa-solid fa-graduation-cap me-1"></i> युवा और छात्र
                    </a>
                    <a href="/skill-up?target=किसान और पुरुष" class="btn btn-sm rounded-pill px-3 py-2 fw-bold {{ ($selectedCategory ?? '') == 'किसान और पुरुष' ? 'btn-success' : 'btn-light text-success' }}">
                        <i class="fa-solid fa-tractor me-1"></i> किसान और पुरुष
                    </a>
                </div>
            </div>
        </div>

        <!-- कोर्सेस की लिस्ट (डेटाबेस से लाइव) -->
        <div class="row g-4">
            @forelse($skills as $skill)
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100 d-flex flex-column">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold" style="font-size: 12px;">
                                <i class="fa-solid fa-tag me-1"></i> {{ $skill->category }}
                            </span>
                            <span class="badge bg-primary-subtle text-primary px-2.5 py-1 rounded-pill" style="font-size: 11px;">
                                <i class="fa-solid fa-user-tag me-1"></i> {{ $skill->target_category ?? 'सभी के लिए' }}
                            </span>
                        </div>
                        <h4 class="fw-bold text-dark mt-2 mb-2" style="font-size: 18px;">{{ $skill->title }}</h4>
                        <p class="text-muted small mb-3 flex-grow-1">{{ $skill->description }}</p>
                        
                        <div class="border-top pt-3 mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3 text-secondary small fw-semibold">
                                <span><i class="fa-regular fa-clock text-primary me-1"></i> अवधि: {{ $skill->duration }}</span>
                                <span class="text-success"><i class="fa-solid fa-certificate me-1"></i> सर्टिफिकेट</span>
                            </div>

                            <!-- 🔥 YouTube वीडियो देखने का बटन (अगर लिंक है तो दिखेगा) -->
                            @if(!empty($skill->video_link))
                                <a href="{{ $skill->video_link }}" target="_blank" class="btn btn-outline-danger btn-sm w-100 rounded-pill fw-bold py-2 mb-2">
                                    <i class="fa-brands fa-youtube me-1"></i> ट्रेनिंग वीडियो देखें
                                </a>
                            @endif

                            <button class="btn btn-success btn-sm w-100 rounded-pill fw-bold py-2" onclick="alert('बधाई हो भाई! आपका इस कोर्स के लिए पंजीकरण दर्ज कर लिया गया है।')">
                                <i class="fa-solid fa-book-open-reader me-1"></i> अभी दाखिला लें (Enroll)
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="card card-custom p-5">
                        <i class="fa-solid fa-graduation-cap fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted fw-bold">इस श्रेणी में फिलहाल कोई कौशल विकास कोर्स उपलब्ध नहीं है।</h5>
                        <p class="text-secondary small mb-0">एडमिन द्वारा जल्द ही नए प्रशिक्षण कोर्स जोड़े जाएंगे।</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>