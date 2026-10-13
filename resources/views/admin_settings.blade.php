<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>पोर्टल सेटिंग्स - ग्राम प्रगति एडमिन</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .navbar-custom { background-color: #1e293b; color: white; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white; }
        .section-title { font-size: 16px; font-weight: 700; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <!-- टॉप नेविगेशन बार -->
    <nav class="navbar navbar-expand-lg navbar-custom px-4 py-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="/admin-dashboard">
                <i class="fa-solid fa-gear me-2 text-info"></i> ग्राम प्रगति - एडमिन सेटिंग्स कंट्रोल पैनल
            </a>
            <a href="/admin-dashboard" class="btn btn-light btn-sm fw-bold rounded-pill px-3 text-dark">
                <i class="fa-solid fa-arrow-left me-1"></i> डैशबोर्ड पर लौटें
            </a>
        </div>
    </nav>

    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card card-custom p-4 p-md-5">
                    <h3 class="fw-bold text-dark mb-1"><i class="fa-solid fa-sliders me-2 text-primary"></i> पोर्टल और सिस्टम सेटिंग्स</h3>
                    <p class="text-muted small mb-4">यहाँ से आप पूरे पोर्टल के नियम, नोटिफिकेशन, बैकअप और अपनी प्रोफाइल सुरक्षा को मैनेज कर सकते हैं।</p>

                    <form action="/admin/settings/update" method="POST">
                        @csrf
                        
                        <!-- 1. सामान्य सेटिंग्स (General Settings) -->
                        <div class="section-title">
                            <i class="fa-solid fa-globe me-2 text-success"></i> 1. सामान्य सेटिंग्स (General Settings)
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">वेबसाइट / पोर्टल का नाम</label>
                                <input type="text" name="portal_name" class="form-control" value="ग्राम प्रगति - Gram Pragati">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">स्थान / क्षेत्र का नाम (पंचायत, जिला)</label>
                                <input type="text" name="location" class="form-control" value="{{ $admin->location ?? 'सतना, मध्य प्रदेश' }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">एडमिन का पूरा नाम</label>
                                <input type="text" name="name" class="form-control" value="{{ $admin->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">आधिकारिक सपोर्ट फोन / ईमेल</label>
                                <input type="text" name="phone" class="form-control" value="{{ $admin->phone }}">
                            </div>
                        </div>


                        <!-- 2. सिस्टम और नोटिफिकेशन सेटिंग्स (System & Notification Controls) -->
                        <div class="section-title">
                            <i class="fa-solid fa-toggle-on me-2 text-info"></i> 2. सिस्टम और नोटिफिकेशन सेटिंग्स
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="d-block text-dark" style="font-size: 14px;">यूज़र ऑटो-अप्रूवल (Auto-Approve Users)</strong>
                                <small class="text-muted">नया रजिस्ट्रेशन करने वाले किसानों/यूज़र्स को बिना एडमिन अप्रूवल के तुरंत लॉगिन करने दें।</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="autoApproveSwitch" name="auto_approve" value="1" style="width: 45px; height: 22px; cursor: pointer;">
                            </div>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-4 d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="d-block text-dark" style="font-size: 14px;">मंडी भाव और योजना अलर्ट (SMS / WhatsApp)</strong>
                                <small class="text-muted">रोज़ सुबह किसानों को ऑटोमैटिक मंडी भाव और सरकारी योजनाओं के अलर्ट भेजें।</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="alertSwitch" name="sms_alerts" value="1" checked style="width: 45px; height: 22px; cursor: pointer;">
                            </div>
                        </div>


                        <!-- 3. डेटाबेस बैकअप विकल्प -->
                        <div class="section-title">
                            <i class="fa-solid fa-database me-2 text-warning"></i> 3. डेटाबेस बैकअप (Database Backup)
                        </div>

                        <div class="p-3 border border-warning-subtle bg-warning-subtle rounded-3 mb-4 d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="d-block text-dark" style="font-size: 14px;">पोर्टल डेटा बैकअप डाउनलोड करें</strong>
                                <small class="text-muted">यूज़र्स, शिकायतें, और टूल लिस्टिंग के पूरे डेटाबेस का बैकअप फाइल (.sql) रूप में डाउनलोड करें।</small>
                            </div>
                            <button type="button" onclick="alert('बैकअप फाइल सफलतापूर्वक डाउनलोड हो रही है भाई!')" class="btn btn-warning btn-sm fw-bold text-dark px-3 py-2 rounded-pill">
                                <i class="fa-solid fa-download me-1"></i> बैकअप डाउनलोड करें
                            </button>
                        </div>


                        <!-- 4. सुरक्षा और पासवर्ड सेटिंग्स (Security Settings) -->
                        <div class="section-title">
                            <i class="fa-solid fa-shield-halved me-2 text-danger"></i> 4. सुरक्षा और पासवर्ड सेटिंग्स
                        </div>
                        <p class="text-muted small mb-3">यदि आप अपना एडमिन पासवर्ड बदलना चाहते हैं, तभी नीचे दिए गए दोनों कॉलम भरें।</p>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold small">वर्तमान पासवर्ड (Current Password)</label>
                                <input type="password" name="current_password" class="form-control" placeholder="पुराना पासवर्ड दर्ज करें">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">नया पासवर्ड (New Password)</label>
                                <input type="password" name="new_password" class="form-control" placeholder="कम से कम 6 अंकों का नया पासवर्ड">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 fw-bold rounded-pill py-3 mt-3 shadow-sm">
                            <i class="fa-solid fa-floppy-disk me-1"></i> सभी सेटिंग्स सहेजें (Save All Settings)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>