<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ग्राम प्रगति - Gram Pragati</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        
        /* 🔥 केवल साइडबार अपनी जगह फिक्स रहेगा और इसके अंदर ही स्क्रॉल होगा */
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
        .search-box { background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 30px; padding: 6px 15px; width: 350px; }
        .search-box input { background: transparent; border: none; outline: none; width: 100%; font-size: 14px; }
        
        /* BANNER CARD WITH DYNAMIC BACKGROUNDS BASED ON USER ROLES */
        .banner-card { 
            background-size: cover;
            background-position: center;
            border-radius: 16px; 
            padding: 30px 35px; 
            border: 1px solid #a5d6a7; 
            min-height: 230px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            background-image: linear-gradient(rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.75)), 
            @auth
                @if(Auth::user()->role == 'student')
                    url("{{ asset('images/skills.jpg') }}");
                @elseif(Auth::user()->role == 'farmer')
                    url("{{ asset('images/fasal.jpg') }}");
                @else
                    url("{{ asset('images/village.jpg') }}");
                @endif
            @else
                url("{{ asset('images/village.jpg') }}");
            @endauth
        }
        
        /* PROFILE AVATAR BOX */
        .farmer-avatar-box { 
            background-color: #ffffff; 
            border-radius: 50%; 
            width: 130px; 
            height: 130px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            border: 4px solid #198754; 
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .farmer-avatar-box img { width: 100%; height: 100%; object-fit: cover; }
        
        /* Mandi Card */
        .mandi-card { background: white; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; height: 100%; }
        .mandi-item { border-bottom: 1px solid #f1f5f9; padding: 10px 0; font-size: 14px; }
        .mandi-item:last-child { border: none; }
        
        /* Service Cards */
        .service-card { background: white; border-radius: 12px; padding: 20px; border: 1px solid #e2e8f0; text-align: center; transition: all 0.2s ease; height: 100%; }
        .service-card:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
        .icon-circle { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px auto; font-size: 20px; }
        .btn-go { border-radius: 20px; font-size: 12px; font-weight: 500; padding: 4px 15px; text-decoration: none; display: inline-block; transition: all 0.2s; }
        .btn-go:hover { opacity: 0.8; }
        
        /* Info Boxes */
        .info-box { background: white; border-radius: 12px; padding: 20px; border: 1px solid #e2e8f0; height: 100%; }
        
        /* Quick Actions Circle Icon */
        .action-circle { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 15px; margin: 0 auto 4px auto; cursor: pointer; transition: transform 0.2s; }
        .action-circle:hover { transform: scale(1.1); }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <!-- 왼쪽 साइडबार (Fixed with Scroll) - बिल्कुल साफ़-सुथरा -->
        <div class="col-md-2 p-0 sidebar d-none d-md-flex flex-column justify-content-between">
            <div>
                <div class="sidebar-brand">
                    <i class="fa-solid fa-leaf text-success me-2"></i> Gram Pragati
                    <div style="font-size: 11px; color: #718096; font-weight: normal; margin-top: 2px;">Sashakt Kisan, Digital Gaon</div>
                </div>
                
                <div class="nav flex-column mt-2 mb-5">
                    <a class="nav-link active" href="/"><i class="fa-solid fa-house"></i> <div>Home / होम</div></a>
                    
                    <a class="nav-link" href="/smart-krishi"><i class="fa-solid fa-seedling text-success"></i> <div>Smart Krishi <span class="sub-text">खेती जानकारी</span></div></a>
                    
                    <a class="nav-link" href="/e-panchayat"><i class="fa-solid fa-landmark text-primary"></i> <div>E-Panchayat <span class="sub-text">ग्राम पंचायत</span></div></a>
                    
                    <a class="nav-link" href="/kheti-bazaar"><i class="fa-solid fa-tractor text-warning"></i> <div>Kheti Bazaar <span class="sub-text">खरीदें / बेचें / किराए पर लें</span></div></a>
                    
                    <a class="nav-link" href="/pashu-swasthya"><i class="fa-solid fa-cow text-info"></i> <div>Pashu & Swasthya <span class="sub-text">पशु स्वास्थ्य</span></div></a>
                    
                    <a class="nav-link" href="/complaint/create"><i class="fa-solid fa-bullhorn text-danger"></i> <div>Citizen Voice <span class="sub-text">समस्या रिपोर्ट करें</span></div></a>
                    
                    <a class="nav-link" href="/skill-up"><i class="fa-solid fa-graduation-cap text-secondary"></i> <div>Skill-Up <span class="sub-text">कौशल विकास</span></div></a>
                    
                    <a class="nav-link" href="/expert-meeting"><i class="fa-solid fa-user-tie text-success"></i> <div>Expert Meeting <span class="sub-text">विशेषज्ञ से जुड़ें</span></div></a>
                    
                    <a class="nav-link" href="/profile"><i class="fa-solid fa-address-card text-primary"></i> <div>Profile <span class="sub-text">मेरा प्रोफ़ाइल</span></div></a>
                    
                    <a class="nav-link" href="/help-support"><i class="fa-solid fa-headset text-info"></i> <div>Help & Support <span class="sub-text">सहायता</span></div></a>
                </div>
            </div>
            
            <!-- साइडबार वाला बोलकर खोजें बटन -->
            <div class="p-3 w-100 bg-white border-top" style="position: sticky; bottom: 0;">
                <button type="button" onclick="startGlobalVoiceSearch()" class="btn btn-outline-success w-100 btn-sm rounded-pill py-2 fw-semibold border-success text-success bg-light-subtle">
                    <i class="fa-solid fa-microphone me-1" id="sidebarMicIcon"></i> बोलकर खोजें (Voice Search)
                </button>
            </div>
        </div>

        <!-- राइट साइड का मुख्य कंटेंट (Normal Page Scroll) -->
        <div class="col-md-10 offset-md-2 p-0">
            
            <div class="top-navbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-bars fs-5 text-secondary cursor-pointer"></i>
                    
                    <div class="d-flex align-items-center text-dark fw-semibold" style="font-size: 14px;">
                        <i class="fa-solid fa-location-dot text-success me-1"></i> 
                        @auth
                            {{ Auth::user()->location }}
                        @else
                            आपकी लोकेशन (लॉगिन करें)
                        @endauth
                        <i class="fa-solid fa-chevron-down ms-1" style="font-size:10px;"></i>
                    </div>
                    
                    <!-- टॉप नेविगेशन बार वाला सर्च बॉक्स और माइक -->
                    <div class="search-box d-flex align-items-center">
                        <input type="text" id="globalSearchInput" placeholder="कुछ भी खोजें...">
                        <i class="fa-solid fa-microphone text-success me-2" style="cursor: pointer;" onclick="startGlobalVoiceSearch()" title="बोलकर खोजें"></i>
                        <i class="fa-solid fa-magnifying-glass text-secondary"></i>
                    </div>
                </div>
                
                <div class="d-flex align-items-center gap-4">
                    <span class="text-muted fw-medium" style="font-size: 14px;"><span class="text-success fw-bold">हिंदी</span> | English</span>
                    <div class="position-relative">
                        <i class="fa-regular fa-bell fs-5 text-secondary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 9px; padding: 3px 5px;">3</span>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        @auth
                            <div class="text-end me-1">
                                <span class="d-block fw-bold" style="font-size: 14px; color: #2d3748;">{{ Auth::user()->name }}</span>
                                @if(Auth::user()->role == 'student')
                                    <small class="text-primary fw-medium d-block" style="font-size: 11px; margin-top:-2px;">युवा साथी 🎓</small>
                                @elseif(Auth::user()->role == 'citizen')
                                    <small class="text-warning-emphasis fw-medium d-block" style="font-size: 11px; margin-top:-2px;">ग्रामवासी 🏡</small>
                                @else
                                    <small class="text-success fw-medium d-block" style="font-size: 11px; margin-top:-2px;">किसान भाई 🌾</small>
                                @endif
                                
                                <form action="/farmer-logout" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn p-0 border-0 text-danger fw-bold shadow-none" style="font-size: 11px; text-decoration: underline; margin-top: 1px;">
                                        <i class="fa-solid fa-right-from-bracket alert-danger me-1"></i> लॉगआउट (Logout)
                                    </button>
                                </form>
                            </div>
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-weight: bold; overflow:hidden; border: 1px solid #dee2e6;">
                                @if(Auth::user()->profile_image)
                                    <img src="{{ asset(Auth::user()->profile_image) }}" style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    <img src="{{ asset('images/kisan.jpg') }}" style="width:100%; height:100%; object-fit:cover;">
                                @endif
                            </div>
                        @else
                            <div class="text-end d-flex gap-2">
                                <a href="/login-form" class="btn btn-sm btn-success rounded-pill px-3 fw-bold" style="font-size: 12px;"><i class="fa-solid fa-right-to-bracket me-1"></i> लॉगिन (Login)</a>
                                <a href="/register-form" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold" style="font-size: 12px;"><i class="fa-solid fa-user-plus me-1"></i> पंजीकरण (Register)</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>

            <div id="main-home-layout" class="p-4">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    
                    <div class="col-lg-8">
                        <div class="banner-card">
                            <div>
                                @auth
                                    @if(Auth::user()->role == 'student')
                                        <h2 class="fw-bold text-success mb-1">नमस्ते {{ Auth::user()->name }} जी! 🎓</h2>
                                        <p class="text-dark fw-medium mb-4" style="font-size: 15px;">युवा शक्ति से ही गाँव आगे बढ़ेगा। स्किल-अप कोर्सेज और नई तकनीकें सीखें!</p>
                                    @elseif(Auth::user()->role == 'citizen')
                                        <h2 class="fw-bold text-success mb-1">नमस्ते {{ Auth::user()->name }} जी! 🏡</h2>
                                        <p class="text-dark fw-medium mb-4" style="font-size: 15px;">गाँव के डिजिटल हब में आपका स्वागत है। चलिए बाज़ार और नागरिक सुविधाएँ देखें।</p>
                                    @else
                                        <h2 class="fw-bold text-success mb-1">नमस्ते {{ Auth::user()->name }} जी! 🌾</h2>
                                        <p class="text-dark fw-medium mb-4" style="font-size: 15px;">हमारे साथ जुड़ें और आधुनिक खेती को बनाएँ और भी डिजिटल व लाभकारी।</p>
                                    @endif
                                @else
                                    <h2 class="fw-bold text-success mb-1">नमस्ते ग्रामवासी भाई! ✨</h2>
                                    <p class="text-dark fw-medium mb-4" style="font-size: 15px;">ग्राम प्रगति (Gram Pragati) में आपका स्वागत है। सेवाओं को आसान और digital बनाने के लिए लॉगिन करें।</p>
                                @endauth
                                
                                <div class="d-flex flex-wrap gap-2">
                                    <div class="bg-white px-3 py-1.5 rounded-3 border d-flex align-items-center gap-2" style="font-size: 12px; font-weight:500;">
                                        <i class="fa-solid fa-calendar-days text-warning"></i> <span>मंडी अपडेट: <strong class="text-success">आज</strong></span>
                                    </div>
                                    <div class="bg-white px-3 py-1.5 rounded-3 border d-flex align-items-center gap-2" style="font-size: 12px; font-weight:500;">
                                        <i class="fa-solid fa-cloud-sun text-primary"></i> <span>मौसम: <strong>28°C</strong></span>
                                    </div>
                                    <div class="bg-white px-3 py-1.5 rounded-3 border d-flex align-items-center gap-2" style="font-size: 12px; font-weight:500;">
                                        <i class="fa-solid fa-circle-exclamation text-danger"></i> <span>शिकायत स्थिति: <strong class="text-danger">2 Pending</strong></span>
                                    </div>
                                    <div class="bg-white px-3 py-1.5 rounded-3 border d-flex align-items-center gap-2" style="font-size: 12px; font-weight:500;">
                                        <i class="fa-solid fa-clock text-info"></i> <span>आने वाली बैठक: <strong class="text-info">कल 11:00 AM</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div class="pe-4">
                                <div class="farmer-avatar-box">
                                    @auth
                                        @if(Auth::user()->profile_image)
                                            <img src="{{ asset(Auth::user()->profile_image) }}" alt="यूज़र फोटो">
                                        @else
                                            <img src="{{ asset('images/kisan.jpg') }}" alt="डिफ़ॉल्ट फोटो">
                                        @endif
                                    @else
                                        <i class="fa-solid fa-user-circle text-success" style="font-size: 100px; color: #198754 !important;"></i>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mandi-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold m-0 text-dark" style="font-size:15px;">आज का मंडी भाव (Mandi Rates)</h6>
                                <a href="javascript:void(0);" onclick="openMandiAnalytics()" class="text-success fw-bold text-decoration-none" style="font-size: 12px;">सभी देखें</a>
                            </div>
                            
                            <div class="mandi-item d-flex justify-content-between align-items-center">
                                <span class="text-secondary">🌾 गेहूँ (Wheat)</span>
                                <span class="fw-bold" style="font-size:14px;">₹ {{ \Illuminate\Support\Facades\DB::table('mandi_rates')->where('district', 'Satna')->where('crop_name', 'गेहूँ')->value('rate') ?? '2150' }} / क्विंटल <i class="fa-solid fa-arrow-up text-success ms-1"></i></span>
                            </div>
                            <div class="mandi-item d-flex justify-content-between align-items-center">
                                <span class="text-secondary">🌾 धान (Paddy)</span>
                                <span class="fw-bold" style="font-size:14px;">₹ {{ \Illuminate\Support\Facades\DB::table('mandi_rates')->where('district', 'Satna')->where('crop_name', 'like', 'धान%')->value('rate') ?? '1880' }} / क्विंटल <i class="fa-solid fa-arrow-down text-danger ms-1"></i></span>
                            </div>
                            <div class="mandi-item d-flex justify-content-between align-items-center">
                                <span class="text-secondary">🌽 मक्का (Maize)</span>
                                <span class="fw-bold" style="font-size:14px;">₹ {{ \Illuminate\Support\Facades\DB::table('mandi_rates')->where('district', 'Satna')->where('crop_name', 'मक्का')->value('rate') ?? '1730' }} / क्विंटल <i class="fa-solid fa-arrow-up text-success ms-1"></i></span>
                            </div>
                            <div class="mandi-item d-flex justify-content-between align-items-center">
                                <span class="text-secondary">🫘 चना (Gram)</span>
                                <span class="fw-bold" style="font-size:14px;">₹ {{ \Illuminate\Support\Facades\DB::table('mandi_rates')->where('district', 'Satna')->where('crop_name', 'चना')->value('rate') ?? '6120' }} / क्विंटल <i class="fa-solid fa-arrow-down text-danger ms-1"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mt-4 mb-3 text-dark" style="font-size: 17px;">हमारी सेवाएँ / Our Services</h5>
                <div class="row g-3">
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card">
                            <div class="icon-circle bg-success-subtle text-success"><i class="fa-solid fa-seedling"></i></div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13.5px;">Smart Krishi</h6>
                            <p class="text-muted mb-3" style="font-size: 11px;">खेती की पूरी जानकारी</p>
                            <a href="/smart-krishi" class="btn-go bg-success-subtle text-success">जाएँ ➔</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card">
                            <div class="icon-circle bg-primary-subtle text-primary"><i class="fa-solid fa-landmark"></i></div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13.5px;">E-Panchayat</h6>
                            <p class="text-muted mb-3" style="font-size: 11px;">सरकारी योजनाएं व सेवाएँ</p>
                            <a href="/e-panchayat" class="btn-go bg-primary-subtle text-primary">जाएँ ➔</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card border-warning">
                            <div class="icon-circle bg-warning-subtle text-warning-emphasis"><i class="fa-solid fa-tractor"></i></div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13.5px;">Kheti Bazaar</h6>
                            <p class="text-muted mb-2" style="font-size: 11px;">किराए पर लें या सामान बेचें</p>
                            <a href="/kheti-bazaar" class="badge bg-warning text-dark text-decoration-none mb-2 p-1.5 d-block" style="font-size: 10px;">
                                <i class="fa-solid fa-plus-circle me-1"></i> बाज़ार देखें
                            </a>
                            <a href="/kheti-bazaar" class="btn-go bg-warning-subtle text-warning-emphasis">जाएँ ➔</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card border-info">
                            <div class="icon-circle bg-info-subtle text-info-emphasis"><i class="fa-solid fa-cow"></i></div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13.5px;">Pashu Swasthya</h6>
                            <p class="text-muted mb-2" style="font-size: 11px;">पशु डॉक्टर व स्वास्थ्य</p>
                            <a href="https://wa.me/916299822734?text=नमस्ते%20एडमिन,%20मैं%20एक%20पशु%20डॉक्टर/विशेषज्ञ%20हूँ%20और%20अपनी%20सेवाएँ%20देने%20के%20लिए%20नाम,%20लोकेशन%20और%20फोटो%20भेज%20रहा%20हूँ।" target="_blank" class="badge bg-info text-dark text-decoration-none mb-2 p-1.5 d-block" style="font-size: 10px;">
                                <i class="fa-solid fa-user-doctor me-1"></i> डॉक्टर सेवा जोड़ें
                            </a>
                            <a href="/pashu-swasthya" class="btn-go bg-info-subtle text-info-emphasis">जाएँ ➔</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card">
                            <div class="icon-circle bg-danger-subtle text-danger"><i class="fa-solid fa-bullhorn"></i></div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13.5px;">Citizen Voice</h6>
                            <p class="text-muted mb-3" style="font-size: 11px;">समस्या रिपोर्ट व समाधान</p>
                            <a href="/complaint/create" class="btn-go bg-danger-subtle text-danger">जाएँ ➔</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card">
                            <div class="icon-circle bg-secondary-subtle text-dark"><i class="fa-solid fa-graduation-cap"></i></div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13.5px;">Skill-Up</h6>
                            <p class="text-muted mb-3" style="font-size: 11px;">नई स्किल सीखें रोज़गार बढ़ाएं</p>
                            <a href="/skill-up" class="btn-go bg-secondary-subtle text-dark">जाएँ ➔</a>
                        </div>
                    </div>

                </div>

                <!-- 🔥 विशेष ग्रामीण सेवाएँ / Special Rural Services (6 शानदार फीचर्स आइकॉन के साथ) -->
                <h5 class="fw-bold mt-4 mb-3 text-dark" style="font-size: 17px;">विशेष ग्रामीण सेवाएँ / Special Rural Services 🌾</h5>
                <div class="row g-3">
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card border-success">
                            <div class="icon-circle bg-success-subtle text-success" style="font-size:24px;">🌤️</div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13px;">मौसम चेतावनी</h6>
                            <p class="text-muted mb-3" style="font-size: 10.5px;">Live Weather Alert</p>
                            <a href="/weather-advisory" class="btn-go bg-success-subtle text-success">जाएँ ➔</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card border-warning">
                            <div class="icon-circle bg-warning-subtle text-warning-emphasis" style="font-size:24px;">🚜</div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13px;">परिवहन सेवा</h6>
                            <p class="text-muted mb-3" style="font-size: 10.5px;">Transport & Tractor</p>
                            <a href="/local-transport" class="btn-go bg-warning-subtle text-warning-emphasis">जाएँ ➔</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card border-info">
                            <div class="icon-circle bg-info-subtle text-info-emphasis" style="font-size:24px;">🧪</div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13px;">खाद कैलकुलेटर</h6>
                            <p class="text-muted mb-3" style="font-size: 10.5px;">Soil & Fertilizer</p>
                            <a href="/soil-calculator" class="btn-go bg-info-subtle text-info-emphasis">जाएँ ➔</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card border-danger">
                            <div class="icon-circle bg-danger-subtle text-danger" style="font-size:24px;">📞</div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13px;">आपातकालीन हेल्प</h6>
                            <p class="text-muted mb-3" style="font-size: 10.5px;">Emergency Helpdesk</p>
                            <a href="/emergency-help" class="btn-go bg-danger-subtle text-danger">जाएँ ➔</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card border-warning">
                            <div class="icon-circle bg-warning-subtle text-warning-emphasis" style="font-size:24px;">📅</div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13px;">फसल व पर्व कैलेंडर</h6>
                            <p class="text-muted mb-3" style="font-size: 10.5px;">Cultural & Crop Calendar</p>
                            <a href="/crop-calendar" class="btn-go bg-warning-subtle text-warning-emphasis">जाएँ ➔</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-lg-2">
                        <div class="service-card border-success">
                            <div class="icon-circle bg-success-subtle text-success" style="font-size:24px;">🌱</div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size:13px;">हरित ग्राम जागरूकता</h6>
                            <p class="text-muted mb-3" style="font-size: 10.5px;">Green Village & Organic</p>
                            <a href="/green-village" class="btn-go bg-success-subtle text-success">जाएँ ➔</a>
                        </div>
                    </div>

                </div>

                <div class="row g-4 mt-1">
                    <div class="col-md-3">
                        <div class="info-box">
                            <h6 class="fw-bold text-success" style="font-size:14px;"><i class="fa-solid fa-video me-1"></i> आगामी लाइव सेशन</h6>
                            <div class="d-flex align-items-center gap-2 mt-3 mb-2">
                                <img src="{{ asset('images/expert.jpg') }}" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;" onerror="this.src='https://via.placeholder.com/40'">
                                <div>
                                    <strong style="font-size:13px;" class="d-block">डॉ. रमेश वर्मा (कृषि विशेषज्ञ)</strong>
                                    <small class="text-muted" style="font-size:11px;">विषय: मृदा स्वास्थ्य और जैविक खेती</small>
                                </div>
                            </div>
                            <small class="text-muted d-block mb-2" style="font-size:11px;"><i class="fa-regular fa-calendar me-1"></i> 18 मई 2024, 11:00 AM</small>
                            <a href="/expert-meeting" class="btn btn-success btn-sm w-100 rounded-2 fw-semibold text-white text-decoration-none d-block text-center" style="font-size:11px;">सेशन जॉइन करें</a>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="info-box">
                            <h6 class="fw-bold text-primary" style="font-size:14px;"><i class="fa-solid fa-cloud-sun-rain me-1"></i> मौसम अपडेट (Weather)</h6>
                            <div class="d-flex align-items-center gap-3 mt-2">
                                <span class="fs-2 fw-bold text-dark">28°C</span>
                                <div style="font-size:11px;" class="text-muted">
                                    <div>आर्द्रता: 62%</div>
                                    <div>हवा: 12 km/h</div>
                                </div>
                            </div>
                            <small class="text-muted d-block" style="font-size:11px;">Partly Cloudy | बारिश की संभावना: 20%</small>
                            <hr class="my-2">
                            <a href="/weather-advisory" class="text-primary text-decoration-none fw-bold d-block text-center" style="font-size:11px;">पूरे 5 दिन का पूर्वानुमान देखें ➔</a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="info-box text-center">
                            <h6 class="fw-bold text-dark text-start mb-3" style="font-size:14px;"><i class="fa-solid fa-bolt text-warning me-1"></i> त्वरित कार्य (Quick Actions)</h6>
                            
                            <div class="row g-1 text-center">
                                <div class="col">
                                    <a href="/complaint/create" class="text-decoration-none">
                                        <div class="action-circle bg-danger-subtle text-danger mx-auto"><i class="fa-solid fa-pen-to-square"></i></div>
                                        <span style="font-size:9px;" class="fw-semibold text-muted d-block mt-1">शिकायत</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#userToolModal">
                                        <div class="action-circle bg-warning-subtle text-warning-emphasis mx-auto"><i class="fa-solid fa-tractor"></i></div>
                                        <span style="font-size:9px;" class="fw-semibold text-muted d-block mt-1">टूल किराए</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#userProductModal">
                                        <div class="action-circle bg-success-subtle text-success mx-auto"><i class="fa-solid fa-store"></i></div>
                                        <span style="font-size:9px;" class="fw-semibold text-muted d-block mt-1">सामान बेचें</span>
                                    </a>
                                </div>
                                <!-- 🔥 नया जोड़ा गया त्वरित कार्य: अपना परिवहन/वाहन किराए पर लगाएं -->
                                <div class="col">
                                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#transportModal">
                                        <div class="action-circle bg-warning-subtle text-warning mx-auto" style="border: 1px dashed #eab308;"><i class="fa-solid fa-truck-fast"></i></div>
                                        <span style="font-size:9px;" class="fw-semibold text-muted d-block mt-1">वाहन किराए</span>
                                    </a>
                                </div>
                                <div class="col" onclick="openMandiAnalytics()" style="cursor: pointer;">
                                    <div class="action-circle bg-success-subtle text-success mx-auto"><i class="fa-solid fa-chart-line"></i></div>
                                    <span style="font-size:9px;" class="fw-semibold text-muted d-block mt-1">मंडी भाव</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="info-box">
                            <h6 class="fw-bold text-danger" style="font-size:14px;"><i class="fa-solid fa-circle-info me-1"></i> महत्वपूर्ण सूचनाएं</h6>
                            <ul class="p-0 m-0 mt-2 list-unstyled" style="font-size:11.5px; color:#4a5568; line-height: 1.5;">
                                
                                @php
                                    $liveNotices = \Illuminate\Support\Facades\DB::table('notices')->orderBy('id', 'desc')->take(3)->get();
                                @endphp

                                @forelse($liveNotices as $notice)
                                    <li class="mb-2" title="{{ $notice->description }}">
                                        <strong class="text-dark">👉 {{ $notice->title }}</strong>
                                    </li>
                                @empty
                                    <li class="mb-1.5">👉 प्रधानमंत्री किसान सम्मान निधि की अगली किश्त 15 जून को जारी होगी।</li>
                                    <li class="mb-1.5">👉 ग्राम सभा बैठक 20 मई 2024 को सुबह 11 बजे होगी।</li>
                                    <li class="mb-2">👉 नई योजना: सोलर पंप पर 60% सब्सिडी उपलब्ध है।</li>
                                @endforelse
                                
                            </ul>
                            <a href="#" class="text-success text-decoration-none fw-bold d-block text-end mt-2" style="font-size:11px;">सभी सूचनाएं देखें ➔</a>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-4 text-white position-relative rounded-4" style="background: linear-gradient(135deg, #115e3b, #198754);">
                            <div class="row align-items-center">
                                <div class="col-md-8 text-center text-md-start">
                                    <span class="badge bg-white text-success fw-bold px-3 py-1.5 mb-2 rounded-pill shadow-sm" style="font-size: 11px; letter-spacing: 0.5px;">💻 DESIGNED & DEVELOPED BY</span>
                                    <h4 class="fw-bold mb-1 text-white">Purshottam Kumar & Rohit Vishwakarma (पुरुषोत्तम कुमार & रोहित विश्वकर्मा)</h4>
                                    <p class="mb-3 text-white-50" style="font-size: 13.5px; font-weight: 500;">क्या आप भी अपने व्यवसाय, दुकान, स्कूल या किसी प्रोजेक्ट के लिए ऐसी ही शानदार, आधुनिक और फ़ास्ट वेबसाइट बनवाना चाहते हैं? आज ही संपर्क करें!</p>
                                    
                                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                                        <a href="tel:6299822734" class="btn btn-light btn-sm text-success fw-bold rounded-pill px-3 shadow-sm" style="font-size: 12px;">
                                            <i class="fa-solid fa-phone me-1"></i> डायरेक्ट कॉल करें
                                        </a>
                                        <a href="https://wa.me/916299822734?text=नमस्ते%20पुरुषोत्तम%20जी,%20मैंने%20आपका%20ग्राम%20प्रगति%20प्रोजेक्ट%20देखा।%20मुझे%20भी%20अपने%20लिए%20एक%20वेबसाइट%20बनवानी%20है।" target="_blank" class="btn btn-success btn-sm fw-bold border border-white-50 rounded-pill px-3 shadow-sm bg-success bg-gradient" style="font-size: 12px;">
                                            <i class="fa-brands fa-whatsapp me-1"></i> व्हाट्सएप पर बात करें
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center mt-3 mt-md-0 d-flex justify-content-center justify-content-md-end">
                                    <div style="background-color: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); border-radius: 12px; padding: 15px 25px;" class="text-center shadow-inner">
                                        <div class="fs-1 text-warning mb-1"><i class="fa-solid fa-laptop-code"></i></div>
                                        <div class="fw-bold text-white" style="font-size: 13px;">Get Your Website</div>
                                        <small class="text-white-50" style="font-size: 11px;">Call/WhatsApp: <strong>6299822734</strong></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="mandi-full-analytics" class="p-4 d-none">
                <div class="d-flex justify-content-center">
                    <div class="card border shadow-sm p-3 rounded-4 bg-white" style="width: 100%; max-width: 460px; min-height: 80vh;">
                        
                        <div class="text-white text-center py-2 rounded-3 mb-3 fw-bold" style="background-color: #198754; font-size: 14px;">
                            2. MANDI ANALYTICS
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <button class="btn p-0 border-0 shadow-none" onclick="closeMandiAnalytics()"><i class="fa-solid fa-arrow-left fs-5 text-dark"></i></button>
                            <h5 class="fw-bold m-0" style="font-size: 16px; color: #1e293b;">Mandi Bhav</h5>
                            <i class="fa-solid fa-filter text-secondary fs-5"></i>
                        </div>

                        <div class="card border-0 p-2.5 mb-3 rounded-3 bg-light">
                            <div class="d-flex align-items-center justify-content-between" style="font-size: 13px;">
                                <span class="fw-bold text-dark"><i class="fa-solid fa-location-dot text-danger me-1"></i> Satna Mandi (सतना मंडी भाव)</span>
                                <i class="fa-solid fa-chevron-down text-secondary"></i>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between gap-1 mb-3">
                            <button class="btn btn-sm btn-light border w-100 fw-semibold" style="font-size: 12px; border-radius: 6px;">आज का भाव</button>
                            <button class="btn btn-sm w-100 fw-bold" style="font-size: 12px; background-color: #e2f0d9; color: #385723; border: 1px solid #c5e0b4; border-radius: 6px;">7 दिन का ट्रेंड</button>
                            <button class="btn btn-sm btn-light border w-100 fw-semibold" style="font-size: 12px; border-radius: 6px;">30 दिन का ट्रेंड</button>
                        </div>

                        <div class="card p-3 mb-3 border rounded-3 bg-white position-relative shadow-sm">
                            <div class="fw-bold text-dark mb-2" style="font-size: 12.5px;">गेहूँ (Wheat) - प्रति क्विंटल (₹)</div>
                            
                            <div style="width: 100%; height: 160px; position: relative;">
                                <canvas id="homepageLineChart"></canvas>
                                <div style="position: absolute; top: 5px; right: 10px; background-color: #198754; color: white; padding: 2px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">
                                    ₹ {{ \Illuminate\Support\Facades\DB::table('mandi_rates')->where('district', 'Satna')->where('crop_name', 'गेहूँ')->value('rate') ?? '2150' }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2 mb-4">
                            <div class="d-flex justify-content-between align-items-center p-2.5 border rounded-3 bg-white shadow-sm">
                                <span class="fw-semibold text-dark" style="font-size: 13.5px;">🌾 गेहूँ (Wheat)</span>
                                <span class="fw-bold text-dark" style="font-size: 13.5px;">₹ {{ \Illuminate\Support\Facades\DB::table('mandi_rates')->where('district', 'Satna')->where('crop_name', 'गेहूँ')->value('rate') ?? '2150' }} <i class="fa-solid fa-arrow-up text-success ms-1"></i></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-2.5 border rounded-3 bg-white shadow-sm">
                                <span class="fw-semibold text-dark" style="font-size: 13.5px;">🌾 धान (Paddy)</span>
                                <span class="fw-bold text-dark" style="font-size: 13.5px;">₹ {{ \Illuminate\Support\Facades\DB::table('mandi_rates')->where('district', 'Satna')->where('crop_name', 'like', 'धान%')->value('rate') ?? '1880' }} <i class="fa-solid fa-arrow-down text-danger ms-1"></i></span>
                            </div>
                            <div class="col-12 d-flex justify-content-between align-items-center p-2.5 border rounded-3 bg-white shadow-sm">
                                <span class="fw-semibold text-dark" style="font-size: 13.5px;">🌽 मक्का (Maize)</span>
                                <span class="fw-bold text-dark" style="font-size: 13.5px;">₹ {{ \Illuminate\Support\Facades\DB::table('mandi_rates')->where('district', 'Satna')->where('crop_name', 'मक्का')->value('rate') ?? '1730' }} <i class="fa-solid fa-arrow-up text-success ms-1"></i></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-2.5 border rounded-3 bg-white shadow-sm">
                                <span class="fw-semibold text-dark" style="font-size: 13.5px;">🫘 चना (Gram)</span>
                                <span class="fw-bold text-dark" style="font-size: 13.5px;">₹ {{ \Illuminate\Support\Facades\DB::table('mandi_rates')->where('district', 'Satna')->where('crop_name', 'चना')->value('rate') ?? '6120' }} <i class="fa-solid fa-arrow-down text-danger ms-1"></i></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal 1: टूल किराए पर चढ़ाने वाला फॉर्म -->
<div class="modal fade" id="userToolModal" tabindex="-1" aria-labelledby="userToolModalLabel" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden; background: #ffffff;">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="userToolModalLabel"><i class="fa-solid fa-tractor me-2"></i> अपना कृषि यंत्र किराए पर चढ़ाएं</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/kheti-bazaar/user-store-tool" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">यंत्र का प्रकार चुनें</label>
                        <select name="tool_type" id="tool_type_select" class="form-select form-select-sm" onchange="checkOtherCategory(this)" required>
                            <option value="ट्रैक्टर">🚜 ट्रैक्टर</option>
                            <option value="थ्रेशर">🌾 थ्रेशर मशीन</option>
                            <option value="पंप">💧 पानी का पंप</option>
                            <option value="स्प्रेयर">🌱 पावर स्प्रेयर</option>
                            <option value="अन्य">➕ अन्य यंत्र (खुद लिखें)</option>
                        </select>
                        <input type="text" id="other_tool_input" class="form-control form-control-sm mt-2 d-none" placeholder="यंत्र का नाम लिखें (जैसे: हार्वेस्टर, कल्टीवेटर)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">कंपनी व मॉडल का नाम</label>
                        <input type="text" name="tool_name" class="form-control form-control-sm" placeholder="उदा: John Deere 5310" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">किराया (₹ प्रति दिन)</label>
                        <input type="number" name="price_per_day" class="form-control form-control-sm" placeholder="उदा: 1500" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">आपका मोबाइल / WhatsApp</label>
                        <input type="text" name="phone" class="form-control form-control-sm" placeholder="उदा: {{ Auth::check() ? Auth::user()->phone : '6299822734' }}" value="{{ Auth::check() ? Auth::user()->phone : '6299822734' }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" style="font-size: 13px;">आपका स्थान (गाँव/क्षेत्र)</label>
                        <input type="text" name="location" class="form-control form-control-sm" placeholder="उदा: सतना, मध्य प्रदेश" value="{{ Auth::check() ? Auth::user()->location : '' }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" style="font-size: 13px;">मशीन की साफ़ फोटो चुनें</label>
                        <input type="file" name="tool_image" class="form-control form-control-sm" accept="image/*" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" style="font-size: 13px;">अतिरिक्त विवरण (वैकल्पिक)</label>
                        <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="मशीन के साथ क्या-क्या सामान मिलेगा, यहाँ लिखें..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary fw-bold rounded-pill px-3" data-bs-dismiss="modal">बंद करें</button>
                    <button type="submit" class="btn btn-sm btn-warning fw-bold rounded-pill px-4 shadow-sm"><i class="fa-solid fa-cloud-arrow-up me-1"></i> बाज़ार में लाइव करें</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 🔥 Modal 2: सामान/उत्पाद बेचने वाला फॉर्म (Product Listing Modal) -->
<div class="modal fade" id="userProductModal" tabindex="-1" aria-labelledby="userProductModalLabel" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden; background: #ffffff;">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="userProductModalLabel"><i class="fa-solid fa-store me-2"></i> अपना कृषि उत्पाद या सामान बाज़ार में बेचें</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/kheti-bazaar/user-store-product" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">उत्पाद की श्रेणी चुनें</label>
                        <select name="product_category" class="form-select form-select-sm" required>
                            <option value="बीज">🌱 बीज (Seeds)</option>
                            <option value="खाद">🧪 खाद एवं उर्वरक (Fertilizers)</option>
                            <option value="शहद">🍯 शुद्ध शहद (Pure Honey)</option>
                            <option value="दूध-दही">🥛 दूध, दही व डेयरी (Dairy Products)</option>
                            <option value="फसल-अनाज">🌾 अनाज व फसल (Crops & Grains)</option>
                            <option value="अन्य">➕ अन्य सामान</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">उत्पाद का नाम / विवरण</label>
                        <input type="text" name="product_name" class="form-control form-control-sm" placeholder="उदा: गेहूँ बीज / शुद्ध शहद (1 लीटर)" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">कीमत (₹ प्रति किलो/लीटर/UNIT)</label>
                        <input type="number" name="price" class="form-control form-control-sm" placeholder="उदा: 100" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">आपका मोबाइल / WhatsApp</label>
                        <input type="text" name="phone" class="form-control form-control-sm" value="{{ Auth::check() ? Auth::user()->phone : '6299822734' }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" style="font-size: 13px;">आपका स्थान (गाँव/क्षेत्र)</label>
                        <input type="text" name="location" class="form-control form-control-sm" value="{{ Auth::check() ? Auth::user()->location : 'सतना, मध्य प्रदेश' }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" style="font-size: 13px;">उत्पाद की साफ़ फोटो चुनें</label>
                        <input type="file" name="product_image" class="form-control form-control-sm" accept="image/*" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" style="font-size: 13px;">अतिरिक्त विवरण (वैकल्पिक)</label>
                        <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="पैकेजिंग, शुद्धता या मात्रा के बारे में लिखें..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary fw-bold rounded-pill px-3" data-bs-dismiss="modal">बंद करें</button>
                    <button type="submit" class="btn btn-sm btn-success fw-bold rounded-pill px-4 shadow-sm"><i class="fa-solid fa-cloud-arrow-up me-1"></i> बाज़ार में लाइव करें</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 🔥 Modal 3: परिवहन/वाहन किराए पर सूचीबद्व करने वाला फॉर्म (Transport Listing Modal) -->
<div class="modal fade" id="transportModal" tabindex="-1" aria-labelledby="transportModalLabel" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden; background: #ffffff;">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold" id="transportModalLabel"><i class="fa-solid fa-truck-fast me-2"></i> अपना परिवहन या वाहन किराए पर लगाएं</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/local-transport/store" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">वाहन की श्रेणी (Category)</label>
                        <select name="vehicle_type" class="form-select form-select-sm" required>
                            <option value="पिकअप / छोटा हाथी">🚚 पिकअप / छोटा हाथी (Pickup)</option>
                            <option value="ट्रैक्टर & ट्रॉली">🚜 ट्रैक्टर & ट्रॉली (Tractor & Trolley)</option>
                            <option value="लोडर / मालवाहक">📦 लोडर / मालवाहक (Loader / Carrier)</option>
                            <option value="जैसीबी / पोक्लेन">🏗️ जेसीबी / पोक्लेन (JCB / Earthmover)</option>
                            <option value="अन्य वाहन">🚗 अन्य व्यावसायिक वाहन (Other)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">वाहन का नाम और मॉडल</label>
                        <input type="text" name="vehicle_name" class="form-control form-control-sm" placeholder="उदा: Tata Ace, Mahindra Bolero" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">किराया (₹ प्रतिदिन / ट्रिप)</label>
                        <input type="number" name="price_per_day" class="form-control form-control-sm" placeholder="उदा: 1500" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="font-size: 13px;">आपका मोबाइल / WhatsApp</label>
                        <input type="text" name="phone" class="form-control form-control-sm" value="{{ Auth::check() ? Auth::user()->phone : '6299822734' }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" style="font-size: 13px;">आपका स्थान / क्षेत्र</label>
                        <input type="text" name="location" class="form-control form-control-sm" value="{{ Auth::check() ? Auth::user()->location : 'सतना, मध्य प्रदेश' }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" style="font-size: 13px;">वाहन की साफ़ फोटो चुनें</label>
                        <input type="file" name="vehicle_image" class="form-control form-control-sm" accept="image/*" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" style="font-size: 13px;">विशेष विवरण (वैकल्पिक)</label>
                        <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="लोडिंग क्षमता या अन्य जानकारी दें..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-sm btn-secondary fw-bold rounded-pill px-3" data-bs-dismiss="modal">बंद करें</button>
                    <button type="submit" class="btn btn-sm btn-warning fw-bold rounded-pill px-4 shadow-sm"><i class="fa-solid fa-cloud-arrow-up me-1"></i> वाहन बाज़ार में लाइव करें</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 🔥 ग्राम सारथी (Gram Sarthi AI) - सेंट्रल फ्लोटिंग चैटबोट विजेट -->
<div id="gramSarthiWidget" style="position: fixed; bottom: 25px; right: 25px; z-index: 99999; font-family: 'Segoe UI', sans-serif;">
    <button onclick="toggleGramSarthi()" class="btn text-white rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 65px; height: 65px; font-size: 28px; background: linear-gradient(135deg, #15803d, #166534); border: 3px solid white; transition: transform 0.2s;" title="ग्राम सारथी AI से बात करें">
        <i class="fa-solid fa-robot"></i>
    </button>

    <div id="gramSarthiWindow" class="card shadow-lg border-0 rounded-4" style="display: none; width: 350px; position: absolute; bottom: 80px; right: 0; background: #ffffff; overflow: hidden;">
        
        <div class="card-header text-white d-flex justify-content-between align-items-center py-3" style="background: linear-gradient(135deg, #15803d, #166534);">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-seedling fs-5"></i>
                <div>
                    <h6 class="m-0 fw-bold" style="font-size: 15px;">ग्राम सारथी (Gram Sarthi)</h6>
                    <small style="font-size: 11px; opacity: 0.9;">आपका डिजिटल कृषि एवं ग्राम सहायक</small>
                </div>
            </div>
            <button onclick="toggleGramSarthi()" class="btn-close btn-close-white btn-sm"></button>
        </div>
        
        <div class="card-body p-3" id="sarthiMessages" style="height: 280px; overflow-y: auto; font-size: 13.5px; background: #f8fafc;">
            <div class="bg-white p-2.5 rounded-3 shadow-sm mb-2 border" style="max-width: 88%;">
                <strong>ग्राम सारथी:</strong> राम-राम भाई! मैं ग्राम प्रगति का एआई सहायक हूँ। नीचे दिए गए माइक से बोलकर या टाइप करके खेती, पशु स्वास्थ्य या मंडी भाव पूछिए।
            </div>
        </div>

        <div class="card-footer bg-white p-2.5 border-top d-flex gap-2 align-items-center">
            <div class="input-group input-group-sm">
                <input type="text" id="sarthiInputMsg" class="form-control rounded-start-pill px-3 py-2" placeholder="बोलकर या लिखकर पूछें..." onkeypress="checkEnterKey(event)">
                <button type="button" onclick="startVoiceRecognition()" class="btn btn-outline-success px-2.5" title="बोलकर पूछें">
                    <i class="fa-solid fa-microphone text-success" id="micIcon"></i>
                </button>
            </div>
            <button onclick="sendSarthiMessage()" class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0; background-color: #15803d;">
                <i class="fa-solid fa-paper-plane" style="font-size: 13px;"></i>
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let currentChart = null;

    function toggleGramSarthi() {
        const win = document.getElementById('gramSarthiWindow');
        win.style.display = (win.style.display === 'none' || win.style.display === '') ? 'block' : 'none';
    }

    function checkEnterKey(e) {
        if (e.key === 'Enter') {
            sendSarthiMessage();
        }
    }

    function startVoiceRecognition() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!SpeechRecognition) {
            alert('क्षमा करें, आपका ब्राउज़र बोलकर टाइप करने की अनुमति नहीं देता। कृपया टाइप करें।');
            return;
        }

        const recognition = new SpeechRecognition();
        recognition.lang = 'hi-IN';
        recognition.interimResults = false;

        const micIcon = document.getElementById('micIcon');
        micIcon.classList.remove('fa-microphone');
        micIcon.classList.add('fa-spinner', 'fa-spin', 'text-danger');

        recognition.onresult = function(event) {
            const spokenText = event.results[0][0].transcript;
            document.getElementById('sarthiInputMsg').value = spokenText;
            micIcon.classList.remove('fa-spinner', 'fa-spin', 'text-danger');
            micIcon.classList.add('fa-microphone');
            sendSarthiMessage();
        };

        recognition.onerror = function() {
            micIcon.classList.remove('fa-spinner', 'fa-spin', 'text-danger');
            micIcon.classList.add('fa-microphone');
            alert('आवाज़ पहचान नहीं पाई, कृपया दोबारा बोलें।');
        };

        recognition.start();
    }

    // ग्लोबल वॉइस सर्च फंक्शन (सर्च बॉक्स और साइडबार माइक के लिए)
    function startGlobalVoiceSearch() {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!SpeechRecognition) {
            alert('क्षमा करें, आपका ब्राउज़र बोलकर खोजने की अनुमति नहीं देता।');
            return;
        }

        const recognition = new SpeechRecognition();
        recognition.lang = 'hi-IN';
        recognition.interimResults = false;

        recognition.onresult = function(event) {
            const spokenText = event.results[0][0].transcript;
            const searchInput = document.getElementById('globalSearchInput');
            if (searchInput) {
                searchInput.value = spokenText;
            }
        };

        recognition.onerror = function() {
            alert('आवाज़ साफ़ सुनाई नहीं दी, कृपया दोबारा बोलें।');
        };

        recognition.start();
    }

    function sendSarthiMessage() {
        const input = document.getElementById('sarthiInputMsg');
        const msg = input.value.trim();
        if(!msg) return;

        const chatBox = document.getElementById('sarthiMessages');
        
        chatBox.innerHTML += `<div class="text-end mb-2"><span class="bg-success text-white p-2.5 rounded-3 d-inline-block shadow-sm" style="max-width: 88%;">${msg}</span></div>`;
        input.value = '';
        chatBox.scrollTop = chatBox.scrollHeight;

        fetch('/smart-krishi/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: msg })
        })
        .then(res => res.json())
        .then(data => {
            chatBox.innerHTML += `<div class="bg-white p-2.5 rounded-3 shadow-sm mb-2 border" style="max-width: 88%;"><strong>ग्राम सारथी:</strong> ${data.reply}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        })
        .catch(err => {
            chatBox.innerHTML += `<div class="bg-white p-2.5 rounded-3 shadow-sm mb-2 border text-danger" style="max-width: 88%;">सर्वर से कनेक्ट करने में दिक्कत आ रही है भाई।</div>`;
        });
    }

    function checkOtherCategory(selectElement) {
        var otherInput = document.getElementById('other_tool_input');
        if(selectElement.value === 'अन्य') {
            otherInput.classList.remove('d-none');
            otherInput.required = true;
            otherInput.name = "tool_type";
            selectElement.removeAttribute('name');
        } else {
            otherInput.classList.add('d-none');
            otherInput.required = false;
            otherInput.removeAttribute('name');
            selectElement.name = "tool_type";
        }
    }

    function openMandiAnalytics() {
        document.getElementById('main-home-layout').classList.add('d-none');
        const analyticsScreen = document.getElementById('mandi-full-analytics');
        analyticsScreen.classList.remove('d-none');

        const liveWheatRate = {{ \Illuminate\Support\Facades\DB::table('mandi_rates')->where('district', 'Satna')->where('crop_name', 'गेहूँ')->value('rate') ?? '2150' }};
        const ctxMandiLine = document.getElementById('homepageLineChart').getContext('2d');
        
        if (currentChart) {
            currentChart.destroy();
        }

        currentChart = new Chart(ctxMandiLine, {
            type: 'line',
            data: {
                labels: ['12 May', '13 May', '14 May', '15 May', '16 May', '17 May', '18 May'],
                datasets: [{
                    data: [1985, 2010, 2185, 2060, 2170, 2100, liveWheatRate],
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.04)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#198754',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    x: { display: true, grid: { display: false } }, 
                    y: { min: 1900, max: 2300, ticks: { stepSize: 100 } } 
                }
            }
        });
    }

    function closeMandiAnalytics() {
        document.getElementById('mandi-full-analytics').classList.add('d-none');
        document.getElementById('main-home-layout').classList.remove('d-none');
    }
</script>

</body>
</html>