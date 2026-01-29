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

        .btn-primary:hover {
            background-color: #067aa7 !important;
            border-color: #067aa7 !important;
        }

        .location-status {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
        }

        .location-status.in-range {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .location-status.out-range {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .location-status.loading {
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
        }

        .distance-badge {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .btn-absen {
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-absen:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .btn-absen.btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
        }

        .btn-absen.btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border: none;
            color: white;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Perizinan Staff</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item text-white" aria-current="page">Daftar Perizinan Staff</li>
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
    <div class="card border">
        <div class="card-body">
            <h4>Perizinan Staff</h4>
            <div class="row">
                <div class="col-12 col-lg-5 mt-3 mb-4">
                    <form class="d-flex gap-2 flex-column flex-lg-row align-items-stretch align-items-lg-center"
                        method="GET" action="{{ url()->current() }}">
                        <div class="position-relative flex-grow-1 mb-2 mb-lg-0">
                            <input type="text" name="search" class="form-control search-chat py-2 px-4 ps-5"
                                id="search-name" placeholder="Cari..." value="{{ request('search') }}">
                            <i class="ti ti-search position-absolute top-50 translate-middle-y fs-6 text-dark ms-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <select name="status" class="form-select" id="search-status">
                                <option value="" {{ request('status') == '' ? 'selected' : '' }}>Pilih</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                        </div>
                        <div class="position-relative flex-grow-1 mb-2 mb-lg-0">
                            <input type="date" name="search" class="form-control search-chat" id="search-name"
                                placeholder="Cari..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-primary w-lg-auto">Filter</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive rounded-2">
                <table class="table border text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="text-white" style="background-color: #0896D1;">No</th>
                            <th class="text-white" style="background-color: #0896D1;">Nama Staff</th>
                            <th class="text-white" style="background-color: #0896D1;">Tanggal</th>
                            <th class="text-white" style="background-color: #0896D1;">Jenis Izin</th>
                            <th class="text-white" style="background-color: #0896D1;">Keterangan</th>
                            {{-- <th class="text-white" style="background-color: #0896D1;">Bukti</th> --}}
                            <th class="text-white" style="background-color: #0896D1;">Status</th>
                            <th class="text-white" style="background-color: #0896D1;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration + $permissions->firstItem() - 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-0">
                                            <h6 class="fs-4 fw-semibold mb-0">
                                                {{ $permission->employee->user->name ?? 'Unknown' }}</h6>
                                            <span
                                                class="fw-normal text-muted">{{ $permission->employee->nip ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ Carbon\Carbon::parse($permission->date)->format('d M Y') }}</td>
                                <td>{{ $permission->permission_type->label() ?? $permission->permission_type->value }}</td>
                                <td>{{ Str::limit($permission->proof, 40) }}</td>
                                {{-- <td>
                                    @if ($permission->proof_image)
                                        <a href="{{ asset('storage/' . $permission->proof_image) }}" target="_blank"
                                            class="btn btn-sm btn-info">
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td> --}}
                                <td>
                                    @if ($permission->status == \App\Enums\StatusPermissionEnum::APPROVED)
                                        <span class="badge bg-light-success text-success">Disetujui</span>
                                    @elseif ($permission->status == \App\Enums\StatusPermissionEnum::REJECTED)
                                        <span class="badge bg-light-danger text-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-light-warning text-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary btn-view-detail"
                                        data-bs-toggle="modal" data-bs-target="#student-permission-modal"
                                        data-id="{{ $permission->id }}"
                                        data-name="{{ $permission->employee->user->name ?? 'Unknown' }}"
                                        data-date="{{ Carbon\Carbon::parse($permission->date)->format('d/m/Y') }}"
                                        data-type="{{ $permission->permission_type->label() ?? $permission->permission_type->value }}"
                                        data-proof="{{ $permission->proof }}" data-duration="{{ $permission->duration }}"
                                        data-proof-image="{{ $permission->proof_image ? asset('storage/' . $permission->proof_image) : '' }}"
                                        data-status="{{ $permission->status->value }}"
                                        data-url-approve="{{ route('employee.approval.permission.approve', $permission->id) }}"
                                        data-url-reject="{{ route('employee.approval.permission.reject', $permission->id) }}">
                                        Lihat
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" width="150"
                                        alt="No Data">
                                    <p class="mt-2 text-muted">Belum ada pengajuan izin masuk</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>

    @include('staff.pages.approval.widget.approval')
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('student-permission-modal');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                // Get data from button attributes
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const date = button.getAttribute('data-date');
                const type = button.getAttribute('data-type');
                const proof = button.getAttribute('data-proof');
                const duration = button.getAttribute('data-duration');
                const proofImage = button.getAttribute('data-proof-image');
                const status = button.getAttribute('data-status');

                // Update modal content
                modal.querySelector('#modal-staff-name').value = name;
                modal.querySelector('#modal-date').value = date;
                modal.querySelector('#modal-type').value = type;
                modal.querySelector('#modal-duration').value = duration || '-';
                modal.querySelector('#modal-proof').value = proof || '-';

                // Update proof image
                const imgContainer = modal.querySelector('#modal-proof-image-container');
                if (proofImage) {
                    imgContainer.innerHTML =
                        `<img src="${proofImage}" class="img-fluid rounded-3" alt="Bukti Izin" style="width: 300px; max-height: 300px; object-fit: cover;">`;
                } else {
                    imgContainer.innerHTML = '<p class="text-muted">Tidak ada bukti</p>';
                }

                // Update status badge
                const statusBadge = modal.querySelector('#modal-status');
                if (status === 'approved') {
                    statusBadge.textContent = 'Disetujui';
                    statusBadge.style.backgroundColor = '#E6FFFA';
                    statusBadge.style.color = '#13DEB9';
                } else if (status === 'rejected') {
                    statusBadge.textContent = 'Ditolak';
                    statusBadge.style.backgroundColor = '#FFE5E5';
                    statusBadge.style.color = '#DC3545';
                } else {
                    statusBadge.textContent = 'Menunggu';
                    statusBadge.style.backgroundColor = '#FFF4E5';
                    statusBadge.style.color = '#FA896B';
                }

                // Update action buttons visibility and form action
                const btnApprove = modal.querySelector('#modal-btn-approve');
                const btnReject = modal.querySelector('#modal-btn-reject');
                const formApprove = modal.querySelector('#form-approve');
                const formReject = modal.querySelector('#form-reject');

                if (status === 'pending') {
                    const urlApprove = button.getAttribute('data-url-approve');
                    const urlReject = button.getAttribute('data-url-reject');

                    btnApprove.style.display = 'block';
                    btnReject.style.display = 'block';
                    formApprove.action = urlApprove;
                    formReject.action = urlReject;
                } else {
                    btnApprove.style.display = 'none';
                    btnReject.style.display = 'none';
                }
            });
        });
    </script>
@endsection
