@extends('school.layouts.app')
<style>
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

    .form-check-input.form-secondary {
        border-color: #0896D1;
    }

    .form-check-input.form-secondary:checked {
        background-color: #0896D1;
        border-color: #0896D1;
    }

    .form-check-input.form-secondary:focus {
        border-color: #0896D1;
        box-shadow: 0 0 0 0.25rem rgba(8, 150, 209, 0.25);
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
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Jam Pelajaran</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar Jam Pelajaran
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/calender.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- <div class="card card-body"> -->
    <div class="card bg-light-warning border-warning border-1 shadow-none position-relative overflow-hidden text-light">
        <div class="card-body px-4 py-4">
            <div class="row align-items-center">
                <div class="col-12">
                    <h4 class="fw-semibold mb-8 text-dark">Informasi</h4>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb ms-3" style="list-style-type: disc; max-width: 70rem;">
                            <li class="text-dark fs-3" aria-current="page">Pada Pengaturan Awal, Jam Pelajaran Dimulai Pada Jam 07:00.</li>
                            <li class="text-dark fs-3" aria-current="page">Saat Anda Menambah Jam Pelajaran, Hanya Perlu Menambah Menit, Jam Akan Otomatis Bertambah Sesuai Menit Dan Jam Pelajaran Terakhir</li>
                            <li class="text-dark fs-3" aria-current="page">Saat Menghapus Data, Maka Yang Terakhir Dalam Jam Pelajaran Akan Terhapus</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="day-tabs-wrapper mb-3">
            <ul class="nav nav-pills rounded align-items-center flex-row" id="day-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-senin-tab" data-bs-toggle="pill" href="#pills-senin" role="tab" aria-controls="pills-senin" aria-selected="true">
                        Senin
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-selasa-tab" data-bs-toggle="pill" href="#pills-selasa" role="tab" aria-controls="pills-selasa" aria-selected="false">
                        Selasa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-rabu-tab" data-bs-toggle="pill" href="#pills-rabu" role="tab" aria-controls="pills-rabu" aria-selected="false">
                        Rabu
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-kamis-tab" data-bs-toggle="pill" href="#pills-kamis" role="tab" aria-controls="pills-kamis" aria-selected="false">
                        Kamis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-jumat-tab" data-bs-toggle="pill" href="#pills-jumat" role="tab" aria-controls="pills-jumat" aria-selected="false">
                        Jumat
                    </a>
                </li>
            </ul>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create">
            <i class="ti ti-plus me-2"></i>Tambah Jam
        </button>
    </div>
<!-- </div> -->

<div class="mt-2 card card-body">
    <div class="tab-content mt-4" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-senin" role="tabpanel" aria-labelledby="pills-senin-tab">
            @include('school.pages.subjects.panes.lesson-hours.tab-monday')
        </div>
        <div class="tab-pane fade" id="pills-selasa" role="tabpanel" aria-labelledby="pills-selasa-tab">
            @include('school.pages.subjects.panes.lesson-hours.tab-tuesday')
        </div>
        <div class="tab-pane fade" id="pills-rabu" role="tabpanel" aria-labelledby="pills-rabu-tab">
            @include('school.pages.subjects.panes.lesson-hours.tab-wednesday')
        </div>
        <div class="tab-pane fade" id="pills-kamis" role="tabpanel" aria-labelledby="pills-kamis-tab">
            @include('school.pages.subjects.panes.lesson-hours.tab-thursday')
        </div>
        <div class="tab-pane fade" id="pills-jumat" role="tabpanel" aria-labelledby="pills-jumat-tab">
            @include('school.pages.subjects.panes.lesson-hours.tab-friday')
        </div>
        <div class="tab-pane fade" id="pills-sabtu" role="tabpanel" aria-labelledby="pills-sabtu-tab">
            @include('school.pages.subjects.panes.lesson-hours.tab-saturday')
        </div>
        <div class="tab-pane fade" id="pills-minggu" role="tabpanel" aria-labelledby="pills-minggu-tab">
            @include('school.pages.subjects.panes.lesson-hours.tab-sunday')
        </div>
    </div>
</div>

<div class="pagination justify-content-end mb-0">
    {{-- <x-paginate-component :paginator="$lessonHours['monday']" /> --}}
</div>

{{-- modal --}}
@include('school.pages.subjects.widgets.modal-create-lesson-hours')
@include('school.pages.subjects.widgets.modal-update-lesson-hours')

<x-delete-modal-component />

@endsection
@section('script')
@include('school.pages.subjects.script.script-lesson-hours')
@endsection
