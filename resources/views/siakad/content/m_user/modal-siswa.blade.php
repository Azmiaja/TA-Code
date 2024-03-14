<div class="modal fade" id="modal-UsrSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modal-tambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
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
                    <form id="form_user_siswa" action="" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="method_siswa" value="POST">
                        <input type="text" hidden id="idUserSiswa">
                        <div class="mb-3 sh-ussis">
                            <label class="form-label" for="idSiswa">Nama Siswa</label>
                            <select class="form-select" id="idSiswa" name="idSiswa[]" multiple="multiple"></select>
                        </div>
                        <div class="mb-3" id="kls_display" hidden>
                            <label class="form-label" for="username">Kelas</label>
                            <input type="text" class="form-control" id="kelas_siswa" name="kelas" disabled>
                        </div>
                        <div class="mb-3" id="uss_display" hidden>
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control" id="username_siswa" name="username"
                                placeholder="Masukan Username">
                        </div>
                        <div class="mb-3" id="pass_display" hidden>
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="password" id="password_siswa" placeholder="Password">
                                <button class="btn btn-alt-primary" type="button" id="reset_password_siswa">
                                    Reset
                                </button>
                            </div>
                        </div>
                        <div class="mb-4 text-end" id="bt-form-siswa">
                            {{-- content button --}}
                        </div>
                    </form>
                </div>
            </div>

            <div class="block-content block-content-full bg-body">
            </div>
        </div>
    </div>
</div>
</div>
