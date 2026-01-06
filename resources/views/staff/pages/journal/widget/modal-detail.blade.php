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
</style>
<div class="modal fade" id="modal-detail-journal" tabindex="-1" aria-labelledby="detailJournalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="importPegawai">Detail Jurnal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <section>
                <div class="modal-body mx-3" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="modal-journal-title" class="mb-1 fw-semibold">Judul</label>
                                <input type="text" id="modal-journal-title" class="form-control rounded-input"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3 form-group">
                                <label for="modal-journal-description" class="mb-1 fw-semibold">Deskripsi
                                    Kegiatan</label>
                                <textarea id="modal-journal-description" class="form-control rounded-input" rows="6" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    function showJournalDetailModal(id, title, description, date) {
        // Set modal content
        document.getElementById('modal-journal-title').value = title || '-';
        document.getElementById('modal-journal-description').value = description || '-';

        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('modal-detail-journal'));
        modal.show();
    }
</script>
