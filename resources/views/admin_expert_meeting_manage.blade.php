<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>एडमिन - विशेषज्ञ मीटिंग मैनेजमेंट - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); background: white; }
    </style>
</head>
<body>

    <div class="container py-4">
        <!-- टॉप हेडर -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h3 class="fw-bold text-success m-0" style="font-size: 20px;">
                <i class="fa-solid fa-user-shield me-2"></i> एडमिन पैनल: विशेषज्ञ मीटिंग नियंत्रण
            </h3>
            <a href="/admin-dashboard" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> एडमिन डैशबोर्ड पर जाएं
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- फॉर्म: नया विशेषज्ञ जोड़ने के लिए -->
            <div class="col-md-4">
                <div class="card card-custom p-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user-plus text-success me-2"></i> नया विशेषज्ञ जोड़ें</h5>
                    <form action="/admin/expert-meeting/store" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">विशेषज्ञ का नाम</label>
                            <input type="text" name="name" class="form-control form-control-sm" placeholder="जैसे: डॉ. रमेश वर्मा" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">पद / विशेषज्ञता</label>
                            <input type="text" name="designation" class="form-control form-control-sm" placeholder="जैसे: वरिष्ठ कृषि वैज्ञानिक" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">विवरण</label>
                            <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="विशेषता या काम की जानकारी" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">उपलब्धता का समय</label>
                            <input type="text" name="availability" class="form-control form-control-sm" placeholder="जैसे: कल सुबह 11:00 AM" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">फोटो अपलोड करें</label>
                            <input type="file" name="image" class="form-control form-control-sm">
                        </div>
                        <button type="submit" class="btn btn-success btn-sm w-100 fw-bold rounded-pill">
                            <i class="fa-solid fa-plus me-1"></i> विशेषज्ञ जोड़ें और लाइव करें
                        </button>
                    </form>
                </div>
            </div>

            <!-- टेबल: जुड़े हुए विशेषज्ञों की लिस्ट -->
            <div class="col-md-8">
                <div class="card card-custom p-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list text-success me-2"></i> सभी जुड़े हुए विशेषज्ञ</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle small">
                            <thead class="table-light">
                                <tr>
                                    <th>नाम व पद</th>
                                    <th>उपलब्धता</th>
                                    <th>स्थिति</th>
                                    <th class="text-end">कार्रवाई</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($experts as $exp)
                                    <tr>
                                        <td>
                                            <strong>{{ $exp->name }}</strong><br>
                                            <span class="text-muted" style="font-size: 11.5px;">{{ $exp->designation }}</span>
                                        </td>
                                        <td>{{ $exp->availability }}</td>
                                        <td><span class="badge bg-success-subtle text-success">Active</span></td>
                                        <td class="text-end">
                                            <form action="/admin/expert-meeting/delete/{{ $exp->id }}" method="POST" onsubmit="return confirm('क्या आप वाकई इस विशेषज्ञ को हटाना चाहते हैं?')">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2" style="font-size: 12px;">
                                                    <i class="fa-solid fa-trash"></i> हटाएँ
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">अभी तक कोई विशेषज्ञ नहीं जोड़ा गया है।</td>
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