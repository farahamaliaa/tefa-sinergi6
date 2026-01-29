<div class="modal fade" id="createInstructorModal" tabindex="-1" aria-labelledby="createInstructorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header border-0 py-3" style="background-color: #0896D1;">
                <h5 class="modal-title text-white" id="createInstructorModalLabel">Tambah Pembina Ekstrakurikuler</h5>
                <button type="button" class="btn-close btn-close-white" style="bs-btn-close-color: white !important;"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('school.extra-instructor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-12 mb-3 text-center">
                            <div class="position-relative d-inline-block">
                                <img id="create-preview-img-instructor"
                                    src="{{ asset('assets/images/default-user.jpeg') }}" alt="Preview"
                                    class="rounded-circle object-fit-cover"
                                    style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #ddd;">
                                <label for="image_instructor"
                                    class="position-absolute bottom-0 end-0 text-white rounded-circle p-2 cursor-pointer"
                                    style="cursor: pointer; background-color: #0896D1">
                                    <i class="ti ti-camera"></i>
                                    <input type="file" class="d-none" id="image_instructor" name="image"
                                        accept="image/*" onchange="previewCreateImageInstructor(event)">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name_instructor" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name_instructor" name="name" required
                                placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email_instructor" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="email_instructor" name="email" required
                                placeholder="Masukkan email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_instructor" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control" id="password_instructor" name="password"
                                required placeholder="Masukkan password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone_number_instructor" class="form-label fw-semibold">Nomor HP</label>
                            <input type="text" class="form-control" id="phone_number_instructor" name="phone_number"
                                placeholder="Masukkan nomor HP">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender_instructor" class="form-label fw-semibold">Jenis Kelamin</label>
                            <select class="form-select" id="gender_instructor" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address_instructor" class="form-label fw-semibold">Alamat</label>
                            <input type="text" class="form-control" id="address_instructor" name="address"
                                placeholder="Masukkan alamat">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="extracurricular_ids" class="form-label fw-semibold">Pilih
                                Ekstrakurikuler</label>
                            <select class="form-select" id="extracurricular_ids" name="extracurricular_ids[]" multiple
                                size="4" style="height: 120px;">
                                @foreach ($extracurriculars as $eskul)
                                    <option value="{{ $eskul->id }}">{{ $eskul->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Tahan CTRL untuk memilih lebih dari satu ekstrakurikuler.</small>
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

<script>
    function previewCreateImageInstructor(event) {
        const file = event.target.files[0];
        if (file) {
            document.getElementById('create-preview-img-instructor').src = URL.createObjectURL(file);
        }
    }
</script>
