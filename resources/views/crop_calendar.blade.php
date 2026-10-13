<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>डायनेमिक कृषि एवं सांस्कृतिक कैलेंडर - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .month-pill { transition: all 0.3s ease; }
        .month-pill:hover { transform: translateY(-3px); }
        .card-custom { border: none; border-radius: 16px; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-custom:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .festival-badge { background: linear-gradient(135deg, #ff7e5f, #feb47b); color: white; }
        .crop-badge { background: linear-gradient(135deg, #56ab2f, #a8e063); color: white; }
    </style>
</head>
<body>

    <div class="container py-5">
        <!-- ऊपर का नेविगेशन -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/" class="btn btn-outline-success btn-sm rounded-pill fw-bold px-3 shadow-sm"><i class="fa-solid fa-arrow-left me-1"></i> होम पर लौटें</a>
            <h3 class="fw-bold text-success m-0"><i class="fa-solid fa-calendar-days me-2"></i> कृषि एवं सांस्कृतिक कैलेंडर</h3>
            <div></div>
        </div>

        <!-- महीने चुनने वाला शानदार बार (Month Selector Tabs) -->
        <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 bg-white text-center">
            <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-filter text-success me-2"></i> वर्ष के माह के अनुसार कैलेंडर देखें:</h5>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                @php
                    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    $currentActive = $selectedMonth ?? date('F');
                @endphp
                @foreach($months as $m)
                    <a href="/crop-calendar?month={{ $m }}" class="month-pill btn {{ $currentActive == $m ? 'btn-success fw-bold shadow' : 'btn-light text-dark border' }} rounded-pill px-3 py-2 small">
                        <i class="fa-solid fa-calendar-check me-1 small"></i> {{ $m }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- वर्तमान चयनित माह का हेडर बैनर -->
        <div class="alert shadow-sm rounded-4 p-4 mb-4 border-0 text-center text-white bg-success d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1"><i class="fa-solid fa-seedling me-2"></i> माह: {{ $currentActive }}</h4>
                <p class="mb-0 small text-white-50">इस महीने की प्रमुख फसलें, कृषि कार्य और पारंपरिक पर्व</p>
            </div>
            <span class="badge bg-light text-success fw-bold px-3 py-2 rounded-pill fs-6 shadow-sm">लाइव कृषि अपडेट</span>
        </div>

        <!-- डायनेमिक कार्ड्स ग्रिड -->
        <div class="row g-4">
            @if(isset($calendars) && count($calendars) > 0)
                @foreach($calendars as $item)
                    <div class="col-md-4">
                        <div class="card card-custom p-4 h-100 bg-white shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge crop-badge px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-wheat-awn me-1"></i> {{ $item->crop_name }}</span>
                                <span class="badge bg-secondary-subtle text-dark px-3 py-2 rounded-pill small fw-bold">{{ $item->stage_title }}</span>
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="fw-bold text-dark"><i class="fa-solid fa-circle-info text-success me-1"></i> कृषि कार्य / सलाह:</h6>
                                <p class="text-muted small mb-0">{{ $item->agricultural_tips }}</p>
                            </div>
                            
                            @if(isset($item->festival_name) && $item->festival_name)
                                <div class="mt-auto bg-light p-3 rounded-4 border-start border-danger border-4">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fa-solid fa-fire text-danger me-2"></i>
                                        <h6 class="fw-bold text-danger m-0">{{ $item->festival_name }}</h6>
                                    </div>
                                    <p class="small text-muted mb-0">{{ $item->festival_desc }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <!-- डिफ़ॉल्ट सुंदर कार्ड्स (यदि डेटाबेस में उस महीने का डेटा न हो) -->
                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100 bg-white shadow-sm border-start border-success border-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge crop-badge px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-wheat-awn me-1"></i> प्रमुख फसल</span>
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill small fw-bold">देखरेख चरण</span>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-dark"><i class="fa-solid fa-circle-info text-success me-1"></i> कृषि सलाह:</h6>
                            <p class="text-muted small mb-0">इस माह में मौसम के अनुसार खेतों में नमी बनाए रखें, निराई-गुड़ाई करें और विशेषज्ञों की सलाह से खाद का प्रयोग करें।</p>
                        </div>
                        <div class="mt-auto bg-light p-3 rounded-4 border-start border-danger border-4">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fa-solid fa-fire text-danger me-2"></i>
                                <h6 class="fw-bold text-danger m-0">पारंपरिक कृषि पर्व</h6>
                            </div>
                            <p class="small text-muted mb-0">ग्रामीण अंचल में प्रकृति और गोधन की पूजा का विशेष महत्व।</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100 bg-white shadow-sm border-start border-primary border-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-tint me-1"></i> सिंचाई प्रबंधन</span>
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill small fw-bold">सतर्कता</span>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-dark"><i class="fa-solid fa-circle-info text-primary me-1"></i> जल प्रबंधन:</h6>
                            <p class="text-muted small mb-0">फसल की मांग के अनुसार समय पर सिंचाई करें ताकि पौधों की जड़ें मजबूत रहें और पैदावार अच्छी हो।</p>
                        </div>
                        <div class="mt-auto bg-light p-3 rounded-4 border-start border-warning border-4">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fa-solid fa-calendar-star text-warning me-2"></i>
                                <h6 class="fw-bold text-dark m-0">ऋतु परिवर्तन उत्सव</h6>
                            </div>
                            <p class="small text-muted mb-0">मौसम के बदलाव के साथ मनाए जाने वाले पारंपरिक ग्रामीण उल्लास।</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-custom p-4 h-100 bg-white shadow-sm border-start border-warning border-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold"><i class="fa-solid fa-shield-halved me-1"></i> फसल सुरक्षा</span>
                            <span class="badge bg-warning-subtle text-dark px-3 py-2 rounded-pill small fw-bold">देखभाल</span>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-bold text-dark"><i class="fa-solid fa-circle-info text-warning me-1"></i> कीट नियंत्रण:</h6>
                            <p class="text-muted small mb-0">फसल को कीटों और फंगस से बचाने के लिए समय-समय पर जैविक या अनुमोदित कीटनाशकों का छिड़काव करें।</p>
                        </div>
                        <div class="mt-auto bg-light p-3 rounded-4 border-start border-success border-4">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fa-solid fa-seedling text-success me-2"></i>
                                <h6 class="fw-bold text-success m-0">समृद्धि उत्सव</h6>
                            </div>
                            <p class="small text-muted mb-0">फसल की अच्छी पैदावार के लिए अन्नपूर्णा माता का स्मरण।</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>