<!-- modal detail -->
<div class="modal fade" id="teacher-detail" tabindex="-1" aria-labelledby="importPegawai" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-lg">
            <div class="modal-header p-0" style="border:none;">
                <div style="background-color: #1AA6D8; width:100%; padding: 14px 20px; border-top-left-radius: .5rem; border-top-right-radius: .5rem; display:flex; align-items:center; justify-content:space-between;">
                    <h5 class="modal-title text-white mb-0" id="importPegawai">Detail Guru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body pt-4 pb-4">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <img id="image-detail-teacher" class="rounded-circle user-profile mb-3" src="{{ asset('assets/images/default-user.jpeg') }}" style="object-fit: cover; width: 150px; height: 150px;" alt="User Profile Picture" onerror="this.onerror=null;this.src='{{ asset('assets/images/default-user.jpeg') }}';" />
                    </div>
                </div>
                <div class="row mt-3 px-4">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label mb-1">Nama</label>
                        <p id="name-detail-teacher" class="detail-field mb-0 text-start"></p>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label mb-1">Email</label>
                        <p id="email-detail-teacher" class="detail-field mb-0 text-start"></p>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label mb-1">Nomor Telepon</label>
                        <p id="phone-detail-teacher" class="detail-field mb-0 text-start"></p>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label mb-1">Jenis Kelamin</label>
                        <p id="gender-detail-teacher" class="detail-field mb-0 text-start"></p>
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label mb-1">NIP</label>
                        <p id="nip-detail-teacher" class="detail-field mb-0 text-start"></p>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label mb-1">RFID</label>
                        <p id="rfid-detail-teacher" class="detail-field mb-0 text-start"></p>
                    </div>

                    <div class="col-12 mb-0">
                        <label class="form-label mb-1">Alamat</label>
                        <p id="address-detail-teacher" class="detail-field mb-0 text-start text-muted text-break" style="min-height:56px;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #teacher-detail .detail-field {
            background: #F6F9FB;
            border-radius: 8px;
            padding: 12px 14px;
            border: 1px solid rgba(0,0,0,0.04);
            min-height: 44px;
            display: flex;
            align-items: center;
            color: #344054;
            margin-bottom: 0;
        }
        #teacher-detail .modal-content { border-radius: 12px; overflow: hidden; }
        .btn-close-white { filter: invert(1) brightness(2); }
    </style>
</div>
