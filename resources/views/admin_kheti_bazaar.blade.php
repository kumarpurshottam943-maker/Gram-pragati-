<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>खेती बाज़ार नियंत्रण - एडमिन पैनल</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .sidebar { background-color: #1e293b; min-height: 100vh; color: #94a3b8; width: 260px; position: fixed; top: 0; left: 0; }
        .sidebar-brand { padding: 22px 20px; font-size: 16px; font-weight: bold; color: #ffffff; text-transform: uppercase; border-bottom: 1px solid #334155; }
        .sidebar .nav-link { color: #94a3b8; font-weight: 500; padding: 11px 20px; border-radius: 8px; margin: 4px 14px; display: flex; align-items: center; text-decoration: none; font-size: 14px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #334155; color: #ffffff !important; }
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
                <a class="nav-link" href="/admin/schemes"><i class="fa-solid fa-layer-group"></i> Scheme Management</a>
                <a class="nav-link text-white active" href="/admin/kheti-bazaar"><i class="fa-solid fa-tractor"></i> Kheti Bazaar Control</a>
                <a class="nav-link" href="/admin/complaints"><i class="fa-solid fa-comment-dots"></i> Complaint Management</a>
                <a class="nav-link" href="/admin/mandi"><i class="fa-solid fa-wheat-awn"></i> Mandi Management</a>
                <a class="nav-link" href="/admin/notice"><i class="fa-solid fa-bullhorn"></i> News / Notice</a>
            </div>
        </div>
    </div>

    <!-- मुख्य एरिया -->
    <div class="main-content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0" style="font-size: 20px;">खेती बाज़ार प्रबंधन केंद्र (Kheti Bazaar Control)</h4>
            <span class="fw-bold text-secondary" style="font-size: 13px;">प्रशासक: Purshottam Kumar</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success mx-4 mt-3"><i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}</div>
        @endif

        <div class="p-4">
            <div class="row g-4">
                
                <!-- फॉर्म 1: व्हाट्सएप पर आए टूल को लाइव करने का फॉर्म -->
                <div class="col-xl-6 col-lg-6">
                    <div class="admin-card">
                        <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-plus-circle text-success me-1"></i> व्हाट्सएप वाली मशीन लाइव करें</h5>
                        <form action="/admin/kheti-bazaar/store-tool" method="POST" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">किसान (मालिक) का नाम</label>
                                <input type="text" name="owner_name" class="form-control form-control-sm" placeholder="उदा: रामप्रसाद सिंह" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">यंत्र का प्रकार</label>
                                <select name="tool_type" id="admin_tool_select" class="form-select form-select-sm" onchange="toggleAdminToolInput(this)" required>
                                    <option value="ट्रैक्टर">🚜 ट्रैक्टर</option>
                                    <option value="थ्रेशर">🌾 थ्रेशर मशीन</option>
                                    <option value="पंप">💧 पानी का पंप</option>
                                    <option value="स्प्रेयर">🌱 पावर स्प्रेयर</option>
                                    <option value="अन्य">➕ अन्य यंत्र (खुद लिखें)</option>
                                </select>
                                <!-- खुद से नया यंत्र टाइप करने का बॉक्स -->
                                <input type="text" id="admin_other_tool_input" class="form-control form-control-sm mt-2 d-none" placeholder="नए यंत्र का नाम लिखें (जैसे: हार्वेस्टर)">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">मॉडल / कंपनी का नाम</label>
                                <input type="text" name="tool_name" class="form-control form-control-sm" placeholder="उदा: John Deere 5310" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">किराया (₹ प्रति दिन)</label>
                                <input type="number" name="price_per_day" class="form-control form-control-sm" placeholder="उदा: 1500" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">किसान का मोबाइल नंबर</label>
                                <input type="text" name="phone" class="form-control form-control-sm" placeholder="उदा: 9876543210" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">किसान की लोकेशन / गाँव</label>
                                <input type="text" name="location" class="form-control form-control-sm" placeholder="उदा: सतना, मध्य प्रदेश" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">मशीन की फोटो अपलोड करें</label>
                                <input type="file" name="tool_image" class="form-control form-control-sm" accept="image/*" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">मशीन का विवरण</label>
                                <textarea name="description" class="form-control form-control-sm" rows="2" placeholder="मशीन की स्थिति या साथ मिलने वाले सामान का विवरण..."></textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-sm btn-success px-3 fw-bold"><i class="fa-solid fa-save me-1"></i> यंत्र लाइव करें</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- फॉर्म 2: गाँव का बाज़ार उत्पाद अपलोडर -->
                <div class="col-xl-6 col-lg-6">
                    <div class="admin-card">
                        <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-store text-purple me-1" style="color: #6f42c1;"></i> गाँव का नया उत्पाद बाज़ार में लाइव करें</h5>
                        <form action="/admin/kheti-bazaar/store-product" method="POST" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">विक्रेता का नाम</label>
                                <input type="text" name="seller_name" class="form-control form-control-sm" placeholder="जैसे: राधा महिला समूह" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">उत्पाद की श्रेणी</label>
                                <select name="product_category" id="admin_product_select" class="form-select form-select-sm" onchange="toggleAdminProductInput(this)" required>
                                    <option value="घी">🍯 घी / दूध उत्पाद</option>
                                    <option value="शहद">🐝 शुद्ध शहद</option>
                                    <option value="अनाज">🌾 अनाज / फसल</option>
                                    <option value="हस्तशिल्प">👜 हस्तशिल्प / अन्य</option>
                                    <option value="अन्य">➕ अन्य उत्पाद श्रेणी (खुद लिखें)</option>
                                </select>
                                <!-- खुद से नई उत्पाद श्रेणी टाइप करने का बॉक्स -->
                                <input type="text" id="admin_other_product_input" class="form-control form-control-sm mt-2 d-none" placeholder="नई श्रेणी लिखें (जैसे: सब्जियां, फल)">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">उत्पाद का नाम व मात्रा</label>
                                <input type="text" name="product_name" class="form-control form-control-sm" placeholder="जैसे: शुद्ध गाय का घी (1kg)" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">कुल कीमत (₹)</label>
                                <input type="number" name="price" class="form-control form-control-sm" placeholder="जैसे: 550" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">विक्रेता का मोबाइल नंबर</label>
                                <input type="text" name="phone" class="form-control form-control-sm" placeholder="उदा: 6299822734" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">लोकेशन / गाँव</label>
                                <input type="text" name="location" class="form-control form-control-sm" placeholder="उदा: सतना, MP" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">उत्पाद की साफ़ फोटो चुनें</label>
                                <input type="file" name="product_image" class="form-control form-control-sm" accept="image/*" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">विवरण</label>
                                <input type="text" name="description" class="form-control form-control-sm" placeholder="घर का बना 100% शुद्ध और जैविक उत्पाद...">
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-sm btn-primary px-3 fw-bold" style="background-color: #6f42c1; border:none;"><i class="fa-solid fa-share-node me-1"></i> उत्पाद लाइव करें</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- भाग 3: लाइव लिस्टिंग डिलीट/मैनेजमेंट तालिका -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="admin-card">
                        <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-list-check text-warning me-1"></i> वर्तमान लाइव कृषि यंत्र लिस्टिंग</h5>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped" style="font-size: 13px;">
                                <thead class="table-dark">
                                    <tr>
                                        <th>आईडी</th>
                                        <th>फोटो</th>
                                        <th>मशीन का नाम</th>
                                        <th>मालिक का नाम</th>
                                        <th>किराया / दिन</th>
                                        <th>लोकेशन</th>
                                        <th>फोन नंबर</th>
                                        <th class="text-center">एक्शन</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($adminTools as $tool)
                                        <tr>
                                            <td>#{{ $tool->id }}</td>
                                            <td>
                                                <img src="{{ asset($tool->image_path) }}" style="width: 45px; height: 35px; object-fit: cover; border-radius: 4px;">
                                            </td>
                                            <td class="fw-bold">{{ $tool->tool_name }}</td>
                                            <td>{{ $tool->owner_name }}</td>
                                            <td class="text-success fw-bold">₹{{ number_format($tool->price_per_day, 0) }}</td>
                                            <td>{{ $tool->location }}</td>
                                            <td>{{ $tool->phone }}</td>
                                            <td class="text-center">
                                                <form action="/admin/kheti-bazaar/delete-tool/{{ $tool->id }}" method="POST" onsubmit="return confirm('क्या आप वाकई इस लिस्टिंग को हटाना चाहते हैं भाई?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger px-2 py-1" style="font-size: 11px;"><i class="fa-solid fa-trash"></i> हटाएं</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">बाज़ार में अभी कोई लाइव मशीन नहीं चल रही है भाई।</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- जावास्क्रिप्ट: 'अन्य' चुनने पर इनपुट बॉक्स को लाइव टॉगल करने का लॉजिक -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // यंत्र फॉर्म के लिए टॉगल फंक्शन
        function toggleAdminToolInput(selectElement) {
            var otherInput = document.getElementById('admin_other_tool_input');
            if(selectElement.value === 'अन्य') {
                otherInput.classList.remove('d-none');
                otherInput.required = true;
                otherInput.name = "tool_type";
                selectElement.removeAttribute('name');
            } else {
                otherInput.classList.add('d-none');
                otherInput.required = false;
                otherInput.removeAttribute('name');
                selectElement.name = "tool_type";
            }
        }

        // उत्पाद फॉर्म के लिए टॉगल फंक्शन
        function toggleAdminProductInput(selectElement) {
            var otherInput = document.getElementById('admin_other_product_input');
            if(selectElement.value === 'अन्य') {
                otherInput.classList.remove('d-none');
                otherInput.required = true;
                otherInput.name = "product_category";
                selectElement.removeAttribute('name');
            } else {
                otherInput.classList.add('d-none');
                otherInput.required = false;
                otherInput.removeAttribute('name');
                selectElement.name = "product_category";
            }
        }
    </script>
</body>
</html>