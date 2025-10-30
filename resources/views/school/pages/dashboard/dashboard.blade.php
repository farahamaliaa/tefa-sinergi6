@extends('school.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('admin_assets/dist/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <style>
        .nav-pills.card {
          background-color: #fff;
          border: 1px solid #e5e7eb;
          border-radius: 8px;
        }

        .nav-pills .nav-link {
          color: #000;
          font-weight: 600;
          border-radius: 8px;
          transition: all 0.3s ease;
        }

        .nav-pills .nav-link.active {
          background-color: #0A94CE;
          color: #fff !important;
          border-radius: 8px;
        }

        .nav-pills .nav-link:hover:not(.active) {
          background-color: rgba(0, 174, 239, 0.1);
          color: #00AEEF;
        }

        .btn-primary {
          background-color: #0A94CE;
          border: none;
          border-radius: 8px;
        }

        .btn-primary:hover {
          background-color: #0096cb;
        }

        input[type="date"] {
          border: 1px solid #d1d5db;
          color: #6b7280;
          border-radius: 8px;
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
                    <svg width="31" height="28" viewBox="0 0 31 28" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M29.0625 24.5C29.0625 24.5 31 24.5 31 22.75C31 21 29.0625 15.75 21.3125 15.75C13.5625 15.75 11.625 21 11.625 22.75C11.625 24.5 13.5625 24.5 13.5625 24.5H29.0625ZM13.6051 22.75L13.5625 22.743C13.5644 22.281 13.8861 20.9405 15.035 19.733C16.1045 18.6007 17.9839 17.5 21.3125 17.5C24.6392 17.5 26.5186 18.6025 27.59 19.733C28.7389 20.9405 29.0586 22.2828 29.0625 22.743L29.047 22.7465L29.0199 22.75H13.6051ZM21.3125 12.25C22.3402 12.25 23.3258 11.8813 24.0525 11.2249C24.7792 10.5685 25.1875 9.67826 25.1875 8.75C25.1875 7.82174 24.7792 6.9315 24.0525 6.27513C23.3258 5.61875 22.3402 5.25 21.3125 5.25C20.2848 5.25 19.2992 5.61875 18.5725 6.27513C17.8458 6.9315 17.4375 7.82174 17.4375 8.75C17.4375 9.67826 17.8458 10.5685 18.5725 11.2249C19.2992 11.8813 20.2848 12.25 21.3125 12.25ZM27.125 8.75C27.125 9.43944 26.9747 10.1221 26.6826 10.7591C26.3904 11.396 25.9623 11.9748 25.4226 12.4623C24.8828 12.9498 24.2421 13.3365 23.5368 13.6004C22.8316 13.8642 22.0758 14 21.3125 14C20.5492 14 19.7934 13.8642 19.0882 13.6004C18.3829 13.3365 17.7422 12.9498 17.2024 12.4623C16.6627 11.9748 16.2346 11.396 15.9424 10.7591C15.6503 10.1221 15.5 9.43944 15.5 8.75C15.5 7.35761 16.1124 6.02226 17.2024 5.03769C18.2925 4.05312 19.7709 3.5 21.3125 3.5C22.8541 3.5 24.3325 4.05312 25.4226 5.03769C26.5126 6.02226 27.125 7.35761 27.125 8.75ZM13.4385 16.24C12.663 16.0211 11.8643 15.8762 11.0554 15.8077C10.6008 15.7677 10.1442 15.7484 9.6875 15.75C1.9375 15.75 0 21 0 22.75C0 23.9167 0.645833 24.5 1.9375 24.5H10.106C9.81891 23.9536 9.67567 23.3547 9.6875 22.75C9.6875 20.9825 10.4179 19.1765 11.7994 17.668C12.2702 17.1535 12.8185 16.6722 13.4385 16.24ZM9.5325 17.5C8.38652 19.0565 7.76714 20.8808 7.75 22.75H1.9375C1.9375 22.295 2.25525 20.9475 3.41 19.733C4.46594 18.62 6.30075 17.535 9.5325 17.5018V17.5ZM2.90625 9.625C2.90625 8.23261 3.51864 6.89726 4.60869 5.91269C5.69875 4.92812 7.17718 4.375 8.71875 4.375C10.2603 4.375 11.7388 4.92812 12.8288 5.91269C13.9189 6.89726 14.5312 8.23261 14.5312 9.625C14.5312 11.0174 13.9189 12.3527 12.8288 13.3373C11.7388 14.3219 10.2603 14.875 8.71875 14.875C7.17718 14.875 5.69875 14.3219 4.60869 13.3373C3.51864 12.3527 2.90625 11.0174 2.90625 9.625ZM8.71875 6.125C7.69104 6.125 6.70541 6.49375 5.97871 7.15013C5.25201 7.8065 4.84375 8.69674 4.84375 9.625C4.84375 10.5533 5.25201 11.4435 5.97871 12.0999C6.70541 12.7563 7.69104 13.125 8.71875 13.125C9.74646 13.125 10.7321 12.7563 11.4588 12.0999C12.1855 11.4435 12.5938 10.5533 12.5938 9.625C12.5938 8.69674 12.1855 7.8065 11.4588 7.15013C10.7321 6.49375 9.74646 6.125 8.71875 6.125Z" fill="white"/>
                    </svg>
                <span class="d-none d-md-block ms-2 fw-medium">Siswa</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#employee-content" data-bs-toggle="tab"
                class="nav-link note-link d-flex align-items-center justify-content-center px-3 py-2"
                id="employee">
                    <svg width="31" height="28" viewBox="0 0 38 38" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M4.75 7.125V9.5H30.875V28.5H14.25V30.875H35.625V28.5H33.25V7.125H4.75ZM9.50237 10.6875C8.24372 10.6919 7.03784 11.1937 6.14761 12.0834C5.25739 12.9732 4.75501 14.1789 4.75 15.4375C4.75 18.0488 6.89225 20.1875 9.50237 20.1875C10.7604 20.1825 11.9654 19.6804 12.8548 18.7906C13.7441 17.9008 14.2456 16.6955 14.25 15.4375C14.25 12.8286 12.1101 10.6875 9.50237 10.6875ZM16.625 11.875V14.25H22.5625V11.875H16.625ZM24.9375 11.875V14.25H28.5V11.875H24.9375ZM9.50237 13.0625C10.8252 13.0625 11.875 14.1111 11.875 15.4375C11.875 16.7675 10.8264 17.8125 9.50237 17.8125C8.17237 17.8125 7.125 16.7675 7.125 15.4375C7.125 14.1111 8.17356 13.0625 9.50237 13.0625ZM16.625 16.625V19H28.5V16.625H16.625ZM4.75 21.375V30.875H7.125V23.75H10.6875V30.875H13.0625V24.5314L15.5135 25.8281C16.2082 26.1963 17.043 26.1951 17.7365 25.8281V25.8305L21.9284 23.6134L20.8204 21.5116L16.6274 23.7286L12.9509 21.7882C12.4379 21.517 11.8663 21.3751 11.286 21.375H4.75Z" fill="black"/>
                    </svg>
                    <span class="d-none d-md-block ms-2 fw-medium">Guru</span>
                </a>
            </li>
        </div>

        <form class="mt-3 mt-md-0">
            <div class="form-group d-flex gap-2 align-items-center">
                <input type="date" name="date" class="form-control px-3 py-2"
                value="{{ date('Y-m-d') }}">
                <button class="btn btn-primary px-4" type="submit">Cari</button>
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
