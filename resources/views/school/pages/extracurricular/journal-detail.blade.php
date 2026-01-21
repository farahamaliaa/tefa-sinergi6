@extends('school.layouts.app')
@section('style')
    <style>
        .card {
            border: 1px solid #E0E6ED !important;
            box-shadow: none !important;
        }

        .btn-primary {
            background-color: #0896D1 !important;
            border-color: #0896D1 !important;
        }

        .badge-hadir {
            background-color: #0D9488;
            color: white;
        }

        .badge-sakit {
            background-color: #D97706;
            color: white;
        }

        .badge-izin {
            background-color: #2563EB;
            color: white;
        }

        .badge-alpha {
            background-color: #DC2626;
            color: white;
        }

        .table thead th {
            background-color: #0896D1 !important;
            color: white !important;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header" style="background-color: #0896D1;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-white">
                    <i class="ti ti-notebook me-2"></i>Detail Jurnal Pembina
                </h4>
                <a href="{{ route('school.extracurricular.show', $extracurricular->id) }}" class="btn btn-light btn-sm">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="fw-semibold mb-3">Informasi Jurnal</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-semibold" width="150">Ekstrakurikuler</td>
                            <td>: {{ $extracurricular->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Tanggal</td>
                            <td>: {{ $journal->date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Jadwal</td>
                            <td>:
                                {{ ucfirst(\App\Enums\DayEnum::tryFrom($journal->schedule->day ?? '')?->label() ?? ($journal->schedule->day ?? '-')) }},
                                {{ \Carbon\Carbon::parse($journal->schedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($journal->schedule->end_time)->format('H:i') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="fw-semibold mb-3">Rekap Kehadiran</h5>
                    <div class="d-flex gap-3 flex-wrap">
                        <span class="badge badge-hadir px-3 py-2">
                            <i class="ti ti-check me-1"></i> Hadir:
                            {{ $journal->attendances->where('status', 'hadir')->count() }}
                        </span>
                        <span class="badge badge-sakit px-3 py-2">
                            <i class="ti ti-heart-broken me-1"></i> Sakit:
                            {{ $journal->attendances->where('status', 'sakit')->count() }}
                        </span>
                        <span class="badge badge-izin px-3 py-2">
                            <i class="ti ti-file-text me-1"></i> Izin:
                            {{ $journal->attendances->where('status', 'izin')->count() }}
                        </span>
                        <span class="badge badge-alpha px-3 py-2">
                            <i class="ti ti-x me-1"></i> Alpha:
                            {{ $journal->attendances->where('status', 'alpha')->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="fw-semibold mb-3">Dokumentasi</h5>
                    <img src="{{ asset('storage/' . $journal->image) }}" class="img-fluid rounded-3"
                        style="max-height: 400px; object-fit: cover;" alt="Dokumentasi">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="fw-semibold mb-3">Deskripsi Kegiatan</h5>
                    <p class="text-muted" style="text-align: justify; line-height: 1.8;">
                        {{ $journal->description }}
                    </p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="fw-semibold mb-3">Daftar Kehadiran Siswa</h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($journal->attendances as $index => $attendance)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $attendance->extracurricularStudent->student->user->name ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $attendance->status }} px-3 py-2">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">Tidak ada data kehadiran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection