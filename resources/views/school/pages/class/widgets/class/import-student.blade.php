<!-- modal import -->
<style>
    .upload-area-excel {
        border: 2px dashed #8ecae6;
        border-radius: 10px;
        padding: 40px 20px;
        text-align: center;
        background-color: #f0f9ff;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }
    
    .upload-area-excel:hover {
        background-color: #e0f2fe;
        border-color: #219ebc;
    }
    
    .upload-area-excel i {
        font-size: 48px;
        color: #0288d1;
        margin-bottom: 15px;
    }
    
    .upload-area-excel h5 {
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 18px;
    }
    
    .upload-area-excel p {
        font-size: 13px;
        color: #9ca3af;
        margin-bottom: 0;
    }
</style>

<div class="modal fade" id="import-student" tabindex="-1" aria-labelledby="importPegawai" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="importPegawai">Import Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('school.student.import', ['classroom' => $classroom]) }}" method="POST" enctype="multipart/form-data">
                @method('post')
                @csrf
                <div class="modal-body">
                    <div class="card p-3 mb-4" style="background-color: #FFF5E3;">
                        <div>
                            <h5 class="text-warning">Informasi</h5>
                        </div>
                        <div>
                            <ul style="list-style-type: disc;" class="ms-4">
                                <li>Jika siswa tidak terimport maka kemungkinan email siswa tersebut telah digunakan.
                                </li>
                                <li>File yang dapat diunggah berupa file excel berekstensi xls, xlsx.</li>
                                <li>Password siswa secara default adalah NISN.</li>
                                <li>Format pengisian file excel seperti dibawah ini.</li>
                            </ul>
                        </div>
                        <div class="ms-4">
                            <a href="{{ route('school.student.download-template') }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="me-1" width="17" height="17" viewBox="0 0 256 256">
                                    <path fill="white" d="m213.66 82.34l-56-56A8 8 0 0 0 152 24H56a16 16 0 0 0-16 16v176a16 16 0 0 0 16 16h144a16 16 0 0 0 16-16V88a8 8 0 0 0-2.34-5.66M160 51.31L188.69 80H160ZM200 216H56V40h88v48a8 8 0 0 0 8 8h48zm-42.34-82.34L139.31 152l18.35 18.34a8 8 0 0 1-11.32 11.32L128 163.31l-18.34 18.35a8 8 0 0 1-11.32-11.32L116.69 152l-18.35-18.34a8 8 0 0 1 11.32-11.32L128 140.69l18.34-18.35a8 8 0 0 1 11.32 11.32" />
                                </svg>
                                Download Format Excel
                            </a>
                        </div>
                    </div>
                    <div>
                        <label for="file-excel" class="form-label fw-bold">File Excel</label>
                        <div class="upload-area-excel" onclick="document.getElementById('file-excel').click()">
                            <div id="excel-upload-placeholder">
                                <i class="ti ti-cloud-upload"></i>
                                <h5>Seret dan lepas file kamu di sini</h5>
                                <p>File yang dapat diunggah berupa file excel berekstensi xls, xlsx</p>
                            </div>
                            <div id="excel-file-info" style="display: none;">
                                <i class="ti ti-file-spreadsheet text-success"></i>
                                <h5 id="excel-filename" class="text-truncate" style="max-width: 100%;">filename.xlsx</h5>
                                <p class="text-success">File siap diunggah</p>
                            </div>
                            <input type="file" class="d-none" name="file" id="file-excel" accept=".xls,.xlsx" onchange="handleExcelUpload(event)">
                        </div>
                        @error('file')
                        <span class="text-danger mt-2 d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn mb-1 waves-effect waves-light btn-light" data-bs-dismiss="modal">Tutup</button> -->
                    <button type="submit" class="btn btn-rounded btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleExcelUpload(event) {
        const file = event.target.files[0];
        const placeholder = document.getElementById('excel-upload-placeholder');
        const fileInfo = document.getElementById('excel-file-info');
        const filename = document.getElementById('excel-filename');
        
        if (file) {
            placeholder.style.display = 'none';
            fileInfo.style.display = 'block';
            filename.textContent = file.name;
        } else {
            placeholder.style.display = 'block';
            fileInfo.style.display = 'none';
            filename.textContent = '';
        }
    }
</script>
