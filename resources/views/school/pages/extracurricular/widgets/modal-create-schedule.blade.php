<div class="modal fade" id="modal-create-schedule" tabindex="-1" aria-labelledby="modal-create-schedule"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="modal-create-schedule">Tambah Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('school.extracurricular-schedule.store', $extracurricular->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="extracurricular_id" value="{{ $extracurricular->id }}">
                    <div class="mb-3">
                        <label class="form-label">Hari <span class="text-danger">*</span></label>
                        <select name="day" class="form-select" required>
                            <option value="" disabled selected>Masukkan Hari</option>
                            @foreach(App\Enums\DayEnum::cases() as $day)
                                <option value="{{ $day->value }}">{{ ucfirst($day->label()) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="start_time" class="form-control" required placeholder="--:--">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jam Berakhir <span class="text-danger">*</span></label>
                            <input type="time" name="end_time" class="form-control" required placeholder="--:--">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>