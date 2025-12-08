@extends('school.layouts.app')

<style>
    .btn-primary{
        background-color: #0896D1 !important;
        border-color: #0896D1 !important;
    }

    .btn-success{
        background-color: #1EB297 !important;
        border-color: #1EB297 !important;
    }

    .text-danger-1{
        color: #F73131 !important;
    }
</style>

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('school.settings-information.update', $school->id) }}" method="POST" enctype="multipart/form-data">
            <div class="row pb-4 mt-4 mx-3">
                <h4>Edit Profil Sekolah</h4>
                <div class="d-flex justify-content-center">
                    <img id="preview-image" src="{{ $school->image && Storage::exists('public/' . $school->image) ? asset('storage/' . $school->image) : asset('assets/images/default-user.jpeg') }}" width="180px" alt="Foto Profil Sekolah">
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button type="button" id="change-photo-button" class="btn btn-primary px-4 d-flex align-items-center gap-2">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21.875 6.24999H18.5417L16.6667 4.16666H10.4167V6.24999H15.7292L17.7083 8.33332H21.875V20.8333H5.20833V11.4583H3.125V20.8333C3.125 21.9792 4.0625 22.9167 5.20833 22.9167H21.875C23.0208 22.9167 23.9583 21.9792 23.9583 20.8333V8.33332C23.9583 7.18749 23.0208 6.24999 21.875 6.24999ZM8.33333 14.5833C8.33333 19.2187 13.9479 21.5521 17.2292 18.2708C20.5104 14.9896 18.1771 9.37499 13.5417 9.37499C10.6667 9.37499 8.33333 11.7083 8.33333 14.5833ZM13.5417 11.4583C14.363 11.4819 15.1442 11.8187 15.7252 12.3997C16.3063 12.9808 16.6431 13.762 16.6667 14.5833C16.6431 15.4047 16.3063 16.1859 15.7252 16.7669C15.1442 17.3479 14.363 17.6847 13.5417 17.7083C12.7203 17.6847 11.9391 17.3479 11.3581 16.7669C10.7771 16.1859 10.4403 15.4047 10.4167 14.5833C10.4403 13.762 10.7771 12.9808 11.3581 12.3997C11.9391 11.8187 12.7203 11.4819 13.5417 11.4583ZM5.20833 6.24999H8.33333V4.16666H5.20833V1.04166H3.125V4.16666H0V6.24999H3.125V9.37499H5.20833" fill="white"/>
                        </svg>
                        Ganti Foto
                    </button>
                </div>
                <input type="file" id="photo-input" name="image" accept="image/*" style="display: none;">
                @method('PUT')
                @csrf
                <div class="row mt-5">
                    <div class="col-md-6 mb-4">
                        <label for="">Nama Sekolah<span class="text-danger-1">*</span></label>
                        <input type="text" class="form-control mt-1" placeholder="Masukan nama sekolah" name="name" value="{{ old('name', $school->user->name) }}">
                        @error('name')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="">Kepala Sekolah<span class="text-danger-1">*</span></label>
                        <input type="text" class="form-control mt-1" placeholder="Masukan kepala sekolah" name="head_school" value="{{ old('head_school', $school->head_school) }}">
                        @error('head_school')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="">Email Sekolah<span class="text-danger-1">*</span></label>
                        <input type="text" class="form-control mt-1" placeholder="Masukan email sekolah" name="email" value="{{ old('email', $school->user->email) }}">
                        @error('email')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="">Telepon Sekolah<span class="text-danger-1">*</span></label>
                        <input type="text" name="phone_number" class="form-control mt-1" placeholder="Masukan telepon sekolah" value="{{ old('phone_number', $school->phone_number) }}">
                        @error('phone_number')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="">Akreditasi<span class="text-danger-1">*</span></label>
                        <input type="text" class="form-control mt-1" name="accreditation" placeholder="Masukan akreditasi sekolah" value="{{ old('accreditation', $school->accreditation) }}">
                        @error('accreditation')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="">Website<span class="text-danger-1">*</span></label>
                        <input type="text" class="form-control mt-1" name="website_school" placeholder="Masukan website sekolah" value="{{ old('website_school', $school->website_school) }}">
                        @error('website_school')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="">Kode Pos<span class="text-danger-1">*</span></label>
                        <input type="text" class="form-control mt-1" name="pas_code" placeholder="Masukan kode pos sekolah" value="{{ old('pas_code', $school->pas_code) }}">
                        @error('pas_code')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="">NPSN<span class="text-danger-1">*</span></label>
                        <input type="text" class="form-control mt-1" name="npsn" placeholder="Masukan NPSN sekolah" value="{{ old('npsn', $school->npsn) }}">
                        @error('npsn')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="">Alamat Sekolah<span class="text-danger-1">*</span></label>
                        <textarea name="address" class="form-control mt-1" placeholder="Masukan alamat sekolah" rows="2">{{ old('address', $school->address) }}</textarea>
                        @error('address')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="">Deskripsi Sekolah<span class="text-danger-1">*</span></label>
                        <textarea name="description" class="form-control mt-1" placeholder="Masukan deskripsi sekolah" rows="6">{{ old('description', $school->description) }}</textarea>
                        @error('description')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="">NIP<span class="text-danger-1">*</span></label>
                        <input type="text" class="form-control mt-1" name="nip" placeholder="Masukan NIP sekolah" value="{{ old('nip', $school->nip) }}">
                        @error('nip')
                            <span class="text-danger-1">{{ $message }}</span>
                        @enderror
                    </div>
                
                    <div class="text-end">
                        <a href="{{ route('school.settings-information.index') }}" class="btn btn-primary me-2">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
    @include('school.pages.settings.scripts.script-update-information')
@endsection
