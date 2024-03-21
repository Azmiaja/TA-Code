{{-- Modal --}}
<div class="modal fade" id="modalSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modalInsertLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title-siswa"></h3>
                    <div class="block-options">
                        <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    {{-- FORM --}}
                    <form id="formSiswa" action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="POST">
                        <div class="row m-0 g-2">
                            <input type="text" id="idSiswa" name="idSiswa" hidden>
                            <legend class="col-12 mb-0">Data Siswa</legend>
                            <div class="col-md-6">
                                <label class="form-label" for="nisn">NISN <span
                                    class="text-danger fs-sm">*</span></label>
                                <input type="number" class="form-control" id="nisn" name="nisn"
                                    placeholder="NISN" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="nis">NIS <span
                                    class="text-danger fs-sm">*</span></label>
                                <input type="number" class="form-control" id="nis" name="nis"
                                    placeholder="NIS" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="namaSiswa">Nama Siswa <span
                                    class="text-danger fs-sm">*</span></label>
                                <input type="text" class="form-control" id="namaSiswa" name="namaSiswa"
                                    placeholder="Nama Lengkap Siswa" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="namaPanggilan">Nama Panggilan</label>
                                <input type="text" class="form-control" id="namaPanggilan" name="namaPanggilan"
                                    placeholder="Nama Panggilan">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="tempatLahir">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempatLahir" name="tempatLahir"
                                    placeholder="Tempat Lahir Siswa">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="tanggalLahir">Tanggal Lahir <span
                                    class="text-danger fs-sm">*</span></label>
                                <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir"
                                    placeholder="Tanggal Lahir Siswa" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="jenisKelamin">Jenis Kelamin</label>
                                <select name="jenisKelamin" id="jenisKelamin" class="form-select">
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="agama">Agama</label>
                                <select name="agama" id="agama" class="form-select add-agama">
                                    <option value="" disabled selected>Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label" for="alamat">Alamat</label>
                                <textarea id="alamat" class="form-control" name="alamat" rows="2" placeholder="Masukan Alamat Siswa" style="resize: none"></textarea>
                            </div>
                            <legend class="col-12">Data Orang Tua Siswa</legend>
                            <div class="col-md-6">
                                <label class="form-label" for="namaAyah">Nama Ayah</label>
                                <input type="text" class="form-control" id="namaAyah" name="namaAyah"
                                    placeholder="Nama Ayah">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="namaIbu">Nama Ibu</label>
                                <input type="text" class="form-control" id="namaIbu" name="namaIbu"
                                    placeholder="Nama Ibu">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="pekerjaanAyah">Pekerjaan Ayah</label>
                                <input type="text" class="form-control" id="pekerjaanAyah" name="pekerjaanAyah"
                                    placeholder="Pekerjaan Ayah">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="pekerjaanIbu">Pekerjaan Ibu</label>
                                <input type="text" class="form-control" id="pekerjaanIbu" name="pekerjaanIbu"
                                    placeholder="Pekerjaan Ibu">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="noTlpAyah">Nomor Telepon Ayah</label>
                                <input type="number" class="form-control" id="noTlpAyah" name="noTlpAyah"
                                    placeholder="Nomor Telepon Ayah">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="noTlpIbu">Nomor Telepon Ibu</label>
                                <input type="number" class="form-control" id="noTlpIbu" name="noTlpIbu"
                                    placeholder="Nomor Telepon Ibu">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="alamatAyah">Alamat Ayah</label>
                                <textarea id="alamatAyah" class="form-control" name="alamatAyah" rows="2" placeholder="Masukan Alamat Ayah"  style="resize: none"></textarea>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="alamatIbu">Alamat Ibu</label>
                                <textarea id="alamatIbu" class="form-control" name="alamatIbu" rows="2" placeholder="Masukan Alamat Ibu" style="resize: none"></textarea>
                            </div>
                            <legend class="col-12">Data Wali Siswa</legend>
                            <div class="col-md-6">
                                <label class="form-label" for="namaWali">Nama Wali</label>
                                <input type="text" class="form-control" id="namaWali" name="namaWali"
                                    placeholder="Nama Wali">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="pekerjaanWali">Pekerjaan Wali</label>
                                <input type="text" class="form-control" id="pekerjaanWali" name="pekerjaanWali"
                                    placeholder="Pekerjaan Wali">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="noTlpWali">Nomor Telepon Wali</label>
                                <input type="number" class="form-control" id="noTlpWali" name="noTlpWali"
                                    placeholder="Nomor Telepon Wali">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label" for="alamatWali">Alamat Wali</label>
                                <textarea id="alamatWali" class="form-control" name="alamatWali" rows="2" placeholder="Masukan Alamat Wali" style="resize: none"></textarea>
                            </div>

                            <hr>

                            <div class="mb-4 text-end" id="bt-form-siswa">
                                {{-- Button --}}
                            </div>
                        </div>
                    </form>
                </div>

                <div class="block-content block-content-full bg-body">
                    {{-- Additional content if needed --}}
                </div>
            </div>
        </div>
    </div>
</div>
