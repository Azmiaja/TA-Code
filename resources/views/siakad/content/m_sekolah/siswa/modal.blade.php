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
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="nisn">NISN</label>
                                <input type="text" class="form-control" id="nisn" name="nisn"
                                    placeholder="NISN">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="nis">NIS</label>
                                <input type="text" class="form-control" id="nis" name="nis"
                                    placeholder="NIS">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="namaSiswa">Nama Siswa</label>
                                <input type="text" class="form-control" id="namaSiswa" name="namaSiswa"
                                    placeholder="Nama Lengkap Siswa">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="namaPanggilan">Nama Panggilan</label>
                                <input type="text" class="form-control" id="namaPanggilan" name="namaPanggilan"
                                    placeholder="Nama Panggilan">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="tempatLahir">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempatLahir" name="tempatLahir"
                                    placeholder="Tempat Lahir Siswa">
                            </div>
                            <div class="col-md-6 col-12">
                                <label class="form-label" for="tanggalLahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir"
                                    placeholder="Tanggal Lahir Siswa">
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <label class="form-label" for="jenisKelamin">Jenis Kelamin</label>
                                <select name="jenisKelamin" id="jenisKelamin" class="form-select">
                                    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <label class="form-label" for="agama">Agama</label>
                                <select name="agama" id="agama" class="form-select add-agama">
                                    <option value="" disabled selected>-- Pilih Agama --</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-6 col-12">
                                <label class="form-label" for="status">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="" disabled selected>-- Pilih Status --</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-lg-12 col-md-6 col-12 mb-3">
                                <label class="form-label" for="alamat">Alamat</label>
                                <textarea id="alamat" class="form-control" name="alamat" rows="3" placeholder="Masukan Alamat Siswa"></textarea>
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
