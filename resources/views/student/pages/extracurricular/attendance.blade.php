@extends('student.layouts.app')

@section('style')
    <style>
        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
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

        #map {
            height: 300px;
            width: 100%;
            border-radius: 12px;
            border: 2px solid #E0E6ED;
        }

        .location-status {
            padding: 15px;
            border-radius: 12px;
            margin-top: 15px;
        }

        .location-status.loading {
            background-color: #FEF9C3;
            border: 1px solid #FDE047;
        }

        .location-status.success {
            background-color: #D1FAE5;
            border: 1px solid #34D399;
        }

        .location-status.error {
            background-color: #FEE2E2;
            border: 1px solid #F87171;
        }

        .distance-indicator {
            font-size: 2rem;
            font-weight: 700;
            color: #0896D1;
        }

        .attendance-btn {
            font-size: 1.25rem;
            padding: 15px 30px;
            border-radius: 12px;
        }
    </style>
@endsection

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Absensi Ekstrakurikuler</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    {{ $extracurricular->name }}
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/laptops.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <h5 class="fw-semibold mb-3">
                        <i class="ti ti-map-pin me-2"></i>Lokasi Titik Kumpul
                    </h5>
                    <div id="map"></div>

                    <div class="location-status loading" id="locationStatus">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border spinner-border-sm me-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span id="statusText">Mencari lokasi Anda...</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <h5 class="fw-semibold mb-3">
                        <i class="ti ti-info-circle me-2"></i>Informasi Jadwal
                    </h5>

                    <table class="table table-borderless">
                        <tr>
                            <td width="120"><strong>Hari</strong></td>
                            <td>:
                                {{ ucfirst(\App\Enums\DayEnum::tryFrom($todaySchedule->day)?->label() ?? $todaySchedule->day) }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Jam</strong></td>
                            <td>: {{ \Carbon\Carbon::parse($todaySchedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($todaySchedule->end_time)->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Lokasi</strong></td>
                            <td>: {{ $todaySchedule->location_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Radius</strong></td>
                            <td>: {{ $todaySchedule->radius ?? 100 }} meter</td>
                        </tr>
                    </table>

                    <div class="text-center mt-4 p-4 bg-light rounded-3">
                        <p class="text-muted mb-2">Jarak Anda dari titik kumpul:</p>
                        <div class="distance-indicator mb-3" id="distanceValue">-- m</div>

                        <button type="button" class="btn btn-primary attendance-btn w-100" id="attendanceBtn" disabled>
                            <i class="ti ti-check me-2"></i>Absen Sekarang
                        </button>

                        <p class="text-muted small mt-3" id="btnHelper">
                            Pastikan Anda berada dalam radius {{ $todaySchedule->radius ?? 100 }} meter dari lokasi titik
                            kumpul
                        </p>
                    </div>
                </div>
            </div>

            {{-- <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('student.extracurricular.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div> --}}
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const targetLat = {{ $todaySchedule->latitude }};
            const targetLng = {{ $todaySchedule->longitude }};
            const radius = {{ $todaySchedule->radius ?? 100 }};
            const scheduleId = {{ $todaySchedule->id }};
            const extracurricularId = '{{ $extracurricular->id }}';

            let userLat = null;
            let userLng = null;
            let userMarker = null;

            // Initialize map centered on target location
            const map = L.map('map').setView([targetLat, targetLng], 17);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Add target marker
            const targetIcon = L.divIcon({
                html: '<div style="background-color: #DC2626; width: 20px; height: 20px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                iconSize: [20, 20],
                className: 'target-marker'
            });

            L.marker([targetLat, targetLng], {
                    icon: targetIcon
                })
                .addTo(map)
                .bindPopup('Lokasi Titik Kumpul');

            // Add radius circle
            L.circle([targetLat, targetLng], {
                color: '#0896D1',
                fillColor: '#0896D1',
                fillOpacity: 0.2,
                radius: radius
            }).addTo(map);

            // Get user location
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(
                    function(position) {
                        userLat = position.coords.latitude;
                        userLng = position.coords.longitude;

                        updateUserPosition();
                    },
                    function(error) {
                        showError('Tidak dapat mengakses lokasi. Pastikan GPS aktif dan izinkan akses lokasi.');
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                showError('Browser tidak mendukung Geolocation');
            }

            function updateUserPosition() {
                if (userMarker) {
                    userMarker.setLatLng([userLat, userLng]);
                } else {
                    const userIcon = L.divIcon({
                        html: '<div style="background-color: #0896D1; width: 16px; height: 16px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                        iconSize: [16, 16],
                        className: 'user-marker'
                    });

                    userMarker = L.marker([userLat, userLng], {
                            icon: userIcon
                        })
                        .addTo(map)
                        .bindPopup('Posisi Anda');
                }

                // Calculate distance
                const distance = calculateDistance(userLat, userLng, targetLat, targetLng);
                document.getElementById('distanceValue').textContent = Math.round(distance) + ' m';

                const statusEl = document.getElementById('locationStatus');
                const btnEl = document.getElementById('attendanceBtn');
                const btnHelperEl = document.getElementById('btnHelper');

                if (distance <= radius) {
                    statusEl.className = 'location-status success';
                    document.getElementById('statusText').textContent = 'Anda berada dalam jangkauan ✓';
                    btnEl.disabled = false;
                    btnHelperEl.textContent = 'Klik tombol di atas untuk melakukan absensi';
                } else {
                    statusEl.className = 'location-status error';
                    document.getElementById('statusText').textContent =
                        `Anda di luar jangkauan (${Math.round(distance)}m dari lokasi)`;
                    btnEl.disabled = true;
                    btnHelperEl.textContent = `Dekati lokasi titik kumpul hingga dalam radius ${radius} meter`;
                }
            }

            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371000;
                const dLat = deg2rad(lat2 - lat1);
                const dLon = deg2rad(lon2 - lon1);
                const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
            }

            function deg2rad(deg) {
                return deg * (Math.PI / 180);
            }

            function showError(message) {
                const statusEl = document.getElementById('locationStatus');
                statusEl.className = 'location-status error';
                statusEl.innerHTML = `<i class="ti ti-alert-circle me-2"></i>${message}`;
            }

            // Attendance button handler
            document.getElementById('attendanceBtn').addEventListener('click', function() {
                if (!userLat || !userLng) {
                    alert('Lokasi Anda belum terdeteksi');
                    return;
                }

                const btn = this;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

                fetch(`/student/extracurricular/${extracurricularId}/attendance`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            latitude: userLat,
                            longitude: userLng,
                            schedule_id: scheduleId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            window.location.href = '{{ route('student.extracurricular.index') }}';
                        } else {
                            alert(data.message);
                            btn.disabled = false;
                            btn.innerHTML = '<i class="ti ti-check me-2"></i>Absen Sekarang';
                        }
                    })
                    .catch(error => {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="ti ti-check me-2"></i>Absen Sekarang';
                    });
            });
        });
    </script>
@endsection
