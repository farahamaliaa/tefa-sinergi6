@extends('staff.layouts.app')
@section('style')
    <style>
        .table-wrapper {
            max-height: 400px;
            overflow-y: auto;
        }

        .table-wrapper::-webkit-scrollbar {
            width: 8px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
        }

        .card-hover:hover {
            border-color: #00A9D9 !important;
            transition: .2s ease-in-out;
        }

        .card.header-wave {
            border-radius: 14px !important;
            overflow: hidden !important;
        }

        .nav-pills .nav-link.active {
            background-color: #098FC6 !important;
            color: #fff !important;
        }

        .nav-pills .nav-link {
            color: #098FC6;
            border-radius: 8px;
        }

        .nav-pills .nav-link:hover {
            background-color: #0A8ABF20;
            color: #098FC6;
        }

        .header-wave {
            background-color: #1A94C8 !important;
            border-radius: 14px;
            position: relative;
            overflow: hidden;
        }

        .header-wave::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 256px;
            background: url("{{ asset('assets/images/wave-header.png') }}");
            background-size: cover;
            opacity: 1;
        }

        .btn-primary {
            background-color: #0896D1 !important;
            border-color: #0896D1 !important;
        }

        .btn-primary:hover {
            background-color: #067aa7 !important;
            border-color: #067aa7 !important;
        }

        .location-status {
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
        }

        .location-status.in-range {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .location-status.out-range {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .location-status.loading {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
        }

        .distance-badge {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .btn-absen {
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-absen.btn-success,
        .btn-absen.btn-primary {
            background: #0896D1 !important;
            border: none;
            color: white !important;
        }

        .btn-absen:disabled {
            background: #e9ecef !important;
            color: #2d3436 !important;
            border: 1px solid #dfe6e9 !important;
            cursor: not-allowed;
            opacity: 1;
        }

        .btn-absen:disabled svg path {
            fill: #2d3436 !important;
        }

        .btn-absen.btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border: none;
            color: white;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        .status-badge-custom {
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.2;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Absensi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white" aria-current="page">Riwayat absensi harian Staff</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/book.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Absensi Hari Ini -->
    <div class="card">
        <div class="card-body">
            <!-- Row 1: Title and Date -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0 text-dark">Absensi Hari Ini :</h2>
                <h4 class="fw-semibold mb-0 text-dark text-end">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </h4>
            </div>

            <!-- Row 2: Status, Location, and Button -->
            <div class="d-flex align-items-center justify-content-between gap-3">
                <!-- Status Badge (Left) -->
                <div style="min-width: 140px;">
                    @if($todayAttendance)
                        <span
                            class="badge px-4 py-2 rounded-2 fs-6 fw-semibold {{ $todayAttendance->status->color() }} w-100 status-badge-custom">
                            {{ ucfirst($todayAttendance->status->label()) }}
                        </span>
                    @else
                        @php
                            $currentTime = now()->format('H:i');
                            $isLate = $currentTime > $timeConfig['late_limit'];
                        @endphp

                        @if($todayPermission)
                            <span
                                class="badge px-4 py-2 rounded-2 fs-6 fw-semibold bg-light-info text-info w-100 status-badge-custom">
                                {{ ucfirst($todayPermission->permission_type->label()) }}
                            </span>
                        @elseif($isLate)
                            <span
                                class="badge px-4 py-2 rounded-2 fs-6 fw-semibold bg-light-danger text-danger w-100 status-badge-custom">
                                Alpha
                            </span>
                        @else
                            <span class="badge px-4 py-2 rounded-2 fs-6 fw-semibold w-100 status-badge-custom"
                                style="background-color: #E6E6E6; color: #555;">
                                Belum Absen
                            </span>
                        @endif
                    @endif
                </div>

                <!-- Location & Action (Right) -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Location Status Box -->
                    <div id="location-status" class="location-status loading mb-0 text-center" style="border-radius: 8px;">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <div class="spinner-border spinner-border-sm" role="status" id="location-spinner">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div id="location-detail" class="small fw-semibold">Mengambil lokasi...</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="min-width: 200px;">
                        @if(!$todayAttendance)
                            <button type="button" id="btn-checkin"
                                class="btn btn-absen btn-success w-100 d-flex align-items-center justify-content-center gap-2"
                                disabled>
                                <svg width="19" height="13" viewBox="0 0 19 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6.49795 10.1626L16.9112 0.347439C17.1569 0.115813 17.4436 0 17.7713 0C18.099 0 18.3856 0.115813 18.6314 0.347439C18.8771 0.579065 19 0.854313 19 1.17318C19 1.49206 18.8771 1.76692 18.6314 1.99777L7.35804 12.6526C7.1123 12.8842 6.8256 13 6.49795 13C6.17029 13 5.8836 12.8842 5.63786 12.6526L0.354434 7.67261C0.108693 7.44098 -0.00926253 7.16612 0.000567093 6.84802C0.0103967 6.52992 0.138591 6.25467 0.385151 6.02227C0.63171 5.78987 0.923733 5.67406 1.26122 5.67483C1.5987 5.6756 1.89031 5.79142 2.13605 6.02227L6.49795 10.1626Z"
                                        fill="white" />
                                </svg>
                                <span id="btn-checkin-text">Absen Sekarang</span>
                            </button>
                        @elseif(!$todayAttendance->checkout)
                            <button type="button" id="btn-checkout"
                                class="btn btn-absen btn-primary w-100 d-flex align-items-center justify-content-center gap-2"
                                disabled>
                                <i class="ti ti-logout fs-5"></i>
                                <span id="btn-checkout-text">Check Out Pulang</span>
                            </button>
                        @else
                            <div class="alert alert-success mb-0 d-flex align-items-center justify-content-center gap-2 py-2 px-3 w-100"
                                style="border-radius: 10px;">
                                <i class="ti ti-check fs-5"></i>
                                <span class="small fw-semibold">Absensi Lengkap</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card border">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Riwayat Absensi</h4>
                    <form class="d-flex gap-2" method="GET" action="{{ url()->current() }}">
                        <div class="position-relative">
                            <input type="date" name="date" class="form-control search-chat" value="{{ request('date') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                </div>
                <div class="table-responsive rounded-2 ">
                    <table class="table border text-nowrap customize-table mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="text-white" style="background-color: #0896D1;">No</th>
                                <th class="text-white" style="background-color: #0896D1;">Hari</th>
                                <th class="text-white" style="background-color: #0896D1;">Tanggal</th>
                                <th class="text-white" style="background-color: #0896D1;">Masuk</th>
                                <th class="text-white" style="background-color: #0896D1;">Pulang</th>
                                <th class="text-white" style="background-color: #0896D1;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $attendance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->created_at)->translatedFormat('l') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendance->created_at)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>
                                        @if(in_array($attendance->status->value, ['present', 'late', 'dinas']))
                                            {{ $attendance->checkin ? \Carbon\Carbon::parse($attendance->checkin)->format('H:i') : '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array($attendance->status->value, ['present', 'late', 'dinas']))
                                            {{ $attendance->checkout ? \Carbon\Carbon::parse($attendance->checkout)->format('H:i') : '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($attendance->checkout)
                                            <span class="badge bg-success">
                                                Hadir (Lengkap)
                                            </span>
                                        @else
                                            <span class="badge {{ $attendance->status->color() }}">
                                                {{ $attendance->status->label() }}
                                            </span>
                                        @endif
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center align-middle">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                                width="300px">
                                            <p class="fs-5 text-dark text-center mt-2">
                                                Belum ada data
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination justify-content-end mt-2 mb-0">
                        @if ($attendances instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {{ $attendances->appends(request()->query())->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const schoolConfig = {
            latitude: {{ $schoolConfig['latitude'] }},
            longitude: {{ $schoolConfig['longitude'] }},
            radius: {{ $schoolConfig['radius'] }},
            name: "{{ $schoolConfig['name'] }}"
        };

        const timeConfig = @json($timeConfig);

        let userLocation = null;
        let userDistance = null;
        let selectedPermissionStatus = null;

        function calculateDistance(lat1, lng1, lat2, lng2) {
            const earthRadius = 6371000;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return earthRadius * c;
        }

        function isWithinTimeRange(type) {
            const now = new Date();
            const currentTimeStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(
                2, '0');

            if (type === 'check-in') {
                return currentTimeStr >= timeConfig.check_in_start && currentTimeStr <= timeConfig.late_limit;
            } else if (type === 'check-out') {
                return currentTimeStr >= timeConfig.check_out_start && currentTimeStr <= timeConfig.check_out_end;
            }
            return false;
        }

        function updateLocationStatus(status, title, detail, distance = null) {
            const statusEl = document.getElementById('location-status');
            const detailEl = document.getElementById('location-detail');
            const spinnerEl = document.getElementById('location-spinner');
            const btnCheckin = document.getElementById('btn-checkin');
            const btnCheckout = document.getElementById('btn-checkout');
            const btnPermission = document.getElementById('btn-permission');

            statusEl.className = 'location-status ' + status + ' mb-0 text-center';
            detailEl.innerHTML = detail;

            if (status === 'loading') {
                spinnerEl.style.display = 'block';
            } else {
                spinnerEl.style.display = 'none';
            }

            // Button Disabling Logic
            if (btnCheckin) {
                const inRange = (status === 'in-range');
                const inTime = isWithinTimeRange('check-in');

                if (inRange && inTime) {
                    btnCheckin.disabled = false;
                    btnCheckin.classList.remove('btn-secondary');
                    btnCheckin.classList.add('btn-success');
                } else {
                    btnCheckin.disabled = true;
                    btnCheckin.classList.add('btn-secondary');
                    btnCheckin.classList.remove('btn-success');

                    if (!inTime && status !== 'loading') {
                        const now = new Date();
                        const currentStr = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
                        let timeMsg = "";
                        if (currentStr < timeConfig.check_in_start) {
                            timeMsg = `Belum waktunya absen. Jadwal: ${timeConfig.check_in_start} - ${timeConfig.late_limit}`;
                        } else {
                            timeMsg = `Batas absen berakhir (Alpha). Jadwal: ${timeConfig.check_in_start} - ${timeConfig.late_limit}`;
                        }

                        // If we have distance info, keep it and append time warning
                        if (status === 'in-range' || status === 'out-range') {
                            detailEl.innerHTML = detail + ` <br><span class="text-danger small fw-bold">${timeMsg}</span>`;
                        } else {
                            detailEl.innerHTML = timeMsg;
                        }
                    }
                }

                if (btnCheckout) {
                    const inRange = (status === 'in-range');
                    const inTime = isWithinTimeRange('check-out');

                    if (inRange && inTime) {
                        btnCheckout.disabled = false;
                        btnCheckout.classList.remove('btn-secondary');
                        btnCheckout.classList.add('btn-primary');
                    } else {
                        btnCheckout.disabled = true;
                        btnCheckout.classList.add('btn-secondary');
                        btnCheckout.classList.remove('btn-primary');

                        if (!inTime && status !== 'loading') {
                            detailEl.innerHTML = `Belum waktunya checkout. Jadwal: ${timeConfig.check_out_start} - ${timeConfig.check_out_end}`;
                        }
                    }
                }
            }
        }

        function getLocation() {
            if (!navigator.geolocation) {
                updateLocationStatus('out-range', 'GPS tidak didukung', 'Browser Anda tidak mendukung geolocation');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    userLocation = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    };

                    userDistance = calculateDistance(
                        userLocation.latitude,
                        userLocation.longitude,
                        schoolConfig.latitude,
                        schoolConfig.longitude
                    );

                    if (userDistance <= schoolConfig.radius) {
                        updateLocationStatus(
                            'in-range',
                            'Anda berada di area sekolah',
                            `Jarak: <strong>${Math.round(userDistance)} meter</strong> dari ${schoolConfig.name}`,
                            userDistance
                        );
                    } else {
                        updateLocationStatus(
                            'out-range',
                            'Anda di luar area sekolah',
                            `Jarak: <strong>${Math.round(userDistance)} meter</strong> (maksimal ${schoolConfig.radius}m)`,
                            userDistance
                        );
                    }
                },
                (error) => {
                    let message = 'Gagal mengambil lokasi';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            message = 'Akses lokasi ditolak. Silakan izinkan akses GPS di browser.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            message = 'Waktu permintaan lokasi habis.';
                            break;
                    }
                    updateLocationStatus('out-range', 'Gagal mengambil lokasi', message);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }

        document.getElementById('btn-checkin')?.addEventListener('click', async function () {
            const btn = this;
            const textEl = document.getElementById('btn-checkin-text');
            const originalText = textEl.textContent;

            // Jika lokasi belum tersedia, coba ambil dulu
            if (!userLocation) {
                btn.disabled = true;
                textEl.textContent = 'Mengambil lokasi...';

                try {
                    // Request GPS secara aktif
                    const position = await new Promise((resolve, reject) => {
                        navigator.geolocation.getCurrentPosition(resolve, reject, {
                            enableHighAccuracy: true,
                            timeout: 15000,
                            maximumAge: 0
                        });
                    });

                    userLocation = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    };
                } catch (error) {
                    btn.disabled = false;
                    textEl.textContent = originalText;
                    alert('Gagal mengambil lokasi. Pastikan GPS diaktifkan dan izinkan akses lokasi di browser.');
                    return;
                }
            }

            btn.disabled = true;
            textEl.textContent = 'Memproses...';

            try {
                const response = await fetch("{{ route('employee.attendance.check-in') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        latitude: userLocation.latitude,
                        longitude: userLocation.longitude
                    })
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    if (data.require_permission) {
                        if (confirm(data.message + '\n\nKlik OK untuk mengajukan izin/sakit/dinas.')) {
                            window.location.href = "{{ route('employee.permission.create') }}";
                        }
                    } else {
                        alert(data.message);
                    }
                }
            } catch (error) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
                console.error(error);
            } finally {
                btn.disabled = false;
                textEl.textContent = originalText;
            }
        });

        document.getElementById('btn-checkout')?.addEventListener('click', async function () {
            if (!userLocation) {
                getLocation();
                alert('Mengambil lokasi... Silakan klik lagi.');
                return;
            }

            const btn = this;
            const originalText = document.getElementById('btn-checkout-text').textContent;
            btn.disabled = true;
            document.getElementById('btn-checkout-text').textContent = 'Memproses...';

            try {
                const response = await fetch("{{ route('employee.attendance.check-out') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        latitude: userLocation.latitude,
                        longitude: userLocation.longitude
                    })
                });

                const data = await response.json();

                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
                console.error(error);
            } finally {
                btn.disabled = false;
                document.getElementById('btn-checkout-text').textContent = originalText;
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            getLocation();

            setInterval(getLocation, 30000);
        });
    </script>
@endsection