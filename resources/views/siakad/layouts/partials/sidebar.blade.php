<nav id="sidebar" aria-label="Main Navigation" class="bg-city">
    {{-- Sidebar header --}}
    <div class="content-header bg-city p-0 shadow-sm">
        <a class="fw-bold text-dual" href="#">
            <span class="smini-visible d-inline">
                <img height="35" style="margin-left: .8rem;" src="{{ asset('assets/media/favicons/logo_sd.png') }}">
                {{-- <i class="fa-solid fa-book fs-2 text-info"></i> --}}
            </span>
            <span class="smini-hide tracking-wider fs-4 border-bottom border-2">SDN LEMAHBANG</span>
        </a>
        <a class="d-lg-none btn btn-sm ms-1 text-light" data-toggle="layout" data-action="sidebar_close"
            href="javascript:void(0)">
            <i class="fa fa-fw fa-times"></i>
        </a>
    </div>
    {{-- End Sidebar header --}}

    {{-- Sidebar menu --}}
    <div class="js-sidebar-scroll bg-dark bg-opacity-10">
        <div class="content-side">
            <ul class="nav-main">
                {{-- Dashboard menu --}}
                <li class="nav-main-item">
                    <a class="nav-main-link {{ Request::routeIs('beranda.index') ? 'active' : '' }}"
                        href="{{ route('beranda.index') }}">
                        <i class="nav-main-link-icon si si-grid"></i>
                        <span class="nav-main-link-name">Beranda</span>
                    </a>
                </li>
                @canany(['super.admin'])
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ $judul === 'Manajemen User' ? 'active' : '' }}"
                            href="{{ route('user.index') }}">
                            <i class="nav-main-link-icon si si-users"></i>
                            <span class="nav-main-link-name">Manajemen User</span>
                        </a>
                    </li>
                    <li class="nav-main-item {{ Request::routeIs('sekolah.index', 'pegawai.index', 'siswa.index') ? 'open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu {{ Request::routeIs('sekolah.index', 'pegawai.index', 'siswa.index') ? 'active' : '' }}"
                            data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="?#">
                            <i class="nav-main-link-icon si si-bulb"></i>
                            <span class="nav-main-link-name">Manajemen Sekolah</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item p-0">
                                <a class="nav-main-link {{ $sub_judul === 'Sekolah' ? 'active' : '' }}"
                                    href="{{ route('sekolah.index') }}">
                                    <span class="nav-main-link-name">Sekolah</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ Request::routeIs('pegawai.index') ? 'active' : '' }}"
                                    href="{{ route('pegawai.index') }}">
                                    <span class="nav-main-link-name">Pegawai</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $sub_judul === 'Siswa' ? 'active' : '' }}"
                                    href="{{ route('siswa.index') }}">
                                    <span class="nav-main-link-name">Siswa</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-heading">Company Profile</li>
                    <li class="nav-main-item {{ Request::routeIs('berita.index', 'tentang.index', 'profil.index', 'galeri.index', 'profil-guru.index','kontak.index', 'dokumentasi.index', 'pesan.index') ? 'open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu {{ Request::routeIs('berita.index', 'profil.index', 'tentang.index', 'galeri.index', 'profil-guru.index','kontak.index', 'dokumentasi.index', 'pesan.index') ? 'active' : '' }}"
                            data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                            <i class="nav-main-link-icon si si-wrench"></i>
                            <span class="nav-main-link-name">Profil Sekolah</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ Request::routeIs('berita.index') ? 'active' : '' }}"
                                    href="{{ route('berita.index') }}">
                                    <span class="nav-main-link-name">Berita</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ Request::routeIs('profil.index') ? 'active' : '' }}"
                                    href="{{ route('profil.index') }}">
                                    <span class="nav-main-link-name">Tentang Sekolah</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ Request::routeIs('dokumentasi.index') ? 'active' : '' }}"
                                    href="{{ route('dokumentasi.index') }}">
                                    <span class="nav-main-link-name">Dokumentasi</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ Request::routeIs('pesan.index') ? 'active' : '' }}"
                                    href="{{ route('pesan.index') }}">
                                    <span class="nav-main-link-name">Pesan Masuk</span>
                                </a>
                            </li>
                            {{-- <li class="nav-main-item">
                                <a class="nav-main-link {{ $sub_judul === 'Profil Guru' ? 'active' : '' }}"
                                    href="{{ route('profil-guru.index') }}">
                                    <span class="nav-main-link-name">Profil Guru</span>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                @endcanany
                <li class="nav-main-item {{ $judul === 'Manajemen Kelas' ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu {{ $judul === 'Manajemen Kelas' ? 'active' : '' }}"
                        data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon si si-briefcase"></i>
                        <span class="nav-main-link-name">
                            @php
                                $allowedRoles = ['Guru', 'Admin', 'Super Admin'];
                            @endphp

                            @if (in_array(Auth::user()->hakAkses, $allowedRoles))
                                Manajemen Kelas
                            @elseif (Auth::user()->hakAkses == 'Siswa')
                                Kelas
                            @endif
                        </span>
                    </a>
                    <ul class="nav-main-submenu">
                        @canany(['super.admin', 'admin'])
                            <li class="nav-main-item">
                                @php
                                    $routePeriode = Auth::user()->hakAkses == 'Super Admin' ? route('periode.index') : route('periode-admin.index');
                                @endphp

                                <a class="nav-main-link {{ $sub_judul === 'periode' ? 'active' : '' }}"
                                    href="{{ $routePeriode }}">
                                    <span class="nav-main-link-name">Periode</span>
                                </a>

                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routeKelas = Auth::user()->hakAkses == 'Super Admin' ? route('data-kelas.index') : route('data-kelas-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $sub_judul === 'data-kelas' ? 'active' : '' }}"
                                    href="{{ $routeKelas }}">
                                    <span class="nav-main-link-name">Data Kelas</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routeMapel = Auth::user()->hakAkses == 'Super Admin' ? route('mapel.index') : route('mapel-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $sub_judul === 'Mata Pelajaran' ? 'active' : '' }}"
                                    href="{{ $routeMapel }}">
                                    <span class="nav-main-link-name">Mata Pelajaran</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routePengajar = Auth::user()->hakAkses == 'Super Admin' ? route('pengajaran.index') : route('pengajaran-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $sub_judul === 'Pengajar' ? 'active' : '' }}"
                                    href="{{ $routePengajar }}">
                                    <span class="nav-main-link-name">Pengajar</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routeJadwal = Auth::user()->hakAkses == 'Super Admin' ? route('penjadwalan.index') : route('penjadwalan-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $sub_judul === 'penjadwalan' ? 'active' : '' }}"
                                    href="{{ $routeJadwal }}">
                                    <span class="nav-main-link-name">Jadwal Pelajaran</span>
                                </a>
                            </li>
                            @can('guru')
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $sub_judul === 'Penilaian' ? 'active' : '' }}"
                                        href="{{ route('penilaian.index') }}">
                                        <span class="nav-main-link-name">Penilaian Siswa
                                        </span>
                                    </a>
                                </li>
                            @endcan

                            <li class="nav-main-item">
                                @php
                                    $routeNilai = Auth::user()->hakAkses == 'Super Admin' ? route('penilaian.index') : route('penilaian-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $sub_judul === 'Penilaian' ? 'active' : '' }}"
                                    href="{{ $routeNilai }}">
                                    <span class="nav-main-link-name">Penilaian Siswa
                                    </span>
                                </a>
                            </li>
                        @endcanany
                        @can('siswa')
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $sub_judul === 'Jadwal' ? 'active' : '' }}"
                                    href="{{ route('jadwal.siswa') }}">
                                    <span class="nav-main-link-name">Jadwal</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $sub_judul === 'Penilaian' ? 'active' : '' }}"
                                    href="{{ route('penilaian.siswa') }}">
                                    <span class="nav-main-link-name">Nilai
                                    </span>
                                </a>
                            </li>
                        @endcan
                        @can('guru')
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $sub_judul === 'Jadwal' ? 'active' : '' }}"
                                    href="{{ route('jadwal.guru') }}">
                                    <span class="nav-main-link-name">Jadwal</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $sub_judul === 'Penilaian' ? 'active' : '' }}"
                                    href="{{ route('penilaian.guru') }}">
                                    <span class="nav-main-link-name">Penilaian Siswa
                                    </span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @cannot('siswa')
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('absensi.index') ? 'active' : '' }}"
                            href="{{ route('absensi.index') }}">
                            <i class="nav-main-link-icon si si-note"></i>
                            <span class="nav-main-link-name">Absensi</span>
                        </a>
                    </li>
                @endcannot
            </ul>
        </div>
    </div>
    {{-- End Sidebar menu --}}
</nav>
