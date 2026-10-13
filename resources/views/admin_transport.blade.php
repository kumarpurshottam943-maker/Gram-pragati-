<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <title>परिवहन सेवा मैनेजमेंट - एडमिन पैनल</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-success"><i class="fa-solid fa-truck-fast me-2"></i> परिवहन सेवा (Transport) एडमिन कंट्रोल</h3>
            <a href="/admin-dashboard" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> एडमिन डैशबोर्ड</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold mb-3">किराए पर चढ़ाई गई सभी गाड़ियाँ</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>फोटो</th>
                            <th>गाड़ी का नाम / श्रेणी</th>
                            <th>मालिक / फोन</th>
                            <th>लोकेशन</th>
                            <th>किराया (प्रति दिन)</th>
                            <th>कार्रवाई</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vehicles as $v)
                            <tr>
                                <td>{{ $v->id }}</td>
                                <td>
                                    @if($v->image_path)
                                        <img src="{{ asset($v->image_path) }}" width="50" height="50" class="rounded object-fit-cover">
                                    @else
                                        <span class="small text-muted">नहीं है</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $v->vehicle_name }}</strong><br>
                                    <small class="text-muted">{{ $v->vehicle_type }}</small>
                                </td>
                                <td>
                                    {{ $v->owner_name }}<br>
                                    <small class="text-success"><i class="fa-solid fa-phone"></i> {{ $v->phone }}</small>
                                </td>
                                <td>{{ $v->location }}</td>
                                <td class="fw-bold text-success">₹{{ $v->price_per_day }}</td>
                                <td>
                                    <form action="/admin/transport-delete/{{ $v->id }}" method="POST" onsubmit="return confirm('क्या आप वाकई इस वाहन को हटाना चाहते हैं?');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3"><i class="fa-solid fa-trash me-1"></i> हटाएं</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">अभी कोई वाहन किराए पर नहीं चढ़ाया गया है।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>