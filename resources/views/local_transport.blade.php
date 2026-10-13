<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>परिवहन एवं ट्रैक्टर सेवा - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .transport-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; transition: transform 0.2s; height: 100%; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .transport-card:hover { transform: translateY(-4px); box-shadow: 0 8px 16px rgba(0,0,0,0.06); }
        .vehicle-img { height: 180px; width: 100%; object-fit: cover; border-bottom: 1px solid #e2e8f0; }
        .badge-category { background-color: #fef3c7; color: #d97706; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
    </style>
</head>
<body>

    <div class="container py-5">
        
        <!-- टॉप नेविगेशन -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> होम पर लौटें</a>
            <h4 class="fw-bold m-0 text-success"><i class="fa-solid fa-truck-fast me-2"></i> ग्रामीण परिवहन एवं ट्रैक्टर सेवा</h4>
            <a href="#" class="btn btn-warning btn-sm rounded-pill fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#transportModal">
                <i class="fa-solid fa-plus-circle me-1"></i> अपनी गाड़ी किराए पर लगाएं
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- कैटेगरी फ़िल्टर टैब -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="/local-transport?category=सभी गाड़ी" class="btn btn-sm {{ ($category == 'सभी गाड़ी') ? 'btn-success fw-bold' : 'btn-light border' }}">सभी गाड़ी</a>
            <a href="/local-transport?category=पिकअप / छोटा हाथी" class="btn btn-sm {{ ($category == 'पिकअप / छोटा हाथी') ? 'btn-success fw-bold' : 'btn-light border' }}">🚚 पिकअप / छोटा हाथी</a>
            <a href="/local-transport?category=ट्रैक्टर & ट्रॉली" class="btn btn-sm {{ ($category == 'ट्रैक्टर & ट्रॉली') ? 'btn-success fw-bold' : 'btn-light border' }}">🚜 ट्रैक्टर & ट्रॉली</a>
            <a href="/local-transport?category=लोडर / मालवाहक" class="btn btn-sm {{ ($category == 'लोडर / मालवाहक') ? 'btn-success fw-bold' : 'btn-light border' }}">📦 लोडर / मालवाहक</a>
            <a href="/local-transport?category=जैसीबी / पोक्लेन" class="btn btn-sm {{ ($category == 'जैसीबी / पोक्लेन') ? 'btn-success fw-bold' : 'btn-light border' }}">🏗️ जेसीबी</a>
        </div>

        <!-- वाहनों की लिस्टिंग ग्रिड -->
        <div class="row g-4">
            @forelse($vehicles as $vehicle)
                <div class="col-md-4">
                    <div class="transport-card">
                        @if($vehicle->image_path)
                            <img src="{{ asset($vehicle->image_path) }}" class="vehicle-img" alt="Vehicle Image">
                        @else
                            <img src="https://via.placeholder.com/400x180?text=Vehicle+Image" class="vehicle-img" alt="Default Image">
                        @endif
                        
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge-category">{{ $vehicle->vehicle_type }}</span>
                                <span class="text-success fw-bold" style="font-size: 15px;">₹ {{ $vehicle->price_per_day }} / दिन</span>
                            </div>
                            
                            <h5 class="fw-bold text-dark mb-1" style="font-size: 17px;">{{ $vehicle->vehicle_name }}</h5>
                            <p class="text-muted mb-2" style="font-size: 12.5px;"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $vehicle->location }} | मालिक: {{ $vehicle->owner_name }}</p>
                            
                            @if($vehicle->description)
                                <p class="text-secondary mb-3" style="font-size: 12px; background: #f8fafc; padding: 8px; border-radius: 6px;">{{ $vehicle->description }}</p>
                            @endif

                            <div class="d-flex gap-2">
                                <a href="tel:{{ $vehicle->phone }}" class="btn btn-success btn-sm w-50 fw-bold" style="font-size: 12px;">
                                    <i class="fa-solid fa-phone me-1"></i> कॉल करें
                                </a>
                                <a href="https://wa.me/91{{ $vehicle->phone }}?text=नमस्ते,%20मुझे%20आपकी%20गाड़ी%20({{ $vehicle->vehicle_name }})%20किराए%20पर%20चाहिए।" target="_blank" class="btn btn-outline-success btn-sm w-50 fw-bold" style="font-size: 12px;">
                                    <i class="fa-brands fa-whatsapp me-1"></i> व्हाट्सएप
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="fs-1 text-muted mb-2">🚜</div>
                    <h5 class="text-muted fw-bold">इस श्रेणी में अभी कोई वाहन उपलब्ध नहीं है।</h5>
                    <p class="text-secondary" style="font-size: 13px;">ऊपर दिए गए बटन से आप अपनी गाड़ी सबसे पहले लिस्ट कर सकते हैं!</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- 🔥 वाहन किराए पर सूचीबद्व करने वाला पॉप-अप फॉर्म (Transport Listing Modal) -->
    <div class="modal fade" id="transportModal" tabindex="-1" aria-labelledby="transportModalLabel" aria-hidden="true" style="z-index: 99999;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; overflow: hidden; background: #ffffff;">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold" id="transportModalLabel"><i class="fa-solid fa-truck-fast me-2"></i> अपना परिवहन या वाहन किराए पर लगाएं</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/local-transport/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 13px;">वाहन की श्रेणी (Category)</label>
                            <select name="vehicle_type" class="form-select form-select-sm" required>
                                <option value="पिकअप / छोटा हाथी">🚚 पिकअप / छोटा हाथी (Pickup)</option>
                                <option value="ट्रैक्टर & ट्रॉली">🚜 ट्रैक्टर & ट्रॉली (Tractor & Trolley)</option>
                                <option value="लोडर / मालवाहक">📦 लोडर / मालवाहक (Loader / Carrier)</option>
                                <option value="जैसीबी / पोक्लेन">🏗️ जेसीबी / पोक्लेन (JCB / Earthmover)</option>
                                <option value="अन्य वाहन">🚗 अन्य व्यावसायिक वाहन (Other)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 13px;">वाहन का नाम और मॉडल</label>
                            <input type="text" name="vehicle_name" class="form-control form-control-sm" placeholder="उदा: Tata Ace, Mahindra Bolero" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 13px;">किराया (₹ प्रतिदिन / ट्रिप)</label>
                            <input type="number" name="price_per_day" class="form-control form-control-sm" placeholder="उदा: 1500" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold" style="font-size: 13px;">आपका मोबाइल / WhatsApp</label>
                            <input type="text" name="phone" class="form-control form-control-sm" value="{{ Auth::check() ? Auth::user()->phone : '6299822734' }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold" style="font-size: 13px;">आपका स्थान / क्षेत्र</label>
                            <input type="text" name="location" class="form-control form-control-sm" value="{{ Auth::check() ? Auth::user()->location : 'सतना, मध्य प्रदेश' }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold" style="font-size: 13px;">वाहन की साफ़ फोटो चुनें</label>
                            <input type="file" name="vehicle_image" class="form-control form-control-sm" accept="image/*" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold" style="font-size: 13px;">विशेष विवरण (वैकल्पिक)</label>
                            <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="लोडिंग क्षमता या अन्य जानकारी दें..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-sm btn-secondary fw-bold rounded-pill px-3" data-bs-dismiss="modal">बंद करें</button>
                        <button type="submit" class="btn btn-sm btn-warning fw-bold rounded-pill px-4 shadow-sm"><i class="fa-solid fa-cloud-arrow-up me-1"></i> वाहन बाज़ार में लाइव करें</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>