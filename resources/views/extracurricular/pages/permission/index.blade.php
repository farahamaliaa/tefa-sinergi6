@php
    use App\Enums\DayEnum;
    use Carbon\Carbon;
@endphp
@extends('extracurricular.layouts.app')
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

        /* Custom Pagination Style */
        .pagination .page-item .page-link {
            border-radius: 8px;
            border: 1px solid #EAEFF4;
            color: #0896D1;
            margin: 0 4px;
            font-weight: 600;
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
            <form class="d-flex gap-2" method="GET">
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
                        @forelse ($permissions as $permission)
                            @php
                                $student = $permission->extracurricularStudent->student;
                                $user = $student->user;

                                $typeColors = [
                                    'sakit' => ['bg' => '#FFF4E5', 'text' => '#FA896B'],
                                    'izin' => ['bg' => '#E8F7FF', 'text' => '#5D87FF'],
                                    'dispen' => ['bg' => '#E6FFFA', 'text' => '#13DEB9'],
                                    'lainnya' => ['bg' => '#F5F5F5', 'text' => '#6B7280'],
                                    'alpha' => ['bg' => '#FEE2E2', 'text' => '#DC2626'],
                                ];
                                $currentTypeColor = $typeColors[$permission->type] ?? $typeColors['lainnya'];

                                $statusColors = [
                                    'pending' => ['bg' => '#FFF4E5', 'text' => '#FFAE1F'],
                                    'approved' => ['bg' => '#E6FFFA', 'text' => '#13DEB9'],
                                    'rejected' => ['bg' => '#FBE4E4', 'text' => '#FA5A7D'],
                                ];
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                ];
                                $currentStatus = $statusColors[$permission->status] ?? $statusColors['pending'];
                                $currentStatusLabel =
                                    $statusLabels[$permission->status] ?? ucfirst($permission->status);
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $student->image ? asset('storage/' . $student->image) : asset('assets/images/default-user.jpeg') }}"
                                            class="rounded-circle" width="40" height="40" style="object-fit: cover">
                                        <div class="ms-3">
                                            <h6 class="fs-4 fw-semibold mb-0">{{ $user->name ?? 'N/A' }}</h6>
                                            <span
                                                class="fw-normal fs-2 text-muted">{{ $student->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $student->classroomStudents->first()?->classroom?->name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($permission->date)->translatedFormat('d F Y') }}</td>
                                <td>
                                    {{ DayEnum::tryFrom($permission->schedule->day ?? '')?->label() ?? '-' }}
                                    <br>
                                    <small
                                        class="text-muted">{{ $permission->schedule ? \Carbon\Carbon::parse($permission->schedule->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($permission->schedule->end_time)->format('H:i') : '' }}</small>
                                </td>
                                <td>
                                    <span class="badge px-4 py-2 rounded-2 fw-semibold"
                                        style="background-color: {{ $currentTypeColor['bg'] }}; color: {{ $currentTypeColor['text'] }};">
                                        {{ ucfirst($permission->type) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 150px;"
                                        data-bs-toggle="tooltip" title="{{ $permission->reason }}">
                                        {{ $permission->reason ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div
                                        style="background-color: white; display: flex; align-items: center; justify-content: center;">
                                        @if ($permission->attachment)
                                            <img src="{{ asset('storage/' . $permission->attachment) }}" alt="Bukti Izin"
                                                class="rounded"
                                                style="width: 117px; height: 101px; object-fit: cover; cursor: pointer;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#student-permission-modal-{{ $permission->id }}">
                                        @else
                                            <div class="text-muted d-flex align-items-center justify-content-center border rounded"
                                                style="width: 117px; height: 101px; background-color: #f5f5f5;">
                                                <i class="ti ti-file-x fs-3"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge px-3 py-2 rounded-2 fw-semibold"
                                        style="background-color: {{ $currentStatus['bg'] }}; color: {{ $currentStatus['text'] }};">
                                        {{ $currentStatusLabel }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn text-white px-4" style="background-color: #098FC6;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#student-permission-modal-{{ $permission->id }}">Lihat</button>
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

    {{-- Modals --}}
    @foreach ($permissions as $permission)
        @php
            $student = $permission->extracurricularStudent->student;
            $user = $student->user;
            // Colors logic repeated
            $typeColors = [
                'sakit' => ['bg' => '#FFF4E5', 'text' => '#FA896B'],
                'izin' => ['bg' => '#E8F7FF', 'text' => '#5D87FF'],
                'dispen' => ['bg' => '#E6FFFA', 'text' => '#13DEB9'],
                'lainnya' => ['bg' => '#F5F5F5', 'text' => '#6B7280'],
            ];
            $currentTypeColor = $typeColors[$permission->type] ?? $typeColors['lainnya'];

            $statusColors = [
                'pending' => ['bg' => '#FFF4E5', 'text' => '#FFAE1F'],
                'approved' => ['bg' => '#E6FFFA', 'text' => '#13DEB9'],
                'rejected' => ['bg' => '#FBE4E4', 'text' => '#FA5A7D'],
            ];
            $statusLabels = [
                'pending' => 'Menunggu',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
            ];
            $currentStatus = $statusColors[$permission->status] ?? $statusColors['pending'];
            $currentStatusLabel = $statusLabels[$permission->status] ?? ucfirst($permission->status);
        @endphp

        <div class="modal fade" id="student-permission-modal-{{ $permission->id }}" tabindex="-1"
            aria-labelledby="permissionModalLabel-{{ $permission->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
                    <div class="modal-header px-4 py-3"
                        style="background-color: #098FC6; display: flex; align-items: center; justify-content: space-between;">
                        <h5 class="modal-title text-white fw-semibold" id="permissionModalLabel-{{ $permission->id }}">
                            Lihat Perizinan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            style="filter: invert(1) brightness(200%); opacity: 1;"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">Nama Siswa</label>
                            <input type="text" class="form-control" value="{{ $user->name ?? 'N/A' }}" readonly
                                style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280;">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Tanggal</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($permission->date)->translatedFormat('d F Y') }}"
                                        readonly style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280;">
                                    <i
                                        class="ti ti-calendar position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Jadwal</label>
                                <input type="text" class="form-control"
                                    value="{{ DayEnum::tryFrom($permission->schedule->day ?? '')?->label() ?? '-' }}"
                                    readonly style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280;">
                            </div>
                        </div>

                        <div class="row mb-4 align-items-start">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Alasan Izin</label>
                                <textarea class="form-control" rows="2" readonly
                                    style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280; resize: none;">{{ $permission->reason ?? '-' }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark d-block">Jenis Izin</label>
                                <span class="badge px-4 py-2 rounded-2 fw-semibold"
                                    style="background-color: {{ $currentTypeColor['bg'] }}; color: {{ $currentTypeColor['text'] }}; font-size: 0.9rem;">
                                    {{ ucfirst($permission->type) }}
                                </span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Surat/Bukti Izin</label>
                            <div class="rounded-3 overflow-hidden text-center" style="max-width: 100%; height: auto;">
                                @if ($permission->attachment)
                                    <img src="{{ asset('storage/' . $permission->attachment) }}"
                                        class="img-fluid rounded-3" alt="Bukti Izin"
                                        style="max-width: 100%; max-height: 400px; object-fit: contain;">
                                @else
                                    <div class="text-muted d-flex align-items-center justify-content-center border rounded-3 mx-auto"
                                        style="width: 300px; height: 200px; background-color: #f5f5f5;">
                                        <div class="text-center">
                                            <i class="ti ti-file-x fs-1 d-block mb-2"></i>
                                            <span>Tidak ada bukti</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($permission->status === 'pending')
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <form action="{{ route('extracurricular.permission.reject', $permission->id) }}"
                                    method="POST" class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menolak izin ini?');">
                                    @csrf
                                    <input type="hidden" name="rejection_note" value="-">
                                    <button type="submit" class="btn text-white px-5 py-2"
                                        style="background-color: #DC3545; border-radius: 8px; font-weight: 500;">Tolak</button>
                                </form>
                                <form action="{{ route('extracurricular.permission.approve', $permission->id) }}"
                                    method="POST" class="d-inline" onsubmit="return confirm('Setujui izin ini?');">
                                    @csrf
                                    <button type="submit" class="btn text-white px-5 py-2"
                                        style="background-color: #13DEB9; border-radius: 8px; font-weight: 500;">Setujui</button>
                                </form>
                            </div>
                        @else
                            <div class="d-flex justify-content-center mt-4">
                                <span class="badge px-5 py-3 rounded-2 fw-semibold fs-4"
                                    style="background-color: {{ $currentStatus['bg'] }}; color: {{ $currentStatus['text'] }};">
                                    Status: {{ $currentStatusLabel }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
