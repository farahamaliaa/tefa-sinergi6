@extends('teacher.layouts.app')

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
    }

    .attendance-radio {
        display: none;
    }

    .attendance-label {
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 500;
    }

    .attendance-label.hadir { background-color: #F0FDFA; color: #0D9488; border: 2px solid #0D9488; }
    .attendance-label.sakit { background-color: #FFFBEB; color: #D97706; border: 2px solid #D97706; }
    .attendance-label.izin { background-color: #EFF6FF; color: #2563EB; border: 2px solid #2563EB; }
    .attendance-label.alpha { background-color: #FEF2F2; color: #DC2626; border: 2px solid #DC2626; }

    .attendance-radio:checked + .attendance-label.hadir { background-color: #0D9488; color: white; }
    .attendance-radio:checked + .attendance-label.sakit { background-color: #D97706; color: white; }
    .attendance-radio:checked + .attendance-label.izin { background-color: #2563EB; color: white; }
    .attendance-radio:checked + .attendance-label.alpha { background-color: #DC2626; color: white; }

    .current-image {
        max-width: 200px;
        border-radius: 8px;
        border: 2px solid #E0E6ED;
    }
</style>
@endsection

@section('content')
<div class="card header-wave shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold text-white mb-8">Edit Jurnal Kegiatan</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-white text-decoration-none" href="javascript:void(0)">
                                {{ $extracurricular->name }} - {{ $journal->date->format('d F Y') }}
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n3">
                    <img src="{{ asset('assets/images/background/laptops.png') }}" alt="" class="img-fluid img-header-floating">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <form action="{{ route('teacher.extracurricular-journal.update', ['id' => $journal->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Journal Details --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="fw-semibold mb-3">Detail Jurnal</h5>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jadwal</label>
                    <input type="text" class="form-control" readonly 
                        value="{{ ucfirst(\App\Enums\DayEnum::tryFrom($journal->schedule->day)?->label() ?? $journal->schedule->day) }}, {{ \Carbon\Carbon::parse($journal->schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($journal->schedule->end_time)->format('H:i') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="text" class="form-control" readonly value="{{ $journal->date->format('d F Y') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" rows="4" required placeholder="Jelaskan kegiatan yang dilakukan hari ini...">{{ old('description', $journal->description) }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Dokumentasi Saat Ini</label>
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $journal->image) }}" class="current-image" alt="Dokumentasi">
                    </div>
                    <label class="form-label">Ganti Dokumentasi (Opsional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto</small>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Attendance --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="fw-semibold mb-3">Absensi Siswa</h5>
                    <p class="text-muted">Total siswa: {{ $journal->attendances->count() }}</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-white" style="background-color: #0896D1;">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th class="text-center">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($journal->attendances as $index => $attendance)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $attendance->extracurricularStudent->student->user->name ?? '-' }}</td>
                                <td>{{ $attendance->extracurricularStudent->student->classroomStudents->first()?->classroom?->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap justify-content-center">
                                        <input type="radio" name="attendance[{{ $attendance->extracurricularStudent->id }}]" value="hadir" 
                                            class="attendance-radio" id="hadir_{{ $attendance->extracurricularStudent->id }}" 
                                            {{ $attendance->status == 'hadir' ? 'checked' : '' }}>
                                        <label for="hadir_{{ $attendance->extracurricularStudent->id }}" class="attendance-label hadir">Hadir</label>

                                        <input type="radio" name="attendance[{{ $attendance->extracurricularStudent->id }}]" value="sakit" 
                                            class="attendance-radio" id="sakit_{{ $attendance->extracurricularStudent->id }}"
                                            {{ $attendance->status == 'sakit' ? 'checked' : '' }}>
                                        <label for="sakit_{{ $attendance->extracurricularStudent->id }}" class="attendance-label sakit">Sakit</label>

                                        <input type="radio" name="attendance[{{ $attendance->extracurricularStudent->id }}]" value="izin" 
                                            class="attendance-radio" id="izin_{{ $attendance->extracurricularStudent->id }}"
                                            {{ $attendance->status == 'izin' ? 'checked' : '' }}>
                                        <label for="izin_{{ $attendance->extracurricularStudent->id }}" class="attendance-label izin">Izin</label>

                                        <input type="radio" name="attendance[{{ $attendance->extracurricularStudent->id }}]" value="alpha" 
                                            class="attendance-radio" id="alpha_{{ $attendance->extracurricularStudent->id }}"
                                            {{ $attendance->status == 'alpha' ? 'checked' : '' }}>
                                        <label for="alpha_{{ $attendance->extracurricularStudent->id }}" class="attendance-label alpha">Alpha</label>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">Tidak ada siswa terdaftar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('teacher.extracurricular-journal.index', ['extracurricular' => $extracurricular->id]) }}" 
                   class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
