<!-- modal tambah -->

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

<div class="modal fade" id="create-class" tabindex="-1" aria-labelledby="importPegawai" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="importPegawai">Tambah Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <form action="{{ route('school.classroom.store') }}" method="POST" enctype="multipart/form-data">
                @method('post')
                @csrf
                <div class="modal-body">
                    <div class="">
                        <div class="email-repeater">
                            <div data-repeater-list="store-class">
                                <div data-repeater-item>
                                    <div class="row mb-3">
                                        <div class="col-md-6 mb-3">
                                            <label for="" class="mb-2">Nama Kelas <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Kelas" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="" class="mb-2">Tingkatan Kelas <span class="text-danger">*</span></label>
                                            <select class="form-select" name="level_class_id">
                                                <option value="">Pilih Tingkatan Kelas</option>
                                                @forelse ($classLevel as $level)
                                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="" class="mb-2">Wali Kelas <span class="text-danger">*</span></label>
                                            <select class="form-select" name="employee_id">
                                                <option value="">Masukkan Nama Wali Kelas</option>
                                                @forelse ($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <!-- <div class="col-md-6 mb-3">
                                            <label for="" class="mb-2">Tahun Ajaran <span class="text-danger">*</span></label>
                                            <select class="form-select" name="school_year_id">
                                                <option value="">Pilih Tahun Ajaran</option>
                                                @if(isset($schoolYears))
                                                    @foreach ($schoolYears as $schoolYear)
                                                        <option value="{{ $schoolYear->id }}">{{ $schoolYear->school_year }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div> -->
                                        <!-- <div class="col-md-12 text-end">
                                            <button data-repeater-delete class="btn btn-danger btn-sm" type="button">
                                                <i class="ti ti-trash"></i> Hapus
                                            </button>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <button type="button" data-repeater-create="" class="btn btn-primary waves-effect waves-light">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-circle-plus me-1 fs-5"></i>
                                    Tambah Data
                                </div>
                            </button>
                        </div>
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
