<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>रिपोर्ट्स एंड एनालिटिक्स - ग्राम प्रगति एडमिन</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .navbar-custom { background-color: #1e293b; color: white; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white; }
        .stat-card { border-left: 4px solid #0d9488; }
    </style>
</head>
<body>

    <!-- टॉप नेविगेशन बार -->
    <nav class="navbar navbar-expand-lg navbar-custom px-4 py-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="/admin-dashboard">
                <i class="fa-solid fa-chart-pie me-2 text-info"></i> ग्राम प्रगति - रिपोर्ट्स और एनालिटिक्स
            </a>
            <a href="/admin-dashboard" class="btn btn-light btn-sm fw-bold rounded-pill px-3 text-dark">
                <i class="fa-solid fa-arrow-left me-1"></i> डैशबोर्ड पर लौटें
            </a>
        </div>
    </nav>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">पोर्टल प्रदर्शन और सांख्यिकी रिपोर्ट</h4>
                <p class="text-muted small m-0">यहाँ ग्राम प्रगति पोर्टल पर दर्ज सभी गतिविधियों और डेटा का सारांश उपलब्ध है।</p>
            </div>
            <button onclick="window.print()" class="btn btn-success btn-sm fw-bold rounded-pill px-3">
                <i class="fa-solid fa-download me-1"></i> रिपोर्ट डाउनलोड (PDF)
            </button>
        </div>

        <!-- मुख्य आँकड़े (KPI Cards) -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card card-custom stat-card p-3">
                    <span class="text-muted small fw-semibold">कुल पंजीकृत यूज़र्स</span>
                    <h3 class="fw-bold text-dark mt-1 mb-0">{{ $totalUsers ?? 0 }}</h3>
                    <small class="text-success mt-2"><i class="fa-solid fa-arrow-up"></i> सक्रिय नागरिक</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3" style="border-left: 4px solid #2563eb;">
                    <span class="text-muted small fw-semibold">कुल दर्ज शिकायतें</span>
                    <h3 class="fw-bold text-dark mt-1 mb-0">{{ $totalComplaints ?? 0 }}</h3>
                    <small class="text-primary mt-2"><i class="fa-solid fa-comments"></i> सिटीजन वॉइस</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3" style="border-left: 4px solid #16a34a;">
                    <span class="text-muted small fw-semibold">हल की गई शिकायतें (Resolved)</span>
                    <h3 class="fw-bold text-dark mt-1 mb-0">{{ $resolvedComplaints ?? 0 }}</h3>
                    <small class="text-success mt-2"><i class="fa-solid fa-circle-check"></i> सफलतापूर्वक समाधान</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom p-3" style="border-left: 4px solid #f97316;">
                    <span class="text-muted small fw-semibold">लंबित शिकायतें (Pending)</span>
                    <h3 class="fw-bold text-dark mt-1 mb-0">{{ $pendingComplaints ?? 0 }}</h3>
                    <small class="text-warning mt-2"><i class="fa-solid fa-clock"></i> प्रक्रियाधीन</small>
                </div>
            </div>
        </div>

        <!-- ग्राफ और विश्लेषण सेक्शन -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card card-custom p-4 h-100">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-chart-bar me-2 text-primary"></i> शिकायत स्थिति का विश्लेषण</h5>
                    <div style="height: 250px; position: relative;">
                        <canvas id="complaintsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-custom p-4 h-100">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-tractor me-2 text-success"></i> कृषि बाज़ार और टूल लिस्टिंग</h5>
                    <div class="p-3 bg-light rounded-3 mb-3 d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-secondary">किराए पर उपलब्ध कुल कृषि उपकरण:</span>
                        <span class="badge bg-success px-3 py-2 fs-6">{{ $totalTools ?? 0 }} टूल</span>
                    </div>
                    <div class="p-3 bg-light rounded-3 mb-3 d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-secondary">सक्रिय किसान और युवा साथी:</span>
                        <span class="badge bg-primary px-3 py-2 fs-6">{{ $totalFarmers ?? $totalUsers }} सदस्य</span>
                    </div>
                    <div class="alert alert-info small m-0">
                        <i class="fa-solid fa-circle-info me-1"></i> सभी डेटा सीधे लाइव डेटाबेस से सिंक किया गया है।
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // शिकायत स्थिति का चार्ट
        const ctx = document.getElementById('complaintsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['हल (Resolved)', 'प्रगति पर (In Progress)', 'लंबित (Pending)'],
                datasets: [{
                    label: 'शिकायतों की संख्या',
                    data: [
                        {{ $resolvedComplaints ?? 0 }}, 
                        {{ $inProgressComplaints ?? 0 }}, 
                        {{ $pendingComplaints ?? 0 }}
                    ],
                    backgroundColor: ['#22c55e', '#38bdf8', '#f97316'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { grid: { display: false } }, y: { grid: { display: false } } }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>