<div class="modal fade" id="editParentModal" tabindex="-1" aria-labelledby="editParentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header border-0 py-3" style="background-color: #0896D1;">
                <h5 class="modal-title text-white" id="editParentModalLabel">Edit Data Orang Tua</h5>
                <button type="button" class="btn-close btn-close-white" style="bs-btn-close-color: white !important;"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editParentForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-12 mb-3 text-center">
                            <div class="position-relative d-inline-block">
                                <img id="edit-preview-img" src="" alt="Preview"
                                    class="rounded-circle object-fit-cover"
                                    style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #ddd;">
                                <label for="edit_image"
                                    class="position-absolute bottom-0 end-0 text-white rounded-circle p-2 cursor-pointer"
                                    style="cursor: pointer; background-color: #0896D1">
                                    <i class="ti ti-pencil"></i>
                                    <input type="file" class="d-none" id="edit_image" name="image" accept="image/*"
                                        onchange="previewEditImage(event)">
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_password" class="form-label fw-semibold">Password (Kosongkan jika tidak
                                diubah)</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_phone_number" class="form-label fw-semibold">Nomor HP</label>
                            <input type="tel" class="form-control" id="edit_phone_number" name="phone_number"
                                pattern="[0-9]*" inputmode="numeric" maxlength="13" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_gender" class="form-label fw-semibold">Jenis Kelamin</label>
                            <select class="form-select" id="edit_gender" name="gender" required>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_students" class="form-label fw-semibold">Pilih Siswa (Anak)</label>
                            <select class="form-select" id="edit_students" name="students[]" size="5" multiple
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
                    <button type="submit" class="btn text-white" style="background-color: #0896D1;">Simpan
                        Perubahan</button>
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
