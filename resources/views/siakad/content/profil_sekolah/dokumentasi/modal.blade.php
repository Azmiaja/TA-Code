<div class="modal fade" id="modalDokumentasi" tabindex="-1" data-bs-backdrop="static" role="dialog"
    aria-labelledby="modalInsert" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title"></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option close-berita-modal" id="btn-close-berita"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form id="formDokumentasi" method="POST" name="formDokumentasi" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="POST">
                        <div class="row p-0">
                            <div class="col-md-4 col-12 order-md-2 order-0">
                                <input type="hidden" id="idDokumentasi" name="idDokumentasi">
                                <div class="mb-2">
                                    <label class="form-label" for="gambarDokumentasi">Gambar</label>
                                    <img src="" class="img-preview img-fluid rounded-2 col-md-12 col-4 mb-3"
                                        style="display: none; border: 2px dashed #dfe3ea;" alt="">
                                    <input type="file" class="form-control" name="gambarDokumentasi"
                                        accept=".jpg,.jpeg,.png,.svg" id="gambarDokumentasi" onchange="prevImg()">
                                    {{-- <div id="gambarDokumentasi" class="dropzone" style="border: 2px dashed #dfe3ea;"></div> --}}
                                </div>
                                <div class="mb-2">
                                    <label for="linkVideo" class="form-label">Link Video
                                        <a href="javascript:void(0)" class="text-info" style="font-size: 0.8rem;"
                                            onclick="videoInfo();">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa-brands fa-youtube"></i>
                                        </span>
                                        <input type="text" class="form-control" name="link_video" id="linkVideo">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-12 order-md-1 order-0">
                                <div class="mb-2">
                                    <label class="form-label" for="judulDokumentasi">Judul</label>
                                    <textarea class="form-control" id="judulDokumentasi" name="judulDokumentasi" style="resize: none" required rows="3"></textarea>
                                    <span id="judulDokumentasiError" class="text-danger fs-sm"></span>
                                </div>
                                <div class="mb-2">
                                    <div class="row p-0">
                                        <div class="col-lg-6 col-12 mb-lg-0 mb-2">
                                            <label class="form-label" for="kategoriMedia">Kategori</label>
                                            <select class="form-select" name="kategoriMedia" id="kategoriMedia" required
                                                onchange="disabledInput();">
                                                <option value="" selected>-- Pilih --</option>
                                                <option value="Foto">Foto</option>
                                                <option value="Video">Video</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <label class="form-label" for="waktu">Tanggal</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa-regular fa-calendar-days"></i>
                                                </span>
                                                <input type="text" class="form-control" id="waktu" name="waktu"
                                                    required autocomplete="none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-4 text-end" id="btn-form">
                            {{-- <button type="button" class="btn btn-secondary me-2 close-berita-modal"
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


@push('scripts')
    <script>
        const gambarDokumentasi = document.getElementById('gambarDokumentasi');
        const imgPrev = document.querySelector('.img-preview');
        const oFReader = new FileReader();
        const videoLink = document.getElementById('linkVideo');


        function prevImg() {

            imgPrev.style.display = 'block';

            oFReader.readAsDataURL(gambarDokumentasi.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPrev.src = oFREvent.target.result;
            }
        }

        function videoInfo() {
            alert(`Langkah - Langkah Menguoload Link Video Dari Youtube

            1) Masuk ke Chanel Youtube.
            2) Pilih Video Youtube yang ingin di upload.
            3) Cari tombol Bagikan.
            4) Salin URL/Link yang tertera.
            5) Tempel/Paste pada kolom Link Video.`);
        }

        function disabledInput() {
            const selectMedia = document.getElementById('kategoriMedia');

            switch (selectMedia.value) {
                case 'Foto':
                    videoLink.disabled = true;
                    videoLink.value = null;
                    gambarDokumentasi.disabled = false;
                    break;
                case 'Video':
                    gambarDokumentasi.disabled = true;
                    gambarDokumentasi.value = null;
                    imgPrev.src = null;
                    imgPrev.style.display = 'none';
                    videoLink.disabled = false;
                    break;
                default:
                    videoLink.disabled = true;
                    gambarDokumentasi.disabled = true;
                    break;
            }
        }
    </script>
@endpush
