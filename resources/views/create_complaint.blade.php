<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>नागरिक आवाज़ - शिकायत एवं ट्रैकिंग</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        
        /* हेडर पट्टियाँ (तस्वीर 62540.jpg के हूबहू रंग) */
        .header-red { background-color: #dc3545; color: white; font-weight: bold; font-size: 14px; text-transform: uppercase; padding: 8px; border-radius: 8px 8px 0 0; text-align: center; letter-spacing: 0.5px; }
        .header-blue { background-color: #0d6efd; color: white; font-weight: bold; font-size: 14px; text-transform: uppercase; padding: 8px; border-radius: 8px 8px 0 0; text-align: center; letter-spacing: 0.5px; }
        
        /* मुख्य कार्ड्स */
        .laptop-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); min-height: 580px; display: flex; flex-column: justify-content; }
        .card-inner { padding: 24px; width: 100%; }

        /* स्टीपर प्रोग्रेस बार (7. COMPLAINT SUBMISSION) */
        .stepper { display: flex; justify-content: space-between; position: relative; margin-bottom: 25px; padding: 0 10px; }
        .stepper::before { content: ''; position: absolute; top: 15px; left: 30px; right: 30px; height: 2px; background-color: #e2e8f0; z-index: 1; }
        .step-item { position: relative; z-index: 2; text-align: center; flex: 1; }
        .step-circle { width: 32px; height: 32px; border-radius: 50%; background-color: white; border: 2px solid #e2e8f0; display: flex; align-items: center; justify-content: center; margin: 0 auto 6px auto; font-weight: bold; font-size: 13px; color: #64748b; }
        .step-item.active .step-circle { background-color: #198754; border-color: #198754; color: white; }
        .step-text { font-size: 11.5px; font-weight: 600; color: #64748b; }
        .step-item.active .step-text { color: #198754; }

        /* इनपुट बॉक्स स्टाइल्स */
        .form-label { font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .form-control, .form-select { font-size: 13.5px; border-radius: 6px; padding: 10px 12px; border: 1px solid #cbd5e1; }
        .form-control:focus, .form-select:focus { border-color: #198754; box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.15); }

        /* वॉइस माइक बटन */
        .textarea-container { position: relative; }
        .mic-btn { position: absolute; bottom: 12px; right: 12px; width: 36px; height: 36px; border-radius: 50%; background-color: #198754; color: white; border: none; display: flex; align-items: center; justify-content: center; font-size: 15px; cursor: pointer; transition: transform 0.2s; }
        .mic-btn:hover { transform: scale(1.05); }

        /* टाइमलाइन ट्रैकिंग (8. COMPLAINT TRACKING) */
        .timeline { position: relative; padding-left: 30px; margin-top: 20px; }
        .timeline::before { content: ''; position: absolute; top: 5px; bottom: 5px; left: 9px; width: 2px; background-color: #e2e8f0; }
        .timeline-item { position: relative; margin-bottom: 24px; }
        .timeline-dot { position: absolute; left: -26px; top: 4px; width: 12px; height: 12px; border-radius: 50%; background-color: #cbd5e1; border: 2px solid white; box-shadow: 0 0 0 2px #e2e8f0; }
        .timeline-item.active .timeline-dot { background-color: #0d6efd; box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25); }
        .timeline-title { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .timeline-date { font-size: 11.5px; color: #64748b; font-weight: 500; }
        
        /* बैक बटन */
        .back-home-btn { font-size: 13.5px; font-weight: 600; color: #475569; text-decoration: none; transition: color 0.2s; }
        .back-home-btn:hover { color: #198754; }
    </style>
</head>
<body>

    <div class="container-fluid py-4 px-5">
        
        <!-- टॉप बार: बैक बटन और यूज़र नेम -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/" class="back-home-btn"><i class="fa-solid fa-arrow-left me-1"></i> मुख्य होमपेज पर वापस जाएँ</a>
            <div class="fw-semibold text-secondary" style="font-size: 13.5px;">
                <i class="fa-solid fa-user text-success me-1"></i> नागरिक: {{ Auth::user()->name }}
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
            </div>
        @endif

        <!-- 💻 लैपटॉप ग्रिड लेआउट (2 कॉलम स्ट्रक्चर) -->
        <div class="row g-4">
            
            <!-- बायाँ कॉलम: 7. COMPLAINT SUBMISSION (शिकायत फ़ॉर्म) -->
            <div class="col-xl-6 col-lg-6">
                <div class="header-red">7. COMPLAINT SUBMISSION</div>
                <div class="laptop-card">
                    <div class="card-inner d-flex flex-column justify-content-between">
                        
                        <div>
                            <h5 class="fw-bold text-dark mb-4 text-center" style="font-size: 17px;">समस्या रिपोर्ट करें</h5>
                            
                            <!-- 62540.jpg का हूबहू स्टीपर प्रोग्रेस बार -->
                            <div class="stepper">
                                <div class="step-item active">
                                    <div class="step-circle">1</div>
                                    <div class="step-text">जानकारी</div>
                                </div>
                                <div class="step-item">
                                    <div class="step-circle">2</div>
                                    <div class="step-text">फोटो</div>
                                </div>
                                <div class="step-item">
                                    <div class="step-circle">3</div>
                                    <div class="step-text">विवरण</div>
                                </div>
                                <div class="step-item">
                                    <div class="step-circle">4</div>
                                    <div class="step-text">सबमिट</div>
                                </div>
                            </div>

                            <!-- शिकायत फॉर्म फॉर्म -->
                            <form action="/complaint/store" method="POST" enctype="multipart/form-data" id="complaintForm">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">समस्या का प्रकार</label>
                                    <select name="category" class="form-select" required>
                                        <option value="सड़क">सड़क (Road)</option>
                                        <option value="पानी">पानी (Water)</option>
                                        <option value="बिजली">बिजली (Electricity)</option>
                                        <option value="सफाई">सफाई (Cleanliness)</option>
                                        <option value="अन्य">अन्य (Other)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">स्थान / वार्ड</label>
                                    <input type="text" name="ward" class="form-control" placeholder="उदा: वार्ड-05 , रामनगर" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">समस्या का विवरण</label>
                                    <div class="textarea-container">
                                        <!-- तस्वीर 62540.jpg के टेक्स्ट के साथ प्लेसहोल्डर -->
                                        <textarea name="description" class="form-control" rows="4" placeholder="सड़क पर गड्ढे हैं, आवागमन में दिक्कत हो रही है।" required style="padding-right: 50px;"></textarea>
                                        <!-- ग्रीन वॉइस माइक बटन -->
                                        <button type="button" class="mic-btn" onclick="alert('बोलकर लिखने की सेवा शुरू हो रही है...')"><i class="fa-solid fa-microphone"></i></button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">समस्या की फोटो (वैकल्पिक)</label>
                                    <input type="file" name="complaint_image" class="form-control" accept="image/*">
                                </div>
                                
                                <!-- हिडन टाइटल ताकि डेटाबेस लॉजिक न टूटे -->
                                <input type="hidden" name="title" value="नागरिक शिकायत पोर्टल">
                            </form>
                        </div>

                        <!-- सबमिट बटन नीचे फिक्स -->
                        <div class="mt-4">
                            <button type="submit" form="complaintForm" class="btn btn-danger w-100 py-2.5 fw-bold rounded-3" style="font-size: 14.5px; background-color: #dc3545;"><i class="fa-solid fa-paper-plane me-1"></i> आगे बढ़ें</button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- दायाँ कॉलम: 8. COMPLAINT TRACKING (लाइव शिकायत ट्रैकिंग इतिहास) -->
            <div class="col-xl-6 col-lg-6">
                <div class="header-blue">8. COMPLAINT TRACKING</div>
                <div class="laptop-card">
                    <div class="card-inner">
                        <h5 class="fw-bold text-dark mb-4 text-center" style="font-size: 17px;">शिकायत की स्थिति</h5>

                        @php
                            // डेटाबेस से इस लॉगिन यूज़र की सबसे ताज़ा शिकायत निकालना
                            $latestComplaint = \Illuminate\Support\Facades\DB::table('complaints')
                                                ->where('user_id', Auth::id())
                                                ->orderBy('id', 'desc')
                                                ->first();
                        @endphp

                        @if($latestComplaint)
                            <!-- शिकायत इन्फो बॉक्स -->
                            <div class="card border p-3 rounded-3 bg-light-subtle mb-4 shadow-sm position-relative">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 11px;">शिकायत ID</small>
                                        <span class="fw-bold text-dark" style="font-size: 15px;">{{ $latestComplaint->complaint_id }}</span>
                                    </div>
                                    <!-- डायनामिक पेंडिंग/प्रोग्रेस स्टेटस टैग -->
                                    @if($latestComplaint->status == 'Pending')
                                        <span class="badge bg-warning text-dark border px-3 py-1.5 fw-bold" style="font-size: 12px; border-radius: 6px;">Pending</span>
                                    @elseif($latestComplaint->status == 'In Progress')
                                        <span class="badge bg-info text-white border px-3 py-1.5 fw-bold" style="font-size: 12px; border-radius: 6px;">In Progress</span>
                                    @else
                                        <span class="badge bg-success text-white border px-3 py-1.5 fw-bold" style="font-size: 12px; border-radius: 6px;">Resolved</span>
                                    @endif
                                </div>

                                <div class="row g-2 pt-2 border-top" style="font-size: 13px;">
                                    <div class="col-4 text-secondary fw-semibold">तिथि</div>
                                    <div class="col-8 text-dark fw-bold">: {{ date('d मई Y', strtotime($latestComplaint->created_at)) }}</div>

                                    <div class="col-4 text-secondary fw-semibold">प्रकार</div>
                                    <div class="col-8 text-dark fw-bold">: {{ $latestComplaint->category }}</div>

                                    <div class="col-4 text-secondary fw-semibold">स्थान</div>
                                    <div class="col-8 text-dark : fw-bold">: {{ $latestComplaint->ward }}</div>
                                </div>
                            </div>

                            <!-- 62540.jpg का हूबहू अपडेट इतिहास (Timeline) -->
                            <h6 class="fw-bold text-dark mb-3" style="font-size: 14px;"><i class="fa-solid fa-history text-primary me-1"></i> अपडेट इतिहास</h6>
                            
                            <div class="timeline">
                                <!-- स्टेज 1: शिकायत दर्ज की गई -->
                                <div class="timeline-item active">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-title">शिकायत दर्ज की गई</div>
                                    <div class="timeline-date">{{ date('d मई Y, h:i A', strtotime($latestComplaint->created_at)) }}</div>
                                </div>

                                <!-- स्टेज 2: अभी प्रगति पर -->
                                <div class="timeline-item {{ $latestComplaint->status == 'In Progress' || $latestComplaint->status == 'Resolved' ? 'active' : '' }}">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-title">अभी प्रगति पर (In Progress)</div>
                                    <div class="timeline-date">
                                        @if($latestComplaint->status == 'In Progress' || $latestComplaint->status == 'Resolved')
                                            {{ date('d मई Y', strtotime($latestComplaint->updated_at)) }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>

                                <!-- स्टेज 3: समस्या समाधान -->
                                <div class="timeline-item {{ $latestComplaint->status == 'Resolved' ? 'active' : '' }}">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-title">समस्या समाधान (Resolved)</div>
                                    <div class="timeline-date">
                                        @if($latestComplaint->status == 'Resolved')
                                            {{ date('d मई Y', strtotime($latestComplaint->updated_at)) }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- अगर यूज़र ने कोई शिकायत नहीं की है -->
                            <div class="text-center py-5 text-muted">
                                <i class="fa-solid fa-folder-open fs-1 d-block mb-3 text-secondary"></i>
                                आपने अभी तक कोई समस्या रिपोर्ट नहीं की है। जब आप कोई शिकायत दर्ज करेंगे, तो उसका लाइव इतिहास यहाँ दिखाई देगा।
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>