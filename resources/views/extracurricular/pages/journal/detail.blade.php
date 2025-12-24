@extends('extracurricular.layouts.app')
@section('style')
    <style>
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
    </style>
@endsection
@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-2">Detail Jurnal Ekstrakurikuler</h4>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Jurnal Kegiatan</h4>
                <a href="javascript:history.back()" class="btn btn-light">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <img src="{{ asset('assets/images/example-jurnal-ekstra.png') }}" 
                         class="img-fluid rounded-3" alt="Kegiatan">
                </div>
                <div class="col-md-8">
                    <h5 class="fw-bold">Ekstrakurikuler - {{ $journal->lessonSchedule->classroom->name ?? 'Kegiatan' }}</h5>
                    <p class="text-muted mb-2">
                        <i class="ti ti-calendar me-1"></i> {{ $journal->created_at->format('d F Y') ?? now()->format('d F Y') }}
                    </p>
                    <hr>
                    <h6 class="fw-semibold">Deskripsi:</h6>
                    <p>{{ $journal->description ?? 'Kegiatan ekstrakurikuler hari ini berjalan dengan lancar. Siswa mengikuti dengan antusias.' }}</p>
                </div>
            </div>

            @if(isset($attendanceJournals) && $attendanceJournals->count() > 0)
                <hr>
                <h5 class="mb-3">Daftar Kehadiran</h5>
                <div class="table-responsive">
                    <table class="table border">
                        <thead style="background-color: #0896D1;">
                            <tr>
                                <th class="text-white">No</th>
                                <th class="text-white">Nama</th>
                                <th class="text-white">Kelas</th>
                                <th class="text-white">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceJournals as $attendance)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $attendance->classroomStudent->student->user->name ?? 'N/A' }}</td>
                                    <td>{{ $attendance->classroomStudent->classroom->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-success">Hadir</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
