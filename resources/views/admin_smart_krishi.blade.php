<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>स्मार्ट कृषि नियंत्रण - एडमिन पैनल</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .sidebar { background-color: #1e293b; min-height: 100vh; color: #94a3b8; width: 260px; position: fixed; top: 0; left: 0; }
        .sidebar-brand { padding: 22px 20px; font-size: 16px; font-weight: bold; color: #ffffff; text-transform: uppercase; border-bottom: 1px solid #334155; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; padding: 11px 20px; border-radius: 8px; margin: 4px 14px; display: flex; align-items: center; text-decoration: none; font-size: 14px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #334155; color: #ffffff !important; }
        .sidebar .nav-link.active { border-left: 4px solid #38bdf8; border-radius: 0 8px 8px 0; margin-left: 0; }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .top-navbar { background-color: white; padding: 15px 30px; border-bottom: 1px solid #e2e8f0; }
        .admin-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.01); }
        .form-label { font-size: 12.5px; font-weight: 600; color: #475569; }
    </style>
</head>
<body>

    <!-- साइडबार पैनल -->
    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="sidebar-brand"><i class="fa-solid fa-gauge-high me-2 text-info"></i> Admin Panel</div>
            <div class="nav flex-column">
                <a class="nav-link" href="/admin-dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a class="nav-link" href="/admin/users"><i class="fa-solid fa-users"></i> User Management</a>
                <a class="nav-link" href="/admin/mandi"><i class="fa-solid fa-wheat-awn"></i> Mandi Management</a>
                <a class="nav-link" href="/admin/notice"><i class="fa-solid fa-bullhorn"></i> News / Notice</a>
                <a class="nav-link" href="/admin/complaints"><i class="fa-solid fa-comment-dots"></i> Complaint Management</a>
                <a class="nav-link text-white active" href="/admin/krishi"><i class="fa-solid fa-seedling text-success"></i> Smart Krishi Config</a>
            </div>
        </div>
    </div>

    <!-- मुख्य एरिया -->
    <div class="main-content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0" style="font-size: 20px;">स्मार्ट कृषि नियंत्रण केंद्र (Smart Krishi Control)</h4>
            <span class="fw-bold text-secondary" style="font-size: 13px;">प्रशासक: {{ Auth::user()->name }}</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success mx-4 mt-3"><i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}</div>
        @endif

        <div class="p-4">
            <div class="row g-4">
                
                <!-- 1. बायाँ कॉलम: लागत गणना फॉर्मूला कॉन्फ़िगरेशन -->
                <div class="col-xl-7 col-lg-7">
                    <div class="admin-card">
                        <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-calculator text-success me-1"></i> फसल लागत अनुपात सेट करें</h5>
                        
                        <form action="/admin/krishi/formula-update" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-4">
                                <label class="form-label">फसल चुनें</label>
                                <select name="crop_name" class="form-select form-select-sm" required>
                                    <option value="गेहूँ">गेहूँ (Wheat)</option>
                                    <option value="धान">धान (Paddy)</option>
                                    <option value="मक्का">मक्का (Maize)</option>
                                    <option value="चरी">उन्नत चरी (चारा)</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">बीज मात्रा (किलो/एकड़)</label>
                                <input type="number" name="seed_per_acre" class="form-control form-control-sm" placeholder="उदा: 40" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">खाद मात्रा (किलो/एकड़)</label>
                                <input type="number" name="fertilizer_per_acre" class="form-control form-control-sm" placeholder="उदा: 160" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">कृषि वैज्ञानिक का विशेष सुझाव (हिंदी में)</label>
                                <textarea name="admin_suggestion" class="form-control form-control-sm" rows="3" placeholder="उदा: संतुलित मात्रा में पोषक तत्व दें और बुवाई के समय कतार से कतार की दूरी २५ सेमी रखें।" required></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-sm btn-success px-3 fw-bold"><i class="fa-solid fa-save me-1"></i> फॉर्मूला लाइव करें</button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <!-- वर्तमान सेव्ड फॉर्मूलों की सूची -->
                        <h6 class="fw-bold text-secondary mb-2" style="font-size: 13px;">वर्तमान सक्रिय अनुपात सूची:</h6>
                        <table class="table table-sm border align-middle m-0" style="font-size: 12.5px;">
                            <thead class="table-light">
                                <tr>
                                    <th>फसल</th>
                                    <th>बीज/एकड़</th>
                                    <th>खाद/एकड़</th>
                                    <th>सुझाव</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($formulas as $f)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $f->crop_name }}</td>
                                        <td>{{ $f->seed_per_acre }} किलो</td>
                                        <td>{{ $f->fertilizer_per_acre }} किलो</td>
                                        <td class="text-muted" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $f->admin_suggestion }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-2">अभी कोई कस्टमाइज्ड फॉर्मूला सेट नहीं है (सिस्टम डिफॉल्ट वैल्यू उपयोग कर रहा है)।</td></tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>

                <!-- 2. दायाँ कॉलम: मौसम अलर्ट जारी करना (तस्वीर 62385_3.png - कार्ड 4 को लाइव चेंज करने हेतु) -->
                <div class="col-xl-5 col-lg-5">
                    <div class="admin-card">
                        <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-bolt text-warning me-1"></i> आपातकालीन मौसम अलर्ट जारी करें</h5>
                        
                        <form action="/admin/krishi/alert-store" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">चेतावनी संदेश (किसानों के होमपेज पर तुरंत चमकेगा)</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="उदा: अगले 2 दिनों में भारी बारिश और ओलावृष्टि की संभावना है। पकी फसलों को काटकर सुरक्षित स्थान पर रखें!" required style="font-size: 13px;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-sm btn-danger w-100 fw-bold py-2"><i class="fa-solid fa-bullhorn me-1"></i> पूरे गाँव को अलर्ट भेजें</button>
                        </form>

                        @if($currentAlert)
                            <div class="mt-4 p-3 rounded-3 border bg-warning-subtle text-dark" style="font-size: 12.5px;">
                                <div class="fw-bold mb-1 text-danger"><i class="fa-solid fa-circle-exclamation"></i> वर्तमान में लाइव अलर्ट संदेश:</div>
                                <span>"{{ $currentAlert->message }}"</span>
                                <small class="d-block text-muted text-end mt-2">जारी तिथि: {{ date('d M, h:i A', strtotime($currentAlert->created_at)) }}</small>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>