<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>हरित ग्राम जागरूकता मैनेजमेंट - एडमिन पैनल</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <!-- ऊपर का नेविगेशन -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/admin-dashboard" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> एडमिन डैशबोर्ड</a>
            <h4 class="fw-bold text-success m-0"><i class="fa-solid fa-seedling me-2"></i> हरित ग्राम जागरूकता मैनेजर</h4>
            <div></div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- नया अभियान और वीडियो जोड़ने का एडवांस फॉर्म -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-plus-circle me-1 text-success"></i> नया अभियान व वीडियो जोड़ें</h5>
                    <form action="/admin/green-village/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">शीर्षक (Title)</label>
                            <input type="text" name="title" class="form-control" placeholder="जैसे: ग्रामीण क्षेत्रों में गोबर गैस प्लांट" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">श्रेणी (Category)</label>
                            <select name="category" class="form-control" required>
                                <option value="Tree Plantation">वृक्षारोपण (Tree Plantation)</option>
                                <option value="Solar Energy">सौर ऊर्जा (Solar Energy)</option>
                                <option value="Waste Management">कचरा प्रबंधन (Waste Management)</option>
                                <option value="Water Conservation">जल संरक्षण (Water Conservation)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">विवरण (Description)</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="अभियान की पूरी जानकारी..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small"><i class="fa-solid fa-video text-danger me-1"></i> वीडियो लिंक / पाथ (Video URL)</label>
                            <input type="text" name="video_url" class="form-control" placeholder="जैसे: YouTube लिंक या लोकल पाथ">
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill shadow-sm py-2">
                            <i class="fa-solid fa-floppy-disk me-1"></i> सुरक्षित करें
                        </button>
                    </form>
                </div>
            </div>

            <!-- डायनेमिक सूचियों का एडवांस टेबल व्यू -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list me-1 text-primary"></i> जागरूकता अभियानों व वीडियो की सूची</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>श्रेणी</th>
                                    <th>शीर्षक</th>
                                    <th>विवरण व वीडियो</th>
                                    <th>एक्शन</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                <tr>
                                    <td><span class="badge bg-success">{{ $post->category }}</span></td>
                                    <td class="fw-bold">{{ $post->title }}</td>
                                    <td>
                                        <div class="small text-muted mb-1">{{ $post->description }}</div>
                                        @if(!empty($post->video_url))
                                            <a href="{{ $post->video_url }}" target="_blank" class="badge bg-danger text-decoration-none py-1 px-2">
                                                <i class="fa-solid fa-play-circle me-1"></i> वीडियो लिंक देखें
                                            </a>
                                        @else
                                            <span class="text-muted small italic">कोई वीडियो नहीं</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="/admin/green-village/delete/{{ $post->id }}" method="POST" onsubmit="return confirm('क्या आप वाकई इस अभियान को हटाना चाहते हैं?');">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">कोई जागरूकता अभियान उपलब्ध नहीं है।</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>