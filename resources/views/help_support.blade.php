<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>सहायता और समर्थन - Help & Support | ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        
        /* Sidebar Styles (होमपेज जैसी फिक्स और स्क्रॉल करने वाली स्टाइल) */
        .sidebar { 
            background-color: #ffffff; 
            height: 100vh; 
            position: fixed; 
            top: 0; 
            left: 0; 
            overflow-y: auto; 
            border-right: 1px solid #e2e8f0; 
            z-index: 1000;
        }
        .sidebar-brand { padding: 20px; font-size: 19px; font-weight: bold; color: #198754; border-bottom: 1px solid #edf2f7; }
        .sidebar .nav-link { color: #4a5568; font-weight: 500; padding: 10px 20px; border-radius: 6px; margin: 4px 12px; display: flex; align-items: center; text-decoration: none; transition: all 0.2s; }
        .sidebar .nav-link i { width: 25px; font-size: 16px; color: #4a5568; }
        .sidebar .nav-link:hover { background-color: #f1f5f9; color: #198754; }
        .sidebar .nav-link:hover i { color: #198754; }
        .sidebar .nav-link.active { background-color: #198754; color: white !important; }
        .sidebar .nav-link.active i { color: white !important; }
        .sub-text { font-size: 11px; color: #718096; display: block; font-weight: normal; margin-top: -2px; }
        
        /* Top Navbar */
        .top-navbar { background-color: white; padding: 12px 30px; border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 999; }
        
        /* Support Card Styles */
        .support-card { background: white; border-radius: 14px; padding: 25px; border: 1px solid #e2e8f0; height: 100%; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
        .faq-item { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 15px; margin-bottom: 12px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <!-- लेफ्ट साइडबार -->
        <div class="col-md-2 p-0 sidebar d-none d-md-flex flex-column justify-content-between">
            <div>
                <div class="sidebar-brand">
                    <i class="fa-solid fa-leaf text-success me-2"></i> Gram Pragati
                    <div style="font-size: 11px; color: #718096; font-weight: normal; margin-top: 2px;">Sashakt Kisan, Digital Gaon</div>
                </div>
                
                <div class="nav flex-column mt-2 mb-5">
                    <a class="nav-link" href="/"><i class="fa-solid fa-house"></i> <div>Home / होम</div></a>
                    <a class="nav-link" href="/smart-krishi"><i class="fa-solid fa-seedling text-success"></i> <div>Smart Krishi <span class="sub-text">खेती जानकारी</span></div></a>
                    <a class="nav-link" href="/e-panchayat"><i class="fa-solid fa-landmark text-primary"></i> <div>E-Panchayat <span class="sub-text">ग्राम पंचायत</span></div></a>
                    <a class="nav-link" href="/kheti-bazaar"><i class="fa-solid fa-tractor text-warning"></i> <div>Kheti Bazaar <span class="sub-text">खरीदें / बेचें / किराए पर लें</span></div></a>
                    <a class="nav-link" href="/pashu-swasthya"><i class="fa-solid fa-cow text-info"></i> <div>Pashu & Swasthya <span class="sub-text">पशु स्वास्थ्य</span></div></a>
                    <a class="nav-link" href="/complaint/create"><i class="fa-solid fa-bullhorn text-danger"></i> <div>Citizen Voice <span class="sub-text">समस्या रिपोर्ट करें</span></div></a>
                    <a class="nav-link" href="/skill-up"><i class="fa-solid fa-graduation-cap text-secondary"></i> <div>Skill-Up <span class="sub-text">कौशल विकास</span></div></a>
                    <a class="nav-link" href="/expert-meeting"><i class="fa-solid fa-user-tie text-success"></i> <div>Expert Meeting <span class="sub-text">विशेषज्ञ से जुड़ें</span></div></a>
                    <a class="nav-link" href="/profile"><i class="fa-solid fa-address-card text-primary"></i> <div>Profile <span class="sub-text">मेरा प्रोफ़ाइल</span></div></a>
                    <a class="nav-link active" href="/help-support"><i class="fa-solid fa-headset text-info"></i> <div>Help & Support <span class="sub-text">सहायता</span></div></a>
                </div>
            </div>
            
            <div class="p-3 w-100 bg-white border-top" style="position: sticky; bottom: 0;">
                <button class="btn btn-outline-success w-100 btn-sm rounded-pill py-2 fw-semibold border-success text-success bg-light-subtle">
                    <i class="fa-solid fa-microphone me-1"></i> बोलकर खोजें
                </button>
            </div>
        </div>

        <!-- राइट साइड का मुख्य कंटेंट -->
        <div class="col-md-10 offset-md-2 p-0">
            
            <div class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="fw-bold m-0 text-success"><i class="fa-solid fa-headset me-2"></i> सहायता और समर्थन केंद्र (Help & Support)</h5>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="/" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold"><i class="fa-solid fa-arrow-left me-1"></i> होम पेज पर लौटें</a>
                </div>
            </div>

            <div class="p-4">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    
                    <!-- कॉलम 1: अक्सर पूछे जाने वाले प्रश्न (FAQ) -->
                    <div class="col-lg-7">
                        <div class="support-card">
                            <h5 class="fw-bold text-dark mb-3" style="font-size: 16px;"><i class="fa-solid fa-circle-question text-success me-2"></i> अक्सर पूछे जाने वाले प्रश्न (FAQ)</h5>
                            
                            <div class="faq-item">
                                <h6 class="fw-bold text-success mb-1" style="font-size: 14px;">1. पोर्टल पर नया रजिस्ट्रेशन कैसे करें?</h6>
                                <p class="text-muted m-0" style="font-size: 12.5px;">होम पेज पर ऊपर दिए गए 'पंजीकरण (Register)' बटन पर क्लिक करें। अपना नाम, मोबाइल नंबर, क्षेत्र और पासवर्ड भरकर रजिस्टर कर सकते हैं।</p>
                            </div>

                            <div class="faq-item">
                                <h6 class="fw-bold text-success mb-1" style="font-size: 14px;">2. मंडी के ताज़ा भाव कैसे देखें?</h6>
                                <p class="text-muted m-0" style="font-size: 12.5px;">होम पेज के दाईं ओर आपको सतना मंडी के गेहूँ, धान, मक्का आदि के लाइव भाव दिख जाएंगे। पूरी जानकारी के लिए 'सभी देखें' पर क्लिक करें।</p>
                            </div>

                            <div class="faq-item">
                                <h6 class="fw-bold text-success mb-1" style="font-size: 14px;">3. अपनी समस्या या शिकायत कैसे दर्ज करें?</h6>
                                <p class="text-muted m-0" style="font-size: 12.5px;">साइडबार में 'Citizen Voice (समस्या रिपोर्ट करें)' पर क्लिक करके अपनी शिकायत फोटो और वार्ड की जानकारी के साथ दर्ज करा सकते हैं।</p>
                            </div>

                            <div class="faq-item">
                                <h6 class="fw-bold text-success mb-1" style="font-size: 14px;">4. कृषि यंत्र किराए पर कैसे लें या चढ़ाएं?</h6>
                                <p class="text-muted m-0" style="font-size: 12.5px;">'Kheti Bazaar' विकल्प पर जाएं। वहाँ आप अपने ट्रैक्टर या थ्रेशर का विवरण भरकर खुद बाज़ार में लाइव कर सकते हैं।</p>
                            </div>
                        </div>
                    </div>

                    <!-- कॉलम 2: हेल्पलाइन और डायरेक्ट कांटेक्ट -->
                    <div class="col-lg-5">
                        <div class="support-card mb-4">
                            <h5 class="fw-bold text-dark mb-3" style="font-size: 16px;"><i class="fa-solid fa-phone-volume text-primary me-2"></i> आधिकारिक हेल्पलाइन नंबर</h5>
                            
                            <div class="d-flex align-items-center gap-3 p-3 border rounded-3 mb-2 bg-light">
                                <div class="fs-4 text-success"><i class="fa-solid fa-phone"></i></div>
                                <div>
                                    <strong class="d-block text-dark" style="font-size: 13.5px;">तकनीकी सहायता (Technical Help)</strong>
                                    <a href="tel:6299822734" class="text-success fw-bold text-decoration-none" style="font-size: 14px;">6299822734</a>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3 p-3 border rounded-3 mb-2 bg-light">
                                <div class="fs-4 text-primary"><i class="fa-solid fa-landmark"></i></div>
                                <div>
                                    <strong class="d-block text-dark" style="font-size: 13.5px;">ग्राम पंचायत सहायता डेस्क</strong>
                                    <span class="text-muted" style="font-size: 12.5px;">सोमवार - शनिवार (सुबह 10:00 - शाम 5:00)</span>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="https://wa.me/916299822734?text=नमस्ते%20एडमिन,%20मुझे%20ग्राम%20प्रगति%20पोर्टल%20के%20संबंध%20में%20सहायता%20चाहिए।" target="_blank" class="btn btn-success w-100 rounded-pill fw-bold shadow-sm py-2" style="font-size: 13.5px;">
                                    <i class="fa-brands fa-whatsapp me-2"></i> व्हाट्सएप पर तुरंत मदद लें
                                </a>
                            </div>
                        </div>

                        <!-- डेवलपर क्रेडिट बॉक्स -->
                        <div class="support-card bg-success bg-gradient text-white text-center">
                            <h6 class="fw-bold mb-1" style="font-size: 15px;"><i class="fa-solid fa-laptop-code me-1"></i> ग्राम प्रगति तकनीकी टीम</h6>
                            <p class="mb-2" style="font-size: 12px; opacity: 0.9;">पुरुषोत्तम कुमार & रोहित विश्वकर्मा</p>
                            <span class="badge bg-white text-success px-3 py-1 rounded-pill" style="font-size: 11px;">सशक्त किसान, डिजिटल गाँव</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>