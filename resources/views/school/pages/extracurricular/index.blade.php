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

        .btn-primary {
            background-color: #0896D1 !important;
            border-color: #0896D1 !important;
        }

        .btn-primary:hover {
            background-color: #067aa7 !important;
            border-color: #067aa7 !important;
        }

        /* Custom Switch */
        .custom-switch {
            position: relative;
            display: inline-block;
            width: 65px;
            height: 25px;
        }

        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #6c757d;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #0896D1;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(40px);
            -ms-transform: translateX(40px);
            transform: translateX(40px);
        }

        .slider-text {
            color: white;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            font-weight: 500;
        }

        .text-on {
            left: 10px;
            display: none;
        }

        .text-off {
            right: 15px;
            display: block;
        }

        input:checked~.slider .text-on {
            display: block;
        }

        input:checked~.slider .text-off {
            display: none;
        }

        /* Pagination Styles */
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
                    <h4 class="fw-semibold text-white mb-8">Ekstrakurikuler</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar ekstrakurikuler yang disekolah
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/ballball.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body">
        <h4 class="mb-4">Daftar Ekstrakurikuler</h4>
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
            <div class="col-12 col-md-6 col-lg-4 mb-3 me-3">
                <form class="d-flex gap-2" action="/school/extracurricular">
                    <div class="position-relative w-70">
                        <input type="text" name="search" class="form-control product-search ps-5" id="input-search"
                            placeholder="Cari..." value="{{ old('search', request()->search) }}">
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
            <div class="col-12 col-lg-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create">
                    <i class="ti ti-plus me-2"></i> Tambah Ekstrakurikuler
                </button>
            </div>
        </div>

        <div class="row">
            @forelse ($extracurriculars as $extracurricular)
                <div class="col-lg-3 mb-3">
                    <div class="card border">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h4 class="mb-2"><b>{{ $extracurricular->name }}</b></h4>
                                <div class="d-flex align-items-center">
                                    <label class="custom-switch">
                                        <input type="checkbox" id="status-{{ $extracurricular->id }}" {{ $extracurricular->is_active ? 'checked' : '' }}>
                                        <span class="slider">
                                            {{-- <span class="slider-text text-on">Aktif</span>
                                            <span class="slider-text text-off">Non</span> --}}
                                        </span>
                                    </label>
                                    <div class="dropdown dropstart">
                                        <a href="#" class="text-muted" id="dropdownMenuButton{{ $extracurricular->id }}"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="category">
                                                <div class="category-business"></div>
                                                <div class="category-social"></div>
                                                <span class="more-options text-dark">
                                                    <i class="ti ti-dots-vertical fs-5"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right category-menu"
                                            data-popper-placement="bottom-end">
                                            <button type="button" data-id="{{ $extracurricular->id }}"
                                                data-name="{{ $extracurricular->name }}"
                                                data-user="{{ $extracurricular->employee->user_id }}"
                                                class="note-business badge-group-item badge-business dropdown-item position-relative category-business d-flex align-items-center btn-edit">
                                                Edit
                                            </button>
                                            <button
                                                class="note-business text-danger badge-group-item badge-business dropdown-item position-relative category-business d-flex align-items-center btn-delete"
                                                data-id="{{ $extracurricular->id }}">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <span class="fs-4">{{ $extracurricular->employee->user->name }}</span>
                            <div class="d-flex align-items-center mb-4 pt-3">
                                <div class="bg-light-primary p-2 rounded text-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 16 16">
                                        <path fill="currentColor"
                                            d="M15 14s1 0 1-1s-1-4-5-4s-5 3-5 4s1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276c.593.69.758 1.457.76 1.72l-.008.002l-.014.002zM11 7a2 2 0 1 0 0-4a2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0a3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904c.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724c.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0a3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4a2 2 0 0 0 0-4" />
                                    </svg>
                                    <span class="ms-2 fs-4">
                                        {{ $extracurricular->extracurricularStudents->count() }} Siswa
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('school.extracurricular.show', $extracurricular->id) }}"
                                class="btn btn-primary w-100">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="300px">
                    <p class="fs-5 text-dark text-center mt-2">
                        Ekstrakurikuler belum ditambahkan
                    </p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center">
            <x-paginate-component :paginator="$extracurriculars" :always-show="true" />
        </div>


        @include('school.pages.extracurricular.widgets.modal-create')
        @include('school.pages.extracurricular.widgets.modal-update')
        <x-delete-modal-component />
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Cek session flash dan kesalahan untuk modal create
            const showCreateModal = @json(session('showCreateModal'));
            const showEditModal = @json(session('showEditModal'));

            if (showCreateModal) {
                var createModalErrors = document.querySelectorAll('.error-create');
                if (createModalErrors.length > 0) {
                    var createModalElement = new bootstrap.Modal(document.getElementById('modal-create'));
                    createModalElement.show();
                }
            }

            // Cek session flash dan kesalahan untuk modal edit
            if (showEditModal) {
                var editModalErrors = document.querySelectorAll('.error-edit');
                if (editModalErrors.length > 0) {
                    var editModalElement = new bootstrap.Modal(document.getElementById('modal-edit'));
                    editModalElement.show();
                }
            }
        });
    </script>

    @include('school.pages.extracurricular.scripts.delete')
    @include('school.pages.extracurricular.scripts.detail')
    @include('school.pages.extracurricular.scripts.select2')
    @include('school.pages.extracurricular.scripts.update')
@endsection