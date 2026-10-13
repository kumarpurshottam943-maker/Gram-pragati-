<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>एडमिन प्रोफाइल - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .navbar-custom { background-color: #1e293b; color: white; }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white; }
        .profile-img { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #38bdf8; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom px-4 py-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="/admin-dashboard">
                <i class="fa-solid fa-gauge me-2"></i> ग्राम प्रगति - एडमिन प्रोफाइल
            </a>
            <a href="/admin-dashboard" class="btn btn-light btn-sm fw-bold rounded-pill px-3 text-dark">
                <i class="fa-solid fa-arrow-left me-1"></i> डैशबोर्ड पर लौटें
            </a>
        </div>
    </nav>

    <div class="container py-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 justify-content-center">
            <div class="col-lg-5">
                <div class="card card-custom p-4 text-center h-100">
                    <div class="mb-3 mt-2">
                        @if($admin->profile_image)
                            <img src="{{ asset($admin->profile_image) }}" class="profile-img shadow-sm" alt="Admin Profile">
                        @else
                            <img src="{{ asset('images/pur.jpg') }}" class="profile-img shadow-sm" alt="Default Admin">
                        @endif
                    </div>
                    
                    <h3 class="fw-bold text-dark mb-1">{{ $admin->name }}</h3>
                    <span class="badge bg-info-subtle text-info px-3 py-1.5 rounded-pill fw-semibold mb-3 d-inline-block">
                        <i class="fa-solid fa-user-shield me-1"></i> Super Administrator
                    </span>

                    <ul class="list-group list-group-flush text-start mt-2 border-top pt-3">
                        <li class="list-group-item d-flex justify-content-between py-2.5">
                            <span class="text-muted"><i class="fa-solid fa-phone text-success me-2"></i> मोबाइल नंबर:</span>
                            <span class="fw-bold">{{ $admin->phone }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between py-2.5">
                            <span class="text-muted"><i class="fa-solid fa-envelope text-success me-2"></i> ईमेल आईडी:</span>
                            <span class="fw-bold text-break" style="font-size: 13px;">{{ $admin->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between py-2.5">
                            <span class="text-muted"><i class="fa-solid fa-location-dot text-danger me-2"></i> क्षेत्र:</span>
                            <span class="fw-bold">{{ $admin->location ?? 'Satna, MP' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card card-custom p-4 h-100">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-user-pen me-2 text-info"></i> एडमिन विवरण अपडेट करें</h5>
                    <p class="text-muted small mb-4">आप यहाँ से अपना एडमिन नाम या प्रोफाइल फोटो बदल सकते हैं।</p>

                    <form action="/admin/profile/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">एडमिन का पूरा नाम (Name)</label>
                            <input type="text" name="name" class="form-control" value="{{ $admin->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">नई प्रोफाइल फोटो चुनें (Profile Image)</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                            <div class="form-text small text-muted">केवल .jpg, .png या .jpeg फॉर्मेट की फोटो अपलोड करें।</div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 fw-bold rounded-pill py-2 mt-3">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> बदलाव सहेजें (Save Changes)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>