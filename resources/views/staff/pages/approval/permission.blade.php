@extends('staff.layouts.app')

@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Approval Perizinan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ route('employee.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Approval Perizinan</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="{{ asset('admin_assets/dist/images/backgrounds/welcome-bg.png') }}" alt="" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Pengajuan Izin Staff</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Staff</th>
                        <th>Tanggal</th>
                        <th>Jenis Izin</th>
                        <th>Keterangan</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration + $permissions->firstItem() - 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-0">
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $permission->employee->user->name ?? 'Unknown' }}</h6>
                                        <span class="fw-normal text-muted">{{ $permission->employee->nip ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ Carbon\Carbon::parse($permission->date)->format('d M Y') }}</td>
                            <td>{{ $permission->permission_type->label() ?? $permission->permission_type->value }}</td>
                            <td>{{ Str::limit($permission->proof, 40) }}</td>
                            <td>
                                @if($permission->proof_image)
                                    <a href="{{ asset('storage/' . $permission->proof_image) }}" target="_blank" class="btn btn-sm btn-info">
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
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
                                @if($permission->status == \App\Enums\StatusPermissionEnum::PENDING)
                                    <form action="{{ route('employee.approval.permission.approve', $permission->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui izin ini?')">
                                            <i class="ti ti-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('employee.approval.permission.reject', $permission->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak izin ini?')">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" width="150" alt="No Data">
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
@endsection
