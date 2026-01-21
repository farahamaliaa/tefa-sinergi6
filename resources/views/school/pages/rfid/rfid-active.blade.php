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
        background: linear-gradient(135deg, #1A94C8 0%, #0EA5E9 100%);
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

    .stats-card {
        border-radius: 16px;
        padding: 24px;
        box-shadow: none;
        border: none;
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    .stats-card.total {
        background: #E8F4FB;
    }

    .stats-card.active {
        background: #E6F7F1;
    }

    .stats-card.inactive {
        background: #FEE9E9;
    }

    .stats-icon {
        width: 64px;
        height: 64px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stats-icon.total {
        background: #0896D1;
        color: #0896D1;
    }

    .stats-icon.active {
        background: #10B981;
        color: #10B981;
    }

    .stats-icon.inactive {
        background: #EF4444;
        color: #EF4444;
    }

    .stats-icon svg {
        width: 36px;
        height: 36px;
        background: white;
        border-radius: 50%;
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stats-content h6 {
        font-size: 14px;
        color: #1E293B;
        margin: 4px 0 8px 0;
        font-weight: 700;
    }

    .stats-content h2 {
        font-size: 36px;
        font-weight: 700;
        margin: 0;
        color: #0896D1;
    }

    .stats-content.active h2 {
        color: #10B981;
    }

    .stats-content.inactive h2 {
        color: #EF4444;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .search-box {
        position: relative;
    }

    .search-box input {
        padding-left: 40px;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        height: 42px;
    }

    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
    }

    .filter-select {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        height: 42px;
        padding-right: 35px;
    }

    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        background: #0896D1;
        color: white;
        font-weight: 600;
        font-size: 14px;
        padding: 14px 16px;
        border: none;
        text-align: center;
        border: 1px solid #0896D1;  /* Tambah border */
    }
    
    .table thead th:first-child {
        border-top-left-radius: 8px;
    }
    
    .table thead th:last-child {
        border-top-right-radius: 8px;
    }

    .table tbody td {
        padding: 16px;
        vertical-align: middle;
        color: #475569;
        font-size: 14px;
        border: 1px solid #E2E8F0;
        text-align: center;
        border: 1px solid #E2E8F0;
        border-top: none;  /* Hapus border atas karena sudah ada dari header */
    }

    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 8px;
    }
    
    .table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 8px;
    }s

    .table tbody tr:hover {
        background-color: #F8FAFC;
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }

    .user-info {
        text-align: left;
    }

    .user-name {
        font-weight: 600;
        color: #1E293B;
        margin: 0;
    }

    .user-role {
        font-size: 12px;
        color: #94A3B8;
        margin: 0;
    }

    .badge-active {
        background: #DCFCE7;
        color: #16A34A;
        padding: 6px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
    }

    .badge-inactive {
        background: #FEE2E2;
        color: #DC2626;
        padding: 6px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
    }

    .btn-delete {
        background: transparent;
        border: none;
        color: #EF4444;
        padding: 8px;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .btn-delete:hover {
        background: #FEE2E2;
    }

    .table-title {
        font-size: 20px;
        font-weight: 700;
        color: #1E293B;
        margin: 0;
    }
</style>

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-2">Kartu RFID</h4>
                    <p class="text-white opacity-75 mb-0">Daftar kartu RFID di sekolah</p>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n3 mb-5">
                        <img src="{{ asset('assets/images/background/book.png') }}" alt=""
                            class="img-fluid img-header-floating">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="stats-card total">
                <div class="stats-icon total">
                    <svg width="40" height="40" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="35" height="35" rx="17.5" fill="white"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.2773 18.5964C13.2773 18.3958 13.3571 18.2033 13.4989 18.0614C13.6408 17.9196 13.8333 17.8398 14.0339 17.8398H21.0953C21.296 17.8398 21.4884 17.9196 21.6303 18.0614C21.7722 18.2033 21.8519 18.3958 21.8519 18.5964C21.8519 18.7971 21.7722 18.9895 21.6303 19.1314C21.4884 19.2733 21.296 19.353 21.0953 19.353H14.0339C13.8333 19.353 13.6408 19.2733 13.4989 19.1314C13.3571 18.9895 13.2773 18.7971 13.2773 18.5964ZM13.2773 21.6227C13.2773 21.4221 13.3571 21.2296 13.4989 21.0878C13.6408 20.9459 13.8333 20.8662 14.0339 20.8662H21.0953C21.296 20.8662 21.4884 20.9459 21.6303 21.0878C21.7722 21.2296 21.8519 21.4221 21.8519 21.6227C21.8519 21.8234 21.7722 22.0158 21.6303 22.1577C21.4884 22.2996 21.296 22.3793 21.0953 22.3793H14.0339C13.8333 22.3793 13.6408 22.2996 13.4989 22.1577C13.3571 22.0158 13.2773 21.8234 13.2773 21.6227Z" fill="#027AAB"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10 9.51754C10 8.40588 10.9059 7.5 12.0175 7.5H18.7662C19.3332 7.5 19.8678 7.74009 20.2441 8.13654L20.2501 8.1436L24.6 12.8868C24.9621 13.2732 25.1316 13.7786 25.1316 14.2588V24.6491C25.1316 25.7608 24.2257 26.6667 23.114 26.6667H12.0175C10.9059 26.6667 10 25.7608 10 24.6491V9.51754ZM18.7652 9.51754H12.0175V24.6491H23.114V14.2507L18.7804 9.52461L18.7773 9.5236L18.7652 9.51754Z" fill="#027AAB"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.7705 7.5C19.038 7.5 19.2946 7.60628 19.4838 7.79546C19.673 7.98464 19.7793 8.24123 19.7793 8.50877V13.25H24.1271C24.2595 13.25 24.3907 13.2761 24.5131 13.3268C24.6355 13.3775 24.7467 13.4518 24.8404 13.5455C24.9341 13.6391 25.0084 13.7503 25.0591 13.8727C25.1097 13.9951 25.1358 14.1263 25.1358 14.2588C25.1358 14.3912 25.1097 14.5224 25.0591 14.6448C25.0084 14.7672 24.9341 14.8784 24.8404 14.9721C24.7467 15.0658 24.6355 15.1401 24.5131 15.1908C24.3907 15.2415 24.2595 15.2675 24.1271 15.2675H18.7705C18.5029 15.2675 18.2464 15.1613 18.0572 14.9721C17.868 14.7829 17.7617 14.5263 17.7617 14.2588V8.50877C17.7617 8.24123 17.868 7.98464 18.0572 7.79546C18.2464 7.60628 18.5029 7.5 18.7705 7.5Z" fill="#027AAB"/>
                    </svg>
                </div>
                <div class="stats-content">
                    <h6>Total Kartu RFID</h6>
                    <h2>{{ $rfids->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card active">
                <div class="stats-icon active">
                    <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="35" height="35" rx="17.5" fill="white"/>
                        <path d="M28 22L22.8718 27L19.2821 23.5L20.8205 22L22.8718 24L26.4615 20.5L28 22ZM10.0513 7C9.50725 7 8.9855 7.21071 8.60081 7.58579C8.21612 7.96086 8 8.46957 8 9V25C8 26.11 8.91282 27 10.0513 27H18.0615C17.6923 26.38 17.4359 25.7 17.3128 25H10.0513V9H17.2308V14H22.359V18.08C22.6974 18.03 23.0462 18 23.3846 18C23.7333 18 24.0718 18.03 24.4103 18.08V13L18.2564 7M12.1026 17V19H20.3077V17M12.1026 21V23H17.2308V21H12.1026Z" fill="#1EBB9E"/>
                    </svg>
                </div>
                <div class="stats-content active">
                    <h6>Kartu Aktif</h6>
                    <h2>{{ $rfids->total() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="stats-card inactive">
                <div class="stats-icon inactive">
                    <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="35" height="35" rx="17.5" fill="white"/>
                        <path d="M11.0769 7C10.5261 7 9.99782 7.21335 9.60832 7.59311C9.21882 7.97287 9 8.48794 9 9.025V25.225C9 26.3489 9.92423 27.25 11.0769 27.25H19.1873C18.8135 26.6222 18.5538 25.9337 18.4292 25.225H11.0769V9.025H18.3462V14.0875H23.5385V18.2185C23.8812 18.1679 24.2342 18.1375 24.5769 18.1375C24.93 18.1375 25.2727 18.1679 25.6154 18.2185V13.075L19.3846 7M13.1538 17.125V19.15H21.4615V17.125M13.1538 21.175V23.2H18.3462V21.175H13.1538Z" fill="#E02123"/>
                        <path d="M21.9239 20.5L20.8125 21.6114L21.38 22.1789L22.783 23.6056L21.38 25.0086L20.8125 25.5525L21.9239 26.6875L22.4914 26.12L23.9181 24.6933L25.3211 26.12L25.865 26.6875L27 25.5525L26.4325 25.0086L25.0058 23.6056L26.4325 22.1789L27 21.6114L25.865 20.5L25.3211 21.0675L23.9181 22.4705L22.4914 21.0675L21.9239 20.5Z" fill="#E02123"/>
                    </svg>
                </div>
                <div class="stats-content inactive">
                    <h6>Kartu Tidak Aktif</h6>
                    <h2>0</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="table-container border mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <h4 class="table-title mb-3 mb-md-0">Daftar Kartu RFID</h4>
        </div>

        <div class="row mb-4">
            <div class="col-lg-8">
                <form class="d-flex gap-2">
                    <div class="search-box" style="width: 280px;">
                        <input type="text" name="name" class="form-control"
                            id="search-name" placeholder="Cari" value="{{ old('name', request()->name) }}">
                        <i class="ti ti-search"></i>
                    </div>

                    <div class="position-relative" style="width: 180px;">
                        <select name="filter" class="form-control filter-select" id="filter-select">
                            <option value="">Tampilkan</option>
                            <option value="terbaru" {{ request()->filter == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request()->filter == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        </select>
                        <i class="ti ti-chevron-down position-absolute top-50 end-0 translate-middle-y me-3" 
                           style="pointer-events: none;"></i>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Nomor RFID</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rfids as $index => $rfid)
                        <tr>
                            <td>{{ $rfids->firstItem() + $index }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        {{ substr($rfid->model_type == 'App\Models\Employee' ? $rfid->model->user->name : ( $rfid->model_type == 'App\Models\ClassroomStudent' ? $rfid->model->student->user->name : $rfid->model->user->name ), 0, 1) }}
                                    </div>
                                    <div class="user-info">
                                        <p class="user-name">{{ $rfid->model_type == 'App\Models\Employee' ? $rfid->model->user->name : ( $rfid->model_type == 'App\Models\ClassroomStudent' ? $rfid->model->student->user->name : $rfid->model->user->name ) }}</p>
                                        <p class="user-role">
                                            @if($rfid->model_type == 'App\Models\Employee')
                                                Pegawai
                                            @elseif($rfid->model_type == 'App\Models\ClassroomStudent')
                                                Siswa
                                            @else
                                                Pengguna
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $rfid->rfid }}</td>
                            <td>
                                <span class="badge-active">Aktif</span>
                            </td>
                            <td>
                                <button type="button" class="btn-delete" data-id="{{ $rfid->id }}">
                                    <i class="ti ti-trash fs-5"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center align-middle py-5">
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
        });

        // Auto submit form on filter change
        $('#filter-select').change(function() {
            $(this).closest('form').submit();
        });

        // Auto submit form on search with debounce
        let searchTimeout;
        $('#search-name').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                $(this).closest('form').submit();
            }, 500);
        });
    </script>
@endsection