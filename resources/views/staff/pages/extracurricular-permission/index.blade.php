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
                    <h4 class="fw-semibold text-white mb-8">Perizinan {{ $extracurricular->name }}</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    Daftar perizinan siswa
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
    <div class="card card-body">
        <h4><b>Perizinan Siswa</b></h4>
        <div class="col-lg-5 mb-3 mt-2">
            <form class="d-flex gap-2" method="GET" action="{{ url()->current() }}">
                <input type="hidden" name="extracurricular" value="{{ $extracurricular->id }}">
                <input type="text" name="search" class="form-control search-chat"
                    value="{{ old('search', request('search')) }}" placeholder="Cari..">
                <div>
                    <select name="status" class="form-select py-2" id="search-status" style="min-width: 120px;">
                        <option value="" {{ old('status', request('status')) == '' ? 'selected' : '' }}>Pilih
                        </option>
                        <option value="pending" {{ old('status', request('status')) == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="approved" {{ old('status', request('status')) == 'approved' ? 'selected' : '' }}>
                            Disetujui
                        </option>
                        <option value="rejected" {{ old('status', request('status')) == 'rejected' ? 'selected' : '' }}>
                            Ditolak
                        </option>
                    </select>
                </div>
                <div class="position-relative">
                    <input type="date" name="date" class="form-control search-chat py-2 px-2 ps-3" id="search-date"
                        value="{{ old('date', request('date')) }}">
                </div>
                <button class="btn text-white" style="background-color: #098FC6;" type="submit">Cari</button>
            </form>
        </div>

        <div class="">
            <div class="table-responsive rounded-2 mb-4">
                <table class="table border text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="text-white" style="background-color: #098FC6;">No</th>
                            <th class="text-white" style="background-color: #098FC6;">Nama Siswa</th>
                            <th class="text-white" style="background-color: #098FC6;">Kelas</th>
                            <th class="text-white" style="background-color: #098FC6;">Tanggal</th>
                            <th class="text-white" style="background-color: #098FC6;">Jadwal</th>
                            <th class="text-white" style="background-color: #098FC6;">Jenis</th>
                            <th class="text-white" style="background-color: #098FC6;">Alasan</th>
                            <th class="text-white text-center" style="background-color: #098FC6;">Bukti Surat</th>
                            <th class="text-white" style="background-color: #098FC6;">Status</th>
                            <th class="text-white text-center" style="background-color: #098FC6;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $index => $permission)
                            <tr>
                                <td>{{ $index + 1 }}.</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $permission->extracurricularStudent->student->user->avatar ?? asset('assets/images/default-user.jpeg') }}"
                                            class="rounded-circle" width="40" height="40" style="object-fit: cover">
                                        <div class="ms-3">
                                            <h6 class="fs-4 fw-semibold mb-0">
                                                {{ $permission->extracurricularStudent->student->user->name }}</h6>
                                            <span
                                                class="fw-normal fs-2 text-muted">{{ $permission->extracurricularStudent->student->gender->label() }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $permission->extracurricularStudent->student->classroomStudents->first()?->classroom?->name ?? 'N/A' }}
                                </td>
                                <td>{{ $permission->date->format('d M Y') }}</td>
                                <td>{{ DayEnum::tryFrom($permission->schedule->day ?? '')?->label() ?? '-' }}</td>
                                <td>
                                    <span class="badge px-4 py-2 rounded-2 fw-semibold"
                                        style="background-color: {{ $permission->type == 'sakit' ? '#FFF4E5' : '#E6F4FF' }}; color: {{ $permission->type == 'sakit' ? '#FA896B' : '#5D87FF' }};">
                                        {{ ucfirst($permission->type) }}
                                    </span>
                                </td>
                                <td>
                                    <span data-bs-toggle="tooltip" title="{{ $permission->reason }}">
                                        {{ \Illuminate\Support\Str::limit($permission->reason, 25) }}
                                    </span>
                                </td>
                                <td>
                                    <div
                                        style="background-color: white; display: flex; align-items: center; justify-content: center;">
                                        @if ($permission->attachment)
                                            <a href="{{ asset('storage/' . $permission->attachment) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $permission->attachment) }}"
                                                    alt="Bukti Surat"
                                                    style="width: 100px; height: 80px; object-fit: cover; border-radius: 5px;">
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $permission->status }} px-3 py-2">
                                        {{ ucfirst($permission->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn text-white px-4" style="background-color: #098FC6;"
                                        data-bs-toggle="modal" data-bs-target="#student-permission-modal"
                                        data-id="{{ $permission->id }}"
                                        data-name="{{ $permission->extracurricularStudent->student->user->name }}"
                                        data-date="{{ $permission->date->format('d/m/Y') }}"
                                        data-schedule="{{ DayEnum::tryFrom($permission->schedule->day ?? '')?->label() ?? '-' }}"
                                        data-type="{{ ucfirst($permission->type) }}"
                                        data-reason="{{ $permission->reason }}" data-status="{{ $permission->status }}"
                                        data-attachment="{{ $permission->attachment ? asset('storage/' . $permission->attachment) : '' }}"
                                        data-approve-url="{{ route('employee.extracurricular-permission.approve', $permission->id) }}"
                                        data-reject-url="{{ route('employee.extracurricular-permission.reject', $permission->id) }}">
                                        Lihat
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center align-middle">
                                    <div class="d-flex flex-column justify-content-center align-items-center py-4">
                                        <img src="{{ asset('admin_assets/dist/images/empty/no-data.png') }}"
                                            alt="" width="200px">
                                        <p class="fs-5 text-dark text-center mt-2">Belum ada pengajuan izin</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('teacher.pages.extracurricular-permission.widgets.detail-extracurricular-permission')
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
                const schedule = button.getAttribute('data-schedule');
                const type = button.getAttribute('data-type');
                const reason = button.getAttribute('data-reason');
                const status = button.getAttribute('data-status');
                const attachment = button.getAttribute('data-attachment');
                const approveUrl = button.getAttribute('data-approve-url');
                const rejectUrl = button.getAttribute('data-reject-url');

                // Update modal content
                modal.querySelector('#modal-student-name').value = name;
                modal.querySelector('#modal-date').value = date;
                modal.querySelector('#modal-schedule').value = schedule;
                modal.querySelector('#modal-reason').value = reason || '-';

                // Update proof image
                const imgContainer = modal.querySelector('#modal-proof-image-container');
                if (attachment) {
                    imgContainer.innerHTML =
                        `<a href="${attachment}" target="_blank"><img src="${attachment}" class="img-fluid rounded-3" alt="Bukti Izin" style="width: 300px; max-height: 300px; object-fit: cover;"></a>`;
                } else {
                    imgContainer.innerHTML = '<p class="text-muted">Tidak ada bukti</p>';
                }

                // Update status badge
                const statusBadge = modal.querySelector('#modal-status');
                statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                if (status === 'approved') {
                    statusBadge.style.backgroundColor = '#D1FAE5';
                    statusBadge.style.color = '#059669';
                } else if (status === 'rejected') {
                    statusBadge.style.backgroundColor = '#FEE2E2';
                    statusBadge.style.color = '#DC2626';
                } else {
                    statusBadge.style.backgroundColor = '#FEF3C7';
                    statusBadge.style.color = '#D97706';
                }

                // Show/hide action buttons based on status
                const actionButtons = modal.querySelector('#modal-action-buttons');
                if (status === 'pending') {
                    actionButtons.style.display = 'flex';
                    // Update form actions
                    modal.querySelector('#modal-approve-form').action = approveUrl;
                    modal.querySelector('#modal-reject-form').action = rejectUrl;
                } else {
                    actionButtons.style.display = 'none';
                }
            });
        });
    </script>
@endsection
