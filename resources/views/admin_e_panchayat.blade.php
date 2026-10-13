<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ई-पंचायत नियंत्रण - एडमिन पैनल</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; overflow-x: hidden; }
        
        /* एडमिन साइडबार थीम */
        .sidebar { background-color: #1e293b; min-height: 100vh; max-height: 100vh; overflow-y: auto; color: #94a3b8; width: 260px; position: fixed; top: 0; left: 0; z-index: 1000; }
        .sidebar-brand { padding: 22px 20px; font-size: 16px; font-weight: bold; color: #ffffff; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #334155; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; padding: 11px 20px; border-radius: 8px; margin: 4px 14px; display: flex; align-items: center; text-decoration: none; transition: all 0.2s; font-size: 14px; }
        .sidebar .nav-link i { width: 28px; font-size: 16px; color: #94a3b8; }
        .sidebar .nav-link:hover { background-color: #334155; color: #ffffff; }
        .sidebar .nav-link.active { background-color: #334155; color: #ffffff !important; border-left: 4px solid #38bdf8; border-radius: 0 8px 8px 0; margin-left: 0; }
        .sidebar .nav-link.active i { color: #38bdf8 !important; }
        .logout-btn { color: #f87171 !important; margin-top: 20px; margin-bottom: 20px; padding: 12px 20px; font-weight: bold; border: none; background: transparent; width: 100%; text-align: left; display: flex; align-items: center; }
        .logout-btn:hover { background-color: #7f1d1d; color: #ffffff !important; }
        .logout-btn i { color: #f87171; width: 28px; }

        /* मुख्य कंटेंट एरिया */
        .main-content { margin-left: 260px; min-height: 100vh; padding-bottom: 40px; }
        .top-navbar { background-color: white; padding: 15px 30px; border-bottom: 1px solid #e2e8f0; }
        .admin-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 22px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .form-label { font-size: 12.5px; font-weight: 600; color: #475569; }
    </style>
</head>
<body>

    <!-- साइडबार पैनल -->
    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="sidebar-brand"><i class="fa-solid fa-gauge-high me-2 text-info"></i> Admin Panel</div>
            <div class="nav flex-column">
                <a class="nav-link" href="/admin-dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a class="nav-link" href="/admin/users"><i class="fa-solid fa-users"></i> User Management</a>
                <a class="nav-link active" href="/admin/schemes"><i class="fa-solid fa-layer-group"></i> Scheme Management</a>
                <a class="nav-link" href="/admin/krishi"><i class="fa-solid fa-seedling"></i> Smart Krishi Config</a>
                <a class="nav-link" href="/admin/crop-diagnoses"><i class="fa-solid fa-user-doctor"></i> फसल डॉक्टर एआई</a>
                <a class="nav-link" href="/admin/complaints"><i class="fa-solid fa-comment-dots"></i> Complaint Management</a>
                <a class="nav-link" href="/admin/mandi"><i class="fa-solid fa-wheat-awn"></i> Mandi Management</a>
                <a class="nav-link" href="/admin/kheti-bazaar"><i class="fa-solid fa-truck-pickup"></i> Kheti Bazaar</a>
                <a class="nav-link" href="/admin/notice"><i class="fa-solid fa-bullhorn"></i> News / Notice</a>
                <a class="nav-link" href="/admin/skill-up"><i class="fa-solid fa-graduation-cap"></i> कौशल विकास</a>
                <a class="nav-link" href="/admin/expert-meeting"><i class="fa-solid fa-handshake"></i> Expert & Meeting</a>
                <a class="nav-link" href="/admin/reports"><i class="fa-solid fa-chart-pie"></i> Reports</a>
                <a class="nav-link" href="/admin/profile"><i class="fa-solid fa-user-gear"></i> एडमिन प्रोफाइल</a>
            </div>
        </div>
        
        <form action="/farmer-logout" method="POST" class="w-100 m-0">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>

    <!-- मुख्य एरिया -->
    <div class="main-content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0 text-success" style="font-size: 20px;"><i class="fa-solid fa-landmark me-2"></i> ई-पंचायत प्रबंधन केंद्र (E-Panchayat Management)</h4>
            <span class="fw-bold text-secondary bg-light px-3 py-1 rounded border" style="font-size: 13px;"><i class="fa-solid fa-user-shield me-1 text-primary"></i> प्रशासक: {{ Auth::user()->name }}</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success mx-4 mt-3 alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="p-4">
            <div class="row g-4">
                
                <!-- फॉर्म 1: नई योजना (आइकॉन सिलेक्शन ड्रॉपडाउन के साथ) -->
                <div class="col-xl-6 col-lg-6">
                    <div class="admin-card h-100">
                        <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom" style="font-size: 15px;"><i class="fa-solid fa-plus-circle text-success me-1"></i> नई सरकारी योजना लाइव करें</h5>
                        <form action="/admin/schemes/store" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-5">
                                <label class="form-label">योजना का नाम</label>
                                <input type="text" name="title" class="form-control form-control-sm" placeholder="उदा: प्रधानमंत्री आवास योजना" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">श्रेणी</label>
                                <select name="category" class="form-select form-select-sm" required>
                                    <option value="केन्द्र सरकार">केन्द्र सरकार</option>
                                    <option value="राज्य सरकार">राज्य सरकार</option>
                                    <option value="अन्य योजनाएँ">अन्य योजनाएँ</option>
                                </select>
                            </div>
                            <!-- आइकॉन सिलेक्ट करने का विकल्प -->
                            <div class="col-md-4">
                                <label class="form-label">योजना का आइकॉन</label>
                                <select name="scheme_icon" class="form-select form-select-sm" required>
                                    <option value="fa-seedling">🌱 पौधा (किसान योजना)</option>
                                    <option value="fa-shield-halved">🛡️ शील्ड (बीमा योजना)</option>
                                    <option value="fa-house-chimney">🏠 घर (आवास योजना)</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">योजना की पात्रता (Eligibility)</label>
                                <input type="text" name="eligibility" class="form-control form-control-sm" placeholder="उदा: ग्रामीण क्षेत्र के बीपीएल कार्ड धारक परिवार" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">योजना का विस्तृत विवरण</label>
                                <textarea name="description" class="form-control form-control-sm" rows="3" placeholder="यहाँ योजना के मुख्य लाभ विस्तार से लिखें..." required style="resize: none;"></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-sm btn-success px-4 fw-bold py-2"><i class="fa-solid fa-save me-1"></i> योजना लाइव करें</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- फॉर्म 2: प्रमाणपत्र स्टेटस अपडेटर -->
                <div class="col-xl-6 col-lg-6">
                    <div class="admin-card h-100">
                        <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom" style="font-size: 15px;"><i class="fa-solid fa-edit text-primary me-1"></i> प्रमाणपत्र स्टेटस जारी/अपडेट करें</h5>
                        <form action="/admin/certificate/update" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">आवेदन संख्या</label>
                                <input type="text" name="application_no" class="form-control form-control-sm" placeholder="जैसे: ABC123456" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">आवेदक का नाम</label>
                                <input type="text" name="user_name" class="form-control form-control-sm" placeholder="जैसे: राहुल कुमार" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">सेवा/प्रमाणपत्र का नाम</label>
                                <input type="text" name="service_name" class="form-control form-control-sm" placeholder="जैसे: जन्म प्रमाणपत्र" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">वर्तमान स्थिति</label>
                                <select name="status" class="form-select form-select-sm" required>
                                    <option value="प्रक्रिया में है">प्रक्रिया में है</option>
                                    <option value="स्वीकृत">स्वीकृत</option>
                                    <option value="निरस्त">निरस्त</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">अगला कदम / टिप्पणी</label>
                                <input type="text" name="next_step" class="form-control form-control-sm" placeholder="जांच अधिकारी द्वारा सत्यापन सफल..." required>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-sm btn-primary px-4 fw-bold py-2"><i class="fa-solid fa-refresh me-1"></i> स्टेटस अपडेट करें</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- अनुभाग 3: वर्तमान लाइव योजनाओं की सूची (Admin Table View) -->
                <div class="col-12">
                    <div class="admin-card mt-2">
                        <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-list text-success me-1"></i> वर्तमान में लाइव सरकारी योजनाएँ (Live Schemes Overview)</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0" style="font-size: 13px;">
                                <thead class="table-success">
                                    <tr>
                                        <th style="width: 5%;">ID</th>
                                        <th style="width: 25%;">योजना का नाम</th>
                                        <th style="width: 15%;">श्रेणी (Category)</th>
                                        <th style="width: 55%;">पात्रता एवं विवरण</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allSchemes as $scheme)
                                        <tr>
                                            <td class="fw-bold">#{{ $scheme->id }}</td>
                                            <td>
                                                <i class="fa-solid {{ $scheme->scheme_icon }} text-success me-1"></i>
                                                <strong>{{ $scheme->title }}</strong>
                                            </td>
                                            <td><span class="badge bg-secondary">{{ $scheme->category }}</span></td>
                                            <td>
                                                <small class="d-block text-dark"><strong>पात्रता:</strong> {{ $scheme->eligibility }}</small>
                                                <small class="text-muted">{{ Str::limit($scheme->description, 80) }}</small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">अभी तक कोई योजना लाइव नहीं की गई है। ऊपर दिए गए फॉर्म से नई योजना जोड़ें!</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>