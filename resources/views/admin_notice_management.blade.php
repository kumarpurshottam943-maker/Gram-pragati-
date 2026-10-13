<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>नोटिस प्रबंधन - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .sidebar { background-color: #1e293b; min-height: 100vh; color: #94a3b8; width: 260px; position: fixed; top: 0; left: 0; }
        .sidebar-brand { padding: 22px 20px; font-size: 16px; font-weight: bold; color: #ffffff; text-transform: uppercase; border-bottom: 1px solid #334155; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; padding: 11px 20px; border-radius: 8px; margin: 4px 14px; display: flex; align-items: center; text-decoration: none; font-size: 14px; }
        .sidebar .nav-link i { width: 28px; font-size: 16px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #334155; color: #ffffff !important; }
        .sidebar .nav-link.active { border-left: 4px solid #38bdf8; border-radius: 0 8px 8px 0; margin-left: 0; }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .top-navbar { background-color: white; padding: 15px 30px; border-bottom: 1px solid #e2e8f0; }
        .management-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; margin: 24px; padding: 24px; }
    </style>
</head>
<body>

    <!-- साइडबार -->
    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="sidebar-brand"><i class="fa-solid fa-gauge-high me-2 text-info"></i> Admin Panel</div>
            <div class="nav flex-column">
                <a class="nav-link" href="/admin-dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a class="nav-link" href="/admin/users"><i class="fa-solid fa-users"></i> User Management</a>
                <a class="nav-link" href="/admin/mandi"><i class="fa-solid fa-wheat-awn"></i> Mandi Management</a>
                <a class="nav-link text-white active" href="/admin/notice"><i class="fa-solid fa-bullhorn text-danger"></i> News / Notice</a>
                <a class="nav-link" href="#"><i class="fa-solid fa-gear"></i> Settings</a>
            </div>
        </div>
    </div>

    <!-- मुख्य एरिया -->
    <div class="main-content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0" style="font-size: 20px;">सूचना एवं नोटिस प्रबंधन (Notice Management)</h4>
            <span class="fw-bold text-secondary" style="font-size: 13px;">प्रशासक: {{ Auth::user()->name }}</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success mx-4 mt-3">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- नया नोटिस फॉर्म -->
        <div class="management-card">
            <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-bullhorn text-danger me-1"></i> गाँव के लिए नया नोटिस जारी करें</h5>
            <form action="/admin/add-notice" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 12px;">नोटिस का मुख्य शीर्षक (Title)</label>
                    <input type="text" name="title" class="form-control" placeholder="उदा: प्रधानमंत्री किसान सम्मान निधि की अगली किश्त 15 जून को जारी होगी।" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 12px;">विवरण / पूरी जानकारी (Description)</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="यहाँ सूचना की पूरी जानकारी विस्तार से लिखें..." required></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-danger px-4 fw-bold" style="font-size: 13.5px;"><i class="fa-solid fa-paper-plane me-1"></i> नोटिस लाइव जारी करें</button>
                </div>
            </form>
        </div>

        <!-- जारी किए गए पुराने नोटिसों की लिस्ट -->
        <div class="management-card">
            <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-history text-primary me-1"></i> आपके द्वारा जारी किए गए नोटिस</h5>
            <div class="table-responsive">
                <table class="table table-hover border m-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-2.5 px-3" style="font-size: 13px;">दिनांक</th>
                            <th class="py-2.5" style="font-size: 13px;">सूचना / शीर्षक</th>
                            <th class="py-2.5" style="font-size: 13px;">पूरी जानकारी</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allNotices as $notice)
                            <tr>
                                <td class="px-3 text-secondary" style="font-size: 12.5px;">{{ date('d M Y', strtotime($notice->created_at)) }}</td>
                                <td class="fw-bold text-dark" style="font-size: 13.5px;">👉 {{ $notice->title }}</td>
                                <td class="text-muted" style="font-size: 13px;">{{ $notice->description }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4 text-muted">अभी तक कोई नोटिस जारी नहीं किया गया है।</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>