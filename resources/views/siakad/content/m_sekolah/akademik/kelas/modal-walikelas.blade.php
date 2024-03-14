{{-- ==================================== MODAL GURU ============================================= --}}
<div class="modal fade" id="modal-bagiKelasGuru" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
aria-labelledby="modal-bagiKelasGuruLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="block block-rounded block-transparent mb-0">
            <div class="block-header block-header-default">
                <h3 class="block-title" id="title-modal">Judul Modal</h3>
                <div class="block-options">
                    <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa fa-fw fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="block-content fs-sm">
                {{-- FORM --}}
                <input type="text" name="idKelas" class="id-kelas" hidden>
                <div class="mb-4">
                    <label class="form-label" for="periode">Perode</label>
                    <select name="periode" id="periode_klas" class="form-select pilih-periode">
                        <option value="" disabled selected>-- Pilih Periode --</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="idPrgawai">Nama Guru</label>
                    <select name="idPrgawai" id="idPrgawai" class="form-select pilih-guru">
                        <option value="" disabled selected>-- Pilih Guru --</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="namaKelas">Kelas</label>
                    <select name="namaKelas" id="namaKelas" class="form-select pilih-kelas">
                        <option value="" disabled selected>-- Pilih Kelas --</option>
                        <option value="1">Kelas 1</option>
                        <option value="2">Kelas 2</option>
                        <option value="3">Kelas 3</option>
                        <option value="4">Kelas 4</option>
                        <option value="5">Kelas 5</option>
                        <option value="6">Kelas 6</option>
                    </select>
                </div>
                <div class="mb-4 text-end" id="cn-btn">
                    {{-- button submit --}}
                </div>
            </div>

            <div class="block-content block-content-full bg-body">
            </div>
        </div>
    </div>
</div>
</div>