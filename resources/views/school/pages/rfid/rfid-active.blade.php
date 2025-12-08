@extends('school.layouts.app')

<style>
    .card {
        border: 1px solid #E0E6ED !important; 
        box-shadow: none !important;
    }

    .card-hover:hover {
        border-color: #00A9D9 !important;
        transition: .2s ease-in-out;
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
</style>

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Kartu RFID</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar kartu RFID di sekolah
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

    <!-- Summary Cards -->
    <div class="row mt-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-light-primary">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3" style="background-color: #0896D1;">
                        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="35" height="35" rx="17.5" fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.2773 18.5964C13.2773 18.3958 13.3571 18.2033 13.4989 18.0614C13.6408 17.9196 13.8333 17.8398 14.0339 17.8398H21.0953C21.296 17.8398 21.4884 17.9196 21.6303 18.0614C21.7722 18.2033 21.8519 18.3958 21.8519 18.5964C21.8519 18.7971 21.7722 18.9895 21.6303 19.1314C21.4884 19.2733 21.296 19.353 21.0953 19.353H14.0339C13.8333 19.353 13.6408 19.2733 13.4989 19.1314C13.3571 18.9895 13.2773 18.7971 13.2773 18.5964ZM13.2773 21.6227C13.2773 21.4221 13.3571 21.2296 13.4989 21.0878C13.6408 20.9459 13.8333 20.8662 14.0339 20.8662H21.0953C21.296 20.8662 21.4884 20.9459 21.6303 21.0878C21.7722 21.2296 21.8519 21.4221 21.8519 21.6227C21.8519 21.8234 21.7722 22.0158 21.6303 22.1577C21.4884 22.2996 21.296 22.3793 21.0953 22.3793H14.0339C13.8333 22.3793 13.6408 22.2996 13.4989 22.1577C13.3571 22.0158 13.2773 21.8234 13.2773 21.6227Z" fill="#027AAB"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 9.51754C10 8.40588 10.9059 7.5 12.0175 7.5H18.7662C19.3332 7.5 19.8678 7.74009 20.2441 8.13654L20.2501 8.1436L24.6 12.8868C24.9621 13.2732 25.1316 13.7786 25.1316 14.2588V24.6491C25.1316 25.7608 24.2257 26.6667 23.114 26.6667H12.0175C10.9059 26.6667 10 25.7608 10 24.6491V9.51754ZM18.7652 9.51754H12.0175V24.6491H23.114V14.2507L18.7804 9.52461L18.7773 9.5236L18.7652 9.51754Z" fill="#027AAB"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.7705 7.5C19.038 7.5 19.2946 7.60628 19.4838 7.79546C19.673 7.98464 19.7793 8.24123 19.7793 8.50877V13.25H24.1271C24.2595 13.25 24.3907 13.2761 24.5131 13.3268C24.6355 13.3775 24.7467 13.4518 24.8404 13.5455C24.9341 13.6391 25.0084 13.7503 25.0591 13.8727C25.1097 13.9951 25.1358 14.1263 25.1358 14.2588C25.1358 14.3912 25.1097 14.5224 25.0591 14.6448C25.0084 14.7672 24.9341 14.8784 24.8404 14.9721C24.7467 15.0658 24.6355 15.1401 24.5131 15.1908C24.3907 15.2415 24.2595 15.2675 24.1271 15.2675H18.7705C18.5029 15.2675 18.2464 15.1613 18.0572 14.9721C17.868 14.7829 17.7617 14.5263 17.7617 14.2588V8.50877C17.7617 8.24123 17.868 7.98464 18.0572 7.79546C18.2464 7.60628 18.5029 7.5 18.7705 7.5Z" fill="#027AAB"/>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold">Total Kartu RFID</p>
                        <h3 class="mb-0 fw-bold" style="color: #0896D1;">{{ $totalRfid ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="background-color: #E8F8F0;">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3" style="background-color: #00B074;">
                        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="35" height="35" rx="17.5" fill="white"/>
                        <path d="M28 22L22.8718 27L19.2821 23.5L20.8205 22L22.8718 24L26.4615 20.5L28 22ZM10.0513 7C9.50725 7 8.9855 7.21071 8.60081 7.58579C8.21612 7.96086 8 8.46957 8 9V25C8 26.11 8.91282 27 10.0513 27H18.0615C17.6923 26.38 17.4359 25.7 17.3128 25H10.0513V9H17.2308V14H22.359V18.08C22.6974 18.03 23.0462 18 23.3846 18C23.7333 18 24.0718 18.03 24.4103 18.08V13L18.2564 7M12.1026 17V19H20.3077V17M12.1026 21V23H17.2308V21H12.1026Z" fill="#1EBB9E"/>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold">Total Kartu Aktif</p>
                        <h3 class="mb-0 fw-bold" style="color: #00B074;">{{ $activeCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="background-color: #FFEEEE;">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3" style="background-color: #F73131;">
                        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="35" height="35" rx="17.5" fill="white"/>
                        <path d="M11.0769 7C10.5261 7 9.99782 7.21335 9.60832 7.59311C9.21882 7.97287 9 8.48794 9 9.025V25.225C9 26.3489 9.92423 27.25 11.0769 27.25H19.1873C18.8135 26.6222 18.5538 25.9337 18.4292 25.225H11.0769V9.025H18.3462V14.0875H23.5385V18.2185C23.8812 18.1679 24.2342 18.1375 24.5769 18.1375C24.93 18.1375 25.2727 18.1679 25.6154 18.2185V13.075L19.3846 7M13.1538 17.125V19.15H21.4615V17.125M13.1538 21.175V23.2H18.3462V21.175H13.1538Z" fill="#E02123"/>
                        <path d="M21.9239 20.5L20.8125 21.6114L21.38 22.1789L22.783 23.6056L21.38 25.0086L20.8125 25.5525L21.9239 26.6875L22.4914 26.12L23.9181 24.6933L25.3211 26.12L25.865 26.6875L27 25.5525L26.4325 25.0086L25.0058 23.6056L26.4325 22.1789L27 21.6114L25.865 20.5L25.3211 21.0675L23.9181 22.4705L22.4914 21.0675L21.9239 20.5Z" fill="#E02123"/>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold">Total Kartu Tidak Aktif</p>
                        <h3 class="mb-0 fw-bold" style="color: #F73131;">{{ $inactiveCount ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="border py-2 px-2 rounded-2">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center py-2 px-3">
        <h4 class="fw-semibold m-0 mb-2 mb-md-0">Daftar Kartu RFID</h4>
    </div>
    <div class="row mt-2 mb-4 py-2 px-3">
        <div class="col-lg-5">
            <form class="d-flex gap-2">
                <div class="position-relative" style="width: 250px;">
                    <input type="text" name="name" class="form-control py-2 ps-5"
                        id="search-name" placeholder="Cari" value="{{ old('name', request()->name) }}">
                    <i class="ti ti-search position-absolute top-50 translate-middle-y fs-6 text-dark ms-3"></i>
                </div>

                <div class="position-relative dropdown-custom" style="width: 180px;">
                    <select name="filter" class="form-control pe-4" id="filter-select" style="appearance: none;">
                        <option value="">Tampilkan</option>
                        <option value="terbaru">Terbaru</option>
                        <option value="terlama">Terlama</option>
                    </select>
                    <i class="ti ti-chevron-down position-absolute top-50 end-0 translate-middle-y fs-6 text-dark me-3 chevron-icon" 
                       id="chevron-icon"
                       style="cursor: pointer; z-index: 1;"></i>
                </div>
                <button type="submit" class="btn btn-primary w-lg-auto">Filter</button>
            </form>
        </div>
    </div>

    <div class="mt-2">
        <div class="table-responsive rounded-2 m-2">
            <table class="table border text-nowrap customize-table mb-0 align-middle text-center">
                <thead>
                    <tr>
                        <th style="background-color: #0896D1;" class="text-white">No</th>
                        <th style="background-color: #0896D1;" class="text-white">Nama Pengguna</th>
                        <th style="background-color: #0896D1;" class="text-white">Nomor RFID</th>
                        <th style="background-color: #0896D1;" class="text-white">Status</th>
                        <th style="background-color: #0896D1;" class="text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rfids as $rfid)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rfid->model_type == 'App\Models\Employee' ? $rfid->model->user->name : ( $rfid->model_type == 'App\Models\ClassroomStudent' ? $rfid->model->student->user->name : $rfid->model->user->name ) }}</td>
                            <td>{{ $rfid->rfid }}</td>
                            <td>
                                <span class="mb-1 badge px-2 py-1 font-medium bg-light-success text-success">Aktif</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-light-danger btn-delete" data-id="{{ $rfid->id }}">
                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.70924 4.91869L5.38203 15.0227C5.45855 15.4853 5.69679 15.9057 6.05432 16.209C6.41184 16.5123 6.86543 16.6788 7.33428 16.6789H9.98478M15.2874 4.91869L13.6154 15.0227C13.5388 15.4853 13.3006 15.9057 12.9431 16.209C12.5856 16.5123 12.132 16.6788 11.6631 16.6789H9.01261M7.93278 8.80023V12.7974M11.0646 8.80023V12.7974M2.17578 4.91869H16.8216M11.6972 4.91869V3.50952C11.6972 3.19458 11.572 2.89253 11.3493 2.66983C11.1266 2.44713 10.8246 2.32202 10.5097 2.32202H8.48774C8.17279 2.32202 7.87075 2.44713 7.64805 2.66983C7.42535 2.89253 7.30024 3.19458 7.30024 3.50952V4.91869H11.6972Z" stroke="#F73131" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center align-middle">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="300px">
                                <p class="fs-5 text-dark text-center mt-2">
                                    Belum ada RFID
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center m-2 mb-3 mt-3">
            <div class="text-muted">
                Menampilkan {{ $rfids->currentPage() }} dari {{ $rfids->lastPage() }} halaman
            </div>
            <div>
                <x-paginate-component :paginator="$rfids" />
            </div>
        </div>  
    </div>
</div>

    <div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="tambahRfid" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahRfid">Tambah RFID</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <span class="text-dark fw-semibold me-2">RFID :</span>
                        </div>
                        <div class="mb-3">
                            Anda juga bisa melakukan tab ke rfid reader untuk menginputkan rfid
                        </div>
                        <div>
                            <input type="text" name="rfid" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-rounded btn-light-danger text-danger"
                            data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-rounded btn-light-success text-success">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <x-delete-modal-component />
@endsection

@section('script')
    <script>
        $('.btn-delete').click(function() {
            var id = $(this).data('id');
            $('#modal-delete').modal('show');
            $('#form-delete').attr('action', `{{ route('school.rfid-school.delete', '') }}/${id}`)
        })
    </script>
@endsection
