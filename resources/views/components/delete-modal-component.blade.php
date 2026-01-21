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

<div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="tambahdataLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form id="form-delete" class="modal-content" method="post">
            @csrf
            @method('DELETE')
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title text-white" id="myModalLabel">
                    Hapus data
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah anda yakin akan menghapus data ini? </p>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-light-danger text-danger font-medium" data-bs-dismiss="modal">
                    Batal
                </button> -->
                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>
