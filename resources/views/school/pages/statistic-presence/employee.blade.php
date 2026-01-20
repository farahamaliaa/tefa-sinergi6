@extends('school.layouts.app')

@section('style')
    <style>
        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
        }

        .stat-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .week-row {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
        }

        .week-label {
            width: 100px;
            font-weight: 500;
            color: #2F393E;
        }

        .progress-stacked {
            flex-grow: 1;
            height: 12px;
            background-color: transparent;
            display: flex;
            gap: 8px;
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-pill {
            height: 100%;
            border-radius: 100px;
        }

        .bg-alfa {
            background-color: #EF4444;
        }

        .bg-permit {
            background-color: #0EA5E9;
        }

        .bg-late {
            background-color: #FBBF24;
        }

        .bg-present {
            background-color: #10B981;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 4px;
            margin-right: 8px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
        }

        .custom-table-header {
            background-color: #00A3CE !important;
            color: white !important;
        }

        .custom-table-header th {
            background-color: #00A3CE !important;
            color: white !important;
            font-weight: 500;
            border: none;
            padding: 14px 16px;
        }

        .custom-table-header th:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .custom-table-header th:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .table-row td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #F3F4F6;
        }

        .badge-status {
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-permit {
            background-color: #E0F2FE;
            color: #0EA5E9;
        }

        .badge-present {
            background-color: #DCFCE7;
            color: #16A34A;
        }

        .print-btn {
            background-color: #14B8A6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .print-btn:hover {
            background-color: #0D9488;
            color: white;
        }

        .pagination-mock {
            display: flex;
            justify-content: flex-end;
            gap: 4px;
        }

        .page-item {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #E5E7EB;
            border-radius: 6px;
            color: #6B7280;
            cursor: pointer;
        }

        .page-item.active {
            background-color: #00A3CE;
            color: white;
            border-color: #00A3CE;
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
    </style>
@endsection

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Statistik Absensi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Statistik Absensi Staff
                                </a>
                            </li>
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


    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3 p-2"
                style="background-color: #E0F2FE; width: 48px; height: 48px;">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.16667 25.3312V32.6645M19.8333 14.3312V32.6645M38.1667 38.1645H1.5M34.5 21.6645V32.6645"
                        stroke="#0896D1" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M8.10001 13.9646C7.81111 13.5794 7.44915 13.2548 7.03482 13.0095C6.62049 12.7642 6.1619 12.6028 5.68523 12.5348C5.20855 12.4667 4.72313 12.4931 4.25668 12.6126C3.79024 12.7321 3.35189 12.9423 2.96668 13.2312C2.58147 13.5201 2.25694 13.8821 2.01161 14.2964C1.76628 14.7108 1.60496 15.1693 1.53687 15.646C1.39934 16.6087 1.64987 17.5866 2.23335 18.3646C2.81682 19.1425 3.68545 19.6569 4.64814 19.7944C5.61082 19.9319 6.58871 19.6814 7.36668 19.0979C8.14465 18.5144 8.65897 17.6458 8.7965 16.6831C8.93402 15.7204 8.68349 14.7425 8.10001 13.9646ZM8.10001 13.9646L16.9 7.36457M16.9 7.36457C17.2749 7.8651 17.7715 8.26145 18.3427 8.51594C18.9139 8.77044 19.5407 8.87462 20.1635 8.81858C20.7863 8.76255 21.3844 8.54816 21.901 8.1958C22.4176 7.84343 22.8355 7.3648 23.115 6.8054M16.9 7.36457C16.5087 6.84205 16.264 6.22454 16.1912 5.57583C16.1183 4.92711 16.22 4.27071 16.4856 3.67442C16.7513 3.07814 17.1714 2.56359 17.7024 2.18392C18.2334 1.80426 18.8562 1.57325 19.5064 1.51475C20.1565 1.45626 20.8105 1.5724 21.4008 1.85118C21.9911 2.12995 22.4962 2.56126 22.8641 3.10055C23.2319 3.63984 23.4491 4.26756 23.4932 4.91886C23.5373 5.57016 23.4068 6.22143 23.115 6.8054M23.115 6.8054L31.2183 10.8571M31.2183 10.8571C31.0029 11.2878 30.8743 11.7567 30.8401 12.2371C30.8058 12.7175 30.8665 13.1999 31.0187 13.6568C31.3261 14.5797 31.9875 15.3426 32.8573 15.7777C33.7272 16.2129 34.7343 16.2847 35.6571 15.9773C36.5799 15.67 37.3428 15.0086 37.778 14.1387C38.2042 13.2702 38.2699 12.2683 37.9607 11.3516C37.6515 10.4348 36.9924 9.6774 36.1272 9.24443C35.262 8.81145 34.2607 8.738 33.3415 9.04006C32.4224 9.34213 31.6599 9.99524 31.2202 10.8571H31.2183Z"
                        stroke="#0896D1" stroke-width="3" />
                </svg>
            </div>
            <h4 class="fw-semibold mb-0" style="color: #374151; font-size: 20px;">Statistik Absensi Staff</h4>
        </div>

        <form action="{{ route('school.teacher-attendance.export') }}">
            <button class="print-btn" type="submit">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M17 17H19C20.1046 17 21 16.1046 21 15V11C21 9.89543 20.1046 9 19 9H5C3.89543 9 3 9.89543 3 11V15C3 16.1046 3.89543 17 5 17H7"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17 9V5C17 3.89543 16.1046 3 15 3H9C7.89543 3 7 3.89543 7 5V9" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M7 15C7 13.8954 7.89543 13 9 13H15C16.1046 13 17 13.8954 17 15V19C17 20.1046 16.1046 21 15 21H9C7.89543 21 7 20.1046 7 19V15Z"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Cetak Absensi
            </button>
        </form>
    </div>

    <div class="card stat-card shadow-sm mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="section-title">Statistik Absensi Staff</h5>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" id="monthDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    {{ $months[$selectedMonth] ?? 'Pilih Bulan' }} {{ $selectedYear }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="monthDropdown">
                    @foreach ($months as $monthNum => $monthName)
                        <li>
                            <a class="dropdown-item {{ $monthNum == $selectedMonth ? 'active' : '' }}"
                                href="{{ route('school.statistic-presence-employee.index', ['month' => $monthNum, 'year' => $selectedYear]) }}">
                                {{ $monthName }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="d-flex mb-4">
            <div class="legend-item">
                <div class="legend-dot bg-alfa"></div>
                <span>Alfa</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot bg-permit"></div>
                <span>Izin/sakit</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot bg-late"></div>
                <span>Telat</span>
            </div>
            <div class="legend-item">
                <div class="legend-dot bg-present"></div>
                <span>Masuk</span>
            </div>
        </div>

        <div class="chart-container">
            @foreach ($weeklyStats as $week)
                <div class="week-row">
                    <span class="week-label">{{ $week['label'] }}</span>
                    <div class="progress-stacked">
                        @if ($week['total'] > 0)
                            @if ($week['alpha_pct'] > 0)
                                <div class="progress-pill bg-alfa" style="width: {{ $week['alpha_pct'] }}%"
                                    title="Alfa: {{ $week['alpha'] }} ({{ $week['alpha_pct'] }}%)"></div>
                            @endif
                            @if ($week['permit_pct'] > 0)
                                <div class="progress-pill bg-permit" style="width: {{ $week['permit_pct'] }}%"
                                    title="Izin/Sakit: {{ $week['permit'] }} ({{ $week['permit_pct'] }}%)"></div>
                            @endif
                            @if ($week['late_pct'] > 0)
                                <div class="progress-pill bg-late" style="width: {{ $week['late_pct'] }}%"
                                    title="Telat: {{ $week['late'] }} ({{ $week['late_pct'] }}%)"></div>
                            @endif
                            @if ($week['present_pct'] > 0)
                                <div class="progress-pill bg-present" style="width: {{ $week['present_pct'] }}%"
                                    title="Masuk: {{ $week['present'] }} ({{ $week['present_pct'] }}%)"></div>
                            @endif
                        @else
                            <div class="text-muted small ps-2" style="line-height: 12px;">Tidak ada data</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card stat-card shadow-sm">
        <div class="d-flex align-items-center mb-4 gap-2">
            <h5 class="section-title mb-0">Data Absensi Staff Hari Ini</h5>
            <span class="text-muted fw-normal">/</span>
            <div class="d-flex align-items-center gap-2"
                style="background-color: #E0F2FE; padding: 4px 12px; border-radius: 6px; color: #0EA5E9;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span
                    style="font-size: 14px; font-weight: 500;">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-borderless">
                <thead class="custom-table-header">
                    <tr>
                        <th>No</th>
                        <th>Nama Staff</th>
                        <th>Masuk</th>
                        <th>Pulang</th>
                        <th>Point</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $employee)
                        <tr class="table-row">
                            <td>{{ $loop->iteration }}.</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div
                                        style="width: 32px; height: 32px; background-color: #E5E7EB; border-radius: 50%; margin-right: 12px; overflow: hidden;">
                                        <img src="{{ asset('assets/icons/user.svg') }}" alt=""
                                            class="w-100 h-100 object-fit-cover" onerror="this.innerHTML='<svg...>'">
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $employee->model->user->name }}</div>
                                        <div class="text-muted small">Staff</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $employee->checkin ? \Carbon\Carbon::parse($employee->checkin)->format('H:i') : '-' }}
                            </td>
                            <td>{{ $employee->checkout ? \Carbon\Carbon::parse($employee->checkout)->format('H:i') : '-' }}
                            </td>
                            <td>{{ $employee->model->point ?? 0 }}</td>
                            <td>
                                @php
                                    $statusLabel = $employee->status->label();
                                    $statusClass = 'badge-present';

                                    if (in_array(strtolower($statusLabel), ['sakit', 'izin'])) {
                                        $statusClass = 'badge-permit';
                                    } elseif (strtolower($statusLabel) == 'alfa') {
                                        $statusClass = 'text-danger bg-light-danger px-3 py-1 rounded';
                                    }
                                @endphp
                                <span
                                    class="badge {{ $employee->status->color() == 'danger' ? 'bg-danger' : ($employee->status->color() == 'warning' ? 'bg-warning' : ($employee->status->color() == 'primary' ? 'badge-permit' : 'badge-present')) }}"
                                    style="{{ $employee->status->color() == 'primary' ? 'background-color: #E0F2FE; color: #0EA5E9;' : '' }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                    width="150px">
                                <p class="text-muted mt-2">Belum ada staff yang absen</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
                Menampilkan 1 dari 12 halaman
            </div>
            <div class="pagination-mock">
                <div class="page-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </div>
                <div class="page-item active">1</div>
                <div class="page-item">2</div>
                <div class="page-item">3</div>
                <div class="page-item border-0">...</div>
                <div class="page-item">12</div>
                <div class="page-item">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Necessary scripts if any -->
@endsection
