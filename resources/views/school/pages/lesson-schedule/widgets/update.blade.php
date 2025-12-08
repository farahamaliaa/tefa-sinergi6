<div class="modal fade" id="modal-update" tabindex="-1" aria-labelledby="tambahPelajaran" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="tambahPelajaran">Edit Mata Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="mataPelajaran" class="mb-2">Mata Pelajaran <span class="text-danger">*</span></label>
                            <select class="form-select subject-update select2 select2-update" id="subject" name="subject_id" required>
                                <option selected disabled>Masukkan Mata Pelajaran</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pengajar" class="mb-2">Pengajar <span class="text-danger">*</span></label>
                            <select class="form-select teacher select2 select2-teacher-update" id="employee_id" name="employee_id" required>
                                <option value="" selected disabled>Masukkan Nama Pengajar</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jamKe" class="mb-2">Jam Mulai <span class="text-danger">*</span></label>
                            <select class="form-select select2 select2-start-update lesson_hour_start" id="lesson_hour_start" name="lesson_hour_start" required>
                                <option value="" selected disabled>Pilih Jam Mulai</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jamKe" class="mb-2">Jam Berakhir <span class="text-danger">*</span></label>
                            <select class="form-select select2 select2-end-update lesson_hour_end" id="lesson_hour_end" name="lesson_hour_end" required>
                                <option value="" selected disabled>Pilih Jam Berakhir</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rounded btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
