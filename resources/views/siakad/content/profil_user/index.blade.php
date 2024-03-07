    @extends('siakad/layouts/app')
    @section('siakad')
        @include('siakad/layouts/partials/hero')
        <div class="content">
            <div class="row g-3">
                @include('siakad/content/profil_user/profil-menu')
                <div class="col-lg-9 col-md-8 col-12 order-md-1 order-0">
                    @cannot('siswa')
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
                                            <div class="col-7">{!! $auths->pegawai->nip ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Nama lengkap</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->pegawai->namaPegawai ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Tempat lahir</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->pegawai->tempatLahir ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Tanggal lahir</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! date('d-m-Y', strtotime($auths->pegawai->tanggalLahir)) ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Jenis kelamin</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->pegawai->jenisKelamin ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Alamat tinggal</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->pegawai->alamat ?: '-' !!}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Agama</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->pegawai->agama ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Telepon</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->pegawai->noHp ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Kategori</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->pegawai->jenisPegawai ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Jabatan</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->pegawai->jabatanPegawai->jabatan ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Status</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">
                                                @if ($auths->pegawai->status !== null)
                                                    <span
                                                        class="fs-sm fw-semibold d-inline-block py-1 px-3 rounded-pill {{ $auths->pegawai->status === 'Aktif' ? 'bg-success-light text-success' : 'bg-danger-light text-danger' }} ">{{ $auths->pegawai->status }}</span>
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcannot
                    @can('siswa')
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Biografi</h3>
                            </div>
                            <div class="block-content">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12">
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">NISN</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->nisn ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">NIS</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->nis ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Nama lengkap</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->namaSiswa ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Nama panggilan</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->panggilan ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Tempat lahir</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->tempatLahir ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Tanggal lahir</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! date('d-m-Y', strtotime($auths->siswa->tanggalLahir)) ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Jenis kelamin</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->jenisKelamin ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Alamat tinggal</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->alamat ?: '-' !!}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Agama</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->agama ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Nama ayah</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->namaAyah ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Pekerjaan ayah</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->pekerjaanAyah ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Nama ibu</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->namaIbu ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Pekerjaan ibu</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->pekerjaanIbu ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Nama wali</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->namaWali ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Pekerjaan wali</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">{!! $auths->siswa->pekerjaanWali ?: '-' !!}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-3 py-2">
                                            <div class="col-4 fw-semibold">Status</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">
                                                @if ($auths->siswa->status !== null)
                                                    <span
                                                        class="fs-sm fw-semibold d-inline-block py-1 px-3 rounded-pill {{ $auths->siswa->status === 'Aktif' ? 'bg-success-light text-success' : 'bg-danger-light text-danger' }} ">{{ $auths->siswa->status }}</span>
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>

        </div>
    @endsection
