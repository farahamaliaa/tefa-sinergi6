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

    <div class="card mt-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="ti ti-file-text me-2"></i>Form Pengajuan Izin</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('student.extracurricular.permission.store', $extracurricular->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jadwal <span class="text-danger">*</span></label>
                        <select name="schedule_id" class="form-select" required>
                            <option value="">Pilih Jadwal</option>
                            @foreach($schedules as $schedule)
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
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control" min="{{ now()->format('Y-m-d') }}"
                            value="{{ old('date', now()->format('Y-m-d')) }}" required>
                        @error('date')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Izin <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="izin" {{ old('type') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ old('type') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        </select>
                        @error('type')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lampiran (Opsional)</label>
                        <input type="file" name="attachment" class="form-control" accept="image/*">
                        <small class="text-muted">Surat keterangan sakit atau dokumen pendukung (maks. 2MB)</small>
                        @error('attachment')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alasan <span class="text-danger">*</span></label>
                    <textarea name="reason" class="form-control" rows="4"
                        placeholder="Jelaskan alasan Anda tidak bisa hadir..." required>{{ old('reason') }}</textarea>
                    @error('reason')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('student.extracurricular.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-send me-1"></i> Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($permissions->count() > 0)
        <div class="card mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="ti ti-history me-2"></i>Riwayat Pengajuan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
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
                            @foreach($permissions as $index => $permission)
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