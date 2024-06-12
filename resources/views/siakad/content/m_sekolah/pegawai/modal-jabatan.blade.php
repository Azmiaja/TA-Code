<!-- Modal -->
<div class="modal fade" id="modalJabatan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modal-tambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <!-- Modal Title -->
                    <h3 class="block-title" id="modal-title-jabatan"></h3>
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
                    <form id="formJabatan" method="POST" name="formJabatan" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="method_jb" value="POST">
                        <input type="hidden" name="idJabatan" id="idJ">
                        <div class="mb-3 kategori-jabatan">
                            <label for="jenis" class="form-label">Kategori</label>
                            <select type="text" name="jenis" id="jenis" class="form-select">
                                <option value="" selected disabled>Pilih Kategori</option>
                                <option value="Guru">Guru</option>
                                <option value="Tendik">Tenaga Kependidikan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Masukan Jabatan Pegawai" required>
                        </div>
                        <div class="mb-3 text-end" id="bt-form-jabatan">
                            <!-- Form Buttons -->
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
