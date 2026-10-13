<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>आपातकालीन हेल्प डेस्क - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <!-- ऊपर का नेविगेशन -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> होम पर लौटें</a>
            <h4 class="fw-bold text-danger m-0"><i class="fa-solid fa-triangle-exclamation me-2"></i> आपातकालीन हेल्प डेस्क ({{ $userLocation ?? 'स्थानीय क्षेत्र' }})</h4>
            <div></div>
        </div>

        <!-- मुख्य चेतावनी बैनर (वन-क्लिक नेशनल कॉलिंग) -->
        <div class="alert alert-danger shadow-sm rounded-4 p-4 mb-4 border-0 text-center bg-danger text-white">
            <h3 class="fw-bold mb-2"><i class="fa-solid fa-phone-volume me-2"></i> तुरंत सहायता के लिए डायल करें</h3>
            <p class="mb-3">किसी भी आपात स्थिति में राष्ट्रीय आपातकालीन नंबरों पर सीधे संपर्क करें:</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="tel:112" class="btn btn-light text-danger fw-bold px-4 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-shield-halved me-1"></i> राष्ट्रीय आपातकाल: 112</a>
                <a href="tel:108" class="btn btn-light text-danger fw-bold px-4 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-truck-medical me-1"></i> एम्बुलेंस: 108</a>
                <a href="tel:101" class="btn btn-light text-danger fw-bold px-4 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-fire-extinguisher me-1"></i> फायर ब्रिगेड: 101</a>
            </div>
        </div>

        <!-- डेटाबेस और स्थानीय आपातकालीन नंबरों की लिस्ट -->
        <div class="row g-4">
            @if(isset($emergencies) && count($emergencies) > 0)
                @foreach($emergencies as $item)
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 rounded-4 p-4 h-100 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger-subtle text-danger p-3 rounded-circle me-3 fs-4">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                                <div>
                                    <span class="badge bg-danger mb-1">{{ $item->category }}</span>
                                    <h5 class="fw-bold text-dark m-0">{{ $item->title }}</h5>
                                </div>
                            </div>
                            <p class="text-muted small mb-3">{{ $item->description ?? 'आपातकालीन सहायता सेवा 24 घंटे उपलब्ध।' }}</p>
                            <a href="tel:{{ $item->phone }}" class="mt-auto btn btn-outline-danger fw-bold rounded-pill w-100">
                                <i class="fa-solid fa-phone me-2"></i> कॉल करें: {{ $item->phone }}
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- डिफ़ॉल्ट स्थानीय कार्ड्स (यूजर की लोकेशन के आधार पर динамический) -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-4 p-4 h-100 bg-white">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger-subtle text-danger p-3 rounded-circle me-3 fs-4">
                                <i class="fa-solid fa-hospital"></i>
                            </div>
                            <div>
                                <span class="badge bg-danger mb-1">स्वास्थ्य</span>
                                <h5 class="fw-bold text-dark m-0">जिला अस्पताल {{ $userLocation ?? 'क्षेत्र' }}</h5>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">स्वास्थ्य एवं आपातकालीन चिकित्सा सेवा।</p>
                        <a href="tel:108" class="mt-auto btn btn-outline-danger fw-bold rounded-pill w-100">
                            <i class="fa-solid fa-phone me-2"></i> एम्बुलेंस कॉल करें: 108
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-4 p-4 h-100 bg-white">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary-subtle text-primary p-3 rounded-circle me-3 fs-4">
                                <i class="fa-solid fa-building-shield"></i>
                            </div>
                            <div>
                                <span class="badge bg-primary mb-1">पुलिस</span>
                                <h5 class="fw-bold text-dark m-0">पुलिस कंट्रोल रूम {{ $userLocation ?? 'क्षेत्र' }}</h5>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">कानून व्यवस्था एवं सुरक्षा सहायता।</p>
                        <a href="tel:112" class="mt-auto btn btn-outline-primary fw-bold rounded-pill w-100">
                            <i class="fa-solid fa-phone me-2"></i> पुलिस कॉल करें: 112
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-4 p-4 h-100 bg-white">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning-subtle text-warning p-3 rounded-circle me-3 fs-4">
                                <i class="fa-solid fa-tractor"></i>
                            </div>
                            <div>
                                <span class="badge bg-warning text-dark mb-1">कृषि आपदा</span>
                                <h5 class="fw-bold text-dark m-0">कृषि विभाग हेल्पडेस्क</h5>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">फसल नुकसान या प्राकृतिक आपदा सहायता।</p>
                        <a href="tel:18001801551" class="mt-auto btn btn-outline-warning text-dark fw-bold rounded-pill w-100">
                            <i class="fa-solid fa-phone me-2"></i> किसान कॉल सेंटर: 1800-180-1551
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>