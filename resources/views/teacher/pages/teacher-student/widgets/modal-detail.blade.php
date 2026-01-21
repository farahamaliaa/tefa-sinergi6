<!-- modal detail -->
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
<div class="modal fade" id="modal-detail-student" tabindex="-1" aria-labelledby="detailStudent" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-lg">
            <div class="modal-header p-0" style="border:none;">
                <div
                    style="width:100%; padding: 14px 20px; border-top-left-radius: .5rem; border-top-right-radius: .5rem; display:flex; align-items:center; justify-content:space-between;">
                    <h5 class="modal-title text-white mb-0" id="detailStudent">Detail Siswa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body pt-4 pb-4">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <img id="image-detail" class="rounded-circle user-profile mb-3"
                            src="{{ asset('assets/images/default-user.jpeg') }}"
                            style="object-fit: cover; width: 150px; height: 150px;" alt="User Profile Picture"
                            onerror="this.onerror=null;this.src='{{ asset('assets/images/default-user.jpeg') }}';" />
                    </div>
                </div>
                <div class="row mt-3 px-4">
                    <div class="col-12 col-md-12 mb-3">
                        <label class="form-label mb-1">Nama</label>
                        <p id="name-detail" class="detail-field mb-0 text-start"></p>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label mb-1">Jenis Kelamin</label>
                        <p id="gender-detail" class="detail-field mb-0 text-start"></p>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label mb-1">NIK</label>
                        <p id="nik-detail" class="detail-field mb-0 text-start"></p>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label mb-1">Email</label>
                        <p id="email-detail" class="detail-field mb-0 text-start"></p>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label mb-1">Kelas</label>
                        <p id="class-detail" class="detail-field mb-0 text-start"></p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <div class="form-control-plaintext" style="height: 100px; overflow-y: auto;"
                            id="address-detail"></div>
                    </div>
                </div>
            </div>
            <style>
                #modal-detail-student .detail-field {
                    background: #F6F9FB;
                    border-radius: 8px;
                    padding: 12px 14px;
                    border: 1px solid rgba(0, 0, 0, 0.04);
                    min-height: 44px;
                    display: flex;
                    align-items: center;
                    color: #344054;
                    margin-bottom: 0;
                }

                #modal-detail-student .modal-content {
                    border-radius: 12px;
                    overflow: hidden;
                }

                .btn-close-white {
                    filter: invert(1) brightness(2);
                }
            </style>
        </div>
    </div>
</div>
