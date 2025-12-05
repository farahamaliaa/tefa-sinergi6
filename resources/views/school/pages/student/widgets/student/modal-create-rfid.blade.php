<div class="modal fade" id="modal-create-rfid" tabindex="-1" aria-labelledby="createRFID" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" style="color:white">Tambah RFID</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form-rfid" method="POST">
                @method('put')
                @csrf
                <input type="hidden" name="old_rfid" id="old_rfid_input">

                <div class="modal-body">

                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-0">Nama:</h6>
                        <p class="ms-3 mb-0" id="name"></p>
                    </div>

                    <div class="mb-3">
                        <h6 class="mb-1">RFID: <span id="rfid"></span></h6>
                        <p class="text-muted mb-3">Lakukan tap pada rfid reader untuk menginputkan rfid</p>
                        <input type="text" id="rfid-input" name="rfid" class="form-control" placeholder="Masukkan RFID">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>

        </div>
    </div>
</div>


<style>
    #modal-create-rfid .modal-header {
        background: #00a7df;
        color: white;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        padding: 20px 24px;
    }

    #modal-create-rfid .modal-content {
        border-radius: 20px;
        border: none;
        overflow: hidden;
    }

    #modal-create-rfid .modal-title {
        font-size: 1.3rem;
        font-weight: 600;
    }

    #modal-create-rfid .modal-body {
        padding: 28px;
    }

    #modal-create-rfid h6 {
        font-size: 1.1rem;
        font-weight: 600;
    }

    #modal-create-rfid p, #modal-create-rfid span {
        font-size: 1rem;
    }

    #modal-create-rfid input.form-control {
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid #dcdcdc;
    }

    #modal-create-rfid .modal-footer {
        padding: 20px 30px;
        border-top: none;
    }

    #modal-create-rfid .btn-primary {
        background: #00a7df;
        border-radius: 10px;
        padding: 8px 28px;
        border: none;
        font-weight: 500;
    }

    #modal-create-rfid .btn-light {
        border-radius: 10px;
        padding: 8px 20px;
    }

</style>