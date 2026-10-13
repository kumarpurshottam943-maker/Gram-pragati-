<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>शिकायत प्रबंधन - ग्राम प्रगति</title>
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
        .management-card { background: white; border-radius: 12px; border: 1px solid #e2e8f0; margin: 24px; padding: 24px; }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <div class="sidebar-brand"><i class="fa-solid fa-gauge-high me-2 text-info"></i> Admin Panel</div>
            <div class="nav flex-column">
                <a class="nav-link" href="/admin-dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
                <a class="nav-link" href="/admin/users"><i class="fa-solid fa-users"></i> User Management</a>
                <a class="nav-link" href="/admin/mandi"><i class="fa-solid fa-wheat-awn"></i> Mandi Management</a>
                <a class="nav-link" href="/admin/notice"><i class="fa-solid fa-bullhorn"></i> News / Notice</a>
                <a class="nav-link text-white active" href="/admin/complaints"><i class="fa-solid fa-comment-dots text-warning"></i> Complaint Management</a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h4 class="fw-bold m-0" style="font-size: 20px;">नागरिक शिकायत प्रबंधन (Complaint Management)</h4>
            <span class="fw-bold text-secondary" style="font-size: 13px;">प्रशासक: {{ Auth::user()->name }}</span>
        </div>

        @if(session('success'))
            <div class="alert alert-success mx-4 mt-3"><i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}</div>
        @endif

        <div class="management-card">
            <h5 class="fw-bold text-dark mb-3" style="font-size: 15px;"><i class="fa-solid fa-list-check text-warning me-1"></i> गाँव से आई लाइव शिकायतों की सूची</h5>
            <div class="table-responsive">
                <table class="table table-hover border align-middle m-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-2.5 px-3" style="font-size:13px;">ID</th>
                            <th class="py-2.5" style="font-size:13px;">समस्या</th>
                            <th class="py-2.5" style="font-size:13px;">श्रेणी व स्थान</th>
                            <th class="py-2.5" style="font-size:13px;">फोटो</th>
                            <th class="py-2.5" style="font-size:13px;">स्थिति बदलें</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allComplaints as $complaint)
                            <tr>
                                <td class="px-3 fw-bold text-secondary" style="font-size:13px;">{{ $complaint->complaint_id }}</td>
                                <td>
                                    <strong class="text-dark d-block" style="font-size:14px;">{{ $complaint->title }}</strong>
                                    <small class="text-muted" style="font-size:12px;">{{ $complaint->description }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border px-2 py-0.5" style="font-size:11px;">{{ $complaint->category }}</span>
                                    <small class="d-block text-muted mt-1" style="font-size:12px;"><i class="fa-solid fa-location-dot text-danger me-0.5"></i> {{ $complaint->ward }}</small>
                                </td>
                                <td>
                                    @if($complaint->image)
                                        <a href="{{ asset($complaint->image) }}" target="_blank">
                                            <img src="{{ asset($complaint->image) }}" style="width:45px; height:45px; object-fit:cover; border-radius:6px;" class="border">
                                        </a>
                                    @else
                                        <span class="text-muted" style="font-size:12px;">कोई फोटो नहीं</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="/admin/complaints/{{ $complaint->id }}/status" method="POST" class="d-flex gap-1.5 align-items-center">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm shadow-none" style="font-size:12.5px; width:120px;">
                                            <option value="Pending" {{ $complaint->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="In Progress" {{ $complaint->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="Resolved" {{ $complaint->status == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-dark px-2 py-1" style="font-size:11px;"><i class="fa-solid fa-save"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">गाँव से अभी कोई शिकायत दर्ज नहीं हुई है।</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>