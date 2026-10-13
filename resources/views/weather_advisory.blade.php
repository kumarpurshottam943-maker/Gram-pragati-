<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>मौसम एवं कृषि चेतावनी - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .module-header { background-color: #0d6efd; color: white; font-weight: bold; font-size: 14px; text-transform: uppercase; padding: 12px 20px; border-radius: 8px 8px 0 0; display: flex; align-items: center; justify-content: space-between; }
        .weather-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 25px; }
        .back-btn { font-size: 13.5px; font-weight: 600; color: #475569; text-decoration: none; }
        .back-btn:hover { color: #0d6efd; }
        .forecast-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 15px; text-align: center; transition: transform 0.2s; }
        .forecast-box:hover { transform: translateY(-3px); box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <div class="container py-4" style="max-width: 900px;">
        
        <!-- टॉप नेविगेशन -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/" class="back-btn"><i class="fa-solid fa-arrow-left me-1"></i> मुख्य होमपेज पर लौटें</a>
            <h4 class="fw-bold m-0 text-primary"><i class="fa-solid fa-cloud-sun-rain me-1"></i> मौसम एवं कृषि चेतावनी पोर्टल</h4>
        </div>

        <!-- मुख्य वेदर डैशबोर्ड कार्ड -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="module-header">
                <span>
                    <i class="fa-solid fa-location-dot me-2"></i> वर्तमान लोकेशन: 
                    @auth
                        {{ Auth::user()->location ?? 'सतना, मध्य प्रदेश' }}
                    @else
                        सतना, मध्य प्रदेश (अतिथि)
                    @endauth
                </span>
                <span style="font-size: 12px; background: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 20px;">लाइव अपडेट</span>
            </div>
            <div class="weather-card bg-white">
                
                <!-- वर्तमान मौसम मुख्य विवरण -->
                <div class="row align-items-center mb-4">
                    <div class="col-md-6 text-center text-md-start border-end-md">
                        <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-3">
                            <i class="fa-solid fa-cloud-sun text-warning display-3"></i>
                            <div>
                                <h1 class="fw-bold display-4 m-0 text-dark">28°C</h1>
                                <p class="text-secondary m-0 fw-medium" style="font-size: 15px;">आंशिक रूप से बादल (Partly Cloudy)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3 mt-md-0">
                        <div class="row g-2 text-dark" style="font-size: 13.5px;">
                            <div class="col-6"><i class="fa-solid fa-droplet text-primary me-2"></i> आर्द्रता (Humidity): <strong>62%</strong></div>
                            <div class="col-6"><i class="fa-solid fa-wind text-info me-2"></i> हवा की गति: <strong>12 km/h</strong></div>
                            <div class="col-6 mt-2"><i class="fa-solid fa-gauge-high text-success me-2"></i> वायुदाब: <strong>1012 hPa</strong></div>
                            <div class="col-6 mt-2"><i class="fa-solid fa-umbrella text-warning me-2"></i> बारिश की संभावना: <strong>20%</strong></div>
                        </div>
                    </div>
                </div>

                <!-- ⚠️ कृषि मौसम चेतावनी बॉक्स (Agro Advisory Alert Box) -->
                <div class="alert alert-warning border-0 shadow-sm p-3.5 rounded-3 mb-4" role="alert">
                    <div class="d-flex align-items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation fs-3 text-warning-emphasis mt-1"></i>
                        <div>
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;">किसान भाइयों के लिए विशेष मौसम सलाह (Agro Advisory)</h6>
                            <p class="text-secondary m-0" style="font-size: 13.5px; line-height: 1.5;">
                                आगामी 48 घंटों में आपके क्षेत्र और आसपास के इलाकों में हल्की हवा के साथ बूंदाबांदी की संभावना है। जिन किसानों ने फसल की कटाई कर ली है, वे अपनी उपज को सुरक्षित स्थान पर रखें। रासायनिक कीटनाशकों का छिड़काव फिलहाल टाल दें।
                            </p>
                        </div>
                    </div>
                </div>

                <!-- आगामी 5 दिनों का पूर्वानुमान (5-Day Forecast) -->
                <h5 class="fw-bold text-dark mb-3" style="font-size: 16px;"><i class="fa-solid fa-calendar-week text-primary me-1"></i> आगामी 5 दिनों का मौसम पूर्वानुमान</h5>
                <div class="row g-3">
                    <div class="col">
                        <div class="forecast-box">
                            <small class="text-muted fw-bold">बुधवार</small>
                            <div class="fs-3 text-warning my-1"><i class="fa-solid fa-sun"></i></div>
                            <div class="fw-bold text-dark">31° / 22°</div>
                            <small class="text-success" style="font-size: 11px;">साफ धूप</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="forecast-box">
                            <small class="text-muted fw-bold">गुरुवार</small>
                            <div class="fs-3 text-primary my-1"><i class="fa-solid fa-cloud-sun"></i></div>
                            <div class="fw-bold text-dark">29° / 21°</div>
                            <small class="text-primary" style="font-size: 11px;">आंशिक बादल</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="forecast-box">
                            <small class="text-muted fw-bold">शुक्रवार</small>
                            <div class="fs-3 text-info my-1"><i class="fa-solid fa-cloud-rain"></i></div>
                            <div class="fw-bold text-dark">26° / 19°</div>
                            <small class="text-info" style="font-size: 11px;">हल्की बारिश</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="forecast-box">
                            <small class="text-muted fw-bold">शनिवार</small>
                            <div class="fs-3 text-warning my-1"><i class="fa-solid fa-cloud-sun"></i></div>
                            <div class="fw-bold text-dark">28° / 20°</div>
                            <small class="text-success" style="font-size: 11px;">धूप खिलेगी</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="forecast-box">
                            <small class="text-muted fw-bold">रविवार</small>
                            <div class="fs-3 text-warning my-1"><i class="fa-solid fa-sun"></i></div>
                            <div class="fw-bold text-dark">30° / 21°</div>
                            <small class="text-success" style="font-size: 11px;">साफ मौसम</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>