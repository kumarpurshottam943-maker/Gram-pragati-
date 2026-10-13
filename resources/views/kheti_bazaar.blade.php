<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>खेती बाज़ार - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .navbar-brand { font-weight: bold; font-size: 22px; }
        .section-title { font-weight: 700; border-left: 5px solid #198754; padding-left: 10px; margin-bottom: 20px; }
        .filter-btn { border-radius: 20px; padding: 6px 18px; font-weight: 600; font-size: 14px; text-decoration: none; display: inline-block; margin-right: 5px; margin-bottom: 8px; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: transform 0.2s; background: white; overflow: hidden; }
        .card-custom:hover { transform: translateY(-3px); }
        .tool-img { width: 100%; height: 160px; object-fit: cover; }
        .badge-price { background-color: #f8f9fa; color: #198754; font-weight: 700; font-size: 15px; border-radius: 8px; padding: 6px 10px; border: 1px solid #e9ecef; }
    </style>
</head>
<body>

    <!-- टॉप नेविगेशन बार -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fa-solid fa-wheat-awn me-2"></i> ग्राम प्रगति - खेती बाज़ार</a>
            <a href="/" class="btn btn-light btn-sm fw-bold rounded-pill px-3"><i class="fa-solid fa-arrow-left me-1"></i> मुख्य होमपेज</a>
        </div>
    </nav>

    <div class="container my-4">
        
        <!-- सफलता का मैसेज -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            
            <!-- ========================================================================= -->
            <!-- 🛠️ भाग 1: खेती का OLX (कृषि उपकरण किराए पर लें) - 100% डायनामिक बटन्स -->
            <!-- ========================================================================= -->
            <div class="col-lg-7">
                <div class="p-3 bg-white rounded-3 shadow-sm mb-4">
                    <h4 class="section-title text-success"><i class="fa-solid fa-truck-pickup me-2"></i> खेती का OLX (यंत्र किराए पर लें)</h4>
                    
                    <!-- डायनामिक यंत्र फ़िल्टर बटन्स (जितने यंत्र कैटगरी डेटाबेस में होंगे, खुद-ब-खुद जनरेट होंगे) -->
                    <div class="mb-3">
                        <a href="/kheti-bazaar?tool_category=सभी&product_category={{ $productCategory }}" class="filter-btn {{ $toolCategory == 'सभी' ? 'btn btn-success text-white' : 'btn btn-outline-secondary bg-white' }}">सभी</a>
                        
                        @php
                            $distinctTools = DB::table('rental_tools')->distinct()->pluck('tool_type');
                        @endphp

                        @foreach($distinctTools as $type)
                            @if($type != 'सभी' && !empty($type))
                                <a href="/kheti-bazaar?tool_category={{ $type }}&product_category={{ $productCategory }}" class="filter-btn {{ $toolCategory == $type ? 'btn btn-success text-white' : 'btn btn-outline-secondary bg-white' }}">
                                    {{ $type }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    <!-- लिस्टिंग ग्रिड -->
                    <div class="row g-3">
                        @forelse($allTools as $tool)
                            <div class="col-md-6">
                                <div class="card-custom h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <img src="{{ $tool->image_path ? asset($tool->image_path) : 'https://placehold.co/400x250/e2e8f0/475569?text='.$tool->tool_name }}" class="tool-img" alt="Tool Image">
                                        <div class="p-3">
                                            <span class="badge bg-secondary mb-1" style="font-size: 11px;">{{ $tool->tool_type }}</span>
                                            <h5 class="fw-bold text-dark m-0" style="font-size: 16px;">{{ $tool->tool_name }}</h5>
                                            <small class="text-muted d-block my-1"><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $tool->location }}</small>
                                            <p class="text-secondary mb-2" style="font-size: 12.5px; line-height: 1.4;">{{ $tool->description ?? 'मालिक द्वारा कोई अतिरिक्त विवरण नहीं दिया गया है।' }}</p>
                                        </div>
                                    </div>
                                    <div class="p-3 pt-0 d-flex justify-content-between align-items-center">
                                        <div class="badge-price">₹{{ number_format($tool->price_per_day, 0) }} / दिन</div>
                                        <div class="d-flex gap-1">
                                            <a href="tel:+91{{ $tool->phone }}" class="btn btn-sm btn-primary rounded-circle" title="कॉल करें"><i class="fa-solid fa-phone"></i></a>
                                            <a href="https://wa.me/91{{ $tool->phone }}?text=नमस्ते%20{{ $tool->owner_name }}%20जी,%20मैने%20ग्राम%20प्रगति%20पर%20आपका%20{{ $tool->tool_name }}%20किराए%20के%20लिए%20देखा%20है।" target="_blank" class="btn btn-sm btn-success rounded-circle" style="background-color: #25D366; border:none;" title="व्हाट्सएप चैट"><i class="fa-brands fa-whatsapp"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4">
                                <p class="text-muted m-0">😔 इस श्रेणी में अभी कोई कृषि यंत्र किराए पर उपलब्ध नहीं है भाई।</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- 🍯 भाग 2: गाँव का बाज़ार (Direct Sell) - अनलिमिटेड डायनामिक ई-कॉमर्स बटन्स -->
            <!-- ========================================================================= -->
            <div class="col-lg-5">
                <div class="p-3 bg-white rounded-3 shadow-sm">
                    <h4 class="section-title text-purple" style="border-left-color: #6f42c1;"><i class="fa-solid fa-store me-2 text-purple" style="color: #6f42c1;"></i> गाँव का बाज़ार (सीधे खरीदें)</h4>
                    
                    <!-- उत्पाद डायनामिक फ़िल्टर (दूध, घी, सब्ज़ी, फल आदि जो भी डेटाबेस में आएगा खुद जनरेट होगा) -->
                    <div class="mb-3">
                        <a href="/kheti-bazaar?tool_category={{ $toolCategory }}&product_category=सभी" class="filter-btn {{ $productCategory == 'सभी' ? 'btn text-white' : 'btn btn-outline-secondary bg-white' }}" style="{{ $productCategory == 'सभी' ? 'background-color: #6f42c1;' : '' }}">सभी</a>
                        
                        @php
                            $distinctProducts = DB::table('village_products')->distinct()->pluck('product_category');
                        @endphp

                        @foreach($distinctProducts as $cat)
                            @if($cat != 'सभी' && !empty($cat))
                                <a href="/kheti-bazaar?tool_category={{ $toolCategory }}&product_category={{ $cat }}" class="filter-btn {{ $productCategory == $cat ? 'btn text-white' : 'btn btn-outline-secondary bg-white' }}" style="{{ $productCategory == $cat ? 'background-color: #6f42c1;' : '' }}">
                                    {{ $cat }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    <!-- उत्पाद लिस्टिंग सूचियाँ -->
                    <div class="d-flex flex-column gap-3">
                        @forelse($allProducts as $product)
                            <div class="card p-2 border-0 rounded-3 shadow-sm bg-light" style="border-left: 4px solid #6f42c1 !important;">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $product->image_path ? asset($product->image_path) : 'https://placehold.co/100x100/e2e8f0/475569?text='.$product->product_name }}" class="rounded-3" style="width: 75px; height: 75px; object-fit: cover;" alt="Product">
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold text-dark m-0" style="font-size: 15px;">{{ $product->product_name }}</h6>
                                        <div class="fw-bold text-purple my-1" style="color: #6f42c1; font-size: 14px;">₹{{ number_format($product->price, 0) }}</div>
                                        <small class="text-muted d-block" style="font-size: 11px;"><i class="fa-solid fa-location-dot text-danger"></i> {{ $product->location }} | विक्रेता: {{ $product->seller_name }}</small>
                                    </div>
                                    <div>
                                        <a href="https://wa.me/91{{ $product->phone }}?text=नमस्ते%20{{ $product->seller_name }}%20जी,%20मैने%20ग्राम%20प्रगति%20गाँव%20बाज़ार%20पर%20आपका%20उत्पाद%20{{ $product->product_name }}%20देखा%20है,%20मुझे%20यह%20खरीदना%20है।" target="_blank" class="btn btn-sm text-white px-3 fw-bold rounded-pill" style="background-color: #6f42c1;">खरीदें</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted m-0">📦 इस श्रेणी में अभी कोई घरेलू शुद्ध उत्पाद उपलब्ध नहीं है भाई।</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>