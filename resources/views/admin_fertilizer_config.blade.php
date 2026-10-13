<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>खाद कैलकुलेटर फॉर्मूला नियंत्रण - एडमिन पैनल</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/admin-dashboard" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> एडमिन डैशबोर्ड पर लौटें</a>
            <h4 class="fw-bold text-success m-0"><i class="fa-solid fa-calculator me-2"></i> खाद और मिट्टी कैलकुलेटर फॉर्मूला मैनेजर</h4>
            <div></div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3">किसान खाद कैलकुलेटर की सेटिंग्स अपडेट करें</h5>
                    <p class="text-muted small mb-4">यहाँ से जो मात्रा और लागत सेट की जाएगी, वही किसानों के कैलकुलेटर में स्वतः लागू होगी।</p>

                    @php
                        $config = \Illuminate\Support\Facades\Schema::hasTable('fertilizer_configs') 
                            ? \Illuminate\Support\Facades\DB::table('fertilizer_configs')->where('id', 1)->first() 
                            : null;
                    @endphp

                    <form action="/admin/fertilizer-config/update" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="font-size: 13px;">प्रति एकड़ यूरिया मात्रा (किग्रा)</label>
                                <input type="number" step="0.1" name="urea_per_acre" class="form-control" value="{{ $config->urea_per_acre ?? 45 }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold" style="font-size: 13px;">प्रति एकड़ डीएपी मात्रा (किग्रा)</label>
                                <input type="number" step="0.1" name="dap_per_acre" class="form-control" value="{{ $config->dap_per_acre ?? 30 }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold" style="font-size: 13px;">जुताई खर्च (₹ प्रति एकड़)</label>
                                <input type="number" name="tillage_cost" class="form-control" value="{{ $config->tillage_cost ?? 1200 }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold" style="font-size: 13px;">बीज खर्च (₹ प्रति एकड़)</label>
                                <input type="number" name="seed_cost" class="form-control" value="{{ $config->seed_cost ?? 1500 }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold" style="font-size: 13px;">उर्वरक खर्च (₹ प्रति एकड़)</label>
                                <input type="number" name="fertilizer_cost" class="form-control" value="{{ $config->fertilizer_cost ?? 1800 }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold" style="font-size: 13px;">विशेष कृषि सलाह संदेश (जो कैलकुलेटर परिणाम में दिखेगा)</label>
                                <textarea name="advisory_message" class="form-control" rows="3">{{ $config->advisory_message ?? 'समय पर हल्की सिंचाई करें और यूरिया का छिड़काव नमी में करें।' }}</textarea>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill py-2 shadow-sm">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> फॉर्मूला और लागत सुरक्षित करें
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>