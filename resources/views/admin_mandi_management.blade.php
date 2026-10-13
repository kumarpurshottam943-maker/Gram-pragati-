<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>मंडी भाव प्रबंधन - ग्राम प्रगति</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; overflow-x: hidden; }
        .sidebar { background-color: #1e293b; min-height: 100vh; color: #94a3b8; width: 260px; position: fixed; top: 0; left: 0; z-index: 1000; }
        .sidebar-brand { padding: 22px 20px; font-size: 16px; font-weight: bold; color: #ffffff; text-transform: uppercase; border-bottom: 1px solid #334155; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; padding: 11px 20px; border-radius: 8px; margin: 4px 14px; display: flex; align-items: center; text-decoration: none; font-size: 14px; }
        .sidebar .nav-link i { width: 28px; font-size: 16px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #334155; color: #ffffff !important; }
        .sidebar .nav-link.active { border-left: 4px solid #38bdf8; border-radius: 0 8px 8px 0; margin-left: 0; }
        .logout-btn { color: #f87171 !important; margin-top: auto; padding: 12px 20px; font-weight: bold; border: none; background: transparent; width: 100%; text-align: left; display: flex; align-items: center; }
        .main-content { margin-left: 260px; padding: 0; min-height: 100vh; }
        .top-navbar { background-color: white; padding: 15px 30px; border-bottom: 1px solid #e2e8f0; }
        .management-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; margin: 24px; padding: 24px; }
    </style>
</head>
<body>

    <!-- 1. बायाँ साइडबार -->
    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="sidebar-brand"><i class="fa-solid fa-gauge-high me-2 text-info"></i> Admin Panel</div>
            <div class="nav flex-column">
                <a class="nav-link" href="/admin-dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a class="nav-link" href="/admin/users"><i class="fa-solid fa-users"></i> User Management</a>
                <a class="nav-link text-white active" href="/admin/mandi"><i class="fa-solid fa-wheat-awn text-success"></i> Mandi Management</a>
                <a class="nav-link" href="#"><i class="fa-solid fa-layer-group"></i> Scheme Management</a>
                <a class="nav-link" href="#"><i class="fa-solid fa-comment-dots"></i> Complaint Management</a>
                <a class="nav-link" href="#"><i class="fa-solid fa-gear"></i> Settings</a>
            </div>
        </div>
        <form action="/farmer-logout" method="POST" class="w-100 m-0">
            @csrf
            <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </form>
    </div>

    <!-- 2. मुख्य कंटेंट एरिया -->
    <div class="main-content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0" style="font-size: 20px;">मंडी भाव प्रबंधन (Mandi Management)</h4>
            <span class="fw-bold text-secondary" style="font-size: 13px;">प्रशासक: {{ Auth::user()->name }}</span>
        </div>

        <!-- मैसेज अलर्ट -->
        @if(session('success'))
            <div class="alert alert-success mx-4 mt-3 alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- 3. 🔥 चारों फसलों का नया सुबह का मंडी भाव अपडेट फॉर्म -->
        <div class="management-card" style="margin-bottom: 0px;">
            <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-pen-to-square text-success me-1"></i> रोज़ सुबह का भाव बदलें (सभी 4 फसलें)</h5>
            <form action="/admin/update-mandi" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- गेहूँ -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 12px;">गेहूँ का नया भाव (₹/क्विंटल)</label>
                        <input type="number" name="wheat_rate" class="form-control" placeholder="उदा. 2150" required style="font-size: 13.5px;">
                    </div>
                    <!-- धान -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 12px;">धान का नया भाव (₹/क्विंटल)</label>
                        <input type="number" name="paddy_rate" class="form-control" placeholder="उदा. 1880" required style="font-size: 13.5px;">
                    </div>
                    <!-- मक्का -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 12px;">मक्का का नया भाव (₹/क्विंटल)</label>
                        <input type="number" name="maize_rate" class="form-control" placeholder="उदा. 1730" required style="font-size: 13.5px;">
                    </div>
                    <!-- चना -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-secondary" style="font-size: 12px;">चना का नया भाव (₹/क्विंटल)</label>
                        <input type="number" name="gram_rate" class="form-control" placeholder="उदा. 6120" required style="font-size: 13.5px;">
                    </div>
                    
                    <!-- सबमिट बटन नीचे फुल विड्थ में -->
                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="font-size: 14px; border-radius: 8px;"><i class="fa-solid fa-sync me-1"></i> चारों फसलों का भाव एक साथ अपडेट करें</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- 4. 🔥 आपकी डिमांड पर अपडेटेड साफ़-सुथरी तालिका (Table) -->
        <div class="management-card">
            <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-table-list text-primary me-1"></i> फसलों की सूची व चालू भाव</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle border m-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-2.5 px-3" style="font-size: 13px; color: #64748b;">फसल का नाम</th>
                            <th class="py-2.5" style="font-size: 13px; color: #64748b;">चालू भाव (₹/क्विंटल)</th>
                            <th class="py-2.5 text-center" style="font-size: 13px; color: #64748b;">स्थिति</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allMandiRates as $rate)
                            <tr>
                                <td class="px-3 fw-bold text-success" style="font-size: 14px;">
                                    @if($rate->crop_name == 'गेहूँ') 🌾 @elseif($rate->crop_name == 'धान') 🌾 @elseif($rate->crop_name == 'मक्का') 🌽 @else 🫘 @endif 
                                    {{ $rate->crop_name }}
                                </td>
                                <td class="fw-bold text-dark" style="font-size: 14px;">₹ {{ $rate->rate }} / क्विंटल</td>
                                <td class="text-center"><span class="badge bg-success-subtle text-success border px-2 py-1" style="font-size: 11px;">🟢 Active</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4 text-muted">डेटाबेस में कोई फसल रिकॉर्ड नहीं मिला।</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>