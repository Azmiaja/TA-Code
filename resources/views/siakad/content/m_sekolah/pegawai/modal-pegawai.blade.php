<!-- Modal -->
<div class="modal fade" id="modalPegawai" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
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
                    <form id="formPegawai" method="POST" name="formPegawai" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="POST">
                        <div class="row g-3 m-0">
                            <div class="col-lg-7 col-12">
                                <!-- ID -->
                                <input type="text" hidden name="idPegawai" id="idPegawai">
                                <!-- NIP -->
                                <div class="mb-2">
                                    <label class="form-label" for="nip">NIP <span
                                            class="text-danger fs-sm">*</span></label>
                                    <input type="number" class="form-control" id="nip" name="nip"
                                        placeholder="Masukan NIP" required>
                                </div>
                                <!-- Nama Pegawai -->
                                <div class="mb-2">
                                    <label class="form-label" for="namaPegawai">Nama Pegawai <span
                                            class="text-danger fs-sm">*</span></label>
                                    <input type="text" class="form-control" id="namaPegawai" name="namaPegawai"
                                        placeholder="Masukan Nama" required>
                                </div>
                                <!-- Jenis Kelamin -->
                                <div class="mb-2">
                                    <label class="form-label" for="jenisKelamin">Jenis Kelamin <span
                                            class="text-danger fs-sm">*</span></label>
                                    <select name="jenisKelamin" id="jenisKelamin" class="form-select" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                {{-- Tempat Lahir --}}
                                <div class="mb-2">
                                    <label class="form-label" for="tempatLahir">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempatLahir" name="tempatLahir"
                                        placeholder="Masukan Tampat Lahir">
                                </div>
                                <!-- Tanggal Lahir -->
                                <div class="mb-2">
                                    <label class="form-label" for="tanggalLahir">Tanggal Lahir <span
                                        class="text-danger fs-sm">*</span></label>
                                    <input type="text" class="form-control" id="tanggalLahir" name="tanggalLahir" required placeholder="Masukan Tanggal Lahir">
                                </div>
                                <!-- Alamat -->
                                <div class="mb-2">
                                    <label class="form-label" for="alamat">Alamat</label>
                                    <textarea id="alamat" class="form-control" rows="3" style="resize: none" name="alamat" placeholder="Masukan Alamat"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-5 col-12">
                                <!-- Jenis Pegawai -->
                                <div class="mb-2">
                                    <label class="form-label" for="jenisPegawai">Jenis Pegawai <span
                                            class="text-danger fs-sm">*</span></label>
                                    <select name="jenisPegawai" id="jenisPegawai" class="form-select" required>
                                        <option value="" selected disabled>Pilih Jenis Pegawai</option>
                                        <option value="Guru">Guru</option>
                                        <option value="Tendik">Tenaga Kependidikan</option>
                                    </select>
                                </div>
                                <!-- Jabatan -->
                                <div class="mb-2">
                                    <label class="form-label" for="jabatan">Jabatan <span
                                            class="text-danger fs-sm"></span></label>
                                    <select name="idJabatan" id="idJabatan" class="form-select">
                                        <option value="" selected disabled>Pilih Jabatan</option>
                                    </select>
                                </div>
                                <!-- Agama -->
                                <div class="mb-2">
                                    <label class="form-label" for="agama">Agama</label>
                                    <select name="agama" id="agama" class="form-select">
                                        <option value="" selected disabled>Pilih Agama</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                                <!-- No Handphone -->
                                <div class="mb-2">
                                    <label class="form-label" for="noHp">No Handphone</label>
                                    <input type="number" name="noHp" id="noHp" class="form-control"
                                        placeholder="Masukan Nomor Handphone">
                                </div>
                                <!-- Status -->
                                <div class="mb-2">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="" selected disabled>Pilih Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-2 text-end" id="bt-form-pegawai">
                                <!-- Form Buttons -->
                            </div>
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
        const gambarPegawai = document.querySelector('#gambarPegawai');
        const imgPrev = document.querySelector('.img-preview');
        const oFReader = new FileReader();


        function prevImg() {

            // imgPrev.style.display = 'block';

            oFReader.readAsDataURL(gambarPegawai.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPrev.src = oFREvent.target.result;
            }
        }
    </script>
@endpush
