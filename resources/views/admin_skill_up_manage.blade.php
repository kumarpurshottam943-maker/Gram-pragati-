<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>एडमिन कौशल विकास मैनेजमेंट - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .navbar-custom { background-color: #198754; color: white; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white; }
        .table-custom th { background-color: #198754; color: white; }
    </style>
</head>
<body>

    <!-- टॉप नेविगेशन बार -->
    <nav class="navbar navbar-expand-lg navbar-custom px-4 py-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="/admin-dashboard">
                <i class="fa-solid fa-gauge me-2"></i> ग्राम प्रगति - एडमिन कंट्रोल पैनल
            </a>
            <a href="/admin-dashboard" class="btn btn-light btn-sm fw-bold rounded-pill px-3 text-success">
                <i class="fa-solid fa-arrow-left me-1"></i> डैशबोर्ड पर लौटें
            </a>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark"><i class="fa-solid fa-graduation-cap text-success me-2"></i> कौशल विकास (Skill-Up) मैनेजमेंट</h2>
                <p class="text-muted">यहाँ से एडमिन महिला, युवा और किसानों के लिए अलग-अलग प्रशिक्षण कोर्स और वीडियो लिंक मैनेज कर सकते हैं।</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- फॉर्म: नया कोर्स जोड़ने के लिए -->
            <div class="col-lg-4">
                <div class="card card-custom p-4 sticky-top" style="top: 20px;">
                    <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-plus-circle me-1"></i> नया कोर्स जोड़ें</h5>
                    
                    <form action="/admin/skill-up/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">कोर्स का नाम (Title)</label>
                            <input type="text" name="title" class="form-control" placeholder="उदा: सिलाई-कढ़ाई या आधुनिक खेती" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">कोर्स श्रेणी (Category)</label>
                            <input type="text" name="category" class="form-control" placeholder="उदा: हस्तशिल्प / कृषि तकनीक" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">किसके लिए है? (Target Audience)</label>
                            <select name="target_category" class="form-select" required>
                                <option value="सभी के लिए">सभी के लिए</option>
                                <option value="गाँव की महिलाएँ">गाँव की महिलाएँ (Women)</option>
                                <option value="युवा और छात्र">युवा और छात्र (Youth & Students)</option>
                                <option value="किसान और पुरुष">किसान और पुरुष (Farmers & Men)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">प्रशिक्षण अवधि (Duration)</label>
                            <input type="text" name="duration" class="form-control" placeholder="उदा: 2 सप्ताह / 1 महीना" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">YouTube ट्रेनिंग वीडियो लिंक (URL)</label>
                            <input type="url" name="video_link" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                            <div class="form-text small text-muted">सीधे वीडियो दिखाने के लिए यूट्यूब लिंक डालें।</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">कोर्स विवरण (Description)</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="कोर्स के बारे में जानकारी दें..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill py-2">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> कोर्स लाइव करें
                        </button>
                    </form>
                </div>
            </div>

            <!-- टेबल: सभी जुड़े हुए कोर्सेस की लिस्ट -->
            <div class="col-lg-8">
                <div class="card card-custom p-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list-check me-1"></i> सभी सक्रिय कोर्सेस की सूची</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-custom">
                                <tr>
                                    <th>#</th>
                                    <th>कोर्स विवरण & टारगेट</th>
                                    <th>अवधि व वीडियो</th>
                                    <th>कार्रवाई</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($skills as $index => $skill)
                                    <tr>
                                        <td class="fw-bold text-muted">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="mb-1">
                                                <span class="badge bg-success-subtle text-success">{{ $skill->category }}</span>
                                                <span class="badge bg-primary-subtle text-primary">{{ $skill->target_category ?? 'सभी के लिए' }}</span>
                                            </div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $skill->title }}</h6>
                                            <p class="text-muted small mb-0" style="font-size: 13px;">{{ Str::limit($skill->description, 55) }}</p>
                                        </td>
                                        <td>
                                            <div class="small text-secondary mb-1"><i class="fa-regular fa-clock me-1"></i> {{ $skill->duration }}</div>
                                            @if(!empty($skill->video_link))
                                                <a href="{{ $skill->video_link }}" target="_blank" class="badge bg-danger text-decoration-none py-1 px-2">
                                                    <i class="fa-brands fa-youtube me-1"></i> वीडियो देखें
                                                </a>
                                            @else
                                                <span class="badge bg-secondary text-light">वीडियो नहीं है</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="/admin/skill-up/delete/{{ $skill->id }}" method="POST" onsubmit="return confirm('क्या आप वाकई इस कोर्स को हटाना चाहते हैं?');">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                    <i class="fa-solid fa-trash-can me-1"></i> हटाएं
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-folder-open fa-2x mb-2"></i>
                                            <p class="mb-0">अभी तक कोई स्किल कोर्स नहीं जोड़ा गया है।</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>