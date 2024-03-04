@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="row g-3">
            @include('siakad/content/profil_user/profil-menu')
            <div class="col-lg-9 col-md-8 col-12 order-md-1 order-0">
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
                                    <div class="row mb-4">
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
                        <form action="{{ route('profil_pengguna.update.biografi', ['id' => $auth->idPegawai]) }}"
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
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label" for="nip">NIP</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="nip" name="nip"
                                                placeholder="Masukan nip.." value="{{ old('nip', $auth->nip) }}">
                                            @error('nip')
                                                <div class="text-danger fs-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label" for="namaPegawai">Nama Lengkap</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="namaPegawai" name="namaPegawai"
                                                placeholder="Masukan nama lengkap.."
                                                value="{{ old('namaPegawai', $auth->namaPegawai) }}">
                                            @error('namaPegawai')
                                                <div class="text-danger fs-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label" for="tempatLahir">Tempat Lahir</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="tempatLahir" name="tempatLahir"
                                                placeholder="Masukan tempat lahir.."
                                                value="{{ old('tempatLahir', $auth->tempatLahir) }}">
                                            @error('tempatLahir')
                                                <div class="text-danger fs-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label" for="tanggalLahir">Tanggal Lahir</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="tanggalLahir"
                                                name="tanggalLahir" placeholder="Masukan tanggal lahir.."
                                                value="{{ old('tanggalLahir', $auth->tanggalLahir) }}">
                                            @error('tanggalLahir')
                                                <div class="text-danger fs-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label" for="jenisKelamin">Jenis Kelamin</label>
                                        <div class="col-sm-8">
                                            <select name="jenisKelamin" id="jenisKelamin" class="form-select">
                                                <option disabled selected value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="Laki-Laki"
                                                    {{ $auth->jenisKelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki
                                                </option>
                                                <option value="Perempuan"
                                                    {{ $auth->jenisKelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                                </option>
                                            </select>
                                            @error('jenisKelamin')
                                                <div class="text-danger fs-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label" for="agama">Agama</label>
                                        <div class="col-sm-8">
                                            <select name="agama" id="agama" class="form-select">
                                                <option disabled selected value="">-- Pilih Agama --</option>
                                                <option value="Islam" {{ $auth->agama == 'Islam' ? 'selected' : '' }}>
                                                    Islam
                                                </option>
                                                <option value="Kristen" {{ $auth->agama == 'Kristen' ? 'selected' : '' }}>
                                                    Kristen
                                                </option>
                                                <option value="Katolik" {{ $auth->agama == 'Katolik' ? 'selected' : '' }}>
                                                    Katolik
                                                </option>
                                                <option value="Hindu" {{ $auth->agama == 'Hindu' ? 'selected' : '' }}>
                                                    Hindu
                                                </option>
                                                <option value="Budha" {{ $auth->agama == 'Budha' ? 'selected' : '' }}>
                                                    Budha
                                                </option>
                                            </select>
                                            @error('agama')
                                                <div class="text-danger fs-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label" for="noHp">Telepon</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="noHp" name="noHp"
                                                placeholder="Masukan nomor telepon.."
                                                value="{{ old('noHp', $auth->noHp) }}">
                                            @error('noHp')
                                                <div class="text-danger fs-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label" for="alamat">Alamat</label>
                                        <div class="col-sm-8">
                                            <textarea type="date" class="form-control" id="alamat" rows="3" name="alamat"
                                                placeholder="Masukan alamat tinggal..">{{ old('alamat', $auth->alamat) }}</textarea>
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
                                                <img src="{{ asset('storage/' . $auth->gambar) }}" class="img-preview rounded"
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
