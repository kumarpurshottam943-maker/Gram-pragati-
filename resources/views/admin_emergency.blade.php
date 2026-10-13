<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>आपातकालीन हेल्प डेस्क मैनेजमेंट - एडमिन पैनल</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/admin-dashboard" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> एडमिन डैशबोर्ड पर लौटें</a>
            <h4 class="fw-bold text-danger m-0"><i class="fa-solid fa-triangle-exclamation me-2"></i> आपातकालीन हेल्प डेस्क मैनेजर</h4>
            <div></div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- नया संपर्क जोड़ने का फॉर्म -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-plus-circle me-1 text-success"></i> नया नंबर जोड़ें</h5>
                    <form action="/admin/emergency-help/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">श्रेणी (Category)</label>
                            <select name="category" class="form-control" required>
                                <option value="Medical">मेडिकल (Medical)</option>
                                <option value="Police">पुलिस (Police)</option>
                                <option value="Fire">अग्निशनक (Fire)</option>
                                <option value="Disaster">आपदा प्रबंधन (Disaster)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">शीर्षक / नाम (Title)</label>
                            <input type="text" name="title" class="form-control" placeholder="जैसे: जिला अस्पताल सतना" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">फ़ोन नंबर (Phone)</label>
                            <input type="text" name="phone" class="form-control" placeholder="जैसे: 112 या 108" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">विवरण (Description)</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="जैसे: 24 घंटे उपलब्ध"></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill shadow-sm py-2">
                            <i class="fa-solid fa-floppy-disk me-1"></i> सुरक्षित करें
                        </button>
                    </form>
                </div>
            </div>

            <!-- पहले से जुड़े संपर्कों की सूची -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list me-1 text-primary"></i> आपातकालीन संपर्कों की सूची</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>श्रेणी</th>
                                    <th>नाम / शीर्षक</th>
                                    <th>फ़ोन नंबर</th>
                                    <th>विवरण</th>
                                    <th>एक्शन</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $contact)
                                <tr>
                                    <td><span class="badge bg-secondary">{{ $contact->category }}</span></td>
                                    <td class="fw-bold">{{ $contact->title }}</td>
                                    <td class="text-danger fw-bold"><i class="fa-solid fa-phone me-1"></i>{{ $contact->phone }}</td>
                                    <td class="small text-muted">{{ $contact->description ?? '-' }}</td>
                                    <td>
                                        <form action="/admin/emergency-help/delete/{{ $contact->id }}" method="POST" onsubmit="return confirm('क्या आप वाकई इसे हटाना चाहते हैं?');">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">कोई आपातकालीन संपर्क उपलब्ध नहीं है।</td>
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