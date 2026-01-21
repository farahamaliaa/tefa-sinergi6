@extends('school.layouts.app')

@section('style')
    <style>
        #keagamaan {
            display: none;
        }

        #editKeagamaan {
            display: none;
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

    /* Custom Pagination Style */
    .pagination .page-item .page-link {
        border-radius: 8px;
        border: 1px solid #EAEFF4;
        color: #0896D1;
        margin: 0 4px;
        font-weight: 600;
        padding: 6px 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 35px;
        min-width: 35px;
    }

    .pagination .page-item.active .page-link {
        background-color: #0896D1;
        border-color: #0896D1;
        color: #fff;
    }

    .pagination .page-item.disabled .page-link {
        color: #A5A5A5;
        background-color: transparent;
        border-color: #EAEFF4;
    }
    
    .pagination .page-item:first-child .page-link, 
    .pagination .page-item:last-child .page-link {
        border-radius: 8px;
    }

    .pagination .page-item .page-link:hover {
        background-color: #EAEFF4;
        color: #0896D1;
    }

    .pagination .page-item.active .page-link:hover {
        background-color: #0896D1;
        color: #fff;
    }

    .pagination .page-item .page-link.pagination-dots {
        border: none;
        padding-bottom: 12px;
        background-color: transparent;
        color: #000;
        font-weight: 900;
    }
    </style>
@endsection

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Mata Pelajaran</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar - daftar Mata Pelajaran
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/booktumpuk3.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 mb-3">
            <div class="col-12 col-lg-3">
                <div class="d-flex gap-2">
                    <form class="position-relative d-flex">
                        <input type="text" class="form-control product-searc ps-5 me-2" name="name"
                            value="{{ old('name', request()->name) }}" id="input-search" placeholder="Cari...">
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-12 col-lg-2 mb-3">
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modal-create">
                <i class="ti ti-plus"></i>
                Tambah Pelajaran
            </button>
        </div>
    </div>

    <div class="row">
        @forelse ($subjects as $subject)
            <div class="col-lg-4">
                <div class="card position-relative">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h4 class="mb-0">{{ $subject->name }}</h4>
                            <div class="btn-group">
                                <a class="nav-link label-group p-0" data-bs-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="true" aria-expanded="true">
                                    <div>
                                        <span class="more-options text-dark">
                                            <i class="ti ti-dots-vertical fs-5"></i>
                                        </span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" data-popper-placement="bottom-end">
                                    <button type="button"
                                        class="note-business badge-group-item badge-business dropdown-item position-relative category-business d-flex align-items-center btn-edit gap-3"
                                        data-id="{{ $subject->id }}" data-name="{{ $subject->name }}"
                                        data-religion="{{ $subject->religion_id }}">
                                        <i class="fs-4 ti ti-edit"></i>
                                        Edit
                                    </button>

                                    <button
                                        class="note-business text-danger badge-group-item badge-business dropdown-item position-relative category-business d-flex align-items-center btn-delete gap-3"
                                        data-id="{{ $subject->id }}">
                                        <i class="fs-4 ti ti-trash"></i>
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="align-items-center pt-3">
                            <h6 class="mb-3">Jenis Pelajaran :</h6>
                            <div class="d-flex align-items-center">
                                @if ($subject->religion)
                                    <span class="mb-1 badge font-medium fs-5 bg-light-warning text-warning">
                                        Keagamaan
                                    </span>
                                    <span class="mb-1 badge font-medium ms-2 fs-5 bg-light-secondary text-secondary">
                                        {{ $subject->religion->name }}
                                    </span>
                                @else
                                    <span class="mb-1 badge font-medium fs-5 bg-light-secondary text-secondary">
                                        Umum
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <!-- Image Container -->
                    <div class="position-absolute bottom-0 end-0" style="padding: 0px;">
                        <img src="{{ asset('assets/images/background/bub3.png') }}" alt="Description" class="img-fluid"
                            style="max-width: 100px; height: auto;">
                    </div>
                </div>
            </div>

        @empty
            <div class="d-flex flex-column justify-content-center align-items-center">
                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="300px">
                <p class="fs-5 text-dark text-center mt-2">
                    Mata pelajaran belum ditambahkan
                </p>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mb-0">
        <x-paginate-component :paginator="$subjects->appends(request()->input())" />
    </div>

    @include('school.pages.subjects.widgets.modal-create-subject')
    @include('school.pages.subjects.widgets.modal-update-subject')

    <x-delete-modal-component />
@endsection

@section('script')
    @include('school.pages.subjects.script.script-create-subjects')
    @include('school.pages.subjects.script.session')
@endsection
