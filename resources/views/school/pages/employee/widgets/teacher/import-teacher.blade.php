<!-- modal import -->
<div class="modal fade" id="import-teacher" tabindex="-1" aria-labelledby="importPegawai" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 rounded-4 overflow-hidden">

            <div class="modal-header border-0 py-3" style="background:#1AA6D8;">
                <h5 class="modal-title text-white">Import Guru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('school.teacher.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body p-4">

                    <div class="info-card p-4 rounded-3 mb-4">
                        <h5 class="text-warning mb-2">Informasi</h5>

                        <ul class="ms-3 mb-3">
                            <li>Jika guru tidak terimport maka kemungkinan email guru tersebut telah digunakan.</li>
                            <li>Password Guru secara default adalah NIK.</li>
                            <li>Format pengisian file excel seperti dibawah ini.</li>
                        </ul>

                        <a href="{{ route('school.teacher.download-template') }}" class="btn btn-primary rounded px-3 d-inline-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 256 256">
                                <path fill="white" d="m213.66 82.34l-56-56A8 8 0 0 0 152 24H56a16 16 0 0 0-16 16v176a16 16 0 0 0 16 16h144a16 16 0 0 0 16-16V88a8 8 0 0 0-2.34-5.66M160 51.31L188.69 80H160ZM200 216H56V40h88v48a8 8 0 0 0 8 8h48zm-42.34-82.34L139.31 152l18.35 18.34a8 8 0 0 1-11.32 11.32L128 163.31l-18.34 18.35a8 8 0 0 1-11.32-11.32L116.69 152l-18.35-18.34a8 8 0 0 1 11.32-11.32L128 140.69l18.34-18.35a8 8 0 0 1 11.32 11.32" />
                            </svg>
                            Download Format Excel
                        </a>
                    </div>

                    <label class="form-label fw-semibold">File Excel</label>

                    <div class="dropzone-import mb-3 text-center">
                        <svg width="35" height="35" fill="#1AA6D8" viewBox="0 0 24 24">
                            <path d="M12 16a1 1 0 0 1-1-1V9.41l-1.29 1.3a1 1 0 1 1-1.42-1.42l3-3a1 1 0 0 1 1.42 0l3 3a1 1 0 0 1-1.42 1.42L13 9.4V15a1 1 0 0 1-1 1zm7-1a1 1 0 0 0-1 1v3H6v-3a1 1 0 0 0-2 0v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3a1 1 0 0 0-1-1z" />
                        </svg>

                        <p class="mt-2 mb-1 fw-semibold">Seret dan lepas file kamu di sini</p>
                        <small class="text-muted">
                            File yang dapat diunggah berupa file excel berekstensi <b>xls, xlsx</b>
                        </small>

                        <input type="file" name="file" class="file-input" />
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary rounded px-4">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .info-card {
        background: #FFF5E3;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
    }

    .dropzone-import {
        border: 2px dashed #1AA6D8;
        background: #F3FAFF;
        padding: 35px;
        border-radius: 12px;
        position: relative;
    }

    .dropzone-import:hover {
        background: #E9F6FF;
    }

    .dropzone-import .file-input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .btn-close-white {
        filter: brightness(200%);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('import-teacher');
        const fileInput = modal.querySelector('.file-input');
        const dropzoneText = modal.querySelector('.dropzone-import p');

        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                dropzoneText.textContent = e.target.files[0].name;
                dropzoneText.style.color = '#0896D1';
            } else {
                dropzoneText.textContent = 'Seret dan lepas file kamu di sini';
                dropzoneText.style.color = '';
            }
        });
    });
</script>
