@extends('extracurricular.layouts.app')

@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">Profil Saya</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="{{ route('extracurricular.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Profil</li>
                    </ol>
                </nav>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="" class="img-fluid mb-n4">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('extracurricular.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/images/default-user.jpeg') }}" 
                                 class="img-fluid rounded-circle mb-3 object-fit-cover" style="width: 150px; height: 150px;">
                            <div class="mb-3">
                                <label for="image" class="form-label">Ganti Foto Profil</label>
                                <input type="file" class="form-control" name="image" id="image">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>
                             <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor HP</label>
                                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $employee->phone_number ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="gender" class="form-select">
                                    <option value="male" {{ (old('gender', $user->gender) == 'male') ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ (old('gender', $user->gender) == 'female') ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control">{{ old('address', $employee->address ?? '') }}</textarea>
                            </div>
                            
                            <!-- Readonly fields -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIP</label>
                                    <input type="text" class="form-control bg-light" value="{{ $employee->nip ?? '-' }}" readonly disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jabatan (Status)</label>
                                    <input type="text" class="form-control bg-light" value="{{ $employee->status ?? '-' }}" readonly disabled>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control" placeholder="Masukkan password saat ini jika ingin mengubah password">
                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                             <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password Baru (Opsional)</label>
                                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
