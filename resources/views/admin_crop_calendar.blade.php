<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>फसल एवं कृषि कैलेंडर मैनेजमेंट - एडमिन पैनल</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/admin-dashboard" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> एडमिन डैशबोर्ड</a>
            <h4 class="fw-bold text-success m-0"><i class="fa-solid fa-calendar-days me-2"></i> फसल एवं कृषि कैलेंडर मैनेजर</h4>
            <div></div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- नया फसल कैलेंडर जोड़ने का फॉर्म -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-plus-circle me-1 text-success"></i> नया कैलेंडर जोड़ें</h5>
                    <form action="/admin/crop-calendar/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">फसल का नाम (Crop Name)</label>
                            <input type="text" name="crop_name" class="form-control" placeholder="जैसे: गेहूं, धान, चना" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">महीना या मौसम (Month / Season)</label>
                            <input type="text" name="month_season" class="form-control" placeholder="जैसे: अक्टूबर - नवंबर" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">बुवाई और खाद गाइड (Sowing Guide)</label>
                            <textarea name="sowing_guide" class="form-control" rows="2" placeholder="बीज की मात्रा और खाद विवरण..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">सिंचाई गाइड (Irrigation Guide)</label>
                            <textarea name="irrigation_guide" class="form-control" rows="2" placeholder="सिंचाई कब और कैसे करें..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill shadow-sm py-2">
                            <i class="fa-solid fa-floppy-disk me-1"></i> सुरक्षित करें
                        </button>
                    </form>
                </div>
            </div>

            <!-- पहले से जुड़े कैलेंडरों की सूची -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list me-1 text-primary"></i> फसल कैलेंडर की सूची</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>फसल</th>
                                    <th>मौसम/महीना</th>
                                    <th>बुवाई गाइड</th>
                                    <th>सिंचाई गाइड</th>
                                    <th>एक्शन</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($calendars as $calendar)
                                <tr>
                                    <td class="fw-bold text-success">{{ $calendar->crop_name }}</td>
                                    <td><span class="badge bg-secondary">{{ $calendar->month_season }}</span></td>
                                    <td class="small text-muted">{{ $calendar->sowing_guide }}</td>
                                    <td class="small text-muted">{{ $calendar->irrigation_guide }}</td>
                                    <td>
                                        <form action="/admin/crop-calendar/delete/{{ $calendar->id }}" method="POST" onsubmit="return confirm('क्या आप वाकई इस कैलेंडर को हटाना चाहते हैं?');">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">कोई फसल कैलेंडर उपलब्ध नहीं है।</td>
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