<div class="modal fade" id="detailParentModal" tabindex="-1" aria-labelledby="detailParentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header border-0 py-3" style="background-color: #0896D1;">
                <h5 class="modal-title text-white" id="detailParentModalLabel">Detail Data Orang Tua</h5>
                <button type="button" class="btn-close btn-close-white" style="bs-btn-close-color: white !important;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-12 mb-4 text-center">
                        <div class="position-relative d-inline-block">
                            <img id="detail-preview-img" src="" alt="Preview" class="rounded-circle object-fit-cover shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Nama Lengkap</label>
                        <p id="detail_name" class="fs-4 fw-medium text-dark border-bottom pb-2"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Email</label>
                        <p id="detail_email" class="fs-4 text-dark border-bottom pb-2"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Nomor HP</label>
                        <p id="detail_phone_number" class="fs-4 text-dark border-bottom pb-2"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold text-muted">Jenis Kelamin</label>
                        <p id="detail_gender" class="fs-4 text-dark border-bottom pb-2"></p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold text-muted">Siswa (Anak)</label>
                        <div id="detail_students" class="d-flex flex-wrap gap-2">
                            <!-- Student badges will be inserted here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%) !important;
    }
</style>
