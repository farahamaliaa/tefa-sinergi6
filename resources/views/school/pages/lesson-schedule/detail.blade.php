@extends('school.layouts.app')

@section('style')
<style>
    .category-selector .dropdown-menu {
        position: absolute;
        z-index: 1050;
        transform: translate3d(0, 0, 0);
    }

    .select2 {
        width: 100% !important;
    }

    .select2-selection__rendered {
        width: 100%;
        height: 36px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .select2-selection {
        height: fit-content !important;
        color: #555 !important;
        background-color: #fff !important;
        background-image: none !important;
        border: 1px solid #ccc !important;
        border-radius: 4px !important;
    }

    .category-selector .dropdown-menu {
        position: absolute;
        z-index: 1050;
        transform: translate3d(0, 0, 0);
    }

    .select2-custom {
        width: 100% !important;
    }

    .select2-custom-selection__rendered {
        width: 100%;
        height: 36px;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .select2-custom-selection {
        height: fit-content !important;
        color: #555 !important;
        background-color: #fff !important;
        background-image: none !important;
        border: 1px solid #ccc !important;
        border-radius: 4px !important;
    }
            .table-custom-header th {
        background-color: #0896D1 !important;
        color: #fff;
    }
    .btn-primary {
        background-color: #0896D1 !important;
        border-color: #0896D1 !important;
    }

    .btn-primary:hover {
        background-color: #067aa7 !important;
        border-color: #067aa7 !important;
    }

    .btn-import {
        background-color: #1EB196 !important;
        border-color: #1EB196 !important;
        color: #fff !important;
    }

    .btn-import:hover {
        background-color: #1e9c87 !important;
        border-color: #1e9c87 !important;
    }

    .card.card-body {
        box-shadow: none !important;
        border: 1px solid #E0E6ED !important;
        border-radius: 10px !important;
    }
    .btn-action {
        border: none !important;
        border-radius: 8px !important;
        padding: 6px 8px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-detail-action {
        background-color: #0dcaf0 !important;
        color: #fff !important;
    }
    .btn-detail-action:hover {
        background-color: #0bb5d8 !important;
    }

    .btn-edit-action {
        background-color: #FFC107 !important;
        color: #fff !important;
    }
    .btn-edit-action:hover {
        background-color: #e6ae06 !important;
    }

    .btn-delete-action {
        background-color: #DC3545 !important;
        color: #fff !important;
    }
    .btn-delete-action:hover {
        background-color: #bb2d3b !important;
    }   
    .bg-year {
        background-color: #ECF2FF !important;
    } 
    .rounded {
        border-radius: 10px !important;
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
    .day-tabs-wrapper {
        border: 1px solid #E0E6ED !important;
        border-color: 10px solid !important;
        background: #ffffff;
        padding: 10px 16px;
        border-radius: 50px;
        overflow-x: auto;
        overflow-y: visible;
        margin-bottom: 1.5rem;
    }

    .day-tabs-wrapper::-webkit-scrollbar {
        display: none;
    }

    #day-tabs {
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        gap: 0.5rem;
        flex-wrap: nowrap;
        margin: 0;
        padding: 0;
        width: 100%;
    }

    /* Tab item */
    #day-tabs .nav-link {
        padding: 0.5rem 1.5rem;
        font-size: 0.9rem;
        border: none;
        border-radius: 36px;
        color: #333;
        background-color: transparent;
        transition: all 0.3s ease;
        white-space: nowrap;
        box-shadow: none;
    }

    #day-tabs .nav-link.active {
        background-color: #0A8FC8;
        color: white;
        box-shadow: 0px 2px 8px rgba(13, 156, 230, 0.3);
    }

    #day-tabs .nav-link:hover {
        background-color: #f0f0f0;
    }

    #day-tabs .nav-link.active:hover {
        background-color: #0A8FC8;
    }
</style>
@endsection

@section('content')
    <!-- <div class="card bg-light-primary shadow-none position-relative overflow-hidden border border-primary">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Jadwal Pelajaran</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">`
                            <li class="breadcrumb-item" aria-current="page">{{ $classroom->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div> -->

    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Jadwal Pelajarann</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white" aria-current="page">{{ $classroom->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/clipboard.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="day-tabs-wrapper mb-0">
            <ul class="nav nav-pills rounded align-items-center flex-row" id="day-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-senin-tab" data-bs-toggle="pill" href="#pills-senin" role="tab"
                        aria-controls="pills-senin" aria-selected="true">
                        Senin
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-selasa-tab" data-bs-toggle="pill" href="#pills-selasa" role="tab"
                        aria-controls="pills-selasa" aria-selected="false">
                        Selasa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-rabu-tab" data-bs-toggle="pill" href="#pills-rabu" role="tab"
                        aria-controls="pills-rabu" aria-selected="false">
                        Rabu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-kamis-tab" data-bs-toggle="pill" href="#pills-kamis" role="tab"
                        aria-controls="pills-kamis" aria-selected="false">
                        Kamis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-jumat-tab" data-bs-toggle="pill" href="#pills-jumat" role="tab"
                        aria-controls="pills-jumat" aria-selected="false">
                        Jumat
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-sabtu-tab" data-bs-toggle="pill" href="#pills-sabtu" role="tab"
                        aria-controls="pills-sabtu" aria-selected="false">
                        Sabtu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-minggu-tab" data-bs-toggle="pill" href="#pills-minggu" role="tab"
                        aria-controls="pills-minggu" aria-selected="false">
                        Minggu
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-primary btn-create" id="btn-tambah-jadwal" data-classroom="{{ $classroom->id }}" data-day="monday">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/></svg>
                    Tambah Jadwal
                </button>
                <button class="btn btn-import" data-bs-toggle="modal" data-bs-target="#modal-import">
                    <svg width="20" height="20" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.7699 8.92256V23.1726M13.7699 8.92256L18.5199 13.6726M13.7699 8.92256L9.0199 13.6726M22.4782 16.8392C24.8833 16.8392 26.4366 14.8901 26.4366 12.4851C26.4365 11.5329 26.1243 10.607 25.5478 9.84915C24.9712 9.09133 24.1622 8.54338 23.2446 8.28923C23.1034 6.51346 22.3674 4.8372 21.1557 3.53146C19.9439 2.22573 18.3272 1.36684 16.5669 1.09366C14.8066 0.820475 13.0056 1.14897 11.4551 2.02602C9.90454 2.90308 8.69515 4.27744 8.0224 5.9269C6.60599 5.53427 5.09162 5.72038 3.81244 6.44431C2.53325 7.16823 1.59403 8.37065 1.2014 9.78707C0.808771 11.2035 0.994888 12.7178 1.71881 13.997C2.44273 15.2762 3.64516 16.2154 5.06157 16.6081" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Import jadwal
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Use 'a' tags since nav-pills use anchor elements
            const tabs = document.querySelectorAll('#day-tabs .nav-link');
            const btnTambah = document.getElementById('btn-tambah-jadwal');
            
            // Map tab IDs to day names expected by the controller (e.g., 'monday', 'tuesday')
            const dayMap = {
                'pills-senin-tab': 'monday',
                'pills-selasa-tab': 'tuesday',
                'pills-rabu-tab': 'wednesday',
                'pills-kamis-tab': 'thursday',
                'pills-jumat-tab': 'friday',
                'pills-sabtu-tab': 'saturday',
                'pills-minggu-tab': 'sunday'
            };

            tabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function (event) {
                    const targetId = event.target.id;
                    const day = dayMap[targetId];
                    if (day) {
                        btnTambah.setAttribute('data-day', day);
                    }
                });
            });
        });
    </script>

    <div class="mt-2 card card-body">
        <div class="d-flex align-items-center mb-2">
            <h4 class="fw-semibold mb-0">Daftar Jadwal Pelajaran</h4>
            <span class="mx-2 fw-semibold fs-5">/</span>
            <span class="badge bg-light-primary text-secondary rounded-sm px-2 py-2 fs-3 fw-semibold">
                {{ $classroom->name }}
            </span>
        </div>
        <div class="tab-content mt-9" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-senin" role="tabpanel" aria-labelledby="pills-senin-tab">
                @include('school.pages.lesson-schedule.panes.tab-monday')
            </div>
            <div class="tab-pane fade" id="pills-selasa" role="tabpanel" aria-labelledby="pills-selasa-tab">
                @include('school.pages.lesson-schedule.panes.tab-tuesday')
            </div>
            <div class="tab-pane fade" id="pills-rabu" role="tabpanel" aria-labelledby="pills-rabu-tab">
                @include('school.pages.lesson-schedule.panes.tab-wednesday')
            </div>
            <div class="tab-pane fade" id="pills-kamis" role="tabpanel" aria-labelledby="pills-kamis-tab">
                @include('school.pages.lesson-schedule.panes.tab-thursday')
            </div>
            <div class="tab-pane fade" id="pills-jumat" role="tabpanel" aria-labelledby="pills-jumat-tab">
                @include('school.pages.lesson-schedule.panes.tab-friday')
            </div>
            <div class="tab-pane fade" id="pills-sabtu" role="tabpanel" aria-labelledby="pills-sabtu-tab">
                @include('school.pages.lesson-schedule.panes.tab-saturday')
            </div>
            <div class="tab-pane fade" id="pills-minggu" role="tabpanel" aria-labelledby="pills-minggu-tab">
                @include('school.pages.lesson-schedule.panes.tab-sunday')
            </div>
        </div>
    </div>

    @include('components.delete-modal-component')
    @include('school.pages.lesson-schedule.widgets.create')
    @include('school.pages.lesson-schedule.widgets.update')
    @include('school.pages.lesson-schedule.widgets.import')

@endsection

@section('script')
    @include('school.pages.lesson-schedule.scripts.create')
    @include('school.pages.lesson-schedule.scripts.update')
    @include('school.pages.lesson-schedule.scripts.delete')
    @include('school.pages.lesson-schedule.scripts.select2')
    @include('school.pages.lesson-schedule.scripts.tab')
@endsection
