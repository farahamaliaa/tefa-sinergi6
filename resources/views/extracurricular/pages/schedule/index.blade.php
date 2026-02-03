@php
    use App\Enums\DayEnum;
    use Carbon\Carbon;
@endphp
@extends('extracurricular.layouts.app')

@section('style')
    <style>
        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
        }

        .app-header {
            z-index: 9999 !important;
            position: relative;
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

        .table-header-custom th {
            background-color: #0891CA !important;
            color: white !important;
        }

        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            border: 2px solid #E0E6ED;
            z-index: 1;
        }

        /* Leaflet Z-Index Fixes */
        .leaflet-container {
            z-index: 1 !important;
        }

        .leaflet-top,
        .leaflet-bottom {
            z-index: 400 !important;
        }

        .leaflet-pane {
            z-index: 200 !important;
            /* Low enough to be below header */
        }

        .location-info {
            background-color: #F8F9FA;
            border-radius: 8px;
            padding: 10px;
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-2">Jadwal {{ $extracurricular->name }}</h4>
                    <h6 class="fw-semibold text-white mb-2">Kelola Jadwal Kegiatan Ekskul {{ $extracurricular->name }}</h6>
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

    <div class="card card-body">
        <h4 class="mb-4 fw-bolder">
            <span class="ti ti-plus"></span>
            Tambah Jadwal Baru
        </h4>
        <form action="{{ route('extracurricular.schedule.store') }}" method="POST" id="scheduleForm">
            @csrf
            <input type="hidden" name="extracurricular_id" value="{{ $extracurricular->id }}">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Hari <span class="text-danger">*</span></label>
                    <select name="day" class="form-select" required>
                        <option value="">Pilih Hari</option>
                        @foreach (DayEnum::cases() as $day)
                            <option value="{{ $day->value }}">{{ $day->label() }}</option>
                        @endforeach
                    </select>
                    @error('day')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                    <input type="time" name="start_time" class="form-control" required>
                    @error('start_time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Jam Selesai <span class="text-danger">*</span></label>
                    <input type="time" name="end_time" class="form-control" required>
                    @error('end_time')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Nama Lokasi <span class="text-danger">*</span></label>
                    <input type="text" name="location_name" id="location_name" class="form-control"
                        placeholder="Contoh: Lapangan Sekolah" required>
                    @error('location_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Radius (m) <span class="text-danger">*</span></label>
                    <input type="number" name="radius" class="form-control" value="100" min="10" max="500"
                        required>
                    @error('radius')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <label class="form-label">
                        <i class="ti ti-map-pin me-1"></i>
                        <span class="fs-5 fw-bolder">Lokasi Titik Kumpul</span><span class="text-danger">*</span>
                    </label>
                    <p class="text-muted small mb-2">Cari lokasi atau klik pada peta untuk menentukan titik kumpul absensi
                    </p>

                    <div class="input-group mb-2">
                        <input type="text" id="searchLocation" class="form-control"
                            placeholder="Cari lokasi... (contoh: Lapangan Sekolah, Jakarta)">
                        <button type="button" class="btn btn-primary text-white" id="searchBtn">
                            <i class="ti ti-search"></i> Cari
                        </button>
                    </div>
                    <div id="searchResults" class="list-group mb-2"
                        style="max-height: 200px; overflow-y: auto; display: none;"></div>

                    <div id="map"></div>
                    <div class="location-info mt-2" id="locationInfo">
                        <i class="ti ti-info-circle me-1"></i>
                        <span id="locationText">Belum ada lokasi dipilih</span>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                        <i class="ti ti-plus me-1"></i> Tambah Jadwal
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card card-body">
        <h4 class="mb-4 fw-bolder">Daftar Jadwal</h4>
        <div class="table-responsive rounded-3 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="fs-4 table-header-custom">
                    <tr>
                        <th width="50" class="text-white">No</th>
                        <th class="text-white">Hari</th>
                        <th class="text-white">Jam Mulai</th>
                        <th class="text-white">Jam Selesai</th>
                        <th class="text-white">Lokasi</th>
                        <th class="text-white">Radius</th>
                        <th width="100" class="text-center text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($extracurricular->schedules as $index => $schedule)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ DayEnum::tryFrom($schedule->day)?->label() ?? ucfirst($schedule->day) }}</td>
                            <td>{{ Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                            <td>{{ Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                            <td>
                                @if ($schedule->location_name)
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-map-pin text-secondary me-2 fs-5"></i>
                                        {{ $schedule->location_name }}
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $schedule->radius ?? '-' }} m</td>
                            <td class="text-center">
                                {{-- Inline form matching logic but visual style of teacher --}}
                                <button type="button" class="btn btn-sm btn-light-danger btn-delete"
                                    data-bs-toggle="modal" data-bs-target="#modal-delete-{{ $schedule->id }}">
                                    <i class="ti ti-trash text-danger"></i>
                                </button>

                                <!-- Individual Delete Modal to ensure no component issue if missing -->
                                <div class="modal fade" id="modal-delete-{{ $schedule->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Hapus Jadwal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                Apakah Anda yakin ingin menghapus jadwal hari
                                                <strong>{{ DayEnum::tryFrom($schedule->day)?->label() }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <form
                                                    action="{{ route('extracurricular.schedule.destroy', $schedule->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                        width="300px">
                                    <p class="fs-5 text-dark text-center mt-2">
                                        Belum ada jadwal
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const defaultLat = -6.200000;
            const defaultLng = 106.816666;

            const map = L.map('map').setView([defaultLat, defaultLng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            let circle = L.circle([defaultLat, defaultLng], {
                color: '#0896D1',
                fillColor: '#0896D1',
                fillOpacity: 0.2,
                radius: 100
            }).addTo(map);

            marker.on('dragend', function(e) {
                const position = marker.getLatLng();
                updateLocation(position.lat, position.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateLocation(e.latlng.lat, e.latlng.lng);
            });

            document.querySelector('input[name="radius"]').addEventListener('change', function() {
                circle.setRadius(parseInt(this.value) || 100);
            });

            function updateLocation(lat, lng) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                document.getElementById('locationText').textContent =
                    `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
                document.getElementById('submitBtn').disabled = false;

                circle.setLatLng([lat, lng]);

                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) {
                            document.getElementById('locationText').textContent = data.display_name;
                        }
                    })
                    .catch(err => console.log('Geocoding error:', err));
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    map.setView([lat, lng], 17);
                    marker.setLatLng([lat, lng]);
                    circle.setLatLng([lat, lng]);
                    updateLocation(lat, lng);
                }, function(error) {
                    console.log('Geolocation error:', error);
                });
            }

            const searchInput = document.getElementById('searchLocation');
            const searchBtn = document.getElementById('searchBtn');
            const searchResults = document.getElementById('searchResults');
            let searchTimeout;

            searchBtn.addEventListener('click', performSearch);

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    performSearch();
                }
            });

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 3) {
                    searchResults.style.display = 'none';
                    return;
                }

                searchTimeout = setTimeout(function() {
                    performSearch();
                }, 500);
            });

            function performSearch() {
                const query = searchInput.value.trim();

                if (query.length < 2) {
                    searchResults.innerHTML =
                        '<div class="list-group-item text-muted">Masukkan minimal 2 karakter</div>';
                    searchResults.style.display = 'block';
                    return;
                }

                searchResults.innerHTML =
                    '<div class="list-group-item text-muted"><i class="ti ti-loader ti-spin me-1"></i>Mencari...</div>';
                searchResults.style.display = 'block';

                fetch(
                        `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5`
                    )
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            searchResults.innerHTML =
                                '<div class="list-group-item text-muted">Lokasi tidak ditemukan</div>';
                            return;
                        }

                        searchResults.innerHTML = data.map(item => `
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action" 
                               data-lat="${item.lat}" data-lng="${item.lon}" data-name="${item.display_name}">
                                <i class="ti ti-map-pin text-primary me-1"></i>
                                <span class="small">${item.display_name}</span>
                            </a>
                        `).join('');

                        searchResults.querySelectorAll('.list-group-item-action').forEach(item => {
                            item.addEventListener('click', function() {
                                const lat = parseFloat(this.dataset.lat);
                                const lng = parseFloat(this.dataset.lng);
                                const name = this.dataset.name;

                                map.setView([lat, lng], 17);
                                marker.setLatLng([lat, lng]);
                                circle.setLatLng([lat, lng]);
                                updateLocation(lat, lng);

                                const locationNameInput = document.getElementById(
                                    'location_name');
                                if (!locationNameInput.value) {
                                    const shortName = name.split(',')[0];
                                    locationNameInput.value = shortName;
                                }

                                searchInput.value = name.split(',').slice(0, 2).join(', ');
                                searchResults.style.display = 'none';
                            });
                        });
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                        searchResults.innerHTML =
                            '<div class="list-group-item text-danger">Gagal mencari lokasi</div>';
                    });
            }

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target) && !searchBtn
                    .contains(e.target)) {
                    searchResults.style.display = 'none';
                }
            });
        });
    </script>
@endsection
