    <style>
        #student-detail .modal-header {
            background-color: #0896D1 !important;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }

        #student-detail .modal-content {
            border-radius: 10px !important;
            overflow: hidden;
            border: none;
        }

        #student-detail .btn-close {
            filter: invert(1) brightness(200%);
        }

        .detail-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #5a6a85;
        }

        .detail-field {
            background-color: #f0f4f8;
            border: 1px solid #e0e6ed;
            border-radius: 8px;
            padding: 10px 15px;
            text-align: left;
            width: 100%;
            min-height: 45px;
            display: flex;
            align-items: center;
        }
    </style>

    <!-- modal detail -->
    <div class="modal fade" id="student-detail" tabindex="-1" aria-labelledby="importPegawai" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="importPegawai">Detail Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="row justify-content-center mb-3">
                        <div class="col-auto">
                            <img id="image-detail" src="{{ asset('admin_assets/dist/images/profile/user-1.jpg') }}"
                                class="rounded-circle user-profile"
                                style="object-fit: cover; width: 150px; height: 150px; border: 4px solid #e0e6ed;"
                                alt="User Profile Picture" />
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3 text-start">
                            <label class="detail-label">Nama</label>
                            <div class="detail-field" id="name-detail"></div>
                        </div>
                        <div class="col-md-6 mb-3 text-start">
                            <label class="detail-label">Email</label>
                            <div class="detail-field" id="email-detail"></div>
                        </div>
                        <div class="col-md-6 mb-3 text-start">
                            <label class="detail-label">Jenis Kelamin</label>
                            <div class="detail-field" id="gender-detail"></div>
                        </div>
                        <div class="col-md-6 mb-3 text-start">
                            <label class="detail-label">NIK</label>
                            <div class="detail-field" id="nik-detail"></div>
                        </div>
                        <div class="col-md-6 mb-3 text-start">
                            <label class="detail-label">RFID</label>
                            <div class="detail-field" id="rfid-detail"></div>
                        </div>
                        <div class="col-md-6 mb-3 text-start">
                            <label class="detail-label">Alamat</label>
                            <div class="detail-field" id="address-detail"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
