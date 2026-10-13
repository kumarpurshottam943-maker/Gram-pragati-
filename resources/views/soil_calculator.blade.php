<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>मिट्टी परीक्षण एवं खाद कैलकुलेटर - ग्राम प्रगति</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="/" class="btn btn-outline-secondary btn-sm rounded-pill fw-bold"><i class="fa-solid fa-arrow-left me-1"></i> होम पर लौटें</a>
            <h4 class="fw-bold text-success m-0"><i class="fa-solid fa-seedling me-2"></i> मिट्टी एवं खाद कैलकुलेटर</h4>
            <div></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                    <form action="/soil-calculator/calculate" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">फसल का नाम चुनें</label>
                            <select name="crop_name" class="form-select" required>
                                <option value="गेहूँ (Wheat)">🌾 गेहूँ (Wheat)</option>
                                <option value="धान (Paddy)">🌾 धान (Paddy)</option>
                                <option value="चना (Gram)">🌿 चना (Gram)</option>
                                <option value="सरसों (Mustard)">🌻 सरसों (Mustard)</option>
                                <option value="सोयाबीन (Soybean)">🌱 सोयाबीन (Soybean)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">खेत का क्षेत्रफल (एकड़ में)</label>
                            <input type="number" step="0.1" name="acreage" class="form-control" placeholder="उदा: 2.5" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">मिट्टी का प्रकार</label>
                            <select name="soil_type" class="form-select" required>
                                <option value="दोमट मिट्टी (Loam Soil)">दोमट मिट्टी (Loam Soil)</option>
                                <option value="काली मिट्टी (Black Soil)">काली मिट्टी (Black Soil)</option>
                                <option value="बलुई मिट्टी (Sandy Soil)">बलुई मिट्टी (Sandy Soil)</option>
                                <option value="लाल मिट्टी (Red Soil)">लाल मिट्टी (Red Soil)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold rounded-pill py-2 shadow-sm">
                            <i class="fa-solid fa-calculator me-2"></i> खाद और लागत की गणना करें
                        </button>
                    </form>

                    @if(isset($result))
                        <div class="alert alert-success mt-4 rounded-3 border-0 shadow-sm" role="alert">
                            <h5 class="fw-bold text-success mb-2"><i class="fa-solid fa-circle-check me-1"></i> गणना परिणाम:</h5>
                            <hr>
                            <p class="mb-1"><strong>चयनित फसल:</strong> {{ $result['crop_name'] }} (क्षेत्रफल: {{ $result['acreage'] }} एकड़)</p>
                            <p class="mb-1"><strong>आवश्यक यूरिया:</strong> {{ $result['total_urea'] }} किग्रा</p>
                            <p class="mb-1"><strong>आवश्यक डीएपी:</strong> {{ $result['total_dap'] }} किग्रा</p>
                            <p class="mb-2"><strong>अनुमानित कुल लागत:</strong> ₹ {{ $result['total_cost'] }}</p>
                            <div class="p-2 bg-white rounded text-dark border" style="font-size: 13.5px;">
                                <i class="fa-solid fa-lightbulb text-warning me-1"></i> {{ $result['suggestion'] }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>