<!-- Modal Detail Perizinan -->
<div class="modal fade" id="student-permission-modal" tabindex="-1" aria-labelledby="permissionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
            <div class="modal-header px-4 py-3"
                style="background-color: #098FC6; display: flex; align-items: center; justify-content: space-between;">
                <h5 class="modal-title text-white fw-semibold" id="permissionModalLabel" style="font-size: 1.1rem;">
                    Lihat Perizinan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1) brightness(200%); opacity: 1;"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark">Nama Staff</label>
                    <input type="text" class="form-control" id="modal-staff-name" readonly
                        style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280;">
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Tanggal</label>
                        <div class="position-relative">
                            <input type="text" class="form-control" id="modal-date" readonly
                                style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280;">
                            <i
                                class="ti ti-calendar position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Jenis Izin</label>
                        <input type="text" class="form-control" id="modal-type" readonly
                            style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280;">
                    </div>
                </div>

                <div class="row mb-4 align-items-start">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Alasan Izin</label>
                        <textarea class="form-control" rows="2" id="modal-proof" readonly
                            style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280; resize: none;"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark d-block">Durasi</label>
                        <input type="text" class="form-control" id="modal-duration" readonly
                            style="background-color: #F9FAFB; border-color: #E5E7EB; color: #6B7280;">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark">Surat/Bukti Izin</label>
                        <div class="rounded-3 overflow-hidden" id="modal-proof-image-container"
                            style="max-width: 100%; height: auto;">
                            <p class="text-muted">Tidak ada bukti</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-dark d-block">Status</label>
                        <div class="mt-2">
                            <span class="badge px-4 py-2 rounded-2 fw-semibold" id="modal-status"
                                style="background-color: #FFF4E5; color: #FA896B; font-size: 0.9rem;"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
