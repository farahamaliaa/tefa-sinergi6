<!-- modal import -->
<div class="modal fade" id="importInstructorModal" tabindex="-1" aria-labelledby="importInstructorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 rounded-4 overflow-hidden">

            <div class="modal-header border-0 py-3" style="background:#0896D1;">
                <h5 class="modal-title text-white" id="importInstructorModalLabel">Import Pembina Ekstrakurikuler</h5>
                <button type="button" class="btn-close btn-close-white" style="bs-btn-close-color: white !important;"
                    data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('school.extra-instructor.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body p-4">

                    <div class="info-card-instructor p-4 rounded-3 mb-4">
                        <h5 class="text-warning mb-2">Informasi</h5>

                        <ul class="ms-3 mb-3">
                            <li>Jika pembina tidak terimport maka kemungkinan email pembina tersebut telah digunakan.
                            </li>
                            <li>Password pembina secara default adalah "password".</li>
                            <li>Format pengisian file excel seperti dibawah ini.</li>
                            <li>Kolom: Nama Pembina, Email, Password, Jenis Kelamin, Nomor HP, Alamat, Ekstrakurikuler
                            </li>
                        </ul>

                        <a href="{{ route('school.extra-instructor.download-template') }}"
                            class="btn btn-primary rounded px-3 d-inline-flex align-items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 256 256">
                                <path fill="white"
                                    d="m213.66 82.34l-56-56A8 8 0 0 0 152 24H56a16 16 0 0 0-16 16v176a16 16 0 0 0 16 16h144a16 16 0 0 0 16-16V88a8 8 0 0 0-2.34-5.66M160 51.31L188.69 80H160ZM200 216H56V40h88v48a8 8 0 0 0 8 8h48zm-42.34-82.34L139.31 152l18.35 18.34a8 8 0 0 1-11.32 11.32L128 163.31l-18.34 18.35a8 8 0 0 1-11.32-11.32L116.69 152l-18.35-18.34a8 8 0 0 1 11.32-11.32L128 140.69l18.34-18.35a8 8 0 0 1 11.32 11.32" />
                            </svg>
                            Download Format Excel
                        </a>
                    </div>

                    <label class="form-label fw-semibold">File Excel</label>

                    <div class="dropzone-import-instructor mb-3 text-center">
                        <svg width="35" height="35" fill="#1AA6D8" viewBox="0 0 24 24">
                            <path
                                d="M12 16a1 1 0 0 1-1-1V9.41l-1.29 1.3a1 1 0 1 1-1.42-1.42l3-3a1 1 0 0 1 1.42 0l3 3a1 1 0 0 1-1.42 1.42L13 9.4V15a1 1 0 0 1-1 1zm7-1a1 1 0 0 0-1 1v3H6v-3a1 1 0 0 0-2 0v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3a1 1 0 0 0-1-1z" />
                        </svg>

                        <p class="mt-2 mb-1 fw-semibold dropzone-text-instructor">Seret dan lepas file kamu di sini</p>
                        <small class="text-muted">
                            File yang dapat diunggah berupa file excel berekstensi <b>xls, xlsx</b>
                        </small>

                        <input type="file" name="file" class="file-input-instructor" required />
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary rounded px-4">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .info-card-instructor {
        background: #FFF5E3;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
    }

    .dropzone-import-instructor {
        border: 2px dashed #1AA6D8;
        background: #F3FAFF;
        padding: 35px;
        border-radius: 12px;
        position: relative;
    }

    .dropzone-import-instructor:hover {
        background: #E9F6FF;
    }

    .dropzone-import-instructor .file-input-instructor {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('importInstructorModal');
        // Ensure modal exists
        if (modal) {
            const fileInput = modal.querySelector('.file-input-instructor');
            const dropzoneText = modal.querySelector('.dropzone-text-instructor');

            if (fileInput && dropzoneText) {
                fileInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        dropzoneText.textContent = e.target.files[0].name;
                        dropzoneText.style.color = '#0896D1';
                    } else {
                        dropzoneText.textContent = 'Seret dan lepas file kamu di sini';
                        dropzoneText.style.color = '';
                    }
                });
            }
        }
    });
</script>
