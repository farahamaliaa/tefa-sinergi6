@php
    use App\Enums\DayEnum;
    use Carbon\Carbon;
@endphp
@extends('staff.layouts.app')
@section('style')
    <style>
        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
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

        .table-header-custom th {
            background-color: #0891CA !important;
            color: white !important;
        }

        .badge-pending {
            background-color: #FEF3C7;
            color: #D97706;
        }

        .badge-approved {
            background-color: #D1FAE5;
            color: #059669;
        }

        .badge-rejected {
            background-color: #FEE2E2;
            color: #DC2626;
        }

        .btn-approve {
            background-color: #059669 !important;
            border-color: #059669 !important;
            color: white !important;
        }

        .btn-reject {
            background-color: #DC2626 !important;
            border-color: #DC2626 !important;
            color: white !important;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-2">Perizinan {{ $extracurricular->name }}</h4>
                    <h6 class="fw-semibold text-white mb-2">Data izin siswa eskul {{ $extracurricular->name }}</h6>
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

    <div class="card card-body mt-4">
        <h4 class="mb-4">Daftar Perizinan Kegiatan {{ $extracurricular->name }}</h4>

        <div class="table-responsive rounded-3 mb-4">
            <table class="table border text-nowrap customize-table mb-0 align-middle">
                <thead class="fs-4 table-header-custom">
                    <tr>
                        <th class="text-white">No</th>
                        <th class="text-white">Nama</th>
                        <th class="text-white">Kelas</th>
                        <th class="text-white">Tanggal</th>
                        <th class="text-white">Jadwal</th>
                        <th class="text-white">Jenis</th>
                        <th class="text-white">Alasan</th>
                        <th class="text-white">Status</th>
                        <th class="text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permissions as $index => $permission)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $permission->extracurricularStudent->student->user->avatar ?? asset('assets/images/default-user.jpeg') }}"
                                        class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    <div class="ms-3">
                                        <h6 class="fs-4 fw-semibold mb-0">
                                            {{ $permission->extracurricularStudent->student->user->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $permission->extracurricularStudent->student->classroomStudents->first()?->classroom?->name ?? 'N/A' }}
                            </td>
                            <td>{{ $permission->date->format('d M Y') }}</td>
                            <td>{{ DayEnum::tryFrom($permission->schedule->day ?? '')?->label() ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $permission->type == 'sakit' ? 'bg-warning' : 'bg-info' }}">
                                    {{ ucfirst($permission->type) }}
                                </span>
                            </td>
                            <td>
                                <span data-bs-toggle="tooltip" title="{{ $permission->reason }}">
                                    {{ \Illuminate\Support\Str::limit($permission->reason, 25) }}
                                </span>
                                @if($permission->attachment)
                                    <a href="{{ asset('storage/' . $permission->attachment) }}" target="_blank"
                                        class="text-primary ms-1">
                                        <i class="ti ti-paperclip"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $permission->status }} px-3 py-2">
                                    {{ ucfirst($permission->status) }}
                                </span>
                            </td>
                            <td>
                                @if($permission->status === 'pending')
                                    <div class="d-flex gap-1">
                                        <form action="{{ route('employee.extracurricular-permission.approve', $permission->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-approve"
                                                onclick="return confirm('Setujui izin {{ $permission->type }} untuk {{ $permission->extracurricularStudent->student->user->name }}?')">
                                                <i class="ti ti-check"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-reject" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal{{ $permission->id }}">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal{{ $permission->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('employee.extracurricular-permission.reject', $permission->id) }}"
                                        method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tolak Izin</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tolak izin dari
                                                <strong>{{ $permission->extracurricularStudent->student->user->name }}</strong>?
                                            </p>
                                            <div class="mb-3">
                                                <label class="form-label">Catatan Penolakan (Opsional)</label>
                                                <textarea name="rejection_note" class="form-control" rows="3"
                                                    placeholder="Berikan alasan penolakan..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak Izin</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center align-middle">
                                <div class="d-flex flex-column justify-content-center align-items-center py-4">
                                    <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}" alt="" width="200px">
                                    <p class="fs-5 text-dark text-center mt-2">Belum ada pengajuan izin</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
