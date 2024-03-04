    @extends('siakad/layouts/app')
    @section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="row g-3">
            @include('siakad/content/profil_user/profil-menu')
            <div class="col-lg-9 col-md-8 col-12 order-md-1 order-0">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Biografi</h3>
                    </div>
                    <div class="block-content">
                        <div class="row g-2">
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">NIP</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">{!! $auth->nip ?: '<em><u>null</u></em>' !!}</div>
                                </div>
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">Nama lengkap</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">{!! $auth->namaPegawai ?: '<em><u>null</u></em>' !!}</div>
                                </div>
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">Tempat lahir</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">{!! $auth->tempatLahir ?: '<em><u>null</u></em>' !!}</div>
                                </div>
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">Tanggal lahir</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">{!! date('d-m-Y', strtotime($auth->tanggalLahir)) ?: '<em><u>null</u></em>' !!}</div>
                                </div>
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">Jenis kelamin</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">{!! $auth->jenisKelamin ?: '<em><u>null</u></em>' !!}</div>
                                </div>
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">Alamat tinggal</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">{!! $auth->alamat ?: '<em><u>null</u></em>' !!}</div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">Agama</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">{!! $auth->agama ?: '<em><u>null</u></em>' !!}</div>
                                </div>
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">Telepon</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">{!! $auth->noHp ?: '<em><u>null</u></em>' !!}</div>
                                </div>
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">Kategori</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">{!! $auth->jenisPegawai ?: '<em><u>null</u></em>' !!}</div>
                                </div>
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">Jabatan</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">{!! $auth->jabatanPegawai->jabatan ?: '<em><u>null</u></em>' !!}</div>
                                </div>
                                <div class="d-flex flex-row mb-3 py-2">
                                    <div class="col-4 fw-semibold">Status</div>
                                    <div class="col-1 fw-semibold">:</div>
                                    <div class="col-7">
                                        <span
                                            class="fs-sm fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">{!! $auth->status ?: '<em><u>null</u></em>' !!}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
