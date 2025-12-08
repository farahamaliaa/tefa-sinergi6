@extends('school.layouts.app')
<style>
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
</style>
@section('content')

    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Kelas</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Masuk kelas untuk atur jadwal
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
<div class="card card-body">
    <h4>Daftar Kelas</h4>
    <div class="row mb-4 mt-4">
        <form class="col-12 col-lg-10" action="">
            <div class="row">
                <div class="col-12 col-lg-3 mb-2">
                    <input type="text" name="name" class="form-control product-search" id="input-search"
                        placeholder="Cari..." value="{{ old('name', request()->name) }}">
                </div>
                <!-- <div class="col-12 col-lg-3 mb-2">
                    <select name="school_year" class="form-select me-2" id="select-school-year">
                        <option value="" disabled selected>Pilih Tahun Ajaran</option>
                        @foreach ($schoolYears as $schoolYear)
                            <option value="{{ $schoolYear->school_year }}"
                                {{ old('school_year', request()->school_year) == $schoolYear->school_year ? 'selected' : '' }}>
                                {{ $schoolYear->school_year }}
                            </option>
                        @endforeach
                    </select>
                </div> -->
                <div class="col-12 col-lg-1 mb-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
        <!-- <div class="col-12 col-lg-2  mb-2">
            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#modal-import">
                Import Jadwal
            </button>
        </div> -->
    </div>


    <div class="row">
        @forelse ($classrooms as $classroom)
            <div class="col-lg-3">
                <div class="card border">
                    <div class="position-relative">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h4 class="mb-2"><b>{{ $classroom->name }}</b></h4>
                                <div class="d-flex align-items-center">
                                    <span
                                        class="mb-1 badge font-medium bg-light-primary text-secondary fs-3">{{ $classroom->schoolYear->school_year }}</span>
                                </div>
                            </div>
                            <span class="fs-4">{{ $classroom->employee->user->name }}</span>
                            <div class="d-flex align-items-center mb-4 pt-3">
                                <div class="bg-light-primary text-secondary p-1 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 16 16">
                                        <path fill="currentColor"
                                            d="M15 14s1 0 1-1s-1-4-5-4s-5 3-5 4s1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276c.593.69.758 1.457.76 1.72l-.008.002l-.014.002zM11 7a2 2 0 1 0 0-4a2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0a3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904c.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724c.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0a3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4a2 2 0 0 0 0-4" />
                                    </svg>
                                    <span class="ms-2 fs-4">
                                        {{ $classroom->classroomStudents->count() }} Siswa
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('school.lesson-schedule.detail', ['classroom' => $classroom->id]) }}"
                                class="btn waves-effect waves-light btn-primary w-100">Masuk Kelas</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="d-flex flex-column justify-content-center align-items-center">
                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="300px">
                <p class="fs-5 text-dark text-center mt-2">
                    Belum ada data
                </p>
            </div>
        @endforelse
    </div>
</div>

    @include('school.pages.lesson-schedule.widgets.import')
@endsection
