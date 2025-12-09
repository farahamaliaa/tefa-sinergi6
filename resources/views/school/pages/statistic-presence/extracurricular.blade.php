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

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
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

        .icon-box {
            background-color: #E0F2FE;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .print-btn {
            background-color: #14B8A6;
            color: white;
            border: none;
            padding: 8px 16px;
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

        .chart-legend {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6B7280;
            font-weight: 500;
        }
        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .bg-masuk { background-color: #10B981; }
        .bg-izin { background-color: #0EA5E9; }
        .bg-alfa { background-color: #EF4444; }

        .bar-chart-container {
            height: 250px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 0 20px 24px 20px;
            border-bottom: 1px dashed #E5E7EB;
            position: relative;
        }
        .bar-chart-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 24px;
            background-image: linear-gradient(to bottom, #F3F4F6 1px, transparent 1px);
            background-size: 100% 50px;
            z-index: 0;
            pointer-events: none;
        }
        .bar-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            z-index: 1;
            position: relative;
        }
        .bars {
            display: flex;
            align-items: flex-end;
            gap: 8px;
        }
        .bar {
            width: 8px;
            border-radius: 10px 10px 10px 10px;
            transition: height 0.3s ease;
        }
        
        .donut-chart {
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: conic-gradient(
                #0EA5E9 0% 65%,
                #EF4444 65% 90%,
                #10B981 90% 100%
            );
            position: relative;
            margin: 0 auto;
        }
        .donut-inner {
            width: 160px;
            height: 160px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: inset 0 0 20px rgba(0,0,0,0.02);
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
            padding: 16px 20px;
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
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #F3F4F6;
        }

        .badge-pertemuan {
            background-color: #E0F2FE;
            color: #0EA5E9;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .pagination-mock {
            display: flex;
            gap: 4px;
        }
        .page-item-mock {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            color: #6B7280;
            cursor: pointer;
            background: white;
            font-weight: 500;
        }
        .page-item-mock.active {
            background-color: #00A3CE;
            color: white;
            border-color: #00A3CE;
        }
        .page-item-mock:hover:not(.active) {
            background-color: #F9FAFB;
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
                                    Statistik Absensi Siswa Ekskul
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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0896D1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 20V10"></path>
                    <path d="M12 20V4"></path>
                    <path d="M6 20V14"></path>
                </svg>
            </div>
            <h4 class="fw-semibold mb-0" style="color: #374151; font-size: 20px;">Statistik Absensi Siswa Ekskul</h4>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle bg-white" type="button" id="eskulDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid #E5E7EB;">
                    Ekstrakulikuler
                </button>
                <ul class="dropdown-menu" aria-labelledby="eskulDropdown">
                    @foreach($extracurriculars as $eskul)
                        <li><a class="dropdown-item" href="#">{{ $eskul->name ?? 'Pramuka' }}</a></li>
                    @endforeach
                    @if(count($extracurriculars) == 0)
                        <li><a class="dropdown-item" href="#">Pramuka</a></li>
                        <li><a class="dropdown-item" href="#">Futsal</a></li>
                    @endif
                </ul>
            </div>
            <button class="print-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9V2h12v7"></path>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <path d="M6 14h12v8H6z"></path>
                </svg>
                Cetak Absensi
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card stat-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="section-title">Statistik Absensi Siswa Ekskul</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Juni
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Juni</a></li>
                        </ul>
                    </div>
                </div>

                <div class="chart-legend">
                    <div class="legend-item"><div class="dot bg-masuk"></div> Masuk</div>
                    <div class="legend-item"><div class="dot bg-izin"></div> Izin/sakit</div>
                    <div class="legend-item"><div class="dot bg-alfa"></div> Alfa</div>
                </div>

                <div class="bar-chart-container">
                    <div class="bar-group">
                        <div class="bars">
                            <div class="bar bg-masuk" style="height: 120px;"></div>
                            <div class="bar bg-izin" style="height: 40px;"></div>
                            <div class="bar bg-alfa" style="height: 30px;"></div>
                        </div>
                        <small class="text-muted mt-2">Minggu 1</small>
                    </div>
                    <div class="bar-group">
                        <div class="bars">
                            <div class="bar bg-masuk" style="height: 140px;"></div>
                            <div class="bar bg-izin" style="height: 50px;"></div>
                            <div class="bar bg-alfa" style="height: 20px;"></div>
                        </div>
                        <small class="text-muted mt-2">Minggu 2</small>
                    </div>
                    <div class="bar-group">
                        <div class="bars">
                            <div class="bar bg-masuk" style="height: 60px;"></div>
                            <div class="bar bg-izin" style="height: 20px;"></div>
                            <div class="bar bg-alfa" style="height: 10px;"></div>
                        </div>
                        <small class="text-muted mt-2">Minggu 3</small>
                    </div>
                    <div class="bar-group">
                        <div class="bars">
                            <div class="bar bg-masuk" style="height: 130px;"></div>
                            <div class="bar bg-izin" style="height: 30px;"></div>
                            <div class="bar bg-alfa" style="height: 45px;"></div>
                        </div>
                        <small class="text-muted mt-2">Minggu 4</small>
                    </div>
                    <div class="bar-group">
                        <div class="bars">
                            <div class="bar bg-masuk" style="height: 135px;"></div>
                            <div class="bar bg-izin" style="height: 45px;"></div>
                            <div class="bar bg-alfa" style="height: 40px;"></div>
                        </div>
                        <small class="text-muted mt-2">Minggu 5</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card stat-card h-100">
                <h5 class="section-title mb-1">Statistik Absensi Siswa</h5>
                <p class="text-muted small mb-4">Hari Ini</p>

                <div class="d-flex flex-column align-items-center justify-content-center h-75">
                    <div class="donut-chart mb-4">
                        <div class="donut-inner"></div>
                    </div>
                    
                    <div class="d-flex gap-3 justify-content-center w-100 px-3">
                         <div class="legend-item"><div class="dot bg-masuk"></div> Masuk</div>
                         <div class="legend-item"><div class="dot bg-izin"></div> Izin/sakit</div>
                         <div class="legend-item"><div class="dot bg-alfa"></div> Alfa</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card stat-card mt-3">
        <div class="d-flex align-items-center mb-4 gap-2">
            <h5 class="section-title mb-0">Data Absensi Siswa Hari Ini</h5>
            <span class="text-muted fw-normal">/</span>
             <div class="d-flex align-items-center gap-2" style="background-color: #E0F2FE; padding: 4px 12px; border-radius: 6px; color: #0EA5E9;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span style="font-size: 14px; font-weight: 500;">08 Desember 2025</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-borderless">
                <thead class="custom-table-header">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Ekstrakulikuler</th>
                        <th>Kelas</th>
                        <th>Total Hadir</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=1; $i<=4; $i++)
                    <tr class="table-row">
                        <td class="align-middle">{{ $i }}.</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div style="width: 32px; height: 32px; background-color: #E5E7EB; border-radius: 50%; margin-right: 12px; overflow: hidden;">
                                    <img src="{{ asset('assets/') }}" alt="" class="w-100 h-100 object-fit-cover" onerror="this.src='{{ asset('assets/') }}'">
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Maulana Rizki R</div>
                                    <div class="text-muted small">XI RPL 1</div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle text-muted">Pramuka</td>
                        <td class="align-middle text-muted">XI RPL 1</td>
                        <td class="align-middle">
                            <span class="badge-pertemuan">10 Pertemuan</span>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>

         <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted small">
            Menampilkan 1 dari 12 halaman
            </div>
            <div class="pagination-mock">
                <div class="page-item-mock">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                </div>
                <div class="page-item-mock active">1</div>
                <div class="page-item-mock">2</div>
                <div class="page-item-mock">3</div>
                <div class="d-flex align-items-end px-1 pb-2">...</div>
                <div class="page-item-mock">12</div>
                <div class="page-item-mock">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Additional JS if needed -->
@endsection
