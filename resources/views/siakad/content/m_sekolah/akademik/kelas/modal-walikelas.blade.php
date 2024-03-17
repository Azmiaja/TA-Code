{{-- ==================================== MODAL GURU ============================================= --}}
<div class="modal fade" id="modal_kelasGuru" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modal-bagiKelasGuruLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="title-modal"></h3>
                    <div class="block-options">
                        <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    {{-- FORM --}}
                    <form action="" id="form_waliKelas" method="post">
                        @csrf
                        <input type="hidden" name="_method" id="method_waliKelas" value="POST">
                        <input type="text" name="idKelas" class="id-kelas" hidden>
                        <div class="mb-3">
                            <label class="form-label" for="periode">Perode</label>
                            <select name="periode" id="periode_klas" name="idPeriode" class="form-select">
                                <option value="" disabled selected>-- Pilih Periode --</option>
                                <option value="{{ $item->idPeriode }}">
                                    Semester
                                    {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="idPegawai">Nama Guru</label>
                            <select name="idPegawai" id="idPegawai" class="form-select"></select>
                        </div>
                        <div class="mb-3">
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
                        <div class="mb-4 text-end" id="bt_modalGuru">
                            {{-- button submit --}}
                        </div>
                </div>
                </form>

                <div class="block-content block-content-full bg-body">
                </div>
            </div>
        </div>
    </div>
</div>
