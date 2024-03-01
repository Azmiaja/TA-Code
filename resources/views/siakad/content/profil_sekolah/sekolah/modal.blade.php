
<div class="modal fade" id="modalProfilSekolah" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="modalInsert"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title"></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option close-profil-modal" id="btn-close-profil"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form id="formProfilSekolah" method="POST" name="formProfilSekolah" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="POST">
                        <div class="row g-3 p-0">
                            <div class="col-lg-8 col-12 order-lg-0 order-2">
                                <input type="hidden" id="idProfilSekolah" name="idProfilSekolah">
                                <div class="mb-2">
                                    <label class="form-label" for="isiProfilSekolah">Deskripsi</label>
                                    <textarea id="isiProfilSekolah" class="form-control clasic-editor" name="isiProfilSekolah"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12 order-lg-0 order-1">
                                <div class="mb-2">
                                    <label class="form-label" for="gambarProfilSekolah">Gambar</label>
                                    <img src="" class="img-preview img-fluid rounded-2 col-md-12 col-sm-4 mb-3"
                                        style="display: none; border: 2px dashed #dfe3ea;" alt="">
                                    <input type="file" class="form-control" name="gambarProfilSekolah"
                                        accept=".jpg,.jpeg,.png,.svg" id="gambarProfilSekolah" onchange="prevImg()">
                                    {{-- <div id="gambarProfilSekolah" class="dropzone" style="border: 2px dashed #dfe3ea;"></div> --}}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-4 text-end" id="btn-form">
                            {{-- <button type="button" class="btn btn-secondary me-2 close-profil-modal"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button> --}}
                        </div>
                    </form>
                </div>
                <div class="block-content block-content-full bg-body"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalVisiMisi" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="modalInsert"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title-vm"></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option close-profil-modal" id="btn-close-profil"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm" id="body-modal">
                    <form id="formVisiMisi" method="POST" name="formVisiMisi" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="methodVM" value="POST">
                        <div class="row g-3 p-0">
                            <input type="hidden" id="idProfilSekolah" name="idProfilSekolah">
                            <div class="mb-2">
                                <label class="form-label" for="isiVisi">Deskripsi Visi</label>
                                <textarea id="isiVisi" class="form-control clasic-editor visi-misi" name="isiVisi"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="isiMisi">Deskripsi Misi</label>
                                <textarea id="isiMisi" class="form-control clasic-editor visi-misi" name="isiMisi"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-4 text-end" id="btn-form">
                            <button type="button" class="btn btn-danger me-2" id="hapusDataVisiMisi">Hapus</button>
                            <button type="submit" class="btn btn-primary" id="ubahDataVisiMisi">Simpan</button>
                        </div>
                    </form>
                </div>
                <div class="block-content block-content-full bg-body"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSambutan" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="modalInsert"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title-sambutan"></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option close-profil-modal" id="btn-close-profil"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm" id="body-modal">
                    <form id="formSambutan" method="POST" name="formSambutan" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="methodSambutan" value="POST">
                        <div class="row g-3 p-0">
                            <input type="hidden" id="idProfilSekolah" name="idProfilSekolah">
                            <div class="mb-2">
                                <label class="form-label" for="sambutanKepsek">Deskripsi Sambutan</label>
                                <textarea id="sambutanKepsek" class="form-control clasic-editor" name="sambutanKepsek"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-4 text-end" id="btn-form">
                            <button type="button" class="btn btn-danger me-2" id="hapusDataSambutan">Hapus</button>
                            <button type="submit" class="btn btn-primary" id="ubahDataSambutan">Simpan</button>
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
        const gambarProfilSekolah = document.querySelector('#gambarProfilSekolah');
        const imgPrev = document.querySelector('.img-preview');
        const oFReader = new FileReader();


        function prevImg() {

            imgPrev.style.display = 'block';

            oFReader.readAsDataURL(gambarProfilSekolah.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPrev.src = oFREvent.target.result;
            }
        }
    </script>
@endpush
