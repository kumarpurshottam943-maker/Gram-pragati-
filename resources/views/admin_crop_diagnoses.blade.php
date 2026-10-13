<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>फसल डॉक्टर एआई (विशेषज्ञ समीक्षा) - एडमिन पैनल</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; overflow-x: hidden; }
        
        /* SIDEBAR STYLES (आपके डैशबोर्ड वाली सेम डार्क थीम) */
        .sidebar { background-color: #1e293b; min-height: 100vh; max-height: 100vh; overflow-y: auto; color: #94a3b8; width: 260px; position: fixed; top: 0; left: 0; z-index: 1000; }
        .sidebar-brand { padding: 22px 20px; font-size: 16px; font-weight: bold; color: #ffffff; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #334155; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; padding: 11px 20px; border-radius: 8px; margin: 4px 14px; display: flex; align-items: center; text-decoration: none; transition: all 0.2s; font-size: 14px; }
        .sidebar .nav-link i { width: 28px; font-size: 16px; color: #94a3b8; }
        .sidebar .nav-link:hover { background-color: #334155; color: #ffffff; }
        .sidebar .nav-link:hover i { color: #ffffff; }
        .sidebar .nav-link.active { background-color: #334155; color: #ffffff !important; border-left: 4px solid #38bdf8; border-radius: 0 8px 8px 0; margin-left: 0; }
        .sidebar .nav-link.active i { color: #38bdf8 !important; }
        .logout-btn { color: #f87171 !important; margin-top: 20px; margin-bottom: 20px; padding: 12px 20px; font-weight: bold; border: none; background: transparent; width: 100%; text-align: left; display: flex; align-items: center; }
        .logout-btn:hover { background-color: #7f1d1d; color: #ffffff !important; }
        .logout-btn i { color: #f87171; width: 28px; }

        /* MAIN AREA CONFIG */
        .main-content { margin-left: 260px; padding: 20px 30px; min-height: 100vh; }
        
        .table-card { background: white; border-radius: 12px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .custom-table th { background-color: #f8fafc; color: #64748b; font-size: 13px; font-weight: 600; padding: 12px; border-bottom: 2px solid #e2e8f0; }
        .custom-table td { font-size: 13.5px; color: #334155; padding: 15px 12px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    </style>
</head>
<body>

    <!-- सेम साइडबार जो आपके डैशबोर्ड में है -->
    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="sidebar-brand">
                <i class="fa-solid fa-gauge-high me-2 text-info"></i> Admin Panel Interface
            </div>
            <div class="nav flex-column">
                <a class="nav-link" href="/admin-dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a class="nav-link" href="/admin/users"><i class="fa-solid fa-users"></i> User Management</a>
                <a class="nav-link" href="/admin/schemes"><i class="fa-solid fa-layer-group"></i> Scheme Management</a>
                <a class="nav-link" href="/admin/krishi"><i class="fa-solid fa-seedling"></i> Smart Krishi Config</a>
                
                <!-- 🔥 यहाँ यह मेनू Active रहेगा क्योंकि हम इसी पेज पर हैं -->
                <a class="nav-link active" href="/admin/crop-diagnoses">
                    <i class="fa-solid fa-user-doctor"></i> फसल डॉक्टर एआई (Expert Review)
                </a>

                <a class="nav-link" href="/admin/complaints"><i class="fa-solid fa-comment-dots"></i> Complaint Management</a>
                <a class="nav-link" href="/admin/mandi"><i class="fa-solid fa-wheat-awn"></i> Mandi Management</a>
                <a class="nav-link" href="/admin/kheti-bazaar"><i class="fa-solid fa-truck-pickup"></i> kheti Bazaar</a>
                <a class="nav-link" href="/admin/notice"><i class="fa-solid fa-bullhorn"></i> News / Notice</a>
                <a class="nav-link" href="/admin/skill-up"><i class="fa-solid fa-graduation-cap"></i> कौशल विकास (Skill-Up)</a>
                <a class="nav-link" href="/admin/expert-meeting"><i class="fa-solid fa-handshake"></i> Expert & Meeting</a>
                <a class="nav-link" href="/admin/pashu-swasthya"><i class="fa-solid fa-cow"></i> Pashu Swasthya</a>
                <a class="nav-link" href="/admin/reports"><i class="fa-solid fa-chart-pie"></i> Reports & Analytics</a>
                <a class="nav-link" href="/admin/profile"><i class="fa-solid fa-user-gear"></i> एडमिन प्रोफाइल</a>
                <a class="nav-link" href="/admin/settings"><i class="fa-solid fa-gear"></i> Settings</a>
            </div>
        </div>
        
        <form action="/farmer-logout" method="POST" class="w-100 m-0">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>

    <!-- मुख्य कंटेंट एरिया -->
    <div class="main-content">
        
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h4 class="fw-bold m-0 text-dark" style="font-size: 22px;">
                <i class="fa-solid fa-microscope text-primary me-2"></i> किसानों की फसल समस्याएं (Expert Review Panel)
            </h4>
            <div class="text-muted" style="font-size: 13.5px;">
                विशेषज्ञ द्वारा किसानों की फोटो की जांच और समाधान
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-card">
            <div class="table-responsive">
                <table class="table custom-table w-100 m-0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 20%;">किसान का विवरण</th>
                            <th style="width: 15%;">फसल की फोटो</th>
                            <th style="width: 25%;">वर्तमान रिपोर्ट / स्थिति</th>
                            <th style="width: 35%;">विशेषज्ञ का जवाब भेजें</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allDiagnoses as $diagnosis)
                            <tr>
                                <td class="fw-bold text-secondary">#{{ $diagnosis->id }}</td>
                                <td>
                                    <strong class="text-dark">{{ $diagnosis->farmer_name }}</strong><br>
                                    <small class="text-muted"><i class="fa-solid fa-phone me-1"></i> {{ $diagnosis->farmer_phone }}</small><br>
                                    <small class="text-muted" style="font-size: 11px;">{{ date('d M Y, h:i A', strtotime($diagnosis->created_at)) }}</small>
                                </td>
                                <td>
                                    @if($diagnosis->image_path)
                                        <a href="{{ asset($diagnosis->image_path) }}" target="_blank" title="फोटो बड़ी करके देखें">
                                            <img src="{{ asset($diagnosis->image_path) }}" alt="Crop" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                                        </a>
                                    @else
                                        <span class="text-muted small">फोटो उपलब्ध नहीं</span>
                                    @endif
                                </td>
                                <td>
                                    @if($diagnosis->status == 'Resolved by Expert')
                                        <span class="badge bg-success mb-2" style="font-size: 11px; padding: 5px 8px;">विशेषज्ञ द्वारा सुलझाया गया</span>
                                    @else
                                        <span class="badge bg-warning text-dark mb-2" style="font-size: 11px; padding: 5px 8px;">समीक्षा हेतु पेंडिंग</span>
                                    @endif
                                    <p class="small text-secondary mb-0" style="font-size: 12px; line-height: 1.4;">{{ $diagnosis->ai_response }}</p>
                                </td>
                                <td>
                                    <!-- विशेषज्ञ द्वारा जवाब सबमिट करने का फॉर्म -->
                                    <form action="/admin/crop-diagnoses/{{ $diagnosis->id }}/reply" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <textarea name="expert_reply" class="form-control" rows="2" placeholder="किसान को क्या उपाय करना चाहिए? यहाँ लिखें..." style="font-size: 12.5px; resize: none;" required></textarea>
                                            <button class="btn btn-primary px-3 fw-bold" type="submit" style="font-size: 13px;">
                                                <i class="fa-solid fa-paper-plane d-block mb-1"></i> भेजें
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="fa-solid fa-seedling fs-1 mb-3 text-success opacity-50"></i><br>
                                    अभी तक किसी भी किसान ने फसल की फोटो अपलोड नहीं की है।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>