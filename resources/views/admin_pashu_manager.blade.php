<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>पशु स्वास्थ्य मैनेजमेंट - एडमिन पैनल | ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --primary-green: #15803d;
            --light-bg: #f8fafc;
        }
        body { background-color: var(--light-bg); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #334155; }
        .card-custom { border: none; border-radius: 14px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); background: white; margin-bottom: 24px; border: 1px solid #f1f5f9; }
        .table th { background-color: #f8fafc; color: #475569; font-size: 12px; font-weight: 600; }
        .table td { font-size: 13px; vertical-align: middle; }
        .section-title { font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; }
    </style>
</head>
<body>

    <div class="container py-4">
        <!-- टॉप हेडर -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <h3 class="fw-bold text-success m-0" style="font-size: 22px;">
                <i class="fa-solid fa-cow me-2 text-success"></i> पशु स्वास्थ्य सेवाएँ <small class="text-muted fw-normal" style="font-size: 14px;">| एडमिन कंट्रोल पैनल</small>
            </h3>
            <a href="/admin-dashboard" class="btn btn-outline-secondary btn-sm fw-semibold rounded-pill px-3">
                <i class="fa-solid fa-arrow-left me-1"></i> एडमिन डैशबोर्ड
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            
            <!-- 1. फॉर्म: नया डॉक्टर या एम्बुलेंस जोड़ने के लिए -->
            <div class="col-lg-5">
                <div class="card card-custom p-4 border-top border-success border-4">
                    <div class="section-title text-success">
                        <i class="fa-solid fa-plus-circle me-2"></i> नया डॉक्टर या एम्बुलेंस जोड़ें
                    </div>
                    <form action="/admin/pashu-service/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">सेवा का प्रकार (Type):</label>
                            <select name="type" class="form-select form-select-sm rounded-3 py-2" required>
                                <option value="doctor">पशु चिकित्सक (Doctor)</option>
                                <option value="ambulance">मोबाइल एम्बुलेंस (Ambulance)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">नाम (डॉक्टर का नाम / वैन नाम):</label>
                            <input type="text" name="title" class="form-control form-control-sm rounded-3 py-2" placeholder="जैसे: डॉ. आर. के. शर्मा" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">फोन नंबर (डेटाबेस आधारित डायरेक्ट कॉल):</label>
                            <input type="text" name="phone" class="form-control form-control-sm rounded-3 py-2" placeholder="जैसे: 9876543210" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">क्षेत्र / विवरण (Location / Details):</label>
                            <textarea name="description" class="form-control form-control-sm rounded-3" rows="2" placeholder="राजकीय पशु चिकित्सा अस्पताल, लखीसराय"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm w-100 fw-bold py-2 shadow-sm rounded-3">डेटाबेस में सुरक्षित करें</button>
                    </form>
                </div>
            </div>

            <!-- 2. लिस्ट: जो डॉक्टर/एम्बुलेंस डेटाबेस में पहले से जुड़े हैं -->
            <div class="col-lg-7">
                <div class="card card-custom p-4 border-top border-primary border-4">
                    <div class="section-title text-primary">
                        <i class="fa-solid fa-list me-2"></i> दर्ज पशु स्वास्थ्य सेवाएँ (Doctors & Ambulances)
                    </div>
                    <div class="table-responsive" style="max-height: 280px; overflow-y: auto;">
                        <table class="table table-bordered table-sm align-middle">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>प्रकार</th>
                                    <th>नाम</th>
                                    <th>मोबाइल नंबर</th>
                                    <th>विवरण</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($services)
                                    @forelse($services as $item)
                                        <tr>
                                            <td><span class="badge bg-{{ $item->type == 'doctor' ? 'success' : 'danger' }}">{{ ucfirst($item->type) }}</span></td>
                                            <td><strong>{{ $item->title }}</strong></td>
                                            <td><a href="tel:{{ $item->phone }}" class="text-decoration-none fw-bold text-primary">{{ $item->phone }}</a></td>
                                            <td><small class="text-muted">{{ $item->description }}</small></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">अभी कोई डॉक्टर या एम्बुलेंस नहीं जोड़ी गई है।</td>
                                        </tr>
                                    @endforelse
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 3. नया सेक्शन: टीकाकरण रिमाइंडर (Vaccination Campaign Manager) -->
            <div class="col-lg-4">
                <div class="card card-custom p-4 border-top border-warning border-4">
                    <div class="section-title text-warning">
                        <i class="fa-solid fa-bell me-2"></i> टीकाकरण शेड्यूलर जोड़ें
                    </div>
                    <form action="/admin/pashu-vaccine/store" method="POST">
                        @csrf
                        <div class="mb-2">
                            <input type="text" name="vaccine_name" class="form-control form-control-sm rounded-3 py-2" placeholder="टीके का नाम (उदा: FMD Vaccine)" required>
                        </div>
                        <div class="mb-2">
                            <input type="date" name="camp_date" class="form-control form-control-sm rounded-3 py-2" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="location" class="form-control form-control-sm rounded-3 py-2" placeholder="ग्राम पंचायत / स्थान" required>
                        </div>
                        <button type="submit" class="btn btn-warning btn-sm w-100 fw-bold text-dark py-2 shadow-sm rounded-3">टीकाकरण कैंपेन लाइव करें</button>
                    </form>
                </div>
            </div>

            <!-- 4. नया सेक्शन: मोबाइल एम्बुलेंस यूनिट शेड्यूलर (Ambulance Tracker Update) -->
            <div class="col-lg-4">
                <div class="card card-custom p-4 border-top border-danger border-4">
                    <div class="section-title text-danger">
                        <i class="fa-solid fa-truck-medical me-2"></i> एम्बुलेंस वैन शेड्यूल अपडेट
                    </div>
                    <form action="/admin/pashu-ambulance/store" method="POST">
                        @csrf
                        <div class="mb-2">
                            <input type="text" name="van_number" class="form-control form-control-sm rounded-3 py-2" placeholder="वैन नंबर (उदा: MP-19-V-2026)" required>
                        </div>
                        <div class="mb-2">
                            <input type="text" name="village_name" class="form-control form-control-sm rounded-3 py-2" placeholder="किस गाँव में जाएगी?" required>
                        </div>
                        <div class="mb-3">
                            <input type="date" name="visit_date" class="form-control form-control-sm rounded-3 py-2" required>
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold py-2 shadow-sm rounded-3">एम्बुलेंस शेड्यूल लाइव करें</button>
                    </form>
                </div>
            </div>

            <!-- 5. नया सेक्शन: पशु बाज़ार हेल्थ सर्टिफिकेट अप्रूवल & QR जनरेटर -->
            <div class="col-lg-4">
                <div class="card card-custom p-4 border-top border-info border-4">
                    <div class="section-title text-info">
                        <i class="fa-solid fa-file-shield me-2"></i> हेल्थ सर्टिफिकेट अप्रूवल
                    </div>
                    <div class="table-responsive" style="max-height: 220px; overflow-y: auto;">
                        <table class="table table-sm align-middle m-0">
                            <thead>
                                <tr>
                                    <th>किसान / टैग</th>
                                    <th>बाज़ार</th>
                                    <th>एक्शन</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($certificates)
                                    @forelse($certificates as $cert)
                                        <tr>
                                            <td><strong>{{ $cert->animal_tag }}</strong><br><small class="text-muted">{{ $cert->farmer_name }}</small></td>
                                            <td><small>{{ $cert->market_name }}</small></td>
                                            <td>
                                                @if($cert->status == 'Pending')
                                                    <form action="/admin/pashu-certificate/approve/{{ $cert->id }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success py-0 px-2" style="font-size: 11px;">Approve</button>
                                                    </form>
                                                @else
                                                    <span class="badge bg-success" style="font-size: 10px;">{{ $cert->certificate_no }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-2 small">कोई नया आवेदन नहीं है।</td>
                                        </tr>
                                    @endforelse
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>  