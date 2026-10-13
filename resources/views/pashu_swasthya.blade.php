<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>पशु स्वास्थ्य एवं चिकित्सा केंद्र - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --primary-green: #15803d;
            --dark-green: #166534;
            --light-bg: #f8fafc;
        }
        body { background-color: var(--light-bg); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #334155; }
        
        /* टॉप नेव / हेडर बार */
        .top-header { background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 15px 0; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        
        /* हीरो बैनर (IT Company Gradient Look) */
        .hero-banner { 
            background: linear-gradient(135deg, #15803d, #166534); 
            color: white; 
            padding: 35px 30px; 
            border-radius: 16px; 
            margin-bottom: 30px; 
            box-shadow: 0 10px 25px -5px rgba(21, 128, 61, 0.2);
            position: relative;
            overflow: hidden;
        }
        .hero-banner::after {
            content: "\f6d7";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            right: -20px;
            bottom: -30px;
            font-size: 160px;
            color: rgba(255, 255, 255, 0.08);
        }

        /* मॉडर्न प्रीमियम कार्ड्स */
        .card-custom { 
            border: none; 
            border-radius: 16px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); 
            transition: all 0.3s ease; 
            background: white; 
            margin-bottom: 24px; 
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }
        .card-custom:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06); 
        }

        /* कार्ड हेडर आइकॉन बॉक्सेस */
        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .btn-custom {
            border-radius: 10px;
            padding: 10px 16px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        /* कस्टम स्क्रॉलहबार डायरेक्टरी के लिए */
        .directory-scroll {
            max-height: 210px;
            overflow-y: auto;
            padding-right: 5px;
        }
        .directory-scroll::-webkit-scrollbar { width: 5px; }
        .directory-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body>

    <!-- टॉप हेडर बार -->
    <div class="top-header mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-success m-0" style="font-size: 20px;">
                <i class="fa-solid fa-cow me-2 text-success"></i> ग्राम प्रगति <small class="text-muted fw-normal" style="font-size: 14px;">| पशु स्वास्थ्य पोर्टल</small>
            </h4>
            <a href="/" class="btn btn-outline-secondary btn-sm fw-semibold rounded-pill px-3">
                <i class="fa-solid fa-house me-1"></i> होम पर जाएं
            </a>
        </div>
    </div>

    <div class="container pb-5">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- प्रीमियम हीरो बैनर -->
        <div class="hero-banner">
            <h1 class="fw-bold fs-3 mb-2">किसान भाइयों, पशुओं की बेहतर देखभाल अब हुई आसान!</h1>
            <p class="mb-0 text-white-50 fs-6" style="max-width: 700px;">एआई तकनीक द्वारा रोग पहचान, आपातकालीन डॉक्टर हेल्पलाइन, और डिजिटल हेल्थ रिकॉर्ड्स की संपूर्ण सुविधा अब आपके मोबाइल पर।</p>
        </div>

        <div class="row g-4">
            
            <!-- 1. 🤖 AI-Powered Disease Detection (एआई रोग पहचान) -->
            <div class="col-lg-6">
                <div class="card card-custom p-4 h-100 border-top border-success border-4">
                    <div class="icon-box bg-success bg-opacity-10 text-success">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">1. एआई रोग पहचान (AI Disease Detection)</h5>
                    <p class="text-muted small mb-4">अपने पशु (गाय, भैंस) की त्वचा या घाव की फोटो अपलोड करें। एआई तुरंत बीमारी का नाम और शुरुआती उपचार बताएगा।</p>
                    
                    <form action="#" method="POST" enctype="multipart/form-data" class="mt-auto">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">बीमार हिस्से या घाव की साफ फोटो चुनें:</label>
                            <input type="file" name="animal_image" class="form-control form-control-sm rounded-3 py-2" required>
                        </div>
                        <button type="button" onclick="alert('एआई मॉडल स्कैन कर रहा है: पशु में सामान्य त्वचा संक्रमण के लक्षण पाए गए हैं। नजदीकी डॉक्टर से संपर्क करें।')" class="btn btn-success btn-custom btn-sm w-100 shadow-sm">
                            <i class="fa-solid fa-wand-magic-sparkles me-2"></i> एआई से जांच करवाएं
                        </button>
                    </form>
                </div>
            </div>

            <!-- 2. 📞 Emergency Vet Directory (आपातकालीन डॉक्टर - डायनामिक डेटाबेस आधारित) -->
            <div class="col-lg-6">
                <div class="card card-custom p-4 h-100 border-top border-primary border-4">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">2. नजदीकी पशु चिकित्सक (Emergency Directory)</h5>
                    <p class="text-muted small mb-3">ये नंबर पूरी तरह से एडमिन द्वारा सत्यापित और अपडेटेड हैं:</p>
                    
                    <div class="directory-scroll pe-2">
                        @isset($doctors)
                            @forelse($doctors as $doc)
                                <div class="d-flex justify-content-between align-items-center bg-light p-2.5 rounded-3 mb-2 border">
                                    <div>
                                        <strong class="text-dark d-block" style="font-size: 14px;">{{ $doc->title }}</strong>
                                        <small class="text-muted" style="font-size: 12px;"><i class="fa-solid fa-location-dot text-danger me-1"></i>{{ $doc->description }}</small>
                                    </div>
                                    <!-- 1-Click Direct Call Button -->
                                    <a href="tel:{{ $doc->phone }}" class="btn btn-sm btn-primary fw-bold px-3 rounded-pill shadow-sm" style="font-size: 13px;">
                                        <i class="fa-solid fa-phone me-1"></i> कॉल करें
                                    </a>
                                </div>
                            @empty
                                <div class="alert alert-warning py-3 small m-0 rounded-3 text-center">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i> अभी एडमिन द्वारा कोई डॉक्टर का नंबर जोड़ा नहीं गया है।
                                </div>
                            @endforelse
                        @endisset
                    </div>
                </div>
            </div>

            <!-- 3. 🚑 Mobile Ambulance / Unit Tracker -->
            <div class="col-lg-4">
                <div class="card card-custom p-4 h-100 text-center d-flex flex-column align-items-center border-top border-danger border-4">
                    <div class="icon-box bg-danger bg-opacity-10 text-danger">
                        <i class="fa-solid fa-truck-medical"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">3. मोबाइल पशु चिकित्सा यूनिट</h6>
                    <p class="text-muted small mb-4">आपके ग्राम पंचायत क्षेत्र में एम्बुलेंस वैन की लाइव उपस्थिति और शेड्यूल।</p>
                    <div class="mt-auto w-100 bg-danger bg-opacity-10 text-danger p-3 rounded-3 fw-semibold small border border-danger border-opacity-25">
                        <i class="fa-solid fa-calendar-days me-1"></i> वैन क्रमांक MP-19-V-2026 कल आपके ग्राम पंचायत में आएगी
                    </div>
                </div>
            </div>

            <!-- 4. 🔔 Vaccination & Deworming Reminders -->
            <div class="col-lg-4">
                <div class="card card-custom p-4 h-100 text-center d-flex flex-column align-items-center border-top border-warning border-4">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-2">4. टीकाकरण रिमाइंडर (Vaccination)</h6>
                    <p class="text-muted small mb-3">खुरपका-मुंहपका (FMD) व गलघोटू टीके की अगली तारीख की सूचना:</p>
                    
                    <div class="mt-auto w-100">
                        @isset($vaccines)
                            @forelse($vaccines as $vac)
                                <div class="alert alert-warning py-2 small mb-1 border-warning">
                                    <strong>{{ $vac->vaccine_name }}</strong><br>
                                    दिनांक: {{ $vac->camp_date }} | स्थान: {{ $vac->location }}
                                </div>
                            @empty
                                <div class="bg-light p-3 rounded-3 text-muted small border">अगला टीकाकरण: एडमिन द्वारा जल्द अपडेट किया जाएगा</div>
                            @endforelse
                        @else
                            <div class="bg-warning bg-opacity-10 text-dark p-3 rounded-3 small fw-semibold border border-warning border-opacity-25">
                                <i class="fa-solid fa-syringe me-1 text-warning"></i> अगला टीका: 15 अगस्त <br><span class="text-muted fw-normal" style="font-size: 11px;">(स्वचालित एसएमएस अलर्ट एक्टिव)</span>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>

            <!-- 5. 🛡️ Health Certificate & QR Verification -->
            <div class="col-lg-4">
                <div class="card card-custom p-4 h-100 border-top border-info border-4">
                    <div class="icon-box bg-info bg-opacity-10 text-info mx-auto">
                        <i class="fa-solid fa-file-shield"></i>
                    </div>
                    <h6 class="fw-bold text-dark text-center mb-2">5. पशु बाज़ार हेल्थ सर्टिफिकेट</h6>
                    <p class="text-muted small text-center mb-3">बाज़ार ले जाने से पहले डिजिटल QR हेल्थ कार्ड के लिए आवेदन करें:</p>
                    
                    <!-- आवेदन फॉर्म -->
                    <form action="/pashu-certificate/apply" method="POST" class="mt-auto">
                        @csrf
                        <div class="mb-2">
                            <input type="text" name="animal_tag" class="form-control form-control-sm rounded-3 py-2" placeholder="पशु टैग नंबर / नाम दर्ज करें" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="market_name" class="form-control form-control-sm rounded-3 py-2" placeholder="किस बाज़ार ले जाना है? (स्थान)" required>
                        </div>
                        <button type="submit" class="btn btn-info btn-custom btn-sm text-white fw-bold w-100 shadow-sm">
                            <i class="fa-solid fa-paper-plane me-1"></i> सर्टिफिकेट के लिए आवेदन करें
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>