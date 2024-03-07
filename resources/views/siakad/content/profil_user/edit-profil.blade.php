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
                            <h3 class="block-title">Profil Prngguna</h3>
                        </div>
                        <div class="block-content">
                            <form action="{{ route('profil_pengguna.update.user', ['id' => Auth::user()->idUser]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        @if (session('user_success'))
                                            <div class="alert alert-success d-flex align-items-center fade show mb-3"
                                                role="alert">
                                                <i class="fa-solid fa-circle-check fs-3 me-3"></i>
                                                <div>
                                                    {{ session('user_success') }}
                                                </div>
                                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            @push('scripts')
                                                <script>
                                                    $(document).ready(function() {
                                                        setTimeout(function() {
                                                            $(".alert").alert('close');
                                                        }, 5000);
                                                    });
                                                </script>
                                            @endpush
                                        @endif
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="username">Username</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="username" name="username"
                                                    placeholder="Masukan username.."
                                                    value="{{ old('username', Auth::user()->username) }}">
                                                @error('username')
                                                    <div class="text-danger fs-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-4 float-end">
                                            <button type="submit" class="btn btn-alt-primary">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Biografi</h3>
                        </div>
                        <div class="block-content">
                            <form action="{{ route('profil_pengguna.update.biografi', ['id' => $auths->idPegawai]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        @if (session('success'))
                                            <div class="alert alert-success d-flex align-items-center fade show mb-3"
                                                role="alert">
                                                <i class="fa-solid fa-circle-check fs-3 me-3"></i>
                                                <div>
                                                    {{ session('success') }}
                                                </div>
                                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            @push('scripts')
                                                <script>
                                                    $(document).ready(function() {
                                                        setTimeout(function() {
                                                            $(".alert").alert('close');
                                                        }, 5000);
                                                    });
                                                </script>
                                            @endpush
                                        @endif
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="nip">NIP</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="nip" name="nip"
                                                    placeholder="Masukan nip.." value="{{ old('nip', $auths->pegawai->nip) }}">
                                                @error('nip')
                                                    <div class="text-danger fs-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="namaPegawai">Nama Lengkap</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="namaPegawai" name="namaPegawai"
                                                    placeholder="Masukan nama lengkap.."
                                                    value="{{ old('namaPegawai', $auths->pegawai->namaPegawai) }}">
                                                @error('namaPegawai')
                                                    <div class="text-danger fs-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="tempatLahir">Tempat Lahir</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="tempatLahir" name="tempatLahir"
                                                    placeholder="Masukan tempat lahir.."
                                                    value="{{ old('tempatLahir', $auths->pegawai->tempatLahir) }}">
                                                @error('tempatLahir')
                                                    <div class="text-danger fs-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="tanggalLahir">Tanggal Lahir</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" id="tanggalLahir" name="tanggalLahir"
                                                    placeholder="Masukan tanggal lahir.."
                                                    value="{{ old('tanggalLahir', $auths->pegawai->tanggalLahir) }}">
                                                @error('tanggalLahir')
                                                    <div class="text-danger fs-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="jenisKelamin">Jenis Kelamin</label>
                                            <div class="col-sm-8">
                                                <select name="jenisKelamin" id="jenisKelamin" class="form-select">
                                                    <option disabled selected value="">-- Pilih Jenis Kelamin --</option>
                                                    <option value="Laki-Laki"
                                                        {{ $auths->pegawai->jenisKelamin == 'Laki-Laki' ? 'selected' : '' }}>
                                                        Laki-Laki
                                                    </option>
                                                    <option value="Perempuan"
                                                        {{ $auths->pegawai->jenisKelamin == 'Perempuan' ? 'selected' : '' }}>
                                                        Perempuan
                                                    </option>
                                                </select>
                                                @error('jenisKelamin')
                                                    <div class="text-danger fs-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="agama">Agama</label>
                                            <div class="col-sm-8">
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
                                                @error('agama')
                                                    <div class="text-danger fs-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="noHp">Telepon</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="noHp" name="noHp"
                                                    placeholder="Masukan nomor telepon.."
                                                    value="{{ old('noHp', $auths->pegawai->noHp) }}">
                                                @error('noHp')
                                                    <div class="text-danger fs-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label" for="alamat">Alamat</label>
                                            <div class="col-sm-8">
                                                <textarea type="date" class="form-control" id="alamat" rows="3" name="alamat"
                                                    placeholder="Masukan alamat tinggal..">{{ old('alamat', $auths->pegawai->alamat) }}</textarea>
                                                @error('alamat')
                                                    <div class="text-danger fs-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label class="col-sm-4 col-form-label" for="gambar">Foto Profil</label>
                                            <div class="col-sm-8">
                                                <div class="ratio mb-2 rounded"
                                                    style="width: 120px; height: 120px; border: 2px dashed #dfe3ea;">
                                                    <img src="{{ asset('storage/' . $auths->pegawai->gambar) }}"
                                                        class="img-preview rounded"
                                                        style="width: 100%; height: 100%; object-fit: contain;"
                                                        alt="">
                                                </div>
                                                <input type="file" class="form-control" name="gambar"
                                                    accept=".jpg,.jpeg,.png,.svg" id="gambar" onchange="prevImg()">
                                                @error('gambar')
                                                    <div class="text-danger fs-sm">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-4 float-end">
                                            <button type="submit" class="btn btn-alt-primary">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endcannot
                @can('siswa')
                    <div class="block block-rounded">
                        <ul class="nav nav-tabs nav-tabs-alt bg-body-light" role="tablist">
                            <li class="nav-item">
                                <button
                                    class="nav-link {{ session('ortu_success') || session('wali_success') ? '' : 'active' }}"
                                    id="tentang_siswa" data-bs-toggle="tab" data-bs-target="#tab_tentang_siswa"
                                    role="tab" aria-controls="tab_tentang_siswa" aria-selected="true">Tentang
                                    Siswa</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link {{ session('ortu_success') ? 'active' : '' }}" id="ortu"
                                    data-bs-toggle="tab" data-bs-target="#tab_ortu" role="tab" aria-controls="tab_ortu"
                                    aria-selected="false">Orang Tua</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link {{ session('wali_success') ? 'active' : '' }}" id="wali"
                                    data-bs-toggle="tab" data-bs-target="#tab_wali" role="tab" aria-controls="tab_wali"
                                    aria-selected="false">Wali Murid</button>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane {{ session('ortu_success') || session('wali_success') ? '' : 'active' }}"
                                id="tab_tentang_siswa" role="tabpanel" aria-labelledby="tentang_siswa" tabindex="0">
                                <form action="{{ route('profil_pengguna.update.biografi.siswa', ['id' => $auths->idSiswa]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            @if (session('siswa_success'))
                                                <div class="alert alert-success d-flex align-items-center fade show mb-3"
                                                    role="alert">
                                                    <i class="fa-solid fa-circle-check fs-3 me-3"></i>
                                                    <div>
                                                        {{ session('siswa_success') }}
                                                    </div>
                                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                                @push('scripts')
                                                    <script>
                                                        $(document).ready(function() {
                                                            setTimeout(function() {
                                                                $(".alert").alert('close');
                                                            }, 5000);
                                                        });
                                                    </script>
                                                @endpush
                                            @endif
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="nis">NIS</label>
                                                <div class="col-sm-8">
                                                    <input type="number" disabled class="form-control" id="nis"
                                                        name="nis" placeholder="Masukan nis.."
                                                        value="{{ old('nis', $auths->siswa->nis) }}">
                                                    @error('nis')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="nisn">NISN</label>
                                                <div class="col-sm-8">
                                                    <input type="number" disabled class="form-control" id="nisn"
                                                        name="nisn" placeholder="Masukan nisn.."
                                                        value="{{ old('nisn', $auths->siswa->nisn) }}">
                                                    @error('nisn')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="namaSiswa">Nama Lengkap</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="namaSiswa"
                                                        name="namaSiswa" placeholder="Masukan nama siswa.."
                                                        value="{{ old('namaSiswa', $auths->siswa->namaSiswa) }}">
                                                    @error('namaSiswa')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="panggilan">Nama Panggilan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="panggilan"
                                                        name="panggilan" placeholder="Masukan nama pangggilan.."
                                                        value="{{ old('panggilan', $auths->siswa->panggilan) }}">
                                                    @error('panggilan')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="tempatLahir">Tempat Lahir</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="tempatLahir"
                                                        name="tempatLahir" placeholder="Masukan nama pangggilan.."
                                                        value="{{ old('tempatLahir', $auths->siswa->tempatLahir) }}">
                                                    @error('tempatLahir')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="tanggalLahir">Tangga Lahir</label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control" id="tanggalLahir"
                                                        name="tanggalLahir" placeholder="Masukan nama pangggilan.."
                                                        value="{{ old('tanggalLahir', $auths->siswa->tanggalLahir) }}">
                                                    @error('tanggalLahir')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="jenisKelamin">Jenis
                                                    Kelamin</label>
                                                <div class="col-sm-8">
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
                                                    @error('jenisKelamin')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="agama">Agama</label>
                                                <div class="col-sm-8">
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
                                                    @error('agama')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="alamat">Alamat</label>
                                                <div class="col-sm-8">
                                                    <textarea type="date" class="form-control" id="alamat" rows="3" name="alamat"
                                                        placeholder="Masukan alamat tinggal..">{{ old('alamat', $auths->siswa->alamat) }}</textarea>
                                                    @error('alamat')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-4 float-end">
                                                <button type="submit" class="btn btn-alt-primary">
                                                    Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane {{ session('ortu_success') ? 'active' : '' }}" id="tab_ortu"
                                role="tabpanel" aria-labelledby="ortu" tabindex="0">
                                <form action="{{ route('profil_pengguna.update.biografi.ortu', ['id' => $auths->idSiswa]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row justify-content-center">
                                        <div class="col-lg-9">
                                            @if (session('ortu_success'))
                                                <div class="alert alert-success d-flex align-items-center fade show mb-3"
                                                    role="alert">
                                                    <i class="fa-solid fa-circle-check fs-3 me-3"></i>
                                                    <div>
                                                        {{ session('ortu_success') }}
                                                    </div>
                                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                                @push('scripts')
                                                    <script>
                                                        $(document).ready(function() {
                                                            setTimeout(function() {
                                                                $(".alert").alert('close');
                                                            }, 5000);
                                                        });
                                                    </script>
                                                @endpush
                                            @endif
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="namaAyah">Nama Ayah</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="namaAyah"
                                                        name="namaAyah" placeholder="Masukan nama ayah.."
                                                        value="{{ old('namaAyah', $auths->siswa->namaAyah) }}">
                                                    @error('namaAyah')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="namaIbu">Nama Ibu</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="namaIbu" name="namaIbu"
                                                        placeholder="Masukan nama ibu.."
                                                        value="{{ old('namaIbu', $auths->siswa->namaIbu) }}">
                                                    @error('namaIbu')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="pekerjaanAyah">Pekerjaan
                                                    Ayah</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="pekerjaanAyah"
                                                        name="pekerjaanAyah" placeholder="Masukan pekerjaan ayah.."
                                                        value="{{ old('pekerjaanAyah', $auths->siswa->pekerjaanAyah) }}">
                                                    @error('pekerjaanAyah')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="pekerjaanIbu">Pekerjaan
                                                    Ibu</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="pekerjaanIbu"
                                                        name="pekerjaanIbu" placeholder="Masukan nama ibu.."
                                                        value="{{ old('pekerjaanIbu', $auths->siswa->pekerjaanIbu) }}">
                                                    @error('pekerjaanIbu')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="noTlpAyah">Nomor Telepon
                                                    Ayah</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="noTlpAyah"
                                                        name="noTlpAyah" placeholder="Masukan nomor telepon ayah.."
                                                        value="{{ old('noTlpAyah', $auths->siswa->noTlpAyah) }}">
                                                    @error('noTlpAyah')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="noTlpIbu">Nomor Telepon
                                                    Ibu</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="noTlpIbu"
                                                        name="noTlpIbu" placeholder="Masukan nomor telepon ibu.."
                                                        value="{{ old('noTlpIbu', $auths->siswa->noTlpIbu) }}">
                                                    @error('noTlpIbu')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="alamatAyah">Alamat Ayah</label>
                                                <div class="col-sm-8">
                                                    <textarea type="date" class="form-control" id="alamatAyah" rows="3" name="alamatAyah"
                                                        placeholder="Masukan alamat tinggal ayah..">{{ old('alamatAyah', $auths->siswa->alamatAyah) }}</textarea>
                                                    @error('alamatAyah')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="alamatIbu">Alamat Ibu</label>
                                                <div class="col-sm-8">
                                                    <textarea type="date" class="form-control" id="alamatIbu" rows="3" name="alamatIbu"
                                                        placeholder="Masukan alamat tinggal ibu..">{{ old('alamatIbu', $auths->siswa->alamatIbu) }}</textarea>
                                                    @error('alamatIbu')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-4 float-end">
                                                <button type="submit" class="btn btn-alt-primary">
                                                    Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane {{ session('wali_success') ? 'active' : '' }}" id="tab_wali"
                                role="tabpanel" aria-labelledby="wali" tabindex="0">
                                <form action="{{ route('profil_pengguna.update.biografi.wali', ['id' => $auths->idSiswa]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row justify-content-center">
                                        <div class="col-lg-9">
                                            @if (session('wali_success'))
                                                <div class="alert alert-success d-flex align-items-center fade show mb-3"
                                                    role="alert">
                                                    <i class="fa-solid fa-circle-check fs-3 me-3"></i>
                                                    <div>
                                                        {{ session('wali_success') }}
                                                    </div>
                                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                                @push('scripts')
                                                    <script>
                                                        $(document).ready(function() {
                                                            setTimeout(function() {
                                                                $(".alert").alert('close');
                                                            }, 5000);
                                                        });
                                                    </script>
                                                @endpush
                                            @endif
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="namaWali">Nama Wali Murid</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="namaWali"
                                                        name="namaWali" placeholder="Masukan nama wali murid.."
                                                        value="{{ old('namaWali', $auths->siswa->namaWali) }}">
                                                    @error('namaWali')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="pekerjaanWali">Pekerjaan Wali
                                                    Murid</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="pekerjaanWali"
                                                        name="pekerjaanWali" placeholder="Masukan pekerjaan wali murid.."
                                                        value="{{ old('pekerjaanWali', $auths->siswa->pekerjaanWali) }}">
                                                    @error('pekerjaanWali')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="noTlpWali">Nomor Telepon Wali
                                                    Murid</label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control" id="noTlpWali"
                                                        name="noTlpWali" placeholder="Masukan nomor telepon wali murid.."
                                                        value="{{ old('noTlpWali', $auths->siswa->noTlpWali) }}">
                                                    @error('noTlpWali')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="alamatWali">Alamat Wali
                                                    Murid</label>
                                                <div class="col-sm-8">
                                                    <textarea type="date" class="form-control" id="alamatWali" rows="3" name="alamatWali"
                                                        placeholder="Masukan alamat tinggal wali murid..">{{ old('alamatWali', $auths->siswa->alamatWali) }}</textarea>
                                                    @error('alamatWali')
                                                        <div class="text-danger fs-sm">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="mb-4 float-end">
                                                <button type="submit" class="btn btn-alt-primary">
                                                    Simpan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const gambar = document.querySelector('#gambar');
            const imgPrev = document.querySelector('.img-preview');
            const oFReader = new FileReader();


            function prevImg() {

                imgPrev.style.display = 'block';

                oFReader.readAsDataURL(gambar.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPrev.src = oFREvent.target.result;
                }
            }
        </script>
    @endpush
@endsection
