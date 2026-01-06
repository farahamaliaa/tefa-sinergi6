<!-- Modal Detail Jurnal -->
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

    .rounded-input {
        border-radius: 10px;
        background: #F6F9FB;
        border: 1px solid rgba(0, 0, 0, 0.06);
    }

    .rounded-input:read-only {
        background: #F6F9FB;
        cursor: default;
    }

    .btn-close-white {
        filter: invert(1) brightness(2);
    }

    .btn-primary {
        background-color: #0896D1 !important;
        border-color: #0896D1 !important;
    }

    .text-primary {
        color: #0896D1 !important;
    }

    .btn-outline-primary {
        color: #0896D1 !important;
        border-color: #0896D1 !important;
        background-color: transparent !important;
    }

    .btn-outline-primary:hover {
        background-color: #0896D1 !important;
        color: #fff !important;
    }

    .btn-primary:hover {
        background-color: #067aa7 !important;
        border-color: #067aa7 !important;
    }
</style>
<div class="modal fade" id="modal-create-journal" tabindex="-1" aria-labelledby="createJournalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="createJournalLabel">Tambah Jurnal</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="{{ route('employee.journal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body mx-3" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="modal-journal-title" class="mb-1 fw-semibold">Judul</label>
                                <input type="text" id="modal-journal-title" name="title"
                                    class="form-control rounded-input" placeholder="Masukkan Judul" required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3 form-group">
                                <label for="modal-journal-description" class="mb-1 fw-semibold">Deskripsi
                                    Kegiatan</label>
                                <textarea id="modal-journal-description" name="description" class="form-control rounded-input" rows="6"
                                    placeholder="Masukkan Deskripsi" required></textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
