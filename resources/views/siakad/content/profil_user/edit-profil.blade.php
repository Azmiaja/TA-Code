<div class="modal fade" id="modal_ubahProfil" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modal-modal_ubahProfil" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            @cannot('siswa')
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="title-modal">Ubah Profil Saya</h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <form action="{{ route('profil_pengguna.update.biografi', ['id' => $auths->idPegawai]) }}"
                            method="POST" enctype="multipart/form-data" id="form-editProfile">
                            @csrf
                            @method('put')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-md-3 mb-5">
                                        <label class="form-label" for="username">Nama Pengguna</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Masukan username.."
                                            value="{{ old('username', $auths->username) }}">
                                        <span class="text-danger error-text username_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="nip">NIP</label>
                                        <input type="number" class="form-control" id="nip" name="nip"
                                            placeholder="Masukan nip.." value="{{ old('nip', $auths->pegawai->nip) }}">
                                        <span class="text-danger error-text nip_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="namaPegawai">Nama Lengkap</label>

                                        <input type="text" class="form-control" id="namaPegawai" name="namaPegawai"
                                            placeholder="Masukan nama lengkap.."
                                            value="{{ old('namaPegawai', $auths->pegawai->namaPegawai) }}">
                                        <span class="text-danger error-text namaPegawai_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="tempatLahir">Tempat Lahir</label>

                                        <input type="text" class="form-control" id="tempatLahir" name="tempatLahir"
                                            placeholder="Masukan tempat lahir.."
                                            value="{{ old('tempatLahir', $auths->pegawai->tempatLahir) }}">
                                        <span class="text-danger error-text tempatLahir_error"></span>

                                    </div>
                                    <div class="">
                                        <label class="form-label" for="tanggalLahir">Tanggal
                                            Lahir</label>

                                        <input type="text" class="form-control" id="tanggalLahir" name="tanggalLahir"
                                            placeholder="Masukan tanggal lahir.."
                                            value="{{ old('tanggalLahir', date('d/m/Y', strtotime($auths->pegawai->tanggalLahir))) }}">
                                        <span class="text-danger error-text tanggalLahir_error"></span>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="jenisKelamin">Jenis
                                            Kelamin</label>

                                        <select name="jenisKelamin" id="jenisKelamin" class="form-select">
                                            <option disabled selected value="">-- Pilih Jenis Kelamin --
                                            </option>
                                            <option value="Laki-Laki"
                                                {{ $auths->pegawai->jenisKelamin == 'Laki-Laki' ? 'selected' : '' }}>
                                                Laki-Laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ $auths->pegawai->jenisKelamin == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan
                                            </option>
                                        </select>
                                        <span class="text-danger error-text jenisKelamin_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="agama">Agama</label>

                                        <select name="agama" id="agama" class="form-select">
                                            <option disabled selected value="">-- Pilih Agama --</option>
                                            <option value="Islam"
                                                {{ $auths->pegawai->agama == 'Islam' ? 'selected' : '' }}>
                                                Islam
                                            </option>
                                            <option value="Kristen"
                                                {{ $auths->pegawai->agama == 'Kristen' ? 'selected' : '' }}>
                                                Kristen
                                            </option>
                                            <option value="Katolik"
                                                {{ $auths->pegawai->agama == 'Katolik' ? 'selected' : '' }}>
                                                Katolik
                                            </option>
                                            <option value="Hindu"
                                                {{ $auths->pegawai->agama == 'Hindu' ? 'selected' : '' }}>
                                                Hindu
                                            </option>
                                            <option value="Budha"
                                                {{ $auths->pegawai->agama == 'Budha' ? 'selected' : '' }}>
                                                Budha
                                            </option>
                                        </select>
                                        <span class="text-danger error-text agama_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="noHp">Telepon</label>

                                        <input type="number" class="form-control" id="noHp" name="noHp"
                                            placeholder="Masukan nomor telepon.."
                                            value="{{ old('noHp', $auths->pegawai->noHp) }}">
                                        <span class="text-danger error-text noHp_error"></span>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="alamat">Alamat</label>

                                        <textarea type="date" class="form-control" id="alamat" rows="3" name="alamat"
                                            placeholder="Masukan alamat tinggal.." style="resize: none;">{{ old('alamat', $auths->pegawai->alamat) }}</textarea>
                                        <span class="text-danger error-text alamat_error"></span>

                                    </div>
                                </div>
                                <div class="mb-4 text-end">
                                    <button type="submit" class="btn btn-alt-primary">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            @endcannot
            @can('siswa')
                <div class="block block-rounded block-transparent mb-0">
                    <ul class="nav nav-tabs nav-tabs-alt bg-body-light" role="tablist">
                        <li class="nav-item">
                            <button
                                class="nav-link {{ session('ortu_success') || session('wali_success') ? '' : 'active' }}"
                                id="tentang_siswa" data-bs-toggle="tab" data-bs-target="#tab_tentang_siswa"
                                role="tab" aria-controls="tab_tentang_siswa" aria-selected="true">Profil
                                Saya</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link {{ session('ortu_success') ? 'active' : '' }}" id="ortu"
                                data-bs-toggle="tab" data-bs-target="#tab_ortu" role="tab" aria-controls="tab_ortu"
                                aria-selected="false">Orang
                                Tua</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link {{ session('wali_success') ? 'active' : '' }}" id="wali"
                                data-bs-toggle="tab" data-bs-target="#tab_wali" role="tab" aria-controls="tab_wali"
                                aria-selected="false">Wali
                                Murid</button>
                        </li>
                        <div class="nav-item ms-auto">
                            <button type="button" id="btn-close" class="btn-block-option mt-1 me-2"
                                data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </ul>
                    <form action="{{ route('profil_pengguna.update.biografi.siswa', ['id' => $auths->idSiswa]) }}"
                        method="POST" enctype="multipart/form-data" id="form_editProfilSiswa">
                        @csrf
                        @method('put')
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="tab_tentang_siswa" role="tabpanel"
                                aria-labelledby="tentang_siswa" tabindex="0">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="nis">NIS</label>
                                        <input type="number" disabled class="form-control" id="nis"
                                            name="nis" placeholder="Masukan nis.."
                                            value="{{ old('nis', $auths->siswa->nis) }}">
                                        <span class="text-danger error-text nis_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="nisn">NISN</label>
                                        <input type="number" disabled class="form-control" id="nisn"
                                            name="nisn" placeholder="Masukan nisn.."
                                            value="{{ old('nisn', $auths->siswa->nisn) }}">
                                        <span class="text-danger error-text nisn_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="namaSiswa">Nama lengkap</label>
                                        <input type="text" class="form-control" id="namaSiswa" name="namaSiswa"
                                            placeholder="Masukan nama siswa.."
                                            value="{{ old('namaSiswa', $auths->siswa->namaSiswa) }}">
                                        <span class="text-danger error-text namaSiswa_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="panggilan">Nama panggilan</label>
                                        <input type="text" class="form-control" id="panggilan" name="panggilan"
                                            placeholder="Masukan nama pangggilan.."
                                            value="{{ old('panggilan', $auths->siswa->panggilan) }}">
                                        <span class="text-danger error-text panggilan_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="tempatLahir">Tempat lahir</label>
                                        <input type="text" class="form-control" id="tempatLahir" name="tempatLahir"
                                            placeholder="Masukan nama pangggilan.."
                                            value="{{ old('tempatLahir', $auths->siswa->tempatLahir) }}">
                                        <span class="text-danger error-text tempatLahir_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="tanggalLahir">Tangga lahir</label>
                                        <input type="text" class="form-control" id="tanggalLahir" name="tanggalLahir"
                                            placeholder="Masukan nama pangggilan.."
                                            value="{{ old('tanggalLahir', date('d/m/Y', strtotime($auths->siswa->tanggalLahir))) }}">
                                        <span class="text-danger error-text tanggalLahir_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="jenisKelamin">Jenis
                                            kelamin</label>
                                        <select name="jenisKelamin" id="jenisKelamin" class="form-select">
                                            <option disabled selected value="">-- Pilih Jenis Kelamin --
                                            </option>
                                            <option value="Laki-Laki"
                                                {{ old('jenisKelamin', $auths->siswa->jenisKelamin) == 'Laki-Laki' ? 'selected' : '' }}>
                                                Laki-Laki
                                            </option>
                                            <option value="Perempuan"
                                                {{ old('jenisKelamin', $auths->siswa->jenisKelamin) == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan
                                            </option>
                                        </select>
                                        <span class="text-danger error-text jenisKelamin_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="agama">Agama</label>
                                        <select name="agama" id="agama" class="form-select">
                                            <option disabled selected value="">-- Pilih Agama --</option>
                                            <option value="Islam"
                                                {{ old('agama', $auths->siswa->agama) == 'Islam' ? 'selected' : '' }}>
                                                Islam
                                            </option>
                                            <option value="Kristen"
                                                {{ old('agama', $auths->siswa->agama) == 'Kristen' ? 'selected' : '' }}>
                                                Kristen
                                            </option>
                                            <option value="Katolik"
                                                {{ old('agama', $auths->siswa->agama) == 'Katolik' ? 'selected' : '' }}>
                                                Katolik
                                            </option>
                                            <option value="Hindu"
                                                {{ old('agama', $auths->siswa->agama) == 'Hindu' ? 'selected' : '' }}>
                                                Hindu
                                            </option>
                                            <option value="Budha"
                                                {{ old('agama', $auths->siswa->agama) == 'Budha' ? 'selected' : '' }}>
                                                Budha
                                            </option>
                                        </select>
                                        <span class="text-danger error-text agama_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="alamat">Alamat</label>
                                        <textarea type="date" class="form-control" id="alamat" rows="3" name="alamat"
                                            placeholder="Masukan alamat tinggal.." style="resize: none;">{{ old('alamat', $auths->siswa->alamat) }}</textarea>
                                        <span class="text-danger error-text alamat_error"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_ortu" role="tabpanel" aria-labelledby="ortu" tabindex="0">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="namaAyah">Nama ayah</label>
                                        <input type="text" class="form-control" id="namaAyah" name="namaAyah"
                                            placeholder="Masukan nama ayah.."
                                            value="{{ old('namaAyah', $auths->siswa->namaAyah) }}">
                                        <span class="text-danger error-text namaAyah_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="namaIbu">Nama ibu</label>
                                        <input type="text" class="form-control" id="namaIbu" name="namaIbu"
                                            placeholder="Masukan nama ibu.."
                                            value="{{ old('namaIbu', $auths->siswa->namaIbu) }}">
                                        <span class="text-danger error-text namaIbu_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="pekerjaanAyah">Pekerjaan
                                            ayah</label>
                                        <input type="text" class="form-control" id="pekerjaanAyah"
                                            name="pekerjaanAyah" placeholder="Masukan pekerjaan ayah.."
                                            value="{{ old('pekerjaanAyah', $auths->siswa->pekerjaanAyah) }}">
                                        <span class="text-danger error-text pekerjaanAyah_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="pekerjaanIbu">Pekerjaan
                                            ibu</label>
                                        <input type="text" class="form-control" id="pekerjaanIbu" name="pekerjaanIbu"
                                            placeholder="Masukan nama ibu.."
                                            value="{{ old('pekerjaanIbu', $auths->siswa->pekerjaanIbu) }}">
                                        <span class="text-danger error-text pekerjaanIbu_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="noTlpAyah">Nomor telepon
                                            ayah</label>
                                        <input type="number" class="form-control" id="noTlpAyah" name="noTlpAyah"
                                            placeholder="Masukan nomor telepon ayah.."
                                            value="{{ old('noTlpAyah', $auths->siswa->noTlpAyah) }}">
                                        <span class="text-danger error-text noTlpAyah_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="noTlpIbu">Nomor telepon
                                            ibu</label>
                                        <input type="number" class="form-control" id="noTlpIbu" name="noTlpIbu"
                                            placeholder="Masukan nomor telepon ibu.."
                                            value="{{ old('noTlpIbu', $auths->siswa->noTlpIbu) }}">
                                        <span class="text-danger error-text noTlpIbu_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="alamatAyah">Alamat domisili ayah</label>
                                        <textarea type="date" class="form-control" id="alamatAyah" rows="3" name="alamatAyah"
                                            placeholder="Masukan alamat tinggal ayah.." style="resize: none;">{{ old('alamatAyah', $auths->siswa->alamatAyah) }}</textarea>
                                        <span class="text-danger error-text alamatAyah_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="alamatIbu">Alamat domisili ibu</label>
                                        <textarea type="date" class="form-control" id="alamatIbu" rows="3" name="alamatIbu"
                                            placeholder="Masukan alamat tinggal ibu.." style="resize: none;">{{ old('alamatIbu', $auths->siswa->alamatIbu) }}</textarea>
                                        <span class="text-danger error-text alamatIbu_error"></span>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_wali" role="tabpanel" aria-labelledby="wali" tabindex="0">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="namaWali">Nama wali</label>
                                        <input type="text" class="form-control" id="namaWali" name="namaWali"
                                            placeholder="Masukan nama wali murid.."
                                            value="{{ old('namaWali', $auths->siswa->namaWali) }}">
                                        <span class="text-danger error-text namaWali_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="pekerjaanWali">Pekerjaan wali
                                        </label>
                                        <input type="text" class="form-control" id="pekerjaanWali"
                                            name="pekerjaanWali" placeholder="Masukan pekerjaan wali murid.."
                                            value="{{ old('pekerjaanWali', $auths->siswa->pekerjaanWali) }}">
                                        <span class="text-danger error-text pekerjaanWali_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="noTlpWali">Nomor telepon wali
                                        </label>
                                        <input type="number" class="form-control" id="noTlpWali" name="noTlpWali"
                                            placeholder="Masukan nomor telepon wali murid.."
                                            value="{{ old('noTlpWali', $auths->siswa->noTlpWali) }}">
                                        <span class="text-danger error-text niTlpWali_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="alamatWali">Alamat domisili wali
                                        </label>
                                        <textarea type="date" class="form-control" id="alamatWali" rows="3" name="alamatWali"
                                            placeholder="Masukan alamat tinggal wali murid.." style="resize: none;">{{ old('alamatWali', $auths->siswa->alamatWali) }}</textarea>
                                        <span class="text-danger error-text alamatWali_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="block-content block-content-full text-end bg-body rounded-bottom">
                    <button type="submit" class="btn btn-alt-primary">
                        Simpan Perubahan
                    </button>
                </div>
                </form>
            </div>
        @endcan
    </div>
</div>
</div>
