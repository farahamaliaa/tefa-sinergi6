@extends('school.layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('admin_assets/dist/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">
    <style>
        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
        }

        .card-hover:hover {
            border-color: #00A9D9 !important;
            transition: .2s ease-in-out;
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

        .card.card-body {
            box-shadow: none !important;
            border: 1px solid #E0E6ED !important;
            border-radius: 10px !important;
        }

        @media (max-width: 767.98px) {
            .card {
                height: auto !important;
            }

            .position-absolute {
                position: relative;
                width: 100px;
                margin-bottom: 0;
                margin-right: 0;
            }

            .row.d-flex.align-items-stretch {
                flex-direction: column;
            }

            .col-lg-3,
            .col-lg-9 {
                width: 100%;
                margin-bottom: 20px;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .card {
                height: auto;
            }

            .position-absolute {
                width: 100px;
                margin-bottom: -10px;
                margin-right: -10px;
            }

            .col-lg-3,
            .col-lg-9 {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>

    @include('school.pages.dashboard.style.journal-statistics')
@endsection

@section('content')
    @include('school.pages.dashboard.panes.corousel')

    @include('school.pages.dashboard.panes.school-year')

    <h4 class="mb-4"><b>Data Absensi Hari Ini</b></h4>

    <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row justify-content-between">
        <div class="d-flex">
            <li class="nav-item">
                <a href="#student-content" data-bs-toggle="tab"
                    class="nav-link note-link d-flex align-items-center justify-content-center active px-3 px-md-3 me-0 me-md-2 text-body-color"
                    id="student">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M17.928 19.634h2.138a1.165 1.165 0 0 0 1.116-1.555a6.851 6.851 0 0 0-6.117-3.95m0-2.759a3.664 3.664 0 0 0 3.665-3.664a3.664 3.664 0 0 0-3.665-3.674m-1.04 16.795a1.908 1.908 0 0 0 1.537-3.035a8.026 8.026 0 0 0-6.222-3.196a8.026 8.026 0 0 0-6.222 3.197a1.909 1.909 0 0 0 1.536 3.034zM9.34 11.485a4.16 4.16 0 0 0 4.15-4.161a4.151 4.151 0 0 0-8.302 0a4.16 4.16 0 0 0 4.151 4.16" />
                    </svg>
                    <span class="d-none d-md-block ms-2 font-weight-medium">Siswa</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#employee-content" data-bs-toggle="tab"
                    class="nav-link note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 text-body-color"
                    id="employee">
                    <svg width="23" height="18" viewBox="0 0 23 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor"
                            d="M0 0V1.75H19.25V15.75H7V17.5H22.75V15.75H21V0H0ZM3.50175 2.625C2.57432 2.62823 1.68578 2.99796 1.02982 3.65358C0.373863 4.30921 0.00368934 5.19758 0 6.125C0 8.04912 1.5785 9.625 3.50175 9.625C4.42871 9.62131 5.31663 9.25132 5.97193 8.59569C6.62723 7.94006 6.99677 7.05196 7 6.125C7 4.20262 5.42325 2.625 3.50175 2.625ZM8.75 3.5V5.25H13.125V3.5H8.75ZM14.875 3.5V5.25H17.5V3.5H14.875ZM3.50175 4.375C4.4765 4.375 5.25 5.14762 5.25 6.125C5.25 7.105 4.47738 7.875 3.50175 7.875C2.52175 7.875 1.75 7.105 1.75 6.125C1.75 5.14762 2.52262 4.375 3.50175 4.375ZM8.75 7V8.75H17.5V7H8.75ZM0 10.5V17.5H1.75V12.25H4.375V17.5H6.125V12.8258L7.931 13.7812C8.44287 14.0525 9.058 14.0516 9.569 13.7812V13.783L12.6577 12.1494L11.8414 10.6006L8.75175 12.2343L6.04275 10.8045C5.66474 10.6046 5.24361 10.5001 4.816 10.5H0Z"
                            fill="#0896D1" />
                    </svg>
                    <span class="d-none d-md-block ms-2 font-weight-medium">Pegawai</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#extra-content" data-bs-toggle="tab"
                    class="nav-link note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 text-body-color"
                    id="extra">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentcolor"
                            d="M18.3085 7.0618L17.5347 6.28803L18.0746 5.71895C18.2193 5.57499 18.2916 5.41266 18.2916 5.23196C18.2916 5.05202 18.2193 4.88969 18.0746 4.74498L15.2539 1.92543C15.1099 1.78148 14.948 1.7095 14.768 1.7095C14.5881 1.7095 14.4258 1.78148 14.2811 1.92543L13.712 2.46528L12.9101 1.66339L13.5376 1.0077C13.8676 0.677801 14.2721 0.517723 14.7512 0.52747C15.2303 0.537217 15.6348 0.706668 15.9647 1.03582L18.9642 4.03644C19.2941 4.36634 19.459 4.76597 19.459 5.23534C19.459 5.7047 19.2941 6.10433 18.9642 6.43424L18.3085 7.0618ZM6.43424 18.9642C6.10433 19.2941 5.7047 19.459 5.23534 19.459C4.76597 19.459 4.36634 19.2941 4.03644 18.9642L1.12354 16.0513C0.778646 15.7064 0.606197 15.2775 0.606197 14.7647C0.606197 14.2518 0.778646 13.8233 1.12354 13.4792L1.66339 12.9382L2.4664 13.7412L1.91869 14.2811C1.77473 14.4258 1.70275 14.5881 1.70275 14.768C1.70275 14.948 1.77473 15.1103 1.91869 15.255L4.74611 18.0813C4.89006 18.226 5.05202 18.2984 5.23196 18.2984C5.41191 18.2984 5.57424 18.226 5.71895 18.0813L6.25879 17.5347L7.0618 18.3366L6.43424 18.9642ZM17.3806 11.3119L18.6594 10.0332C18.8034 9.88922 18.8753 9.72352 18.8753 9.53607C18.8753 9.34863 18.8034 9.18293 18.6594 9.03897L10.961 1.34173C10.8171 1.19702 10.6514 1.12467 10.4639 1.12467C10.2765 1.12467 10.1108 1.19665 9.96682 1.34061L8.68807 2.61936C8.54412 2.76331 8.47214 2.92564 8.47214 3.10634C8.47214 3.28628 8.54412 3.44861 8.68807 3.59332L16.4078 11.3119C16.5518 11.4559 16.7137 11.5279 16.8937 11.5279C17.0736 11.5279 17.2359 11.4559 17.3806 11.3119ZM10.0051 18.6875L11.2838 17.402C11.4278 17.2581 11.4997 17.0961 11.4997 16.9162C11.4997 16.7362 11.4278 16.5739 11.2838 16.4292L3.57083 8.71619C3.42687 8.57223 3.26454 8.50025 3.08384 8.50025C2.9039 8.50025 2.74194 8.57223 2.59799 8.71619L1.31249 9.99494C1.16853 10.1389 1.09655 10.3046 1.09655 10.492C1.09655 10.6795 1.16853 10.8452 1.31249 10.9891L9.01085 18.6864C9.15481 18.8311 9.32051 18.9034 9.50796 18.9034C9.6954 18.9034 9.8611 18.8315 10.0051 18.6875ZM9.20879 12.7571L12.7346 9.23691L10.762 7.26537L7.24287 10.7912L9.20879 12.7571ZM10.7856 19.4827C10.4414 19.8276 10.0156 20 9.50796 20C9.00036 20 8.57411 19.8276 8.22921 19.4827L0.517348 11.7708C0.172449 11.4259 0 10.9996 0 10.492C0 9.98444 0.172449 9.55857 0.517348 9.21442L1.79497 7.9143C2.13987 7.5694 2.56875 7.39695 3.08159 7.39695C3.59444 7.39695 4.02294 7.5694 4.36709 7.9143L6.44098 9.98819L9.96682 6.46235L7.89293 4.39521C7.54803 4.05031 7.37558 3.62069 7.37558 3.10634C7.37558 2.59199 7.54803 2.16236 7.89293 1.81747L9.19192 0.517348C9.53682 0.172449 9.96532 0 10.4774 0C10.9895 0 11.4184 0.172449 11.764 0.517348L19.4827 8.23596C19.8276 8.58085 20 9.00973 20 9.52258C20 10.0354 19.8276 10.4639 19.4827 10.8081L18.1837 12.1082C17.8388 12.4531 17.4088 12.6255 16.8937 12.6255C16.3786 12.6255 15.9489 12.4531 15.6048 12.1082L13.5376 10.0332L10.0118 13.559L12.0857 15.6329C12.4306 15.9778 12.603 16.4067 12.603 16.9195C12.603 17.4324 12.4306 17.8609 12.0857 18.205L10.7856 19.4827Z"
                            fill="#0896D1" />
                    </svg>
                    <span class="d-none d-md-block ms-2 font-weight-medium">Pembina Extra</span>
                </a>
            </li>
        </div>

        <form class="mt-4 mt-md-0">
            <div class="form-group d-flex gap-2">
                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
                <button class="btn text-white" type="submit" style="background-color: #0896d1; border-color: #0896d1;">
                    Cari
                </button>
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

        <div id="extra-content" class="tab-pane fade">
            <div class="note-has-grid row">
                <div class="col-12">
                    @include('school.pages.dashboard.panes.extra-tab.index')
                </div>
            </div>
        </div>
    </div>

    {{-- <h4 class="mb-4"><b>Data Pelanggaran</b></h4>
    @include('school.pages.dashboard.panes.violations-list') --}}

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
            window.attendanceChart = new ApexCharts(document.querySelector("#investments"), investments);
            window.attendanceChart.render();
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
            series: [{{ $fill->count() }}, {{ $notfill->count() }}], // Updated to use real data initially
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
            colors: ['#13deb9', '#fa896b'], // Green for filled, Red for not filled
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

        window.journalChart = new ApexCharts(document.querySelector('#jurnal'), breakupOptions);
        window.journalChart.render();
    </script>
    <script>
        setInterval(function() {
            fetch("{{ route('school.realtime-data') }}")
                .then(response => response.json())
                .then(data => {
                    // Update Counts
                    if (data.counts) {
                        // Student
                        if (document.getElementById('student-late-count')) document.getElementById(
                            'student-late-count').innerText = data.counts.student_late + " Siswa";
                        if (document.getElementById('student-permit-count')) document.getElementById(
                            'student-permit-count').innerText = data.counts.student_permit + " Siswa";
                        if (document.getElementById('student-alpha-count')) document.getElementById(
                            'student-alpha-count').innerText = data.counts.student_alpha + " Siswa";

                        // Employee
                        if (document.getElementById('employee-late-count')) document.getElementById(
                            'employee-late-count').innerText = data.counts.employee_late + " Staff";
                        if (document.getElementById('employee-permit-count')) document.getElementById(
                            'employee-permit-count').innerText = data.counts.employee_permit + " Guru";
                        if (document.getElementById('employee-alpha-count')) document.getElementById(
                            'employee-alpha-count').innerText = data.counts.employee_alpha + " Guru";

                        // Extra (re-using employee data as per current implementation)
                        if (document.getElementById('extra-late-count')) document.getElementById(
                            'extra-late-count').innerText = data.counts.employee_late + " Pembina";
                        if (document.getElementById('extra-permit-count')) document.getElementById(
                            'extra-permit-count').innerText = data.counts.employee_permit + " Pembina";
                        if (document.getElementById('extra-alpha-count')) document.getElementById(
                            'extra-alpha-count').innerText = data.counts.employee_alpha + " Pembina";
                    }

                    // Update Panes/Tables
                    if (data.panes) {
                        // Student Tables
                        if (document.getElementById('student-late-table')) document.getElementById(
                            'student-late-table').innerHTML = data.panes.student_late;
                        if (document.getElementById('student-permit-table')) document.getElementById(
                            'student-permit-table').innerHTML = data.panes.student_permit;
                        if (document.getElementById('student-alpha-table')) document.getElementById(
                            'student-alpha-table').innerHTML = data.panes.student_alpha;

                        // Employee Tables
                        if (document.getElementById('employee-late-table')) document.getElementById(
                            'employee-late-table').innerHTML = data.panes.employee_late;
                        if (document.getElementById('employee-permit-table')) document.getElementById(
                            'employee-permit-table').innerHTML = data.panes.employee_permit;
                        if (document.getElementById('employee-alpha-table')) document.getElementById(
                            'employee-alpha-table').innerHTML = data.panes.employee_alpha;

                        // Extra Tables (re-using Student data as per current implementation mirror)
                        if (document.getElementById('extra-late-table')) document.getElementById(
                            'extra-late-table').innerHTML = data.panes.student_late;
                        if (document.getElementById('extra-permit-table')) document.getElementById(
                            'extra-permit-table').innerHTML = data.panes.student_permit;
                        if (document.getElementById('extra-alpha-table')) document.getElementById(
                            'extra-alpha-table').innerHTML = data.panes.student_alpha;

                        // Journal Panes
                        if (document.getElementById('staff-journal-container')) document.getElementById(
                            'staff-journal-container').innerHTML = data.panes.staff_journal;
                        if (document.getElementById('teacher-journal-container')) document.getElementById(
                            'teacher-journal-container').innerHTML = data.panes.teacher_journal;
                        if (document.getElementById('extra-teacher-journal-container')) document.getElementById(
                            'extra-teacher-journal-container').innerHTML = data.panes.teacher_journal;
                    }

                    // Update Charts
                    if (data.charts) {
                        // Attendance Chart
                        if (window.attendanceChart && data.charts.attendance) {
                            var attData = data.charts.attendance;
                            var data1 = attData.map(item => item.attendance_present);
                            var data2 = attData.map(item => item.attendance_permit);
                            var data3 = attData.map(item => item.attendance_sick);
                            var data4 = attData.map(item => item.attendance_alpha);

                            window.attendanceChart.updateSeries([{
                                    name: "Masuk",
                                    data: data1
                                },
                                {
                                    name: "Izin",
                                    data: data2
                                },
                                {
                                    name: "Sakit",
                                    data: data3
                                },
                                {
                                    name: "Alpha",
                                    data: data4
                                }
                            ]);
                        }

                        // Student Statistic Chart (Donut)
                        if (window.studentStatisticChart && data.charts.student) {
                            var stuData = data.charts.student;
                            window.studentStatisticChart.updateSeries([
                                stuData.chartSick,
                                stuData.chartLate,
                                stuData.chartAlpha
                            ]);
                        }

                        if (window.employeeStatisticChart && data.charts.employee) {
                            var empData = data.charts.employee;
                            window.employeeStatisticChart.updateSeries([
                                empData.chartSick,
                                empData.chartLate,
                                empData.chartAlpha
                            ]);
                        }

                        if (window.extraStatisticChart && data.charts.extra) {
                            var extData = data.charts.extra;
                            window.extraStatisticChart.updateSeries([
                                extData.chartSick,
                                extData.chartLate,
                                extData.chartAlpha
                            ]);
                        }

                        // Violation Chart (Line)
                        if (window.violationChart && data.charts.violation) {
                            var vioData = data.charts.violation.map(item => item.violation);
                            window.violationChart.updateSeries([{
                                data: vioData
                            }]);
                        }

                        // Journal Chart (Donut)
                        if (window.journalChart && data.charts.journal) {
                            window.journalChart.updateSeries([
                                data.charts.journal.fill,
                                data.charts.journal.notfill
                            ]);
                        }
                    }
                })
                .catch(error => console.error('Error fetching realtime data:', error));
        }, 5000); // Update every 5 seconds
    </script>
@endsection
