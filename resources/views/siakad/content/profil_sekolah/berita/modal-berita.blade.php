
<div class="modal fade" id="modalBerita" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="modalInsert"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title">Tambah Berita</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option close-berita-modal" id="btn-close-berita"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form id="formBerita" method="POST" name="formBerita" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="POST">
                        <div class="row g-3 p-0">
                            <div class="col-lg-8 col-12 ">
                                <input type="hidden" id="idBerita" name="idBerita">
                                <div class="mb-2">
                                    <label class="form-label" for="judulBerita">Judul</label>
                                    <input type="text" class="form-control" id="judulBerita" name="judulBerita"
                                        required>
                                    <span id="judulBeritaError" class="text-danger fs-sm"></span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="isiBerita">Deskripsi</label>
                                    <textarea id="isiBerita" class="form-control clasic-editor" name="isiBerita"></textarea>
                                </div>

                            </div>
                            <div class="col-lg-4 col-12 ">
                                <div class="mb-2">
                                    <label class="form-label" for="gambarBerita">Gambar</label>
                                    <img src="" class="img-preview img-fluid rounded-2 col-md-12 col-sm-4 mb-3"
                                        style="display: none; border: 2px dashed #dfe3ea;" alt="">
                                    <input type="file" class="form-control" name="gambarBerita"
                                        accept=".jpg,.jpeg,.png,.svg" id="gambarBerita" onchange="prevImg()">
                                    {{-- <div id="gambarBerita" class="dropzone" style="border: 2px dashed #dfe3ea;"></div> --}}
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="waktu">Tanggal</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fa-regular fa-calendar-days"></i>
                                        </span>
                                    <input type="text" class="form-control" id="waktu" name="waktu" required>
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
        const gambarBerita = document.querySelector('#gambarBerita');
        const imgPrev = document.querySelector('.img-preview');
        const oFReader = new FileReader();


        function prevImg() {

            imgPrev.style.display = 'block';

            oFReader.readAsDataURL(gambarBerita.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPrev.src = oFREvent.target.result;
            }
        }
    </script>
@endpush
