<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>यूज़र मैनेजमेंट - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; overflow-x: hidden; }
        
        /* साइडबार स्टाइल (मुख्य डैशबोर्ड से मैचिंग) */
        .sidebar { background-color: #1e293b; min-height: 100vh; color: #94a3b8; width: 260px; position: fixed; top: 0; left: 0; z-index: 1000; }
        .sidebar-brand { padding: 22px 20px; font-size: 16px; font-weight: bold; color: #ffffff; text-transform: uppercase; border-bottom: 1px solid #334155; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; padding: 11px 20px; border-radius: 8px; margin: 4px 14px; display: flex; align-items: center; text-decoration: none; font-size: 14px; }
        .sidebar .nav-link i { width: 28px; font-size: 16px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #334155; color: #ffffff !important; }
        .sidebar .nav-link.active { border-left: 4px solid #38bdf8; border-radius: 0 8px 8px 0; margin-left: 0; }
        .logout-btn { color: #f87171 !important; margin-top: auto; padding: 12px 20px; font-weight: bold; border: none; background: transparent; width: 100%; text-align: left; display: flex; align-items: center; }
        .logout-btn:hover { background-color: #7f1d1d; color: #ffffff !important; }

        /* मुख्य कंटेंट एरिया */
        .main-content { margin-left: 260px; padding: 0; min-height: 100vh; }
        .top-navbar { background-color: white; padding: 15px 30px; border-bottom: 1px solid #e2e8f0; }
        
        /* टेबल और कार्ड डिज़ाइन */
        .management-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; margin: 24px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1; }
        
        /* रोल के रंगीन बैज */
        .role-badge-farmer { background-color: #dcfce7; color: #16a34a; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .role-badge-student { background-color: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .role-badge-citizen { background-color: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="sidebar-brand">
                <i class="fa-solid fa-gauge-high me-2 text-info"></i> Admin Panel Interface
            </div>
            <div class="nav flex-column">
                <a class="nav-link" href="/admin-dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a class="nav-link active" href="/admin/users"><i class="fa-solid fa-users"></i> User Management</a>
                <a class="nav-link" href="/admin/schemes"><i class="fa-solid fa-layer-group"></i> Scheme Management</a>
                <a class="nav-link" href="/admin/complaints"><i class="fa-solid fa-comment-dots"></i> Complaint Management</a>
                <a class="nav-link" href="/admin/mandi"><i class="fa-solid fa-wheat-awn"></i> Mandi Management</a>
                <a class="nav-link" href="/admin/kheti-bazaar"><i class="fa-solid fa-truck-pickup"></i> kheti Bazaar</a>
                <a class="nav-link" href="/admin/news-notice"><i class="fa-solid fa-bullhorn"></i> News / Notice</a>
                <a class="nav-link" href="/admin/expert-meeting"><i class="fa-solid fa-handshake"></i> Expert & Meeting</a>
                <a class="nav-link" href="/admin/reports-analytics"><i class="fa-solid fa-chart-pie"></i> Reports & Analytics</a>
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

    <div class="main-content">
        
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0 text-dark" style="font-size: 20px;">उपयोगकर्ता प्रबंधन (User Management)</h4>
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-secondary" style="font-size: 13px;">प्रशासक: {{ Auth::user()->name }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mx-4 mt-3 alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="management-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0 text-dark" style="font-size: 16px;">सभी पंजीकृत ग्रामवासी, किसान एवं युवा साथी</h5>
                <span class="badge bg-primary px-3 py-2 rounded-pill">कुल: {{ count($allUsers) }}</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle m-0" style="border: 1px solid #e2e8f0;">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-3" style="font-size: 13px; color: #64748b;">प्रोफाइल</th>
                            <th class="py-3" style="font-size: 13px; color: #64748b;">पूरा नाम</th>
                            <th class="py-3" style="font-size: 13px; color: #64748b;">मोबाइल नंबर</th>
                            <th class="py-3" style="font-size: 13px; color: #64748b;">यूज़र रोल</th>
                            <th class="py-3" style="font-size: 13px; color: #64748b;">क्षेत्र / लोकेशन</th>
                            <th class="py-3 text-center" style="font-size: 13px; color: #64748b; width: 200px;">एक्शन (Actions)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allUsers as $user)
                            <tr>
                                <td class="px-3">
                                    @if($user->profile_image)
                                        <img src="{{ asset($user->profile_image) }}" class="user-avatar" alt="User">
                                    @else
                                        <img src="{{ asset('images/pur.jpg') }}" class="user-avatar" alt="Default">
                                    @endif
                                </td>
                                
                                <td class="fw-semibold text-dark">{{ $user->name }}</td>
                                
                                <td class="text-secondary fw-medium">{{ $user->phone }}</td>
                                
                                <td>
                                    @if($user->role === 'किसान' || $user->role === 'farmer')
                                        <span class="role-badge-farmer"><i class="fa-solid fa-wheat-awn me-1"></i> किसान</span>
                                    @elseif($user->role === 'युवा साथी' || $user->role === 'student')
                                        <span class="role-badge-student"><i class="fa-solid fa-graduation-cap me-1"></i> युवा साथी</span>
                                    @else
                                        <span class="role-badge-citizen"><i class="fa-solid fa-user me-1"></i> ग्रामवासी</span>
                                    @endif
                                </td>
                                
                                <td class="text-secondary">{{ $user->location ?? 'Not Provided' }}</td>
                                
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="/admin/users/{{ $user->id }}/approve" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success px-2 py-1" title="अकाउंट अप्रूव करें" style="font-size: 12px; font-weight: 600;">
                                                <i class="fa-solid fa-check me-1"></i> अप्रूव
                                            </button>
                                        </form>

                                        <form action="/admin/users/{{ $user->id }}/delete" method="POST" class="m-0" onsubmit="return confirm('क्या आप वाकई इस यूज़र को हटाना चाहते हैं?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger px-2 py-1" title="यूज़र डिलीट करें" style="font-size: 12px; font-weight: 600;">
                                                <i class="fa-solid fa-trash-can me-1"></i> हटाएँ
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted fw-medium">
                                    <i class="fa-solid fa-users-slash d-block fs-2 mb-2 text-secondary"></i>
                                    डेटाबेस में अभी कोई भी पंजीकृत उपयोगकर्ता नहीं है।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>