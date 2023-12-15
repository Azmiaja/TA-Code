{{-- ========================= MODAL INSERT ================== --}}
<div class="modal fade" id="modalBerita" tabindex="-1" role="dialog" aria-labelledby="modalInsert" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title">Tambah Berita</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" id="btn-close-berita" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form id="formBerita" enctype="multipart/form-data">
                        <input type="hidden" id="idBerita">
                        <div class="mb-4">
                            <label class="form-label" for="judulBerita">Judul Berita</label>
                            <input type="text" class="form-control" id="judulBerita" name="judulBerita" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="gambarBerita">Gambar Berita</label>
                            <div class="row m-0 mb-2">
                                <div class="col-md-4 p-2 text-center form-control">
                                    <img id="preview-img" alt="preview_img" style="max-height: 200px;">
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="file" name="gambar" id="gambarBerita"
                                    accept="image/*">
                                <button class="btn btn-primary">Submit Gambar</button>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="isiBerita">Isi Berita</label>
                            <textarea id="isiBerita" class="form-control clasic-editor" name="isiBerita"></textarea>
                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div class="col-lg-4 col-sm-12 col-12 px-0 mb-sm-0 mb-4">
                                    <label class="form-label" for="waktuBerita">Tanggal Berita</label>
                                    <input type="datetime-local" class="form-control" id="waktuBerita"
                                        name="waktuBerita">
                                </div>
                                <div class="col-lg-8 col-sm-12 col-12 px-0 ps-lg-3 ps-0">
                                    <label class="form-label" for="sumberBerita">Sumber Berita</label>
                                    <input type="text" class="form-control" id="sumberBerita" name="sumberBerita">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 text-end" id="btn-form">
                            {{-- Button --}}
                        </div>
                    </form>
                </div>
                <div class="block-content block-content-full bg-body"></div>
            </div>
        </div>
    </div>
</div>

{{-- ========================= MODAL UPDATE ================== --}}
<div class="modal fade" id="modalBerita_update" tabindex="-1" role="dialog" aria-labelledby="modalInsert"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title">Edit Berita</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" id="btn-close-berita" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form id="form_update_berita" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('put')
                        <input type="hidden" id="idBerita_update">
                        <div class="mb-4">
                            <label class="form-label" for="judulBerita">Judul Berita</label>
                            <input type="text" class="form-control" id="judulBerita_update" name="judulBerita"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="gambarBerita">Gambar Berita</label>
                            <div class="row m-0 mb-2">
                                <div class="col-md-4 p-2 text-center form-control">
                                    <img id="preview-img_update" alt="preview_img" style="max-height: 200px;">
                                </div>
                            </div>
                            {{-- <div class="form-group"> --}}
                            <input class="form-control" type="file" name="gambar" id="gambarBerita_update"
                                accept="image/*">
                            {{-- <button class="btn btn-primary">Submit Gambar</button> --}}
                            {{-- </div> --}}
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="isiBerita">Isi Berita</label>
                            <textarea id="isiBerita_update" class="form-control clasic-editor" name="isiBerita"></textarea>
                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div class="col-lg-4 col-sm-12 col-12 px-0 mb-sm-0 mb-4">
                                    <label class="form-label" for="waktuBerita">Tanggal Berita</label>
                                    <input type="datetime-local" class="form-control" id="waktuBerita_update"
                                        name="waktuBerita">
                                </div>
                                <div class="col-lg-8 col-sm-12 col-12 px-0 ps-lg-3 ps-0">
                                    <label class="form-label" for="sumberBerita">Sumber Berita</label>
                                    <input type="text" class="form-control" id="sumberBerita_update"
                                        name="sumberBerita">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 text-end" id="btn-form_update">
                            {{-- Button --}}
                        </div>
                    </form>
                </div>
                <div class="block-content block-content-full bg-body"></div>
            </div>
        </div>
    </div>
</div>
