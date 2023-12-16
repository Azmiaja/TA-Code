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
                            <input class="form-control gambar-berita" type="file" name="gambar" id="gambarBerita"
                                accept="image/jpeg, image/jpg, image/png, image/svg+xml" onchange="handleImageChange()">
                            <div class="gambarBeritaWarning" style="color: red; display: none;">
                                Ukuran gambar tidak boleh lebih dari 2 MB.
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
                            <small class="text-danger">*Ukuran gambar tidak boleh lebih dari 2 MB.</small>
                            <input class="form-control gambar-berita" type="file" name="gambar" id="gambarBerita_update"
                                accept="image/jpeg, image/jpg, image/png, image/svg+xml">

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

@push('scripts')
    <script>
        function toggleWarning(visible) {
            const warningElement = document.querySelector('.gambarBeritaWarning');
            warningElement.style.display = visible ? 'block' : 'none';
        }

        // Fungsi untuk menangani perubahan pada input gambar
        function handleImageChange() {
            const inputElement = document.querySelector('.gambar-berita');
            const warningElement = document.querySelector('.gambarBeritaWarning');

            // Periksa ukuran gambar saat dipilih
            if (inputElement.files.length > 0) {
                const fileSize = inputElement.files[0].size;
                const maxSize = 2 * 1024 * 1024; // 2 MB

                if (fileSize > maxSize) {
                    // Tampilkan peringatan jika ukuran gambar melebihi 2 MB
                    toggleWarning(true);
                } else {
                    // Sembunyikan peringatan jika ukuran gambar sesuai atau di bawah 2 MB
                    toggleWarning(false);
                }
            }
        }
    </script>
@endpush
