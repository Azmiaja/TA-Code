<div class="col-lg-3 col-md-4 col-12 order-md-2 order-0">
    <div class="block block-rounded">
        <div class="block-header mb-1 pb-0">
            <div class="row mt-3 m-0 justify-content-center w-100">
                <div class="col-lg-8 col-6 mb-3">
                    <div class="ratio ratio-1x1">
                        <img src="{{ asset('storage/' . Auth::user()->pegawai->gambar) }}"
                            class="rounded-circle border border-5" style="width: 100%; height: 100%; object-fit: cover"
                            alt="" srcset="">
                    </div>
                </div>
                <div class="text-center">
                    <h5 class="fw-semibold mb-0">{{ Auth::user()->pegawai->namaPegawai }}</h5>
                    <p class="fw-medium mb-0"><span>@</span>{{ Auth::user()->username }}</p>
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
                <li class="nav-main-item {{ Request::routeIs('profil_pengguna.edit') ? 'bg-body-light' : '' }}">
                    <a class="nav-main-link {{ Request::routeIs('profil_pengguna.edit') ? 'active' : '' }}"
                        href="{{ route('profil_pengguna.edit') }}">
                        <i class="fa-solid fa-pen-to-square me-2"></i>
                        <span class="nav-main-link-name">Edit profil</span>
                    </a>
                </li>
                <li class="nav-main-item {{ Request::routeIs('profil_pengguna.chpassword') ? 'bg-body-light' : '' }}">
                    <a class="nav-main-link {{ Request::routeIs('profil_pengguna.chpassword') ? 'active' : '' }}"
                        href="{{ route('profil_pengguna.chpassword') }}">
                        <i class="fa-solid fa-key me-2"></i>
                        <span class="nav-main-link-name">Ubah password</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
