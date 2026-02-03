<div class="modal fade" id="createParentModal" tabindex="-1" aria-labelledby="createParentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header border-0 py-3" style="background-color: #0896D1;">
                <h5 class="modal-title text-white" id="createParentModalLabel">Tambah Data Orang Tua</h5>
                <button type="button" class="btn-close btn-close-white" style="bs-btn-close-color: white !important;"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('school.parent.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-12 mb-3 text-center">
                            <div class="position-relative d-inline-block">
                                <img id="create-preview-img" src="{{ asset('assets/images/default-user.jpeg') }}"
                                    alt="Preview" class="rounded-circle object-fit-cover"
                                    style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #ddd;">
                                <label for="image"
                                    class="position-absolute bottom-0 end-0 text-white rounded-circle p-2 cursor-pointer"
                                    style="cursor: pointer; background-color: #0896D1">
                                    <i class="ti ti-camera"></i>
                                    <input type="file" class="d-none" id="image" name="image" accept="image/*"
                                        onchange="previewCreateImage(event)">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="Masukkan email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Masukkan password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label fw-semibold">Nomor HP</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                pattern="[0-9]*" inputmode="numeric" maxlength="13" required
                                placeholder="Masukkan nomor HP">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label fw-semibold">Jenis Kelamin</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="students" class="form-label fw-semibold">Pilih Siswa (Anak)</label>
                            <select class="form-select" id="students" name="students[]" size="5" multiple
                                style="height: 150px;">
                                @foreach ($students as $student)
                                    <option value="{{ $student['id'] }}">{{ $student['name'] }} -
                                        {{ $student['classroom'] }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Tahan CTRL untuk memilih lebih dari satu anak.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background-color: #0896D1;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%) !important;
    }
</style>
