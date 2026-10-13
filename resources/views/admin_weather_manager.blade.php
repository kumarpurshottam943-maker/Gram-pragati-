<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>एडमिन - मौसम एवं कृषि चेतावनी मैनेजमेंट</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .module-header { background-color: #1e293b; color: white; font-weight: bold; font-size: 15px; padding: 15px 20px; border-radius: 10px 10px 0 0; display: flex; align-items: center; justify-content: space-between; }
        .admin-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 30px; }
        .back-btn { font-size: 13.5px; font-weight: 600; color: #475569; text-decoration: none; }
        .back-btn:hover { color: #0d6efd; }
    </style>
</head>
<body>

    <div class="container py-5" style="max-width: 900px;">
        
        <!-- टॉप नेविगेशन -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/admin-dashboard" class="back-btn"><i class="fa-solid fa-arrow-left me-1"></i> एडमिन डैशबोर्ड पर लौटें</a>
            <h4 class="fw-bold m-0 text-success"><i class="fa-solid fa-cloud-sun-rain me-1"></i> मौसम एवं कृषि चेतावनी नियंत्रण पैनल</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- 1. वर्तमान मौसम चेतावनी अपडेट करने का फॉर्म -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="module-header">
                <span><i class="fa-solid fa-sliders me-2"></i> किसानों के लिए वर्तमान मौसम चेतावनी और सलाह अपडेट करें</span>
                <span class="badge bg-success">Alert Control</span>
            </div>
            <div class="admin-card">
                <form action="/admin/weather-advisory/update" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark" style="font-size: 14px;">सक्रिय चेतावनी / सलाह संदेश (Alert Message)</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="यहाँ किसानों के लिए नई मौसम चेतावनी या कृषि सलाह लिखें..." required>{{ $currentAlert->message ?? '' }}</textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold rounded-pill shadow-sm" style="font-size: 14px;">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> चेतावनी लाइव करें
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 2. आगामी दिनों का मौसम पूर्वानुमान (Forecast) अपडेट करने का फॉर्म -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="module-header" style="background-color: #0d6efd;">
                <span><i class="fa-solid fa-calendar-week me-2"></i> आगामी दिनों का तापमान और मौसम पूर्वानुमान अपडेट करें</span>
                <span class="badge bg-primary">Forecast Control</span>
            </div>
            <div class="admin-card">
                <form action="/admin/weather-forecast/update" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="font-size: 13.5px;">दिन का नाम (Day)</label>
                            <select name="day_name" class="form-select" required>
                                <option value="बुधवार">बुधवार</option>
                                <option value="गुरुवार">गुरुवार</option>
                                <option value="शुक्रवार">शुक्रवार</option>
                                <option value="शनिवार">शनिवार</option>
                                <option value="रविवार">रविवार</option>
                                <option value="सोमवार">सोमवार</option>
                                <option value="मंगलवार">मंगलवार</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="font-size: 13.5px;">तापमान (Temperature)</label>
                            <input type="text" name="temperature" class="form-control" placeholder="उदा: 31° / 22°" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" style="font-size: 13.5px;">मौसम की स्थिति (Condition)</label>
                            <input type="text" name="condition_text" class="form-control" placeholder="उदा: साफ धूप / हल्की बारिश" required>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-pill shadow-sm" style="font-size: 14px;">
                            <i class="fa-solid fa-sync me-1"></i> फोरकास्ट अपडेट करें
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>