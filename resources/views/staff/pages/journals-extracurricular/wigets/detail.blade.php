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

    .form-control-plaintext {
        background-color: #F8F9FA;
        border: 1px solid #DFE5EF;
        border-radius: 8px;
        padding: 10px 15px;
        color: #5A6A85;
        width: 100%;
    }
</style>
<!-- modal detail -->
<div class="modal fade" id="modal-detail" tabindex="-1" aria-labelledby="importPegawai" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="importPegawai">Detail Jurnal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                {{-- Judul --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark fs-4">Judul</label>
                    <div class="form-control-plaintext text-dark">
                        Semangat Pantang Kendor di Lapangan Basket!
                    </div>
                </div>

                {{-- Bukti Foto --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark fs-4">Bukti Foto</label>
                    <div>
                        {{-- Using a placeholder image or an existing asset that might fit --}}
                        <img src="{{ asset('assets/images/example-jurnal-ekstra.png') }}"
                            class="img-fluid rounded-3 object-fit-cover shadow-sm"
                            style="width: 300px; height: 200px; object-fit: cover;" alt="Bukti Foto Kegiatan" />
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark fs-4">Deskripsi</label>
                    <div class="form-control-plaintext text-dark" style="min-height: 120px; text-align: justify;">
                        Kegiatan basket hari ini sukses bikin capek dan ketawa bareng. Latihan berjalan aman dan tertib,
                        meskipun ring masih terkesan pilih-pilih bola saat sesi shooting. Siswa tetap antusias mengikuti
                        setiap
                        latihan dari awal sampai akhir, walaupun beberapa sudah mulai kehabisan napas. Secara
                        keseluruhan,
                        semangat dan kebersamaan siswa patut diapresiasi.
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                {{-- No buttons needed as per image, or keep close if desired --}}
            </div>
        </div>
    </div>
</div>
