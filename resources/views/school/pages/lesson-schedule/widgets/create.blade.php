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
</style>

<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="tambahPelajaran" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="tambahPelajaran">Tambah Jadwal Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="mataPelajaran" class="mb-2">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select class="form-select subject select2 select2-create" id="mataPelajaran" name="subject_id" required>
                                <option selected disabled>Masukkan Mata Pelajaran</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pengajar" class="mb-2">Pengajar <span class="text-danger">*</span></label>
                            <select class="form-select teacher select2 select2-teacher" id="pengajar" name="employee_id" required>
                                <option value="" selected disabled>Masukkan Nama Pengajar</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jamStart" class="mb-2">Jam Mulai <span class="text-danger">*</span></label>
                            <select class="form-select select2 select2-start" id="jamStart" name="lesson_hour_start" required>
                                <option value="" selected disabled>Pilih Jam Mulai</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jamEnd" class="mb-2">Jam Berakhir <span class="text-danger">*</span></label>
                            <select class="form-select select2 select2-end" id="jamEnd" name="lesson_hour_end" required>
                                <option value="" selected disabled>Pilih Jam Berakhir</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
