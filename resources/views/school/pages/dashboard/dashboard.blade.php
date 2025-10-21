@extends('school.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('admin_assets/dist/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <style>
        .nav-pills.card {
          background-color: #fff;
          border: 1px solid #e5e7eb;
          border-radius: 4px;
        }

        .nav-pills .nav-link {
          color: #000;
          font-weight: 600;
          border-radius: 3px;
          transition: all 0.3s ease;
        }

        .nav-pills .nav-link.active {
          background-color: #00AEEF; /* cyan biru seperti gambar */
          color: #fff !important;
        }

        .nav-pills .nav-link:hover:not(.active) {
          background-color: rgba(0, 174, 239, 0.1);
          color: #00AEEF;
        }

        .btn-primary {
          background-color: #00AEEF;
          border: none;
          border-radius: 3px;
        }

        .btn-primary:hover {
          background-color: #0096cb;
        }

        input[type="date"] {
          border: 1px solid #d1d5db;
          color: #6b7280;
        }

        input[type="date"]:focus {
          border-color: #00AEEF;
          box-shadow: 0 0 0 2px rgba(0, 174, 239, 0.2);
        }

        @media (max-width: 767.98px) {
          .nav-pills {
            flex-direction: column;
            gap: 10px;
          }
      
          .form-group {
            flex-direction: column;
            width: 100%;
          }
        }
    </style>

    @include('school.pages.dashboard.style.journal-statistics')
@endsection

@section('content')
    @include('school.pages.dashboard.panes.corousel')

    @include('school.pages.dashboard.panes.school-year')

    <h4 class="mb-4"><b>Data Absensi Hari Ini</b></h4>

    <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row justify-content-between shadow-sm">
        <div class="d-flex align-items-center">
            <li class="nav-item me-2">
                <a href="#student-content" data-bs-toggle="tab"
                class="nav-link note-link d-flex align-items-center justify-content-center active px-3 py-2"
                id="student">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor"
                        d="M16 11C17.66 11 19 9.66 19 8C19 6.34 17.66 5 16 5C14.34 5 13 6.34 13 8C13 9.66 14.34 11 16 11ZM8 11C9.66 11 11 9.66 11 8C11 6.34 9.66 5 8 5C6.34 5 5 6.34 5 8C5 9.66 6.34 11 8 11ZM8 13C5.33 13 0 14.34 0 17V19H16V17C16 14.34 10.67 13 8 13ZM16 13C15.65 13 15.28 13.02 14.89 13.05C15.86 13.76 16.5 14.77 16.5 16V19H24V17C24 14.34 18.67 13 16 13Z" />
                    </svg>
                <span class="d-none d-md-block ms-2 fw-medium">Siswa</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#employee-content" data-bs-toggle="tab"
                class="nav-link note-link d-flex align-items-center justify-content-center px-3 py-2"
                id="employee">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor"
                    d="M4 4H20V6H4V4ZM4 8H20V10H4V8ZM4 12H14V14H4V12ZM4 16H14V18H4V16ZM16 12H20V18H16V12Z" />
                    </svg>
                    <span class="d-none d-md-block ms-2 fw-medium">Guru</span>
                </a>
            </li>
        </div>

        <form class="mt-3 mt-md-0">
            <div class="form-group d-flex gap-2 align-items-center">
                <input type="date" name="date" class="form-control rounded-pill px-3 py-2"
                value="{{ date('Y-m-d') }}">
                <button class="btn btn-primary rounded-pill px-4" type="submit">Cari</button>
            </div>
        </form>
    </ul>


    <div class="tab-content mb-4">
        <div id="student-content" class="tab-pane fade show active">
            <div class="note-has-grid row">
                <div class="col-12">
                    @include('school.pages.dashboard.panes.student-tab.index')
                </div>
            </div>
        </div>

        <div id="employee-content" class="tab-pane fade">
            <div class="note-has-grid row">
                <div class="col-12">
                    @include('school.pages.dashboard.panes.employee-tab.index')
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-4"><b>Data Jurnal Guru Hari Ini / </b>
        <span class="mb-1 badge font-medium bg-light-primary text-primary" style="font-size: ">
            <b>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</b>
        </span>
    </h4>

    @include('school.pages.dashboard.panes.teacher-journal')

    <h4 class="mb-4"><b>Data Pelanggaran</b></h4>
    @include('school.pages.dashboard.panes.violations-list')

    {{-- <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body pb-2">
                    <div class="d-md-flex align-items-center gap-3 justify-content-between mb-3">
                        <div>
                            <h5 class="card-title fw-semibold">Statistik Absensi</h5>
                        </div>
                        <div class="d-flex align-items-center gap-3 mt-4 mt-md-0">
                            <form>
                                <div class="form-group mb-4">
                                    <select class="form-select mr-sm-2" id="inlineFormCustomSelect">
                                        <option selected>2024</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="investments"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title mb-9 fw-semibold">Statistik Jurnal Guru</h5>
                            <h4 class="fw-semibold mb-3">5 Juli 2024</h4>
                            <div class=" align-items-center">
                                <div class="me-4">
                                    <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                    <span class="fs-2">Sudah Mengisi</span>
                                </div>
                                <div>
                                    <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                    <span class="fs-2">Belum Mengisi</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-center">
                                <div id="jurnal"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    @include('school.pages.dashboard.widgets.violation-detail')
@endsection

@section('script')
    {{-- <script src="{{ asset('admin_assets/dist/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('admin_assets/dist/js/apex-chart/apex.area.init.js') }}"></script> --}}
    {{-- <script src="{{ asset('admin_assets/dist/js/dashboard.js') }}"></script> --}}

    @include('school.pages.dashboard.scripts.script-corousel')
    @include('school.pages.dashboard.scripts.chart-student')
    @include('school.pages.dashboard.scripts.chart-violations')
    @include('school.pages.dashboard.scripts.btn-detail')

    <script>
        $(function() {
            var attendanceChartData = @json($attendanceChart);

            var categories = attendanceChartData.map(item => item.month);
            var data1 = attendanceChartData.map(item => item.attendance_present);
            var data2 = attendanceChartData.map(item => item.attendance_permit);
            var data3 = attendanceChartData.map(item => item.attendance_sick);
            var data4 = attendanceChartData.map(item => item.attendance_alpha);

            var investments = {
                series: [{
                        name: "Masuk",
                        data: data1,
                    },
                    {
                        name: "Izin",
                        data: data2,
                    },
                    {
                        name: "Sakit",
                        data: data3,
                    },
                    {
                        name: "Alpha",
                        data: data4,
                    },
                ],
                chart: {
                    ffontFamily: "Plus Jakarta Sans', sans-serif",
                    foreColor: "#adb0bb",
                    height: 325,
                    type: "line",
                    toolbar: {
                        show: false,
                    },
                },
                legend: {
                    show: false,
                },
                stroke: {
                    width: 4,
                    curve: "smooth",
                },
                grid: {
                    borderColor: "transparent",
                },
                colors: ["#13deb9", "#5d87ff", "#ffae1f", "#fa896b"],
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: "dark",
                        gradientToColors: ["#6993ff"],
                        shadeIntensity: 1,
                        type: "horizontal",
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100],
                    },
                },
                markers: {
                    size: 0,
                },
                xaxis: {
                    type: 'category',
                    categories: categories,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    }
                },
                tooltip: {
                    theme: "dark",
                },
            };
            new ApexCharts(document.querySelector("#investments"), investments).render();
        });
    </script>

    <script>
        var breakupOptions = {
            chart: {
                type: 'donut',
                width: 180,
                fontFamily: "'Plus Jakarta Sans', sans-serif",
                foreColor: '#adb0bb',
            },
            series: [38, 40],
            labels: ['Mengisi', 'Tidak Mengisi'],
            plotOptions: {
                pie: {
                    startAngle: 0,
                    endAngle: 360,
                    donut: {
                        size: '75%',
                    },
                },
            },
            colors: ['var(--bs-primary)', '#ecf2ff', '#F9F9FD'],
            stroke: {
                show: false,
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            responsive: [{
                breakpoint: 991,
                options: {
                    chart: {
                        width: 120,
                    },
                },
            }, ],
            tooltip: {
                theme: 'dark',
                fillSeriesColor: false,
            },
        };

        var chart = new ApexCharts(document.querySelector('#jurnal'), breakupOptions);
        chart.render();
    </script>
@endsection
