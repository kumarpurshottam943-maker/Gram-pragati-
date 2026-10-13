<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>हरित ग्राम जागरूकता एवं जैविक खेती - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-custom { border: none; border-radius: 16px; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-custom:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .icon-box { width: 60px; height: 60px; background: rgba(25, 135, 84, 0.1); color: #198754; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 24px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <div class="container py-5">
        <!-- ऊपर का नेविगेशन -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/" class="btn btn-outline-success btn-sm rounded-pill fw-bold px-3 shadow-sm"><i class="fa-solid fa-arrow-left me-1"></i> होम पर लौटें</a>
            <h3 class="fw-bold text-success m-0"><i class="fa-solid fa-seedling me-2"></i> हरित ग्राम एवं जैविक खेती</h3>
            <div></div>
        </div>

        <!-- शीर्ष बैनर -->
        <div class="alert shadow-sm rounded-4 p-4 mb-4 border-0 text-center text-white bg-success">
            <h4 class="fw-bold mb-2"><i class="fa-solid fa-earth-asia me-2"></i> मिट्टी बचाओ, गाँव हरा-भरा बनाओ</h4>
            <p class="mb-0 text-white-50">जैविक खेती, जल संरक्षण, गोबर गैस और सरकार की हरित पहलों से जुड़े विशेष वीडियो और मार्गदर्शिका।</p>
        </div>

        <!-- डेटाबेस से आने वाले डायनेमिक कार्ड्स ग्रिड -->
        <div class="row g-4">
            @php
                $posts = \Illuminate\Support\Facades\DB::table('green_village_awareness')->latest()->get();
            @endphp

            @if(isset($posts) && count($posts) > 0)
                @foreach($posts as $post)
                    @php
                        // अगर एडमिन ने लिंक डाला है तो वो खुलेगा, नहीं तो टाइटल के हिसाब से YouTube पर सीधे सर्च हो जाएगा
                        $targetUrl = !empty($post->video_url) ? $post->video_url : "https://www.youtube.com/results?search_query=" . urlencode($post->title);
                    @endphp

                    <div class="col-md-4">
                        <div class="card card-custom p-4 h-100 bg-white shadow-sm d-flex flex-column">
                            
                            <!-- प्रोफाइल जैसी आइकॉन हेडर और डायरेक्ट सर्च/ओपन बटन -->
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="icon-box m-0">
                                    <i class="fa-solid fa-leaf"></i>
                                </div>
                                <a href="{{ $targetUrl }}" target="_blank" class="btn btn-danger btn-sm rounded-pill fw-bold px-3 py-2 shadow-sm d-flex align-items-center">
                                    <i class="fa-brands fa-youtube me-1 fs-5"></i> वीडियो देखें
                                </a>
                            </div>

                            <div class="mb-2">
                                <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill fw-bold">{{ $post->category }}</span>
                            </div>

                            <h5 class="fw-bold text-dark mb-2">{{ $post->title }}</h5>
                            <p class="text-muted small mb-3">{{ $post->description }}</p>

                            <!-- नीचे की तरफ एक और बड़ा डायरेक्ट एक्शन बटन -->
                            <div class="mt-auto">
                                <a href="{{ $targetUrl }}" target="_blank" class="btn btn-outline-success w-100 rounded-pill fw-bold shadow-sm py-2">
                                    <i class="fa-solid fa-play-circle me-1"></i> इस विषय पर वीडियो खोजें / चलाएं
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                        <i class="fa-solid fa-seedling fs-1 text-success mb-3"></i>
                        <h5 class="fw-bold text-dark">फिलहाल कोई हरित ग्राम जागरूकता अभियान उपलब्ध नहीं है।</h5>
                        <p class="text-muted small">एडमिन पैनल से नए अभियान जोड़े जाने के बाद वे यहाँ दिखाई देंगे।</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>