@extends('staff.layouts.app')
@section('style')
    <style>
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
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Jurnal Staff</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-white text-decoration-none"
                                    href="javascript:void(0)">{{ auth_user()->name }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3">
                        <img src="{{ asset('assets/images/background/laptops.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="card bg-info shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Jurnal dan Absensi</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-white text-decoration-none"
                                    href="javascript:void(0)">{{ auth_user()->name }}</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('admin_assets/dist/images/breadcrumb/ChatBc.png') }}" alt=""
                            class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="card">
        <div>
            <span class="badge bg-warning fs-5 px-4 text-white mt-3 fw-semibold me-4 mb-4"
                style="border-radius:0px 5px 5px 0px;">Informasi</span>
        </div>
        <ul class="ms-5 pb-2" style="list-style-type:disc;">
            <li>Jurnal wajib di isi oleh semua guru & staff untuk direkap sekolah</li>
            <li>Ketika tidak mengisi jurnal, maka pihak sekolah akan menganggap bahwa staff tersebut tidak masuk pada hari
                itu</li>
            <li>Batas jam pengisian jurnal adalah 23.59 WIB</li>
        </ul>
        <div class="position-absolute bottom-0 end-0" style="padding: 0px;">
            <img src="{{ asset('assets/images/background/bub2.png') }}" alt="Description" class="img-fluid"
                style="max-width: 150px; height: auto;">
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card border">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Data Jurnal</h4>
                    <div class="d-flex align-items-center gap-2">
                        <form class="d-flex gap-2" method="GET" action="{{ route('employee.journal.index') }}">
                            <div class="position-relative">
                                <input type="date" name="date" class="form-control search-chat"
                                    value="{{ request('date') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                            data-bs-target="#modal-create-journal">
                            <i class="ti ti-plus me-1"></i> Tambah Jurnal
                        </button>
                    </div>
                </div>
                <div class="table-responsive rounded-2 ">
                    <table class="table border text-nowrap customize-table mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="text-white" style="background-color: #0896D1;">No</th>
                                <th class="text-white" style="background-color: #0896D1;">Tanggal</th>
                                <th class="text-white" style="background-color: #0896D1;">Judul</th>
                                <th class="text-white" style="background-color: #0896D1;">Deskripsi Kegiatan</th>
                                <th class="text-white" style="background-color: #0896D1;">Status</th>
                                <th class="text-white text-center" style="background-color: #0896D1;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employeeJournals as $employeeJournal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($employeeJournal->created_at)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ $employeeJournal->title }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($employeeJournal->description, 50, '...') }}</td>
                                    <td>
                                        @if ($employeeJournal->title && $employeeJournal->description)
                                            <span class="badge rounded-2 px-3 py-2 fs-2 fw-semibold"
                                                style="background-color: #E5F9F6; color: #1EB196;">
                                                Mengisi
                                            </span>
                                        @else
                                            <span class="badge rounded-2 px-3 py-2 fs-2 fw-semibold"
                                                style="background-color: #FDEDED; color: #D9534F;">
                                                Tidak Mengisi
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button type="button"
                                                class="btn btn-sm btn-light-primary text-primary btn-detail-journal"
                                                data-title="{{ $employeeJournal->title }}"
                                                data-description="{{ $employeeJournal->description }}">
                                                <i class="ti ti-eye fs-5"></i>
                                            </button>
                                            @if ($employeeJournal->created_at->isToday())
                                                <button type="button"
                                                    class="btn btn-sm btn-light-warning text-warning btn-edit-journal"
                                                    data-id="{{ $employeeJournal->id }}"
                                                    data-title="{{ $employeeJournal->title }}"
                                                    data-description="{{ $employeeJournal->description }}">
                                                    <i class="ti ti-edit fs-5"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center align-middle">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                                alt="" width="300px">
                                            <p class="fs-5 text-dark text-center mt-2">
                                                Belum ada data
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination justify-content-end mt-2 mb-0">
                        {{-- <x-paginate-component :paginator="$attendances" /> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('staff.pages.journal.widget.modal-create')
    @include('staff.pages.journal.widget.modal-edit')
    @include('staff.pages.journal.widget.modal-detail')
@endsection
