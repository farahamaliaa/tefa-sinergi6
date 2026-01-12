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
</style>

<div class="card card-body">
    <h4>Daftar Tingkatan Kelas</h4>
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
            <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#create-level">
                <i class="ti ti-plus"></i> Tambah Kegiatan Kelas
            </a>
        </div>
    </div>
    <div class="row">
        @forelse ($levelClasses as $levelClass)
            <div class="col-lg-4">
                <div class="card position-relative">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h2 class="fs-4 mb-0">Tingkatan Kelas</h2>
                            <div class="btn-group">
                                <a class="nav-link label-group p-0" data-bs-toggle="dropdown" href="#"
                                    role="button" aria-haspopup="true" aria-expanded="true">
                                    <div>
                                        <span class="more-options text-dark">
                                            <i class="ti ti-dots-vertical fs-5"></i>
                                        </span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" data-popper-placement="bottom-end">
                                    <button type="button" data-id="{{ $levelClass->id }}"
                                        data-name="{{ $levelClass->name }}"
                                        class="btn-update-level note-business badge-group-item badge-business dropdown-item position-relative category-business d-flex align-items-center gap-3">
                                        <i class="fs-4 ti ti-edit"></i>
                                        Edit
                                    </button>

                                    <button
                                        class="btn-delete-level note-business text-danger badge-group-item badge-business dropdown-item position-relative category-business d-flex align-items-center gap-3"
                                        data-id="{{ $levelClass->id }}">
                                        <i class="fs-4 ti ti-trash"></i>
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center pt-3">
                            <span class="mb-1 badge font-medium fs-5 bg-light-primary text-secondary">
                                {{ $levelClass->name }}
                            </span>
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
        <x-paginate-component :paginator="$levelClasses" />
    </div>
</div>
