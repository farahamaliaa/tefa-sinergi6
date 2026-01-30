@extends('extracurricular.layouts.app')

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
    </style>
@endsection

@section('content')
    <div class="card header-wave shadow-none position-relative overflow-hidden">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold text-white mb-8">Detail Jurnal</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-white text-decoration-none" href="javascript:void(0)">
                                    {{ $journal->extracurricular->name }} - {{ $journal->date->format('d F Y') }}
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
        <div class="card-body">
            {{-- Journal Info --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="fw-semibold mb-3">Informasi Jurnal</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-semibold" width="150">Ekstrakurikuler</td>
                            <td>: {{ $journal->extracurricular->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Tanggal</td>
                            <td>: {{ $journal->date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Jadwal</td>
                            <td>:
                                {{ ucfirst(\App\Enums\DayEnum::tryFrom($journal->schedule->day)?->label() ?? $journal->schedule->day) }},
                                {{ \Carbon\Carbon::parse($journal->schedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($journal->schedule->end_time)->format('H:i') }}
                            </td>
                        </tr>
                    </table>
                </div>

            </div>

            {{-- Documentation --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="fw-semibold mb-3">Dokumentasi</h5>
                    <img src="{{ asset('storage/' . $journal->image) }}" class="img-fluid rounded-3"
                        style="max-height: 400px; object-fit: cover;" alt="Dokumentasi">
                </div>
            </div>

            {{-- Description --}}
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="fw-semibold mb-3">Deskripsi Kegiatan</h5>
                    <p class="text-muted" style="text-align: justify; line-height: 1.8;">
                        {{ $journal->description }}
                    </p>
                </div>
            </div>



            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('extracurricular.journal.index', ['extracurricular' => $journal->extracurricular_id]) }}"
                    class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('extracurricular.journal.edit', ['id' => $journal->id]) }}" class="btn btn-warning">
                        <i class="ti ti-pencil me-1"></i> Edit
                    </a>
                    <form action="{{ route('extracurricular.journal.destroy', ['id' => $journal->id]) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus jurnal ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti ti-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
