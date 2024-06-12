<div class="col-lg-3 col-md-4 col-12 order-md-2 order-0">
    <div class="block block-rounded">
        <div class="block-header mb-1 pb-0">
            <div class="row mt-3 m-0 justify-content-center w-100">
                <div class="col-lg-8 col-6 mb-3">
                    <div class="ratio ratio-1x1">
                        @cannot('siswa')
                            @php
                                $pegawai = Auth::user()->pegawai;
                                $gambar = $pegawai->gambar
                                    ? (file_exists(public_path('storage/' . $pegawai->gambar))
                                        ? asset('storage/' . $pegawai->gambar)
                                        : asset('assets/media/avatars/avatar1.jpg'))
                                    : asset('assets/media/avatars/avatar1.jpg');
                            @endphp
                            <img id="gambar_pegawai" src="{{ $gambar }}" class="rounded-circle border border-5"
                                style="width: 100%; height: 100%; object-fit: cover" alt="" srcset="">
                            <div class="position-relative">
                                <div class="position-absolute bottom-0 end-0 translate-middle-x">
                                    <button type="button" id="edit_fotoProfil"
                                        class="btn btn-sm btn-primary rounded-circle" title="Ubah Foto Profil"><i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                </div>
                            </div>
                        @endcannot
                        @can('siswa')
                            <img src="{{ asset('assets/media/avatars/avatar1.jpg') }}"
                                class="rounded-circle border border-5" style="width: 100%; height: 100%; object-fit: cover"
                                alt="" srcset="">
                        @endcan
                    </div>
                </div>
                <div class="text-center">
                    <h5 class="fw-semibold mb-0" id="name_ppw">
                        @cannot('siswa')
                            {{ Auth::user()->pegawai->namaPegawai }}
                        @endcannot
                        @can('siswa')
                            {{ Auth::user()->siswa->namaSiswa }}
                        @endcan
                    </h5>
                    <p id="us_name" class="fw-medium mb-0"><span>@</span>{{ Auth::user()->username }}</p>
                    <p class="fw-normal text-muted">{{ Auth::user()->hakAkses }}</p>
                </div>
            </div>
        </div>
        <div class="block-content pt-0">
            <ul class="nav-main">
                {{-- profil menu --}}
                <li class="nav-main-item {{ Request::routeIs('profil_pengguna.index') ? 'bg-body-light' : '' }}">
                    <a class="nav-main-link {{ Request::routeIs('profil_pengguna.index') ? 'active' : '' }}"
                        href="{{ route('profil_pengguna.index') }}">
                        <i class="fa-solid fa-user me-2"></i>
                        <span class="nav-main-link-name">Profil</span>
                    </a>
                </li>
                {{-- edit profil menu --}}
                <li class="nav-main-item">
                    <a class="nav-main-link" id="btn_ubahprofil" href="javascript:void(0)"">
                        <i class="fa-solid fa-pen-to-square me-2"></i>
                        <span class="nav-main-link-name">Ubah profil</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" id="btn_changepassword" href="javascript:void(0)">
                        <i class="fa-solid fa-key me-2"></i>
                        <span class="nav-main-link-name">Ubah password</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
