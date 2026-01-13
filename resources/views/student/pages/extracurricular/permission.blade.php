@php
    use App\Enums\DayEnum;
    use Carbon\Carbon;
@endphp
@extends('student.layouts.app')

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

        .btn-primary {
            background-color: #0896D1 !important;
            border-color: #0896D1 !important;
        }

        .table thead th {
            background-color: #0896D1 !important;
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

        .btn-primary {
            background-color: #0896D1 !important;
            border-color: #0896D1 !important;
        }

        .text-primary {
            color: #0896D1 !important;
        }

        .btn-outline-primary {
            color: #0896D1 !important;
            border-color: #0896D1 !important;
            background-color: transparent !important;
        }

        .btn-outline-primary:hover {
            background-color: #0896D1 !important;
            color: #fff !important;
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
                    <h4 class="fw-semibold text-white mb-8">Pengajuan Izin</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    {{ $extracurricular->name }}
                                </a>
                            </li>
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

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-2 gap-2">
                <svg class="mb-2 width="24" height="24" viewBox="0 0 30 30" fill="none"
                    xmlns="http://www.w3.org/2000/svg" class="me-2">
                    <path
                        d="M19.25 4.125V9.625C19.25 9.98967 19.3949 10.3394 19.6527 10.5973C19.9106 10.8551 20.2603 11 20.625 11H26.125"
                        stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M12.375 12.375H13.75M12.375 17.875H20.625M12.375 23.375H20.625M23.375 28.875H9.625C8.89565 28.875 8.19618 28.5853 7.68046 28.0695C7.16473 27.5538 6.875 26.8543 6.875 26.125V6.875C6.875 6.14565 7.16473 5.44618 7.68046 4.93046C8.19618 4.41473 8.89565 4.125 9.625 4.125H19.25L26.125 11V26.125C26.125 26.8543 25.8353 27.5538 25.3195 28.0695C24.8038 28.5853 24.1043 28.875 23.375 28.875Z"
                        stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h4>Form Pengajuan Izin</h4>
            </div>
            <p class="text-muted fst-italic">Silahkan isi form berikut untuk mengajukan izin tidak hadir.</p>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('student.extracurricular.permission.store', $extracurricular->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly
                                    placeholder="Masukkan Nama Lengkap">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Izin <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control" min="{{ now()->format('Y-m-d') }}"
                                    value="{{ old('date', now()->format('Y-m-d')) }}" required>
                                @error('date')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jadwal <span class="text-danger">*</span></label>
                                <select name="schedule_id" class="form-select" required>
                                    <option value="">Pilih Jadwal</option>
                                    @foreach ($schedules as $schedule)
                                        <option value="{{ $schedule->id }}">
                                            {{ DayEnum::tryFrom($schedule->day)?->label() ?? ucfirst($schedule->day) }} -
                                            {{ Carbon::parse($schedule->start_time)->format('H:i') }} -
                                            {{ Carbon::parse($schedule->end_time)->format('H:i') }}
                                            ({{ $schedule->location_name ?? 'Lokasi belum diatur' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('schedule_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jenis Izin <span class="text-danger">*</span></label>
                                <select name="type" class="form-select" required>
                                    <option value="izin" {{ old('type') == 'izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="sakit" {{ old('type') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                </select>
                                @error('type')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Unggah Bukti Izin (Opsional)</label>
                            <p class="text-muted small mb-2">Unggah bukti berupa foto surat dokter / izin jika ada.</p>
                            <div class="position-relative text-center p-5 rounded-3"
                                style="border: 2px dashed #e0e6ed; background-color: #fafafa;">
                                <input type="file" name="attachment"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer"
                                    accept="image/*" id="file-upload" onchange="updateFileName(this)">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="mb-3 text-primary">
                                        <i class="ti ti-photo-up fs-8" style="font-size: 3rem;"></i>
                                    </div>
                                    <h6 class="fw-semibold mb-1">Seret File Disini, atau <span
                                            class="text-primary text-decoration-underline">Browse</span></h6>
                                    <small class="text-muted">Format JPG/PNG, maksimal 2MB</small>
                                    <div id="file-name-display" class="mt-2 text-info fw-semibold"></div>
                                </div>
                            </div>
                            @error('attachment')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alasan Izin <span class="text-danger">*</span></label>
                            <textarea name="reason" class="form-control" rows="4"
                                placeholder="Tuliskan alasan izin Anda secara singkat dan jelas..." required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('student.extracurricular.index') }}" class="btn btn-outline-primary px-4">
                                <i class="ti ti-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ti ti-send me-1"></i> Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>

                <script>
                    function updateFileName(input) {
                        var fileName = input.files[0] ? input.files[0].name : '';
                        document.getElementById('file-name-display').textContent = fileName;
                    }
                </script>
            </div>
        </div>
    </div>

    @if ($permissions->count() > 0)
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 gap-2">
                    <svg class="mb-2 width="24" height="24" viewBox="0 0 30 30" fill="none"
                        xmlns="http://www.w3.org/2000/svg" class="me-2">
                        <path
                            d="M19.25 4.125V9.625C19.25 9.98967 19.3949 10.3394 19.6527 10.5973C19.9106 10.8551 20.2603 11 20.625 11H26.125"
                            stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M12.375 12.375H13.75M12.375 17.875H20.625M12.375 23.375H20.625M23.375 28.875H9.625C8.89565 28.875 8.19618 28.5853 7.68046 28.0695C7.16473 27.5538 6.875 26.8543 6.875 26.125V6.875C6.875 6.14565 7.16473 5.44618 7.68046 4.93046C8.19618 4.41473 8.89565 4.125 9.625 4.125H19.25L26.125 11V26.125C26.125 26.8543 25.8353 27.5538 25.3195 28.0695C24.8038 28.5853 24.1043 28.875 23.375 28.875Z"
                            stroke="black" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h4>Riwayat Pengajuan</h4>
                </div>
                <div class="table-responsive rounded-2 mt-3" style="max-height: 400px; overflow-y: auto;">
                    <table class="table border text-nowrap customize-table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jadwal</th>
                                <th>Jenis</th>
                                <th>Alasan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $index => $permission)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $permission->date->format('d M Y') }}</td>
                                    <td>{{ DayEnum::tryFrom($permission->schedule->day ?? '')?->label() ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $permission->type == 'sakit' ? 'bg-warning' : 'bg-info' }}">
                                            {{ ucfirst($permission->type) }}
                                        </span>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($permission->reason, 30) }}</td>
                                    <td>
                                        <span class="badge badge-{{ $permission->status }}">
                                            {{ ucfirst($permission->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
