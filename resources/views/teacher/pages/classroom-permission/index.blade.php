@extends('teacher.layouts.app')
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

        /* Custom Pagination Style */
        .pagination .page-item .page-link {
            border-radius: 8px;
            border: 1px solid #EAEFF4;
            color: #0896D1;
            margin: 0 4px;
            font-weight: 600;
            padding: 6px 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 35px;
            min-width: 35px;
        }

        .pagination .page-item.active .page-link {
            background-color: #0896D1;
            border-color: #0896D1;
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #A5A5A5;
            background-color: transparent;
            border-color: #EAEFF4;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            border-radius: 8px;
        }

        .pagination .page-item .page-link:hover {
            background-color: #EAEFF4;
            color: #0896D1;
        }

        .pagination .page-item.active .page-link:hover {
            background-color: #0896D1;
            color: #fff;
        }

        .pagination .page-item .page-link.pagination-dots {
            border: none;
            padding-bottom: 12px;
            background-color: transparent;
            color: #000;
            font-weight: 900;
        }
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Perizinan {{ $classroom->name }}</h4>
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
            <form class="d-flex gap-2">
                <input type="hidden" name="classroom" value="{{ $classroom->id }}">
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
                            <th class="text-white" style="background-color: #098FC6;">Tanggal</th>
                            {{-- <th class="text-white" style="background-color: #098FC6;">Durasi</th> --}}
                            <th class="text-white" style="background-color: #098FC6;">Jenis</th>
                            <th class="text-white text-center" style="background-color: #098FC6;">Bukti Surat</th>
                            <th class="text-white text-center" style="background-color: #098FC6;">Status & Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permissions as $permission)
                            @php
                                $student = $permission->student;
                                $permissionTypeLabel = \App\Enums\PermissionTypeEnum::tryFrom($permission->permission_type)?->label() ?? ucfirst($permission->permission_type);
                                
                                // Status badge colors
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
                                $currentStatusLabel = $statusLabels[$permission->status] ?? 'Pending';
                                
                                // Type badge colors  
                                $typeColors = [
                                    'sick' => ['bg' => '#FFF4E5', 'text' => '#FA896B'],
                                    'permit' => ['bg' => '#E8F7FF', 'text' => '#5D87FF'],
                                    'dinas' => ['bg' => '#E6FFFA', 'text' => '#13DEB9'],
                                    'other' => ['bg' => '#F5F5F5', 'text' => '#6B7280'],
                                ];
                                $currentTypeColor = $typeColors[$permission->permission_type] ?? $typeColors['other'];
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}.</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $student?->user?->image ? asset('storage/' . $student->user->image) : asset('assets/images/default-user.jpeg') }}" 
                                            class="rounded-circle" width="40" height="40" style="object-fit: cover">
                                        <div class="ms-3">
                                            <h6 class="fs-4 fw-semibold mb-0">{{ $student?->user?->name ?? 'N/A' }}</h6>
                                            <span class="fw-normal fs-2 text-muted">{{ $student?->user?->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($permission->date)->locale('id')->translatedFormat('d F Y') }}</td>
                                {{-- <td>{{ $permission->duration ?? 1 }} Hari</td> --}}
                                <td>
                                    <span class="badge px-4 py-2 rounded-2 fw-semibold"
                                        style="background-color: {{ $currentTypeColor['bg'] }}; color: {{ $currentTypeColor['text'] }};">
                                        {{ $permissionTypeLabel }}
                                    </span>
                                </td>
                                <td>
                                    <div style="background-color: white; display: flex; align-items: center; justify-content: center;">
                                        @if($permission->proof_image)
                                            <img src="{{ asset('storage/' . $permission->proof_image) }}" 
                                                alt="Bukti Izin" class="rounded" 
                                                style="width: 117px; height: 101px; object-fit: cover;">
                                        @else
                                            <div class="text-muted d-flex align-items-center justify-content-center border rounded" 
                                                style="width: 117px; height: 101px; background-color: #f5f5f5;">
                                                <i class="ti ti-file-x fs-3"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        <span class="badge px-3 py-2 rounded-2 fw-semibold mb-1"
                                            style="background-color: {{ $currentStatus['bg'] }}; color: {{ $currentStatus['text'] }};">
                                            {{ $currentStatusLabel }}
                                        </span>
                                        <button class="btn text-white px-4" style="background-color: #098FC6;"
                                            data-bs-toggle="modal" data-bs-target="#student-permission-modal-{{ $permission->id }}">Lihat</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="ti ti-inbox fs-1 d-block mb-2"></i>
                                    Belum ada perizinan siswa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Include modal for each permission --}}
    @foreach ($permissions as $permission)
        @include('teacher.pages.classroom-permission.widgets.detail-permission', ['permission' => $permission])
    @endforeach
@endsection
