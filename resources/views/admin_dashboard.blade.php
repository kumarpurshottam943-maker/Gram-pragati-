<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>एडमिन पैनल - ग्राम प्रगति (Gram Pragati)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; overflow-x: hidden; }
        
        /* SIDEBAR STYLES (साइडबार को स्क्रॉल करने के लिए max-height और overflow-y) */
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
        .main-content { margin-left: 260px; padding: 0; min-height: 100vh; }
        
        /* TOP NAVBAR */
        .top-navbar { background-color: white; padding: 12px 30px; border-bottom: 1px solid #e2e8f0; }
        .admin-profile-img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 1px solid #cbd5e1; }

        /* DYNAMIC KPI MINI CARDS LAYOUT */
        .kpi-container { display: grid; grid-template-columns: repeat(6, 1fr); gap: 12px; padding: 20px 24px 10px 24px; }
        .kpi-card { background: white; border-radius: 12px; padding: 14px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .kpi-title { font-size: 12px; font-weight: 600; margin-bottom: 6px; }
        .kpi-value { font-size: 20px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .kpi-badge { font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 4px; }

        /* CHARTS SECTION */
        .charts-row { display: grid; grid-template-columns: 1.2fr 1.3fr 2.5fr; gap: 15px; padding: 10px 24px; }
        .chart-card { background: white; border-radius: 12px; padding: 16px; border: 1px solid #e2e8f0; min-height: 250px; }
        .chart-card-title { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 15px; }

        /* DATA TABLE STYLE */
        .table-card { background: white; border-radius: 12px; padding: 18px; border: 1px solid #e2e8f0; margin: 10px 24px; }
        .custom-table th { background-color: #f8fafc; color: #64748b; font-size: 12px; font-weight: 600; padding: 10px; border-bottom: 1px solid #e2e8f0; }
        .custom-table td { font-size: 13px; color: #334155; padding: 12px 10px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        
        /* STATUS BADGES */
        .badge-pending { background-color: #ffedd5; color: #ea580c; border-radius: 6px; padding: 4px 8px; font-size: 11px; font-weight: 600; }
        .badge-progress { background-color: #e0f2fe; color: #0284c7; border-radius: 6px; padding: 4px 8px; font-size: 11px; font-weight: 600; }
        .badge-resolved { background-color: #dcfce7; color: #16a34a; border-radius: 6px; padding: 4px 8px; font-size: 11px; font-weight: 600; }

        /* BOTTOM ACTION BAR */
        .bottom-action-bar { display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; padding: 15px 24px 25px 24px; }
        .action-bar-btn { background: white; border: 1px solid #e2e8f0; border-radius: 10px; padding: 12px; font-size: 13px; font-weight: 600; color: #334155; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.02); }
        .action-bar-btn:hover { background-color: #f8fafc; transform: translateY(-1px); box-shadow: 0 4px 6px rgba(0,0,0,0.05); color: #1e293b; }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="sidebar-brand">
                <i class="fa-solid fa-gauge-high me-2 text-info"></i> Admin Panel Interface
            </div>
            <div class="nav flex-column">
                <a class="nav-link active" href="/admin-dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a class="nav-link" href="/admin/users"><i class="fa-solid fa-users"></i> User Management</a>
                <a class="nav-link" href="/admin/schemes"><i class="fa-solid fa-layer-group"></i> Scheme Management</a>
                <a class="nav-link" href="/admin/krishi"><i class="fa-solid fa-seedling"></i> Smart Krishi Config</a>
                
                <!-- 🔥 फसल डॉक्टर एआई (Expert Review) -->
                <a class="nav-link {{ Request::is('admin/crop-diagnoses*') ? 'active' : '' }}" href="/admin/crop-diagnoses">
                    <i class="fa-solid fa-user-doctor"></i> फसल डॉक्टर एआई (Expert Review)
                </a>

                <a class="nav-link" href="/admin/complaints"><i class="fa-solid fa-comment-dots"></i> Complaint Management</a>
                <a class="nav-link" href="/admin/mandi"><i class="fa-solid fa-wheat-awn"></i> Mandi Management</a>
                <a class="nav-link" href="/admin/kheti-bazaar"><i class="fa-solid fa-truck-pickup"></i> Kheti Bazaar</a>
                <a class="nav-link" href="/admin/notice"><i class="fa-solid fa-bullhorn"></i> News / Notice</a>
                <a class="nav-link" href="/admin/skill-up"><i class="fa-solid fa-graduation-cap"></i> कौशल विकास (Skill-Up)</a>
                <a class="nav-link" href="/admin/expert-meeting"><i class="fa-solid fa-handshake"></i> Expert & Meeting</a>
                <a class="nav-link" href="/admin/pashu-swasthya"><i class="fa-solid fa-cow"></i> Pashu Swasthya</a>
                <a class="nav-link" href="/admin/reports"><i class="fa-solid fa-chart-pie"></i> Reports & Analytics</a>
                
                <!-- एडमिन प्रोफाइल का लिंक -->
                <a class="nav-link {{ Request::is('admin/profile*') ? 'active' : '' }}" href="/admin/profile"><i class="fa-solid fa-user-gear"></i> एडमिन प्रोफाइल</a>

                <a class="nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}" href="/admin/settings"><i class="fa-solid fa-gear"></i> Settings</a>
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
            <h4 class="fw-bold m-0 text-dark" style="font-size: 20px;">Dashboard</h4>
            
            <div class="d-flex align-items-center gap-3">
                <div class="bg-light px-3 py-1.5 rounded-3 border fw-semibold text-secondary" style="font-size: 13px;">
                    <i class="fa-regular fa-clock me-1 text-primary"></i> {{ date('d M Y, h:i A') }}
                </div>
                
                <div class="d-flex align-items-center gap-2">
                    <div class="text-end">
                        <span class="d-block fw-bold text-dark" style="font-size: 13.5px;">{{ Auth::user()->name }}</span>
                        <small class="text-muted d-block" style="font-size: 11px; margin-top: -3px;">Super Administrator</small>
                    </div>
                    @if(Auth::user()->profile_image)
                        <img src="{{ asset(Auth::user()->profile_image) }}" class="admin-profile-img" alt="Admin">
                    @else
                        <img src="{{ asset('images/pur.jpg') }}" class="admin-profile-img" alt="Admin">
                    @endif
                    <i class="fa-solid fa-chevron-down text-secondary" style="font-size: 11px;"></i>
                </div>
            </div>
        </div>

        <div class="kpi-container">
            <div class="kpi-card" style="border-top: 3px solid #16a34a;">
                <div class="kpi-title" style="color: #16a34a;">कुल पंजीकृत उपयोगकर्ता</div>
                <div class="kpi-value">{{ \Illuminate\Support\Facades\DB::table('users')->where('role', '!=', 'admin')->count() }}</div>
                <div class="kpi-badge text-success"><i class="fa-solid fa-arrow-up"></i> सक्रिय यूज़र्स</div>
            </div>
            <div class="kpi-card" style="border-top: 3px solid #2563eb;">
                <div class="kpi-title" style="color: #2563eb;">कुल शिकायतें</div>
                <div class="kpi-value">{{ \Illuminate\Support\Facades\DB::table('complaints')->count() }}</div>
                <div class="kpi-badge text-primary"><i class="fa-solid fa-comments"></i> सिटीजन वॉइस</div>
            </div>
            <div class="kpi-card" style="border-top: 3px solid #ea580c;">
                <div class="kpi-title" style="color: #ea580c;">लंबित शिकायतें</div>
                <div class="kpi-value">{{ \Illuminate\Support\Facades\DB::table('complaints')->where('status', 'Pending')->count() }}</div>
                <div class="kpi-badge text-danger"><i class="fa-solid fa-clock"></i> प्रक्रियाधीन</div>
            </div>
            
            <!-- 🔥 1. कुल योजनाएँ (अब डेटाबेस से लाइव) -->
            <div class="kpi-card" style="border-top: 3px solid #8b5cf6;">
                <div class="kpi-title" style="color: #8b5cf6;">कुल योजनाएँ</div>
                <div class="kpi-value">
                    @php
                        $schemesCount = \Illuminate\Support\Facades\Schema::hasTable('schemes') ? \Illuminate\Support\Facades\DB::table('schemes')->count() : 0;
                    @endphp
                    {{ $schemesCount }}
                </div>
                <div class="kpi-badge text-purple" style="color:#8b5cf6;"><i class="fa-solid fa-layer-group"></i> सरकारी योजनाएँ</div>
            </div>

            <!-- 🔥 2. कुल टूल लिस्टिंग (अब डेटाबेस से लाइव) -->
            <div class="kpi-card" style="border-top: 3px solid #0d9488;">
                <div class="kpi-title" style="color: #0d9488;">कुल टूल लिस्टिंग</div>
                <div class="kpi-value">
                    @php
                        $toolsCount = \Illuminate\Support\Facades\Schema::hasTable('rental_tools') ? \Illuminate\Support\Facades\DB::table('rental_tools')->count() : 0;
                    @endphp
                    {{ $toolsCount }}
                </div>
                <div class="kpi-badge text-teal" style="color:#0d9488;"><i class="fa-solid fa-tractor"></i> कृषि बाज़ार</div>
            </div>

            <!-- 🔥 3. कुल बिक्री (अब डेटाबेस से लाइव) -->
            <div class="kpi-card" style="border-top: 3px solid #db2777;">
                <div class="kpi-title" style="color: #db2777;">कुल बिक्री (इस माह)</div>
                <div class="kpi-value">
                    @php
                        $totalSales = \Illuminate\Support\Facades\Schema::hasTable('rental_tools') ? \Illuminate\Support\Facades\DB::table('rental_tools')->sum('price') : 0;
                    @endphp
                    ₹ {{ number_format($totalSales) }}
                </div>
                <div class="kpi-badge text-pink" style="color:#db2777;"><i class="fa-solid fa-indian-rupee-sign"></i> कुल मूल्य</div>
            </div>
        </div>

        <!-- 🔥 विशेष ग्रामीण सेवाएँ नियंत्रण कक्ष (Special Rural Services Admin Control Grid) -->
        <div class="px-4 py-2">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold m-0 text-dark" style="font-size: 16px;"><i class="fa-solid fa-sliders text-success me-2"></i> विशेष ग्रामीण सेवाएँ नियंत्रण कक्ष (Special Rural Services Management)</h5>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill" style="font-size: 11px;">लाइव एडमिन कंट्रोल</span>
                </div>
                <p class="text-muted mb-3" style="font-size: 12.5px;">यहाँ से एडमिन सीधे होमपेज पर प्रदर्शित होने वाली सभी 6 विशेष ग्रामीण सेवाओं के अलर्ट, डेटा और स्टेटस को कंट्रोल कर सकते हैं:</p>
                
                <div class="row g-3">
                    <!-- 1. मौसम चेतावनी कंट्रोल (अब एडमिन रूट पर जाएगा) -->
                    <div class="col-md-4 col-lg-2">
                        <div class="p-3 border rounded-3 bg-light text-center h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="fs-4 text-success mb-1">🌤️</div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">मौसम चेतावनी</h6>
                                <p class="text-muted mb-2" style="font-size: 10.5px;">Live Weather Alert</p>
                            </div>
                            <a href="/admin/weather-advisory" class="btn btn-sm btn-outline-success fw-bold py-1" style="font-size: 11px;">मैनेज करें ➔</a>
                        </div>
                    </div>
                    <!-- 2. परिवहन सेवा कंट्रोल (फिक्स किया गया एडमिन लिंक) -->
                    <div class="col-md-4 col-lg-2">
                        <div class="p-3 border rounded-3 bg-light text-center h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="fs-4 text-warning mb-1">🚜</div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">परिवहन सेवा</h6>
                                <p class="text-muted mb-2" style="font-size: 10.5px;">Transport & Tractor</p>
                            </div>
                            <a href="/admin/transport-manage" class="btn btn-sm btn-outline-warning fw-bold text-dark py-1" style="font-size: 11px;">मैनेज करें ➔</a>
                        </div>
                    </div>
                    

                    <!-- 3. खाद कैलकुलेटर कंट्रोल -->
                    <div class="col-md-4 col-lg-2">
                        <div class="p-3 border rounded-3 bg-light text-center h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="fs-4 text-info mb-1">🧪</div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">खाद कैलकुलेटर</h6>
                                <p class="text-muted mb-2" style="font-size: 10.5px;">Soil & Fertilizer</p>
                            </div>
                            <a href="/admin/fertilizer-config" target="_blank" class="btn btn-sm btn-outline-info fw-bold py-1" style="font-size: 11px;">मैनेज करें ➔</a>
                        </div>
                    </div>

                    <!-- 4. आपातकालीन हेल्प कंट्रोल -->
                    <div class="col-md-4 col-lg-2">
                        <div class="p-3 border rounded-3 bg-light text-center h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="fs-4 text-danger mb-1">📞</div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">आपातकालीन हेल्प</h6>
                                <p class="text-muted mb-2" style="font-size: 10.5px;">Emergency Helpdesk</p>
                            </div>
                            <a href="/admin/emergency-help" target="_blank" class="btn btn-sm btn-outline-danger fw-bold py-1" style="font-size: 11px;">मैनेज करें ➔</a>
                        </div>
                    </div>

                    <!-- 5. फसल व पर्व कैलेंडर कंट्रोल -->
                    <div class="col-md-4 col-lg-2">
                        <div class="p-3 border rounded-3 bg-light text-center h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="fs-4 text-warning mb-1">📅</div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">फसल व पर्व कैलेंडर</h6>
                                <p class="text-muted mb-2" style="font-size: 10.5px;">Crop & Calendar</p>
                            </div>
                            <a href="/admin/crop-calendar" target="_blank" class="btn btn-sm btn-outline-warning fw-bold text-dark py-1" style="font-size: 11px;">मैनेज करें ➔</a>
                        </div>
                    </div>

                    <!-- 6. हरित ग्राम जागरूकता कंट्रोल -->
                    <div class="col-md-4 col-lg-2">
                        <div class="p-3 border rounded-3 bg-light text-center h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="fs-4 text-success mb-1">🌱</div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 13px;">हरित ग्राम जागरूकता</h6>
                                <p class="text-muted mb-2" style="font-size: 10.5px;">Green Village</p>
                            </div>
                            <a href="/admin/green-village" target="_blank" class="btn btn-sm btn-outline-success fw-bold py-1" style="font-size: 11px;">मैनेज करें ➔</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="charts-row">
            <div class="chart-card">
                <div class="chart-card-title">शिकायत स्थिति</div>
                <div style="width: 100%; height: 170px; display: flex; justify-content: center; align-items: center;">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-card-title">शिकायत श्रेणी</div>
                <div style="width: 100%; height: 170px;">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-card-title">7 दिन का मंडी औसत भाव (गेहूँ)</div>
                <div style="width: 100%; height: 170px;">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="fw-bold mb-3 text-dark" style="font-size: 14px;">हाल की शिकायतें</div>
            <div class="table-responsive">
                <table class="table custom-table w-100 m-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>समस्या</th>
                            <th>स्थान</th>
                            <th>स्थिति</th>
                            <th>दिनांक</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recentComplaints = \Illuminate\Support\Facades\Schema::hasTable('complaints') ? \Illuminate\Support\Facades\DB::table('complaints')->orderBy('id', 'desc')->take(4)->get() : [];
                        @endphp
                        
                        @forelse($recentComplaints as $complaint)
                            <tr>
                                <td class="fw-semibold text-secondary">{{ $complaint->complaint_id }}</td>
                                <td><strong class="text-dark">{{ $complaint->title }}</strong></td>
                                <td class="text-muted"><i class="fa-solid fa-location-dot text-danger" style="font-size:11px;"></i> {{ $complaint->ward }}</td>
                                <td>
                                    @if($complaint->status == 'Pending')
                                        <span class="badge-pending">Pending</span>
                                    @elseif($complaint->status == 'In Progress')
                                        <span class="badge-progress">In Progress</span>
                                    @else
                                        <span class="badge-resolved">Resolved</span>
                                    @endif
                                </td>
                                <td class="text-secondary">{{ date('d M Y', strtotime($complaint->created_at)) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">कोई हालिया शिकायत नहीं मिली है।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bottom-action-bar">
            <a href="/admin/notice" class="action-bar-btn"><i class="fa-solid fa-bullhorn text-danger"></i> नया नोटिस जारी करें</a>
            <a href="/admin/schemes" class="action-bar-btn"><i class="fa-solid fa-gift text-success"></i> योजना जोड़ें</a>
            <a href="/admin/expert-meeting" class="action-bar-btn"><i class="fa-solid fa-calendar-days text-primary"></i> नई मीटिंग शेड्यूल करें</a>
            <a href="/admin/reports" class="action-bar-btn"><i class="fa-solid fa-file-lines text-success"></i> रिपोर्ट देखें</a>
            <a href="/admin/settings" class="action-bar-btn"><i class="fa-solid fa-gear text-secondary"></i> Settings</a>
        </div>

    </div>

    <script>
        // 1. डोनट चार्ट लॉजिक
        const ctxDonut = document.getElementById('donutChart').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'In Progress', 'Resolved'],
                datasets: [{
                    data: [
                        {{ \Illuminate\Support\Facades\Schema::hasTable('complaints') ? \Illuminate\Support\Facades\DB::table('complaints')->where('status', 'Pending')->count() : 0 }},
                        {{ \Illuminate\Support\Facades\Schema::hasTable('complaints') ? \Illuminate\Support\Facades\DB::table('complaints')->where('status', 'In Progress')->count() : 0 }},
                        {{ \Illuminate\Support\Facades\Schema::hasTable('complaints') ? \Illuminate\Support\Facades\DB::table('complaints')->where('status', 'Resolved')->count() : 0 }}
                    ],
                    backgroundColor: ['#f97316', '#38bdf8', '#22c55e'],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'right', labels: { boxWidth: 12, font: { size: 10 } } } },
                cutout: '65%'
            }
        });

        // 2. हॉरिजॉन्टल बार चार्ट
        const ctxBar = document.getElementById('barChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['सड़क', 'पानी', 'बिजली', 'सफाई', 'अन्य'],
                datasets: [{
                    data: [
                        {{ \Illuminate\Support\Facades\Schema::hasTable('complaints') ? \Illuminate\Support\Facades\DB::table('complaints')->where('category', 'सड़क')->count() : 0 }},
                        {{ \Illuminate\Support\Facades\Schema::hasTable('complaints') ? \Illuminate\Support\Facades\DB::table('complaints')->where('category', 'पानी')->count() : 0 }},
                        {{ \Illuminate\Support\Facades\Schema::hasTable('complaints') ? \Illuminate\Support\Facades\DB::table('complaints')->where('category', 'बिजली')->count() : 0 }},
                        {{ \Illuminate\Support\Facades\Schema::hasTable('complaints') ? \Illuminate\Support\Facades\DB::table('complaints')->where('category', 'सफाई')->count() : 0 }},
                        {{ \Illuminate\Support\Facades\Schema::hasTable('complaints') ? \Illuminate\Support\Facades\DB::table('complaints')->where('category', 'अन्य')->count() : 0 }}
                    ],
                    backgroundColor: ['#ef4444', '#f97316', '#eab308', '#2563eb', '#22c55e'],
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { grid: { display: false } }, y: { grid: { display: false } } }
            }
        });

        // 3. LINE CHART LOGIC
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['10 मई', '11 मई', '12 मई', '13 मई', '14 मई', '15 मई', '16 मई'],
                datasets: [{
                    label: 'भाव (₹)',
                    data: [1800, 1950, 2050, 1920, 2150, 2000, 2150],
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 4,
                    pointBackgroundColor: '#22c55e'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    x: { grid: { display: false } }, 
                    y: { min: 1000, max: 2400, ticks: { stepSize: 200 } } 
                }
            }
        });
    </script>

</body>
</html>