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

    <div class="card">

        {{-- <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Perizinan Staff</h5>
            <a href="{{ route('employee.permission.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Buat Izin
            </a>
        </div> --}}
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
                <div class="col-12 col-lg-7 mt-3 mb-4 d-flex flex-wrap justify-content-lg-end gap-2">
                    <a href="{{ route('employee.permission.create') }}" class="btn btn-primary w-lg-auto">
                        <i class="ti ti-plus me-1"></i> Buat Izin
                    </a>
                </div>
            </div>
            <div class="table-wrapper rounded-2">
                <table class="table border text-nowrap customize-table mb-0 align-middle text-center">
                    <thead>
                        <tr>
                            <th class="text-white" style="background-color: #0896D1;">No</th>
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
                                <td>{{ Carbon\Carbon::parse($permission->date)->format('d M Y') }}</td>
                                <td>{{ $permission->permission_type->label() ?? $permission->permission_type->value }}</td>
                                <td>{{ Str::limit($permission->proof, 50) }}</td>
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
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($permission->status == \App\Enums\StatusPermissionEnum::REJECTED)
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info btn-view-detail"
                                        data-bs-toggle="modal" data-bs-target="#student-permission-modal"
                                        data-id="{{ $permission->id }}"
                                        data-name="{{ $permission->employee->user->name ?? 'Unknown' }}"
                                        data-date="{{ Carbon\Carbon::parse($permission->date)->format('d/m/Y') }}"
                                        data-type="{{ $permission->permission_type->label() ?? $permission->permission_type->value }}"
                                        data-proof="{{ $permission->proof }}"
                                        data-proof-image="{{ $permission->proof_image ? asset('storage/' . $permission->proof_image) : '' }}"
                                        data-status="{{ $permission->status->value }}">
                                        <i class="ti ti-eye"></i>
                                    </button>
                                    @if ($permission->status == \App\Enums\StatusPermissionEnum::PENDING)
                                        <form action="{{ route('employee.permission.destroy', $permission->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus pengajuan ini?')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-tr">
                                <td colspan="7" class="text-center align-middle">
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="No Data"
                                            width="200px">
                                        <p class="fs-5 text-dark text-center mt-2">
                                            Belum ada riwayat perizinan
                                        </p>
                                    </div>
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

    @include('staff.pages.permission.widgets.detail')
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('student-permission-modal');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                // Get data from button attributes
                const name = button.getAttribute('data-name');
                const date = button.getAttribute('data-date');
                const type = button.getAttribute('data-type');
                const proof = button.getAttribute('data-proof');
                const proofImage = button.getAttribute('data-proof-image');
                const status = button.getAttribute('data-status');

                // Update modal content
                modal.querySelector('#modal-staff-name').value = name;
                modal.querySelector('#modal-date').value = date;
                modal.querySelector('#modal-type').value = type;
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
            });
        });
    </script>
@endsection
