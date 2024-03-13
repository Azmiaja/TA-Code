<div class="modal fade" id="modal-UserPegawai" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modal-tambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="modal-title-pegawai"></h3>
                    <div class="block-options">
                        <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    {{-- FORM --}}
                    <form id="form_user_pegawai" action="" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="POST">
                        <input type="text" hidden id="idUser">
                        <div class="mb-3 sh-ussis">
                            <label class="form-label" for="idPegawai">Nama Pegawai</label>
                            <select class="form-select" id="idPegawai" name="idPegawai[]" multiple="multiple"></select>
                        </div>
                        <div class="mb-3" id="uss_display_pegawai" hidden>
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control" id="username_pegawai" name="username"
                            placeholder="Username">
                        </div>
                        <div class="mb-3" id="pass_display_pegawai" hidden>
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="password_pegawai" placeholder="Password">
                                <button class="btn btn-alt-primary" type="button" id="reset_password_pegawai">
                                    Reset
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="hak_akses">Hak Akses</label>
                            <select name="hakAkses" id="hak_akses" class="form-select">
                                <option value="" selected disabled>-- Pilih Hak Akses --</option>
                                <option value="Guru">Guru</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-4 text-end" id="bt-form-pegawai">
                            {{-- content button --}}
                        </div>
                    </form>
                </div>

                <div class="block-content block-content-full bg-body">
                </div>
            </div>
        </div>
    </div>
</div>
