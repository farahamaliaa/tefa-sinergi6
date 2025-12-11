<style>
    .modal-header {
        border-top-left-radius: 10.1px !important;
        border-top-right-radius: 10.1px !important;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        background-color: #0896D1 !important;
    }

    .modal-content {
        border-radius: 10px !important;
        overflow: hidden;
        border: none;
    }

    .btn-close {
        filter: invert(1) brightness(200%);
    }

    .form-control-plaintext {
        background-color: #F8F9FA;
        border: 1px solid #DFE5EF;
        border-radius: 8px;
        padding: 10px 15px;
        color: #5A6A85;
        width: 100%;
    }
</style>
<!-- modal detail -->
<div class="modal fade" id="modal-detail" tabindex="-1" aria-labelledby="importPegawai" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="importPegawai">Detail Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center mb-4">
                    <div class="col-12 text-center">
                        <img src="{{ asset('admin_assets/dist/images/profile/user-7.jpg') }}" id="image-detail"
                            class="rounded-circle user-profile mb-3"
                            style="object-fit: cover; width: 120px; height: 120px;" alt="User Profile Picture" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label fw-semibold">Nama</label>
                        <div class="form-control-plaintext" id="name-detail"></div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="form-control-plaintext" id="email-detail"></div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <div class="form-control-plaintext" id="gender-detail"></div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label fw-semibold">NIK</label>
                        <div class="form-control-plaintext" id="nik-detail"></div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label fw-semibold">RFID</label>
                        <div class="form-control-plaintext" id="rfid-detail">-</div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label fw-semibold">Status Kehadiran</label>
                        <div>
                            <span class="badge bg-light-success text-success px-3 py-2 rounded-2"
                                id="status-detail">Masuk</span>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <div class="form-control-plaintext" style="height: 100px; overflow-y: auto;"
                            id="address-detail"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                {{-- No buttons needed as per image, or keep close if desired --}}
            </div>
        </div>
    </div>
</div>
