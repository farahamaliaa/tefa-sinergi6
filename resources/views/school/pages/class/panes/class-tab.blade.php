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
 </style>

<div class="card card-body">
    <h4>Daftar Kelas</h4>
    <div class="row mb-3 mt-3 align-items-center">
        <div class="col-12 col-md-8 col-lg-4">
            <form class="position-relative d-flex">
                <input type="text" class="form-control product-searc ps-5 me-2" name="name"
                    value="{{ old('name', request()->name) }}" id="input-search" placeholder="Cari...">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
        <div class="col-12 col-md-4 col-lg-2 ms-auto d-flex justify-content-end">
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#create-class">
                <i class="ti ti-plus"></i> Tambah Kelas
            </a>
        </div>
    </div>
    <div class="row">
        @forelse ($classrooms as $classroom)
        <div class="col-lg-4 mb-3">
            <div class="card d-flex flex-column h-100 hover-img overflow-hidden rounded-2">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0"><b>{{ $classroom->name }}</b></h4>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge font-medium bg-year text-secondary">{{ $classroom->schoolYear->school_year }}</span>
                            <!-- <label class="custom-switch">
                                <input type="checkbox" id="status-{{ $classroom->id }}" {{ $classroom->is_active ? 'checked' : '' }}>
                                <span class="slider">
                                    <span class="slider-text text-on">Aktif</span>
                                    <span class="slider-text text-off">Non</span>
                                </span>
                            </label> -->
                            <div class="category-selector btn-group">
                                <a class="nav-link category-dropdown label-group p-0" data-bs-toggle="dropdown"
                                    href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <div class="category d-flex align-items-center">
                                        <span class="more-options text-dark">
                                            <i class="ti ti-dots-vertical fs-5"></i>
                                        </span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end category-menu">
                                    <button type="button" data-id="{{ $classroom->id }}" data-name="{{ $classroom->name }}" data-level="{{ $classroom->level_class_id }}" data-employee="{{ $classroom->employee_id }}" data-whatsapp="{{ $classroom->whatsapp_group_id }}" class="btn-update-classroom dropdown-item d-flex align-items-center btn-edit">
                                        <i class="ti ti-edit me-2"></i> Edit
                                    </button>
                                    <button class="dropdown-item d-flex align-items-center text-danger btn-delete-class" data-id="{{ $classroom->id }}">
                                        <i class="ti ti-trash me-2"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span class="fs-4 mb-2">{{ $classroom->employee->user->name }}</span>
                    @if($classroom->whatsapp_group_id)
                        <span class="badge bg-light-success text-success mb-2">
                            <i class="ti ti-brand-whatsapp"></i> WA Terhubung
                        </span>
                    @endif
                    <div class="d-flex align-items-center pt-3 text-secondary">
                        <div class="bg-year p-2 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 16 16" class="pb-1">
                                <path fill="currentColor"
                                    d="M15 14s1 0 1-1s-1-4-5-4s-5 3-5 4s1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276c.593.69.758 1.457.76 1.72l-.008.002l-.014.002zM11 7a2 2 0 1 0 0-4a2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0a3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904c.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724c.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0a3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4a2 2 0 0 0 0-4" />
                            </svg>
                            <span class="ms-2 fs-6">
                                {{ $classroom->classroomStudents->count() }} Siswa
                            </span>
                        </div>
                    </div>

                    <!-- Spacer to push the button to the bottom -->
                    <div class="mt-auto"></div>

                    <a href="{{ route('school.class-student.index', ['classroom' => $classroom->id ]) }}" class="btn waves-effect waves-light btn-primary w-100">Masuk Kelas</a>
                </div>
            </div>
        </div>

        @empty
        <tr>
            <td colspan="7" class="text-center align-middle">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt=""
                        width="300px">
                    <p class="fs-5 text-dark text-center mt-2">
                        Belum ada data
                    </p>
                </div>
            </td>
        </tr>
        @endforelse
    </div>

    <div class="pagination justify-content-center mb-0">
        <x-paginate-component :paginator="$classrooms" />
    </div>
</div>


