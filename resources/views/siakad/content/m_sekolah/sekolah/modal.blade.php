<!-- Modal -->
<div class="modal fade" id="modalSekolah" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modal-tambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <!-- Modal Title -->
                    <h3 class="block-title" id="modal-title"></h3>
                    <div class="block-options">
                        <!-- Close Button -->
                        <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <!-- Form -->
                    <form id="formSekolah" method="POST" name="formSekolah" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="PUT">
                        <input type="hidden" name="idSekolah" id="idSekolah">
                        <div class="row g-2">
                            <div class="col-lg-8 col-12">
                                <div class="row g-2 p-0 mb-2">
                                    <div class="col-lg-6">
                                        <label for="fm_namaSekolah" class="form-label">Nama Sekolah</label>
                                        <input type="text" name="namaSekolah" class="form-control"
                                            id="fm_namaSekolah">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_npsn" class="form-label">NPSN</label>
                                        <input type="text" name="npsn" class="form-control" id="fm_npsn">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_alamat" class="form-label">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" id="fm_alamat">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_desa" class="form-label">Desa</label>
                                        <input type="text" name="desa" class="form-control" id="fm_desa">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_kecamatan" class="form-label">Kecamatan</label>
                                        <input type="text" name="kecamatan" class="form-control" id="fm_kecamatan">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_kabupaten" class="form-label">Kabupate/Kota</label>
                                        <input type="text" name="kabupaten" class="form-control" id="fm_kabupaten">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_provinsi" class="form-label">Provinsi</label>
                                        <input type="text" name="provinsi" class="form-control" id="fm_provinsi">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_kodePos" class="form-label">Kode Pos</label>
                                        <input type="number" name="kodePos" class="form-control" id="fm_kodePos">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_telp" class="form-label">Telepon</label>
                                        <input type="tel" name="telp" class="form-control" id="fm_telp">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_website" class="form-label">Website</label>
                                        <input type="url" name="website" class="form-control" id="fm_website">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="fm_email">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="fm_slogan" class="form-label">Slogan</label>
                                        <input type="text" name="slogan" class="form-control" id="fm_slogan">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="mb-2">
                                    <label for="fm_mapsLink" class="form-label">Maps Link
                                        <a href="javascript:void(0)" class="text-info" style="font-size: 0.8rem;"
                                            onclick="mapsLinkInfo();">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                    </label>
                                    <input type="url" name="mapsLink" class="form-control"
                                        placeholder="https://maps.app.goo.gl/..." id="fm_mapsLink">
                                </div>
                                <div class="mb-2">
                                    <label for="fm_mapsEmbed" class="form-label">Maps Embed
                                        <a href="javascript:void(0)" class="text-info" style="font-size: 0.8rem;"
                                            onclick="mapsEmbedInfo();">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                    </label>
                                    <textarea name="mapsEmbed" class="form-control" id="fm_mapsEmbed" placeholder="<iframe>...</iframe>"
                                        rows="4"></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="logoSekolah">Logo Sekolah</label>
                                    <img src="" class="img-preview img-fluid mb-2 rounded-2 col-12"
                                        style="display: none; border: 2px dashed #dfe3ea;" alt="">
                                    <input type="file" class="form-control d-none" name="logo"
                                        accept=".jpg,.jpeg,.png,.svg" id="logoSekolah" onchange="prevImg()">
                                    <div class="text-end">
                                        <button type="button" id="fileButton" class="btn btn-success"><i class="fa-solid fa-file-image me-2"></i>Pilih
                                            File</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="mb-4 text-end" id="btn-form">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
                <div class="block-content block-content-full bg-body">
                    <!-- Additional Content (if any) -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const logoSekolah = document.querySelector('#logoSekolah');
        const imgPrev = document.querySelector('.img-preview');
        const oFReader = new FileReader();

        function mapsLinkInfo() {
            Swal.fire({
                title: "Cara mendapatkan maps link",
                html: `
                        1) Masuk ke Google Maps.<br>
                        2) Tentukan lokasi sekolah.<br>
                        3) Pilih menu <b>Bagikan</b> di paling kanan.<br>
                        4) Salin URL/Link yang tertera.<br>
                        5) Tempel/Paste pada kolom Maps Link.`,
                icon: "info"
            });
        }

        function mapsEmbedInfo() {
            Swal.fire({
                title: "Cara mendapatkan maps embed iframe",
                html: `
                        1) Masuk ke Google Maps.<br>
                        2) Tentukan lokasi sekolah.<br>
                        3) Pilih menu <b>Bagikan</b> di paling kanan.<br>
                        4) Pilih <b>Smatkan Peta</b>.<br>
                        5) Sesuaikan ukuran menjadi <b>Kecil</b>.<br>
                        6) Salin URL/Link <b>iframe</b> yang tertera.<br>
                        7) Tempel/Paste pada kolom Maps Embed.`,
                icon: "info"
            });
        }


        function prevImg() {

            imgPrev.style.display = 'block';

            oFReader.readAsDataURL(logoSekolah.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPrev.src = oFREvent.target.result;
            }
        }
    </script>
@endpush
