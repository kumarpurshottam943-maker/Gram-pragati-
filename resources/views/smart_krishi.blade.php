<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>स्मार्ट कृषि हब - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .module-header { background-color: #198754; color: white; font-weight: bold; font-size: 14px; text-transform: uppercase; padding: 10px; border-radius: 8px 8px 0 0; text-align: center; }
        .krishi-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; min-height: 580px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        
        /* चैटबॉट डिज़ाइन */
        .chat-box { height: 260px; overflow-y: auto; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-bottom: 12px; }
        .chat-message { margin-bottom: 12px; max-width: 85%; padding: 10px 14px; border-radius: 12px; font-size: 13.5px; line-height: 1.4; }
        .chat-message.bot { background-color: #e2f0d9; color: #2d3748; align-self: flex-start; border-top-left-radius: 0; }
        .chat-message.user { background-color: #198754; color: white; align-self: flex-end; margin-left: auto; border-top-right-radius: 0; }
        
        .alert-orange { background-color: #fff3cd; border-left: 4px solid #ffc107; color: #856404; padding: 10px; border-radius: 6px; font-size: 12.5px; }
        .back-btn { font-size: 13.5px; font-weight: 600; color: #475569; text-decoration: none; }
        .back-btn:hover { color: #198754; }
    </style>
</head>
<body>

    <div class="container-fluid py-4 px-5">
        
        <!-- टॉप बार -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="/" class="back-btn"><i class="fa-solid fa-arrow-left me-1"></i> मुख्य होमपेज पर जाएँ</a>
            <h4 class="fw-bold m-0 text-success"><i class="fa-solid fa-seedling me-1"></i> स्मार्ट कृषि डिजिटल हब (Smart Krishi)</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> <strong>परिणाम:</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            
            <!-- बायाँ कॉलम: लागत गणना, मौसम अलर्ट और Crop Doctor AI -->
            <div class="col-xl-6 col-lg-6">
                <div class="module-header" style="background-color: #2e7d32;">3. COST CALCULATOR & WEATHER & CROP DOCTOR</div>
                <div class="krishi-card p-4" style="min-height: 650px;">
                    
                    <!-- लागत गणना फॉर्म -->
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 14px;"><i class="fa-solid fa-calculator text-success me-1"></i> लागत गणना (Cost Optimizer)</h6>
                    <form action="/smart-krishi/calculate" method="POST" class="row g-2 mb-3">
                        @csrf
                        <div class="col-md-5">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 11.5px;">फसल चुनें</label>
                            <select name="crop_name" class="form-select form-select-sm" required>
                                <option value="गेहूँ" {{ isset($result) && $result['crop_name'] == 'गेहूँ' ? 'selected' : '' }}>गेहूँ (Wheat)</option>
                                <option value="धान" {{ isset($result) && $result['crop_name'] == 'धान' ? 'selected' : '' }}>धान (Paddy)</option>
                                <option value="मक्का" {{ isset($result) && $result['crop_name'] == 'मक्का' ? 'selected' : '' }}>मक्का (Maize)</option>
                                <option value="चरी" {{ isset($result) && $result['crop_name'] == 'चरी' ? 'selected' : '' }}>उन्नत चरी (चारा)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-secondary" style="font-size: 11.5px;">आकार (एकड़)</label>
                            <input type="number" name="acreage" class="form-control form-control-sm" placeholder="उदा: 2" value="{{ $result['acreage'] ?? '' }}" required>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-success btn-sm w-100 fw-bold" style="font-size: 12px;"><i class="fa-solid fa-sync me-1"></i> गणना</button>
                        </div>
                        
                        @if(isset($config))
                            <input type="hidden" name="tillage_rate" value="{{ $config->tillage_cost }}">
                            <input type="hidden" name="seed_rate" value="{{ $config->seed_cost }}">
                            <input type="hidden" name="fertilizer_rate" value="{{ $config->fertilizer_cost }}">
                            <input type="hidden" name="labor_rate" value="{{ $config->labor_cost }}">
                        @endif
                    </form>

                    <!-- गणना का रिस्पॉन्स बॉक्स -->
                    @if(isset($result))
                        <div class="p-2.5 border rounded-3 bg-light mb-3 shadow-sm" style="font-size: 12.5px;">
                            <div class="fw-bold text-success mb-1"><i class="fa-solid fa-circle-check"></i> अनुमानित लागत ({{ $result['crop_name'] }}):</div>
                            <div class="row g-1 text-dark">
                                <div class="col-6">🌾 बीज: <strong>{{ $result['total_seed'] }} किग्रा</strong></div>
                                <div class="col-6">🧪 खाद: <strong>{{ $result['total_fertilizer'] }} किग्रा</strong></div>
                                @if(isset($result['total_cost']))
                                    <div class="col-12 text-danger mt-1">💰 कुल खर्च: <strong>₹ {{ number_format($result['total_cost']) }}</strong></div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <hr class="my-3 text-muted">

                    <!-- 🔥 फसल डॉक्टर एआई (Crop Doctor AI) - स्वतंत्र फॉर्म और विशेषज्ञ संवाद बॉक्स -->
                    <div class="p-3 border rounded-3 bg-success-subtle mb-3" style="border-color: #a3d9a5 !important;">
                        <h6 class="fw-bold text-success mb-1" style="font-size: 13.5px;"><i class="fa-solid fa-camera-retro me-1"></i> फसल डॉक्टर एआई (Crop Doctor AI & Expert Review)</h6>
                        <p class="text-muted mb-2" style="font-size: 11.5px;">खराब फसल या सूखी जड़ की फोटो अपलोड करें, AI और हमारे कृषि विशेषज्ञ तुरंत समाधान देंगे।</p>
                        
                        <form action="/smart-krishi/analyze-crop" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group input-group-sm mb-2">
                                <input type="file" name="crop_image" class="form-control" accept="image/*" required>
                                <button type="submit" class="btn btn-success fw-bold px-3"><i class="fa-solid fa-wand-magic-sparkles me-1"></i> जांच करें</button>
                            </div>
                        </form>

                        <!-- 🌟 विशेषज्ञ समाधान बॉक्स (Expert & AI Response Box): किसान को यहीं एआई और विशेषज्ञ का जवाब दिखेगा -->
                        @if(isset($latestDiagnosis) && $latestDiagnosis)
                            <div class="mt-3 p-3 bg-white rounded border shadow-sm" style="font-size: 13px;">
                                <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-1">
                                    <span class="fw-bold text-success"><i class="fa-solid fa-user-doctor me-1"></i> फसल रिपोर्ट & स्थिति:</span>
                                    <span class="badge bg-{{ $latestDiagnosis->status == 'Resolved by Expert' ? 'primary' : 'warning text-dark' }}">
                                        {{ $latestDiagnosis->status }}
                                    </span>
                                </div>

                                <div class="row align-items-center g-2">
                                    @if($latestDiagnosis->image_path)
                                        <div class="col-md-4 text-center">
                                            <img src="{{ asset($latestDiagnosis->image_path) }}" alt="Crop Photo" class="img-fluid rounded border" style="max-height: 90px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <div class="{{ $latestDiagnosis->image_path ? 'col-md-8' : 'col-md-12' }}">
                                        <p class="mb-1 text-dark"><strong>एआई / कृषि विशेषज्ञ का संदेश:</strong></p>
                                        <p class="mb-0 text-secondary bg-light p-2 rounded border-0" style="font-size: 12.5px;">
                                            {{ $latestDiagnosis->ai_response }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif(session('success'))
                            <!-- यदि डेटाबेस वेरिएबल पास नहीं हुआ तो सेशन से दिखाएगा -->
                            <div class="mt-3 p-2.5 bg-white rounded border shadow-sm" style="font-size: 12.5px;">
                                <div class="fw-bold text-success mb-1"><i class="fa-solid fa-circle-check"></i> एआई विजन जांच परिणाम:</div>
                                <p class="mb-2 text-dark">{{ session('success') }}</p>
                                @if(session('uploadedImage'))
                                    <div class="text-center bg-light p-2 rounded border">
                                        <small class="text-muted d-block mb-1">अपलोड की गई फसल की फोटो:</small>
                                        <img src="{{ session('uploadedImage') }}" alt="Uploaded Crop" class="img-fluid rounded" style="max-height: 110px; object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- एडमिन कृषि सलाह और मौसम -->
                    <div class="alert alert-success mb-2 p-2.5 shadow-sm border-0" style="background-color: #e8f5e9; color: #1b5e20; font-size: 12px;">
                        <i class="fa-solid fa-bullhorn me-1"></i>
                        <strong>कृषि सलाह:</strong> {{ isset($config) && $config->advisory_message ? $config->advisory_message : 'समय पर फसलों की सिंचाई करें।' }}
                    </div>

                    <div class="d-flex justify-content-between align-items-center bg-light p-2 rounded-3 border mb-2" style="font-size: 12.5px;">
                        <div><span class="fs-4 fw-bold text-dark me-2">28°C</span> सतना, म.प्र.</div>
                        <div class="text-secondary text-end">आर्द्रता: 65% | हवा: 12 km/h</div>
                    </div>

                    <div class="alert-orange py-1.5" style="font-size: 11.5px;">
                        <i class="fa-solid fa-triangle-exclamation text-warning me-1"></i>
                        <strong>मौसम अलर्ट:</strong> {{ isset($liveAlert) && $liveAlert ? $liveAlert->message : 'अगले 2 दिनों में मौसम सामान्य रहेगा।' }}
                    </div>

                </div>
            </div>

            <!-- दायाँ कॉलम: 10. AI CHATBOT (KISANMITRA AI) -->
            <div class="col-xl-6 col-lg-6">
                <div class="module-header" style="background-color: #4527a0;">10. AI CHATBOT (KISANMITRA AI)</div>
                <div class="krishi-card p-4 d-flex flex-column justify-content-between" style="min-height: 650px;">
                    <div>
                        <div class="d-flex align-items-center gap-2 border-bottom pb-2 mb-3">
                            <div class="bg-purple text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background-color: #4527a0;"><i class="fa-solid fa-robot"></i></div>
                            <div>
                                <strong class="d-block text-dark" style="font-size: 14px;">KisanMitra AI (उन्नत कृषि सहायक)</strong>
                                <small class="text-success fw-bold" style="font-size: 11px;">🟢 Online & Trained on 100+ Expert Queries</small>
                            </div>
                        </div>

                        <!-- चैट मैसेजेस डिस्प्ले एरिया -->
                        <div class="chat-box d-flex flex-column" id="chatDisplay">
                            <div class="chat-message bot">
                                राम-राम किसान भाई! मैं **KisanMitra AI** हूँ। आप मुझसे गेहूँ, धान, मक्का की पैदावार, कीट नियंत्रण, खाद की मात्रा, या सरकारी योजनाओं के बारे में कुछ भी पूछ सकते हैं। बताइए क्या मदद करूँ? 😊
                            </div>
                        </div>
                    </div>

                    <!-- चैट इनपुट फॉर्म -->
                    <div class="input-group">
                        <input type="text" id="userInput" class="form-control shadow-none" placeholder="यहाँ सवाल पूछें (उदा: गेहूँ में कौन सी खाद डालें?)..." style="font-size: 13.5px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="startVoiceSearch()"><i class="fa-solid fa-microphone text-success" id="micIcon"></i></button>
                        <button class="btn btn-success px-4" type="button" id="sendBtn" style="background-color: #198754;"><i class="fa-solid fa-paper-plane"></i></button>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- जावास्क्रिप्ट (AJAX चैट और वॉइस सर्च लॉजिक) -->
    <script>
        document.getElementById('sendBtn').addEventListener('click', sendMessage);
        document.getElementById('userInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendMessage();
        });

        function startVoiceSearch() {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                alert('आपका ब्राउज़र बोलकर पूछने की अनुमति नहीं देता।');
                return;
            }
            const recognition = new SpeechRecognition();
            recognition.lang = 'hi-IN';
            recognition.onresult = function(event) {
                document.getElementById('userInput').value = event.results[0][0].transcript;
                sendMessage();
            };
            recognition.start();
        }

        function sendMessage() {
            const inputField = document.getElementById('userInput');
            const messageText = inputField.value.trim();
            if (!messageText) return;

            const chatDisplay = document.getElementById('chatDisplay');

            const userDiv = document.createElement('div');
            userDiv.className = 'chat-message user';
            userDiv.innerText = messageText;
            chatDisplay.appendChild(userDiv);
            inputField.value = '';
            chatDisplay.scrollTop = chatDisplay.scrollHeight;

            fetch('/smart-krishi/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: messageText })
            })
            .then(response => response.json())
            .then(data => {
                const botDiv = document.createElement('div');
                botDiv.className = 'chat-message bot';
                botDiv.innerText = data.reply;
                chatDisplay.appendChild(botDiv);
                chatDisplay.scrollTop = chatDisplay.scrollHeight;
            })
            .catch(error => {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'chat-message bot text-danger';
                errorDiv.innerText = 'सर्वर से जुड़ने में समस्या आ रही है भाई, कृपया पुनः प्रयास करें।';
                chatDisplay.appendChild(errorDiv);
            });
        }
    </script>
</body>
</html>