@extends('staff.layouts.app')
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

        .btn-primary {
            background-color: #0896D1 !important;
            border-color: #0896D1 !important;
        }

        .text-primary {
            color: #0896D1 !important;
        }

        .btn-outline-primary {
            color: #0896D1 !important;
            border-color: #0896D1 !important;
            background-color: transparent !important;
        }

        .btn-outline-primary:hover {
            background-color: #0896D1 !important;
            color: #fff !important;
        }

        .btn-primary:hover {
            background-color: #067aa7 !important;
            border-color: #067aa7 !important;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Pengajuan Izin</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white" aria-current="page">Halaman Pengajuan Izin</li>
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

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2 gap-2">
                <svg class="mb-2 width="24" height="24" viewBox="0 0 30 30" fill="none"
                    xmlns="http://www.w3.org/2000/svg" class="me-2">
                    <path
                        d="M19.25 4.125V9.625C19.25 9.98967 19.3949 10.3394 19.6527 10.5973C19.9106 10.8551 20.2603 11 20.625 11H26.125"
                        stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M12.375 12.375H13.75M12.375 17.875H20.625M12.375 23.375H20.625M23.375 28.875H9.625C8.89565 28.875 8.19618 28.5853 7.68046 28.0695C7.16473 27.5538 6.875 26.8543 6.875 26.125V6.875C6.875 6.14565 7.16473 5.44618 7.68046 4.93046C8.19618 4.41473 8.89565 4.125 9.625 4.125H19.25L26.125 11V26.125C26.125 26.8543 25.8353 27.5538 25.3195 28.0695C24.8038 28.5853 24.1043 28.875 23.375 28.875Z"
                        stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h4>Form Pengajuan Izin</h4>
            </div>
            <p class="text-muted fst-italic">Silahkan isi form berikut untuk mengajukan izin tidak hadir.</p>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employee.permission.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly
                                    placeholder="Masukkan Nama Lengkap">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Izin <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ old('date', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Durasi <span class="text-danger">*</span></label>
                                <input type="text" name="duration" class="form-control"
                                    placeholder="Masukan Durasi Izin">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jenis Izin <span class="text-danger">*</span></label>
                                <select name="permission_type" class="form-select" required>
                                    <option value="">Pilih</option>
                                    @foreach (\App\Enums\PermissionTypeEnum::cases() as $type)
                                        <option value="{{ $type->value }}"
                                            {{ old('permission_type') == $type->value ? 'selected' : '' }}>
                                            {{ $type->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Unggah Bukti Izin <span
                                    class="text-danger">*</span></label>
                            <p class="text-muted small mb-2">Wajib mengunggah bukti berupa foto surat dokter / izin.</p>
                            <div class="position-relative text-center p-5 rounded-3"
                                style="border: 2px dashed #e0e6ed; background-color: #fafafa;">
                                <input type="file" name="proof_image"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                    accept="image/*" required id="file-upload" onchange="updateFileName(this)">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="mb-3 text-primary">
                                        <i class="ti ti-photo-up fs-8" style="font-size: 3rem;"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-1">Seret File Disini, atau <span
                                            class="text-primary text-decoration-underline">Browse</span></h6>
                                    <small class="text-muted">Format JPG/PNG, maksimal 2MB</small>
                                    <div id="file-name-display" class="mt-2 text-info fw-semibold"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alasan Izin <span class="text-danger">*</span></label>
                            <textarea name="proof" class="form-control" rows="4"
                                placeholder="Tuliskan alasan izin Anda secara singkat dan jelas..." required>{{ old('proof') }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('employee.permission.index') }}" class="btn btn-outline-primary px-4">
                                <i class="ti ti-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ti ti-send me-1"></i> Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>

                <script>
                    function updateFileName(input) {
                        var fileName = input.files[0] ? input.files[0].name : '';
                        document.getElementById('file-name-display').textContent = fileName;
                    }
                </script>
            </div>
        </div>
    </div>
@endsection
