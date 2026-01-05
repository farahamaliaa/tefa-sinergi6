@extends('staff.layouts.app')

@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Ajukan Izin</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ route('employee.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ route('employee.permission.index') }}">Perizinan</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Ajukan</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="{{ asset('admin_assets/dist/images/backgrounds/welcome-bg.png') }}" alt="" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('employee.permission.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Tanggal Izin</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Izin</label>
                <select name="permission_type" class="form-select" required>
                    <option value="">Pilih Jenis Izin</option>
                    @foreach(\App\Enums\PermissionTypeEnum::cases() as $type)
                        <option value="{{ $type->value }}">{{ $type->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan / Alasan</label>
                <textarea name="proof" class="form-control" rows="4" placeholder="Jelaskan alasan izin..." required>{{ old('proof') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Bukti Lampiran (Foto/Surat)</label>
                <input type="file" name="proof_image" class="form-control" accept="image/*" required>
                <div class="form-text">Maksimal 2MB. Format: JPG, PNG, JPEG.</div>
            </div>

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('employee.permission.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>
@endsection
