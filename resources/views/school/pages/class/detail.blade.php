@extends('school.layouts.app')
@section('style')
    <style>
        .table-wrapper {
            max-height: 400px;
            overflow-y: auto;
        }

        .table-wrapper::-webkit-scrollbar {
            width: 8px;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555;
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

    .btn-detail-action {
        background-color: #EAF9FF !important;
        color: #00A9D9 !important;
    }
    .btn-detail-action:hover {
        background-color: #d2f2ff !important;
    }

    .btn-edit-action {
        background-color: #FFF8E1 !important;
        color: #FFC107 !important;
    }
    .btn-edit-action:hover {
        background-color: #fff2cc !important;
    }

    .btn-delete-action {
        background-color: #FFE1E1 !important;
        color: #DC3545 !important;
    }
    .btn-delete-action:hover {
        background-color: #ffd1d1 !important;
    }   
    .bg-year {
        background-color: #ECF2FF !important;
    } 
    .rounded {
        border-radius: 10px !important;
    }
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
    input:checked + .slider {
        background-color: #0896D1;
    }
    input:checked + .slider:before {
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
    input:checked ~ .slider .text-on {
        display: block;
    }
    input:checked ~ .slider .text-off {
        display: none;
    }

            #inimize {
            scale: 1;
            position: absolute;
            transition: all ease 0.3s;
        }

        .minimize {
            scale: 0;
            position: absolute;
            box-sizing: border-box;
            bottom: 0;
            left: 0;
        }

        .rolling-flex {
            display: flex;
            position: relative;
            justify-content: flex-start;
            align-items: flex-start;
        }

        .hidden {
            display: none;
        }

        .form-check-input.form-red {
            border-color: #FA896B;
        }

        .form-check-input.form-red:checked {
            background-color: #FA896B;
            border-color: #FA896B;
        }

        .form-check-input.form-red:focus {
            border-color: #FA896B;
            box-shadow: 0 0 0 0.25rem rgba(250, 137, 107, 0.25);
        }

        .form-check-input.form-green {
            border-color: #1EB196;
        }

        .form-check-input.form-green:checked {
            background-color: #1EB196;
            border-color: #1EB196;
        }

        .form-check-input.form-green:focus {
            border-color: #1EB196;
            box-shadow: 0 0 0 0.25rem rgba(250, 137, 107, 0.25);
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
                    <h4 class="fw-semibold text-white mb-8">Daftar Siswa</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    {{ $classroom->name }}
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

    <div class="rolling-flex flex-column">
        <button class="toggle-rolling btn mb-2 btn-primary" id="minimize-button">Rolling Siswa</button>

        <div class="card card-body w-100 minimize mt-2 " id="minimize">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>Rolling Siswa</h4>
                    <div>
                        <p>Pilih siswa di sebelah kiri untuk memasukkan siswa ke dalam Kelas</p>
                    </div>
                </div>
                <div>
                    <button id="back-button" class="btn btn-light-danger mx-2 px-4 text-danger">
                        <!-- <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.82484 13L12.7248 17.9C12.9248 18.1 13.0208 18.3333 13.0128 18.6C13.0048 18.8667 12.9005 19.1 12.6998 19.3C12.4998 19.4833 12.2665 19.5793 11.9998 19.588C11.7332 19.5967 11.4998 19.5007 11.2998 19.3L4.69984 12.7C4.59984 12.6 4.52884 12.4917 4.48684 12.375C4.44484 12.2583 4.42451 12.1333 4.42584 12C4.42718 11.8667 4.44818 11.7417 4.48884 11.625C4.52951 11.5083 4.60018 11.4 4.70084 11.3L11.3008 4.7C11.4842 4.51667 11.7135 4.425 11.9888 4.425C12.2642 4.425 12.5015 4.51667 12.7008 4.7C12.9008 4.9 13.0008 5.13767 13.0008 5.413C13.0008 5.68834 12.9008 5.92567 12.7008 6.125L7.82484 11H18.9998C19.2832 11 19.5208 11.096 19.7128 11.288C19.9048 11.48 20.0005 11.7173 19.9998 12C19.9992 12.2827 19.9032 12.5203 19.7118 12.713C19.5205 12.9057 19.2832 13.0013 18.9998 13H7.82484Z" fill="#E02123"/>
                        </svg> -->
                        <svg class="me-2" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M3.39906 8.575L8.29906 13.475C8.49906 13.675 8.59506 13.9083 8.58706 14.175C8.57906 14.4417 8.47473 14.675 8.27406 14.875C8.07406 15.0583 7.84073 15.1543 7.57406 15.163C7.30739 15.1717 7.07406 15.0757 6.87406 14.875L0.274061 8.275C0.174061 8.175 0.103061 8.06667 0.0610614 7.95C0.0190614 7.83333 -0.00127179 7.70833 6.15388e-05 7.575C0.00139487 7.44167 0.0223946 7.31667 0.0630613 7.2C0.103728 7.08333 0.174395 6.975 0.275062 6.875L6.87506 0.275C7.05839 0.0916663 7.28773 0 7.56306 0C7.8384 0 8.07573 0.0916663 8.27506 0.275C8.47506 0.475 8.57506 0.712667 8.57506 0.988C8.57506 1.26333 8.47506 1.50067 8.27506 1.7L3.39906 6.575H14.5741C14.8574 6.575 15.0951 6.671 15.2871 6.863C15.4791 7.055 15.5747 7.29233 15.5741 7.575C15.5734 7.85767 15.4774 8.09533 15.2861 8.288C15.0947 8.48067 14.8574 8.57633 14.5741 8.575H3.39906Z" fill="#E02123"/>
                        </svg>
                            Kembali
                    </button>
                    <button id="save-button" class="btn btn-primary px-4">Simpan</button>
                </div>
            </div>
            <div class="row">
                @php
                    // Filter and Pagination for Left Table (Available Students)
                    $searchLeft = request()->input('search_left');
                    $filteredStudents = $students;
                    if ($searchLeft) {
                        $filteredStudents = $students->filter(function($student) use ($searchLeft) {
                            return stripos($student->user->name, $searchLeft) !== false || stripos($student->nisn, $searchLeft) !== false;
                        });
                    }

                    $perPageLeft = 5;
                    $pageLeft = request()->input('page_left', 1);
                    $offsetLeft = ($pageLeft - 1) * $perPageLeft;
                    $itemsLeft = $filteredStudents->slice($offsetLeft, $perPageLeft);
                    $studentsPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
                        $itemsLeft,
                        $filteredStudents->count(),
                        $perPageLeft,
                        $pageLeft,
                        ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'page_left']
                    );

                    // Filter and Pagination for Right Table (Classroom Students)
                    $searchRight = request()->input('search_right');
                    $filteredClassroomStudents = $classroomStudents;
                    if ($searchRight) {
                        $filteredClassroomStudents = $classroomStudents->filter(function($item) use ($searchRight) {
                             return stripos($item->student->user->name, $searchRight) !== false || stripos($item->student->nisn, $searchRight) !== false;
                        });
                    }

                    $perPageRight = 5;
                    $pageRight = request()->input('page_right', 1);
                    $offsetRight = ($pageRight - 1) * $perPageRight;
                    $itemsRight = $filteredClassroomStudents->slice($offsetRight, $perPageRight);
                    $classroomRollingPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
                        $itemsRight,
                        $filteredClassroomStudents->count(),
                        $perPageRight,
                        $pageRight,
                        ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'page_right']
                    );
                @endphp
                <div class="col-md-6">
                    <div class="d-flex flex-wrap mb-3">
                        <form class="d-flex gap-2" id="form-search-left">
                            <div class="position-relative flex-grow-1">
                                <input type="text" name="search_left" class="form-control product-search ps-5"
                                    id="input-search-left" placeholder="Cari..." value="{{ request('search_left') }}">
                                <i
                                    class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </div>
                            <button type="submit" class="btn btn-primary w-lg-auto">Filter</button>
                        </form>
                    </div>

                    <div class="table-wrapper rounded-2">
                        <table id="left-table"
                            class="table border text-nowrap customize-table mb-0 align-middle text-center">
                            <thead>
                                <tr>
                                    <th class="text-white" style="background-color: #0896D1;">No</th>
                                    <th class="text-white" style="background-color: #0896D1;">Siswa</th>
                                    <th class="text-white" style="background-color: #0896D1;">NISN</th>
                                    <th class="text-white" style="background-color: #0896D1;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($studentsPaginator as $student)
                                    <tr data-id="{{ $student->id }}">
                                        <td>{{ ($studentsPaginator->currentPage() - 1) * $studentsPaginator->perPage() + $loop->iteration }}</td>
                                        <td>{{ $student->user->name }}</td>
                                        <td>{{ $student->nisn }}</td>
                                        <td class="d-flex justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input form-green" type="checkbox">
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty-tr">
                                        <td colspan="4" class="text-center align-middle">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                                    alt="" width="200px">
                                                <p class="fs-5 text-dark text-center mt-2">
                                                    Siswa belum ditambahkan
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Menampilkan {{ $studentsPaginator->currentPage() }} dari {{ $studentsPaginator->lastPage() }} halaman
                        </div>
                        <div>
                            <x-paginate-component :paginator="$studentsPaginator" />
                        </div>
                    </div>
                    <div class="text-end mt-3 mb-3">
                        <button id="move-to-right" class="btn btn-import">
                            Masukan
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex flex-wrap mb-3">
                        <form class="d-flex gap-2" id="form-search-right">
                            <div class="position-relative flex-grow-1">
                                <input type="text" name="search_right" class="form-control product-search ps-5"
                                    id="input-search-right" placeholder="Cari..." value="{{ request('search_right') }}">
                                <i
                                    class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                            </div>
                            <button type="submit" class="btn btn-primary w-lg-auto">Filter</button>
                        </form>
                    </div>

                    <div class="table-wrapper rounded-2">
                        <table id="right-table"
                            class="table border text-nowrap customize-table mb-0 align-middle text-center">
                            <thead>
                                <tr>
                                    <th class="text-white" style="background-color: #0896D1;">No</th>
                                    <th class="text-white" style="background-color: #0896D1;">Siswa</th>
                                    <th class="text-white" style="background-color: #0896D1;">NISN</th>
                                    <th class="text-white" style="background-color: #0896D1;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($classroomRollingPaginator as $classroomStudent)
                                    <tr data-id="{{ $classroomStudent->student->id }}">
                                        <td>{{ ($classroomRollingPaginator->currentPage() - 1) * $classroomRollingPaginator->perPage() + $loop->iteration }}</td>
                                        <td>{{ $classroomStudent->student->user->name }}</td>
                                        <td>{{ $classroomStudent->student->nisn }}</td>
                                        <td class="d-flex justify-content-center">
                                            <div class="form-check">
                                                <input class="form-check-input form-red" type="checkbox">
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty-tr">
                                        <td colspan="4" class="text-center align-middle">
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                                    alt="" width="200px">
                                                <p class="fs-5 text-dark text-center mt-2">
                                                    Siswa belum ditambahkan
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="text-muted">
                            Menampilkan {{ $classroomRollingPaginator->currentPage() }} dari {{ $classroomRollingPaginator->lastPage() }} halaman
                        </div>
                        <div>
                            <x-paginate-component :paginator="$classroomRollingPaginator" />
                        </div>
                    </div>
                    <div class="text-end mt-3 mb-3">
                        <button id="move-to-left" class="btn btn-danger">
                            Keluarkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden fields to store changes -->
    <form id="save-form" action="{{ route('school.student-classroom.update', ['classroom' => $classroom]) }}"
        method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="add_students" id="add-students">
        <input type="hidden" name="remove_students" id="remove-students">
    </form>

    <div class="card card-body mt-4 ">
        <h4>Daftar Siswa</h4>
    @php
        $perPage = 10;
        $page = request()->input('page', 1);
        $offset = ($page - 1) * $perPage;
        $items = $classroomStudents->slice($offset, $perPage);
        $classroomStudentsPaginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $classroomStudents->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    @endphp
        
    <div class="row">
        <div class="col-12 col-lg-5 mt-3 mb-4">
            <form class="d-flex gap-2 flex-column flex-lg-row align-items-stretch align-items-lg-center" method="GET" action="{{ url()->current() }}">
                <div class="position-relative flex-grow-1 mb-2 mb-lg-0">
                    <input type="text" name="search" class="form-control search-chat py-2 px-4 ps-5" id="search-name"
                        placeholder="Cari" value="{{ old('search', request('search')) }}">
                    <i class="ti ti-search position-absolute top-50 translate-middle-y fs-6 text-dark ms-3"></i>
                </div>
                <div class="flex-grow-1">
                    <select name="gender" class="form-select" id="search-status">
                        <option value="" {{ old('gender', request('gender')) == '' ? 'selected' : '' }}>Semua</option>
                        <option value="male" {{ old('gender', request('gender')) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender', request('gender')) == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-lg-auto">Filter</button>
            </form>
        </div>
            <div class="col-12 col-lg-7 mt-3 mb-4 d-flex flex-wrap justify-content-lg-end gap-2">
                <a class="btn btn-import w-lg-auto" href="#" data-bs-toggle="modal" data-bs-target="#import-student">
                    <svg width="20" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.7699 8.92256V23.1726M13.7699 8.92256L18.5199 13.6726M13.7699 8.92256L9.0199 13.6726M22.4782 16.8392C24.8833 16.8392 26.4366 14.8901 26.4366 12.4851C26.4365 11.5329 26.1243 10.607 25.5478 9.84915C24.9712 9.09133 24.1622 8.54338 23.2446 8.28923C23.1034 6.51346 22.3674 4.8372 21.1557 3.53146C19.9439 2.22573 18.3272 1.36684 16.5669 1.09366C14.8066 0.820475 13.0056 1.14897 11.4551 2.02602C9.90454 2.90308 8.69515 4.27744 8.0224 5.9269C6.60599 5.53427 5.09162 5.72038 3.81244 6.44431C2.53325 7.16823 1.59403 8.37065 1.2014 9.78707C0.808771 11.2035 0.994888 12.7178 1.71881 13.997C2.44273 15.2762 3.64516 16.2154 5.06157 16.6081" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>  Import
                </a>

                <a class="btn btn-primary w-lg-auto" href="#" data-bs-toggle="modal" data-bs-target="#create-student">
                    <i class="ti ti-plus me-1"></i>Tambah Siswa
                </a>
            </div>
        </div>
        <div class="table-responsive rounded-2 mb-3">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="text-white" style="background-color: #0896D1;">No</th>
                        <th class="text-white" style="background-color: #0896D1;">Nama</th>
                        <th class="text-white" style="background-color: #0896D1;">Jenis Kelamin</th>
                        <th class="text-white" style="background-color: #0896D1;">NISN</th>
                        <th class="text-white" style="background-color: #0896D1;">RFID</th>
                        <th class="text-white" style="background-color: #0896D1;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($classroomStudentsPaginator as $student)
                        <tr>
                            <td>{{ ($classroomStudentsPaginator->currentPage() - 1) * $classroomStudentsPaginator->perPage() + $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $student->student->image ? asset('storage/' . $student->student->image) : asset('assets/images/default-user.jpeg') }}"
                                        class="rounded-circle" width="40" height="40" style="object-fit: cover">
                                    <div class="ms-3">
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $student->student->user->name }}</h6>
                                        <span class="fw-normal">{{ $student->classroom->name }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->student->gender->label() }}</td>
                            <td>{{ $student->student->nisn }}</td>
                            <td>{{ $student->student->modelHasRfid ? $student->student->modelHasRfid->rfid : '-' }}
                                <button type="button" class="btn btn-rounded btn-warning p-1 ms-2 btn-rfid"
                                    data-name="{{ $student->student->user->name }}" data-id="{{ $student->student->id }}"
                                    data-rfid="{{ $student->student->modelHasRfid ? $student->student->modelHasRfid->rfid : 'Kosong' }}"
                                    data-old-rfid="{{ $student->student->modelHasRfid ? $student->student->modelHasRfid->rfid : 'Kosong' }}"
                                    data-role="{{ $student->student->user->roles->pluck('name')[0] }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M21 12a1 1 0 0 0-1 1v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h6a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-6a1 1 0 0 0-1-1m-15 .76V17a1 1 0 0 0 1 1h4.24a1 1 0 0 0 .71-.29l6.92-6.93L21.71 8a1 1 0 0 0 0-1.42l-4.24-4.29a1 1 0 0 0-1.42 0l-2.82 2.83l-6.94 6.93a1 1 0 0 0-.29.71m10.76-8.35l2.83 2.83l-1.42 1.42l-2.83-2.83ZM8 13.17l5.93-5.93l2.83 2.83L10.83 16H8Z" />
                                    </svg>
                                </button>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-action btn-detail-action btn-detail"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#student-detail"
                                        data-name="{{ $student->student->user->name }}"
                                        data-email="{{ $student->student->user->email }}"
                                        data-image="{{ $student->student->image ? asset('storage/' . $student->student->image) : asset('assets/images/default-user.jpeg') }}"
                                        data-gender="{{ $student->student->gender->label() }}"
                                        data-nik="{{ $student->student->nik }}"
                                        data-rfid="{{ $student->student->modelHasRfid ? $student->student->modelHasRfid->rfid : '-' }}"
                                        data-address="{{ $student->student->address }}">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                    <button type="button"
                                        class="btn btn-action btn-edit-action btn-edit"
                                        data-id="{{ $student->student->id }}"
                                        data-name="{{ $student->student->user->name }}"
                                        data-email="{{ $student->student->user->email }}"
                                        data-nisn="{{ $student->student->nisn }}"
                                        data-religion_id="{{ $student->student->religion_id }}"
                                        data-gender="{{ $student->student->gender }}"
                                        data-birth_place="{{ $student->student->birth_place }}"
                                        data-birth_date="{{ $student->student->birth_date }}"
                                        data-nik="{{ $student->student->nik }}"
                                        data-number_kk="{{ $student->student->number_kk }}"
                                        data-number_akta="{{ $student->student->number_akta }}"
                                        data-order_child="{{ $student->student->order_child }}"
                                        data-count_siblings="{{ $student->student->count_siblings }}"
                                        data-address="{{ $student->student->address }}">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <button
                                        class="btn btn-action btn-delete-action btn-delete"
                                        data-id="{{ $student->student->id }}">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                                        width="300px">
                                    <p class="fs-5 text-dark text-center mt-2">
                                        Belum ada siswa
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Menampilkan {{ $classroomStudentsPaginator->currentPage() }} dari {{ $classroomStudentsPaginator->lastPage() }} halaman
            </div>
            <div>
                <x-paginate-component :paginator="$classroomStudentsPaginator" />
            </div>
        </div>  
    </div>

    @include('school.pages.class.widgets.class.create-student')
    @include('school.pages.class.widgets.class.import-student')
    @include('school.pages.class.widgets.class.update-student')
    @include('school.pages.class.widgets.class.rfid-student')
    @include('school.pages.class.widgets.class.detail-student')

    <x-delete-modal-component />
@endsection

@section('script')
    @include('school.pages.class.script.script-validation')
    @include('school.pages.class.script.script-preview')
    @include('school.pages.class.script.script-toggle-rolling')
    @include('school.pages.class.script.script-create-rfid')
    @include('school.pages.class.script.script-rolling-student')
    @include('school.pages.class.script.script-update-student')
    @include('school.pages.class.script.script-delete-student')

    <script>
        $(document).ready(function() {
            // Event delegation for the 'Next' button
            $(document).on('click', '#btn-next-step', function() {
                $('#form-step-1').addClass('hidden');
                $('#footer-step-1').addClass('hidden');
                $('#form-step-2').removeClass('hidden');
                $('#footer-step-2').removeClass('hidden');
            });

            // Event delegation for the 'Previous' button
            $(document).on('click', '#btn-prev-step', function() {
                $('#form-step-2').addClass('hidden');
                $('#footer-step-2').addClass('hidden');
                $('#form-step-1').removeClass('hidden');
                $('#footer-step-1').removeClass('hidden');
            });

            // Event delegation for the 'Next' button in edit modal
            $(document).on('click', '#btn-next-step-edit', function() {
                $('#form-step-1-edit').addClass('hidden');
                $('#footer-step-1-edit').addClass('hidden');
                $('#form-step-2-edit').removeClass('hidden');
                $('#footer-step-2-edit').removeClass('hidden');
            });

            // Event delegation for the 'Previous' button in edit modal
            $(document).on('click', '#btn-prev-step-edit', function() {
                $('#form-step-2-edit').addClass('hidden');
                $('#footer-step-2-edit').addClass('hidden');
                $('#form-step-1-edit').removeClass('hidden');
                $('#footer-step-1-edit').removeClass('hidden');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.btn-detail').click(function() {
                var name = $(this).data('name');
                var email = $(this).data('email');
                var image = $(this).data('image');
                var gender = $(this).data('gender');
                var nik = $(this).data('nik');
                var rfid = $(this).data('rfid');
                var address = $(this).data('address');

                $('#name-detail').text(name);
                $('#email-detail').text(email);
                $('#image-detail').attr('src', image);
                $('#gender-detail').text(gender);
                $('#nik-detail').text(nik);
                $('#rfid-detail').text(rfid);
                $('#address-detail').text(address);
            });
        });
    </script>
@endsection
