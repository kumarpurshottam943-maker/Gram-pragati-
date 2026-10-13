<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>विशेषज्ञ मीटिंग (Expert Meeting) - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .card-custom { border: none; border-radius: 14px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); background: white; transition: transform 0.2s; }
        .card-custom:hover { transform: translateY(-3px); }
        .expert-img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #198754; }
    </style>
</head>
<body>

    <div class="container py-5">
        <!-- टॉप हेडर -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h3 class="fw-bold text-success m-0" style="font-size: 22px;">
                <i class="fa-solid fa-user-tie me-2 text-success"></i> विशेषज्ञ मीटिंग (Expert Meeting) <small class="text-muted fw-normal" style="font-size: 14px;">| कृषि वैज्ञानिकों व डॉक्टरों से सीधा संवाद</small>
            </h3>
            <a href="/" class="btn btn-outline-secondary btn-sm fw-semibold rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> होम पेज पर जाएं
            </a>
        </div>

        <!-- मुख्य बैनर -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 text-white rounded-4 shadow-sm" style="background: linear-gradient(135deg, #115e3b, #198754);">
                    <h2 class="fw-bold mb-2">फसल या पशुओं में कोई समस्या है? 👨‍🌾</h2>
                    <p class="mb-0 text-white-50" style="font-size: 14.5px;">सतना और आसपास के कृषि विशेषज्ञों से लाइव वीडियो कॉल या मीटिंग बुक करें और अपनी समस्या का तुरंत समाधान पाएं।</p>
                </div>
            </div>
        </div>

        <!-- विशेषज्ञों की लिस्ट -->
        <div class="row g-4">
            <!-- विशेषज्ञ 1 -->
            <div class="col-md-4">
                <div class="card card-custom p-4 text-center h-100">
                    <div class="mb-3">
                        <img src="{{ asset('images/expert.jpg') }}" class="expert-img" onerror="this.src='https://via.placeholder.com/80'">
                    </div>
                    <h5 class="fw-bold text-dark mb-1">डॉ. रमेश वर्मा</h5>
                    <p class="text-success fw-semibold small mb-2">वरिष्ठ कृषि वैज्ञानिक (मृदा एवं फसल)</p>
                    <p class="text-muted small">फसल में कीट नियंत्रण, खाद प्रबंधन और आधुनिक खेती के विशेषज्ञ।</p>
                    <div class="mt-auto pt-3">
                        <span class="badge bg-success-subtle text-success mb-3 d-block py-2">उपलब्धता: कल सुबह 11:00 AM</span>
                        <button class="btn btn-success btn-sm w-100 rounded-pill fw-bold" onclick="alert('आपकी मीटिंग की रिक्वेस्ट दर्ज हो गई है। विशेषज्ञ जल्द ही आपसे संपर्क करेंगे।')">
                            <i class="fa-solid fa-video me-1"></i> मीटिंग बुक करें
                        </button>
                    </div>
                </div>
            </div>

            <!-- विशेषज्ञ 2 -->
            <div class="col-md-4">
                <div class="card card-custom p-4 text-center h-100">
                    <div class="mb-3">
                        <img src="https://via.placeholder.com/80" class="expert-img" alt="डॉक्टर फोटो">
                    </div>
                    <h5 class="fw-bold text-dark mb-1">डॉ. सुरेश पटेल</h5>
                    <p class="text-info-emphasis fw-semibold small mb-2">मुख्य पशु चिकित्सा अधिकारी</p>
                    <p class="text-muted small">पशुओं की संक्रामक बीमारियाँ, टीकाकरण और डेयरी फॉर्म गाइडेंस।</p>
                    <div class="mt-auto pt-3">
                        <span class="badge bg-info-subtle text-info-emphasis mb-3 d-block py-2">उपलब्धता: आज दोपहर 02:00 PM</span>
                        <button class="btn btn-info btn-sm w-100 rounded-pill fw-bold text-white" onclick="alert('आपकी मीटिंग की रिक्वेस्ट दर्ज हो गई है। विशेषज्ञ जल्द ही आपसे संपर्क करेंगे।')">
                            <i class="fa-solid fa-video me-1"></i> मीटिंग बुक करें
                        </button>
                    </div>
                </div>
            </div>

            <!-- विशेषज्ञ 3 -->
            <div class="col-md-4">
                <div class="card card-custom p-4 text-center h-100">
                    <div class="mb-3">
                        <img src="https://via.placeholder.com/80" class="expert-img" alt="विशेषज्ञ फोटो">
                    </div>
                    <h5 class="fw-bold text-dark mb-1">श्री राकेश त्रिपाठी</h5>
                    <p class="text-warning-emphasis fw-semibold small mb-2">उद्यानिकी एवं जैविक खेती विशेषज्ञ</p>
                    <p class="text-muted small">बागवानी, फल-सब्जी उत्पादन और ड्रिप इरिगेशन योजना मार्गदर्शन।</p>
                    <div class="mt-auto pt-3">
                        <span class="badge bg-warning-subtle text-warning-emphasis mb-3 d-block py-2">उपलब्धता: परसों सुबह 10:00 AM</span>
                        <button class="btn btn-warning btn-sm w-100 rounded-pill fw-bold text-dark" onclick="alert('आपकी मीटिंग की रिक्वेस्ट दर्ज हो गई है। विशेषज्ञ जल्द ही आपसे संपर्क करेंगे।')">
                            <i class="fa-solid fa-video me-1"></i> मीटिंग बुक करें
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>