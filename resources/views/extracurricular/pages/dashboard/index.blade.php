@extends('extracurricular.layouts.app')

@section('style')
    <style>
        .bg-ekstra {
            background-image: url('{{ asset('assets/images/bg-ekstra.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100%;
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

        .scroll-container {
            white-space: nowrap;
            overflow-x: auto;
        }

        .scroll-container::-webkit-scrollbar {
            height: 6px;
        }

        .scroll-container::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        .scroll-container::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        .scroll-container {
            scrollbar-width: thin;
            scrollbar-color: #888 #f0f0f0;
        }

        .nav-pills .nav-link.active {
            background-color: #0B95D0 !important;
            color: white !important;
        }

        .nav-pills .nav-link:hover {
            background-color: #0B95D0 !important;
            color: white !important;
        }

        .nav-pills .nav-link {
            color: #0B95D0 !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @include('extracurricular.pages.dashboard.panes.profile')
        </div>
    </div>

    <div class="card card-body">
        <h4 class="mb-4 fw-bolder">Jadwal Mengajar</h4>
        <div class="border rounded-pill p-1 d-inline-block w-100" style="max-width: 600px;">
            <ul class="nav nav-pills nav-justified" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill" id="pills-senin-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-senin" type="button" role="tab" aria-controls="pills-senin"
                        aria-selected="true">
                        Senin
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-selasa-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-selasa" type="button" role="tab" aria-controls="pills-selasa"
                        aria-selected="false">
                        Selasa
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-rabu-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-rabu" type="button" role="tab" aria-controls="pills-rabu"
                        aria-selected="false">
                        Rabu
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-kamis-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-kamis" type="button" role="tab" aria-controls="pills-kamis"
                        aria-selected="false">
                        Kamis
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-jumat-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-jumat" type="button" role="tab" aria-controls="pills-jumat"
                        aria-selected="false">
                        Jumat
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content mt-4" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-senin" role="tabpanel" aria-labelledby="pills-senin-tab">
                @include('extracurricular.pages.dashboard.panes.schedule-tab.tab-monday')
            </div>
            <div class="tab-pane fade" id="pills-selasa" role="tabpanel" aria-labelledby="pills-selasa-tab">
                @include('extracurricular.pages.dashboard.panes.schedule-tab.tab-tuesday')
            </div>
            <div class="tab-pane fade" id="pills-rabu" role="tabpanel" aria-labelledby="pills-rabu-tab">
                @include('extracurricular.pages.dashboard.panes.schedule-tab.tab-wednesday')
            </div>
            <div class="tab-pane fade" id="pills-kamis" role="tabpanel" aria-labelledby="pills-kamis-tab">
                @include('extracurricular.pages.dashboard.panes.schedule-tab.tab-thursday')
            </div>
            <div class="tab-pane fade" id="pills-jumat" role="tabpanel" aria-labelledby="pills-jumat-tab">
                @include('extracurricular.pages.dashboard.panes.schedule-tab.tab-friday')
            </div>
            <div class="tab-pane fade" id="pills-sabtu" role="tabpanel" aria-labelledby="pills-sabtu-tab">
                @include('extracurricular.pages.dashboard.panes.schedule-tab.tab-saturday')
            </div>
            <div class="tab-pane fade" id="pills-minggu" role="tabpanel" aria-labelledby="pills-minggu-tab">
                @include('extracurricular.pages.dashboard.panes.schedule-tab.tab-sunday')
            </div>
        </div>
    </div>

    <h4 style="font-size: 30px;" class="fw-bold">Riwayat Jurnal</h4>
    <h6 class="mb-4">Daftar jurnal pembina setelah berkegiatan ekstrakurikuler</h6>

    <div class="row">
        <div class="col-lg-12">
            @include('extracurricular.pages.dashboard.panes.journal-history')
        </div>
    </div>

    @if ($recentJournals->count() > 3)
        <a class="btn mb-5 waves-effect waves-light btn-outline-info w-100" href="{{ route('extracurricular.list') }}">Lihat
            Selengkapnya
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16">
                <path fill="currentColor"
                    d="M8.22 2.97a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.042-.018a.75.75 0 0 1-.018-1.042l2.97-2.97H3.75a.75.75 0 0 1 0-1.5h7.44L8.22 4.03a.75.75 0 0 1 0-1.06" />
            </svg>
        </a>
    @endif
@endsection
