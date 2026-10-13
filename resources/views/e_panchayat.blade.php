<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ई-पंचायत डिजिटल सेवा - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .module-header { background-color: #198754; color: white; font-weight: bold; font-size: 14px; text-transform: uppercase; padding: 10px; border-radius: 8px 8px 0 0; text-align: center; }
        .panchayat-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; min-height: 580px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 24px; }
        
        /* सुंदर कार्ड्स और आइकॉन्स */
        .scheme-item-card { border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 16px; background: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.01); }
        .scheme-icon-box { width: 65px; height: 65px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 28px; transition: transform 0.2s; }
        .scheme-item-card:hover .scheme-icon-box { transform: scale(1.05); }
        
        /* आइकॉन्स के बैकग्राउंड रंग */
        .icon-seedling { background-color: #e2f0d9; color: #2e7d32; }
        .icon-shield { background-color: #fff3cd; color: #d97706; }
        .icon-house { background-color: #e0f2fe; color: #0284c7; }
        
        /* विवरण देखें ग्रीन बटन */
        .btn-view-details { background-color: #198754; color: white; font-size: 13px; font-weight: 600; border-radius: 6px; padding: 6px 16px; border: none; transition: background 0.2s; }
        .btn-view-details:hover { background-color: #146c43; color: white; }

        .back-btn { font-size: 13.5px; font-weight: 600; color: #475569; text-decoration: none; }
        .back-btn:hover { color: #198754; }
    </style>
</head>
<body>

    <div class="container-fluid py-4 px-5">
        
        <!-- टॉप नेविगेशन बार -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="/" class="back-btn"><i class="fa-solid fa-arrow-left me-1"></i> मुख्य होमपेज पर जाएँ</a>
            <h4 class="fw-bold m-0 text-success"><i class="fa-solid fa-landmark me-1"></i> ई-पंचायत डिजिटल पोर्टल (E-Panchayat)</h4>
        </div>

        <div class="row g-4">
            
            <!-- बायाँ कॉलम: 5. SCHEME DETAILS -->
            <div class="col-xl-6 col-lg-6">
                <div class="module-header" style="background-color: #198754;">5. SCHEME DETAILS & GOVT SERVICES</div>
                <div class="panchayat-card">
                    
                    <h5 class="fw-bold text-dark mb-3" style="font-size: 16px;"><i class="fa-solid fa-gift text-success me-1"></i> सरकारी योजनाएँ एवं सेवाएँ</h5>
                    
                    <!-- कैटगरी फ़िल्टर बटन्स -->
                    <div class="d-flex gap-2 mb-4">
                        <a href="/e-panchayat?category=केन्द्र सरकार" class="btn btn-sm w-100 fw-bold {{ $category == 'केन्द्र सरकार' ? 'btn-success' : 'btn-light border' }}" style="font-size:12.5px;">केन्द्र सरकार</a>
                        <a href="/e-panchayat?category=राज्य सरकार" class="btn btn-sm w-100 fw-bold {{ $category == 'राज्य सरकार' ? 'btn-success' : 'btn-light border' }}" style="font-size:12.5px;">राज्य सरकार</a>
                        <a href="/e-panchayat?category=अन्य योजनाएँ" class="btn btn-sm w-100 fw-bold {{ $category == 'अन्य योजनाएँ' ? 'btn-success' : 'btn-light border' }}" style="font-size:12.5px;">अन्य योजनाएँ</a>
                    </div>

                    <!-- योजनाओं की लाइव लिस्टिंग एरिया -->
                    <div style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                        @forelse($schemes as $scheme)
                            <div class="scheme-item-card">
                                <div class="d-flex align-items-start gap-3">
                                    
                                    @php
                                        $iconColorClass = 'icon-seedling';
                                        if($scheme->scheme_icon == 'fa-shield-halved') $iconColorClass = 'icon-shield';
                                        if($scheme->scheme_icon == 'fa-house-chimney') $iconColorClass = 'icon-house';
                                    @endphp
                                    <div class="scheme-icon-box {{ $iconColorClass }}"><i class="fa-solid {{ $scheme->scheme_icon }}"></i></div>
                                    
                                    <div class="w-100">
                                        <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;">{{ $scheme->title }}</h6>
                                        <p class="text-secondary m-0 mb-3" style="font-size: 13px; line-height: 1.4;">{{ Str::limit($scheme->description, 90) }}</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted" style="font-size: 11.5px;">📋 पात्रता: {{ Str::limit($scheme->eligibility, 35) }}</small>
                                            
                                            <!-- 🔥 आधुनिक बूस्ट्रैप मॉडल ट्रिगर करने वाला बटन -->
                                            <button type="button" class="btn-view-details" data-bs-toggle="modal" data-bs-target="#schemeModal{{ $scheme->id }}">
                                                विवरण देखें
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 🌟 हर योजना के लिए अलग और सुंदर पॉप-अप मॉडल (Modal) -->
                            <div class="modal fade" id="schemeModal{{ $scheme->id }}" tabindex="-1" aria-labelledby="schemeModalLabel{{ $scheme->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title fw-bold" id="schemeModalLabel{{ $scheme->id }}" style="font-size: 16px;">
                                                <i class="fa-solid fa-circle-info me-2"></i> {{ $scheme->title }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start" style="font-size: 13.5px;">
                                            <div class="mb-3">
                                                <strong class="text-success d-block mb-1"><i class="fa-solid fa-file-lines me-1"></i> योजना का पूरा विवरण:</strong>
                                                <p class="text-secondary bg-light p-2.5 rounded m-0">{{ $scheme->description }}</p>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <strong class="text-success d-block mb-1"><i class="fa-solid fa-user-check me-1"></i> पात्रता (Eligibility):</strong>
                                                <p class="text-dark bg-light p-2.5 rounded m-0">{{ $scheme->eligibility }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <strong class="text-success d-block mb-1"><i class="fa-solid fa-folder-open me-1"></i> आवश्यक दस्तावेज (Required Documents):</strong>
                                                <ul class="text-secondary ps-3 m-0" style="font-size: 13px;">
                                                    <li>[Aadhaar Redacted] (आधार कार्ड)</li>
                                                    <li>बैंक पासबुक (Bank Passbook)</li>
                                                    <li>भूमि का पर्चा / खसरा-खतौनी (यदि कृषि योजना हो)</li>
                                                    <li>निवास प्रमाण पत्र / मोबाइल नंबर</li>
                                                </ul>
                                            </div>

                                            <div class="alert alert-warning py-2 m-0" style="font-size: 12px;">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> <strong>आवेदन प्रक्रिया:</strong> इस योजना का लाभ लेने के लिए ग्रामीण नजदीकी ई-पंचायत भवन या सीएससी (CSC) केंद्र से संपर्क कर सकते हैं।
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light py-2">
                                            <a href="/help-support" class="btn btn-success btn-sm fw-bold w-100">सहायता केंद्र से संपर्क करें</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">इस केटेगरी में अभी कोई योजना लाइव नहीं है। एडमिन पैनल से योजना जोड़ें!</div>
                        @endforelse
                    </div>

                </div>
            </div>

            <!-- दायाँ कॉलम: 6. CERTIFICATE TRACKER (अपडेटेड विथ सर्विस ड्रॉपडाउन) -->
            <div class="col-xl-6 col-lg-6">
                <div class="module-header" style="background-color: #0d6efd;">6. CERTIFICATE TRACKER & STATUS</div>
                <div class="panchayat-card">
                    <h5 class="fw-bold text-dark mb-3" style="font-size: 16px;"><i class="fa-solid fa-file-invoice text-primary me-1"></i> आवेदन एवं प्रमाण पत्र की स्थिति देखें</h5>
                    
                    <form action="/e-panchayat/track" method="POST" class="mb-4">
                        @csrf
                        
                        <!-- सेवा चयन ड्रॉपडाउन -->
                        <div class="mb-2">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 12px;">सेवा या प्रमाण पत्र का प्रकार चुनें</label>
                            <select name="service_type" class="form-select form-select-sm shadow-none py-2" style="font-size: 13px;">
                                <option value="सभी सेवाएं">-- सभी सेवाएं / सामान्य खोज --</option>
                                <option value="जन्म प्रमाण पत्र">जन्म प्रमाण पत्र (Birth Certificate)</option>
                                <option value="आय प्रमाण पत्र">आय प्रमाण पत्र (Income Certificate)</option>
                                <option value="जाति प्रमाण पत्र">जाति प्रमाण पत्र (Caste Certificate)</option>
                                <option value="निवास प्रमाण पत्र">निवास प्रमाण पत्र (Domicile Certificate)</option>
                                <option value="सरकारी योजना आवेदन">सरकारी योजना आवेदन (Govt Scheme)</option>
                            </select>
                        </div>

                        <label class="form-label fw-semibold text-secondary mt-2" style="font-size: 12px;">अपना आवेदन संख्या (Application No.) डालें</label>
                        <div class="input-group input-group-sm">
                            <input type="text" name="application_no" class="form-control shadow-none py-2" placeholder="जैसे: ABC123456" value="{{ $trackResult->application_no ?? '' }}" required style="font-size: 13.5px;">
                            <button type="submit" class="btn btn-primary px-4 fw-bold shadow-none" style="font-size: 13px;"><i class="fa-solid fa-search me-1"></i> खोजें</button>
                        </div>
                    </form>

                    @if(isset($trackResult))
                        <div class="card border p-4 rounded-3 bg-white shadow-sm">
                            <h6 class="fw-bold text-dark mb-3 border-bottom pb-2" style="font-size: 14px;"><i class="fa-solid fa-circle-info text-primary"></i> आवेदन विवरण परिणाम</h6>
                            <div class="row g-2.5 text-dark mb-3" style="font-size: 13px;">
                                <div class="col-4 text-secondary fw-semibold">आवेदक का नाम</div>
                                <div class="col-8 fw-bold">: {{ $trackResult->user_name }}</div>
                                <div class="col-4 text-secondary fw-semibold">सेवा का नाम</div>
                                <div class="col-8 fw-bold">: {{ $trackResult->service_name }}</div>
                                <div class="col-4 text-secondary fw-semibold">आवेदन संख्या</div>
                                <div class="col-8 fw-bold text-primary">: {{ $trackResult->application_no }}</div>
                                <div class="col-4 text-secondary fw-semibold">वर्तमान स्थिति</div>
                                <div class="col-8">: <span class="badge bg-warning text-dark border px-2.5 py-1 fw-bold" style="font-size:11.5px;">{{ $trackResult->status }}</span></div>
                            </div>
                            <div class="p-2.5 bg-light border rounded text-dark" style="font-size: 12px;">🎯 <strong>अगला कदम / टिप्पणी:</strong> {{ $trackResult->next_step ?? 'प्रक्रिया जारी है।' }}</div>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fa-solid fa-magnifying-glass-location fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            <small>यहाँ सेवा का चयन करें और अपना एप्लीकेशन नंबर डालकर सबमिट करें, लाइव स्थिति यहाँ दिखाई देगी।</small>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS (मॉडल्स को काम करने के लिए अनिवार्य) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>