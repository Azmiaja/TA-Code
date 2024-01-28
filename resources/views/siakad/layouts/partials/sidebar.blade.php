<nav id="sidebar" aria-label="Main Navigation">
    {{-- Sidebar header --}}
    <div class="content-header">
        <a class="fw-semibold text-dual" href="#">
            <span class="smini-visible" style="padding-top: 1.25rem;">
                <img style="height: 35px; padding-left: .8rem;"
                    src="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
            </span>
            <span class="smini-hide fs-4 fw-bold tracking-wider" style="padding-left: 1.25rem;">SIAKAD</span><br>
            <small class="smini-hide tracking-wider" style="padding-left: 1.25rem;">SDN Lemahbang</small>
        </a>
        <a class="d-lg-none btn btn-sm ms-1 text-light" data-toggle="layout" data-action="sidebar_close"
            href="javascript:void(0)">
            <i class="fa fa-fw fa-times"></i>
        </a>
    </div>
    {{-- End Sidebar header --}}

    {{-- Sidebar menu --}}
    <div class="js-sidebar-scroll">
        <div class="content-side">
            <ul class="nav-main">
                {{-- Dashboard menu --}}
                <li class="nav-main-item">
                    <a class="nav-main-link {{ $title === 'Dashboard' ? 'active' : '' }}"
                        href="{{ route('dashboard.index') }}">
                        <i class="nav-main-link-icon si si-grid"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                    </a>
                </li>
                @canany(['super.admin'])
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ $title === 'Manajemen User' ? 'active' : '' }}"
                            href="{{ route('user.index') }}">
                            <i class="nav-main-link-icon si si-users"></i>
                            <span class="nav-main-link-name">Manajemen User</span>
                        </a>
                    </li>
                    <li class="nav-main-item {{ $title === 'Manajemen Sekolah' ? 'open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu {{ $title === 'Manajemen Sekolah' ? 'active' : '' }}"
                            data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="?#">
                            <i class="nav-main-link-icon si si-bulb"></i>
                            <span class="nav-main-link-name">Manajemen Sekolah</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item p-0">
                                <a class="nav-main-link {{ $title2 === 'Sekolah' ? 'active' : '' }}"
                                    href="{{ route('sekolah.index') }}">
                                    <span class="nav-main-link-name">Sekolah</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $title2 === 'Pegawai' ? 'active' : '' }}"
                                    href="{{ route('pegawai.index') }}">
                                    <span class="nav-main-link-name">Pegawai</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $title2 === 'Siswa' ? 'active' : '' }}"
                                    href="{{ route('siswa.index') }}">
                                    <span class="nav-main-link-name">Siswa</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item {{ $title === 'Company Profil' ? 'open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu {{ $title === 'Company Profil' ? 'active' : '' }}"
                            data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                            <i class="nav-main-link-icon si si-wrench"></i>
                            <span class="nav-main-link-name">Company Profil</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $title2 === 'profil' ? 'active' : '' }}"
                                    href="{{ route('profil.index') }}">
                                    <span class="nav-main-link-name">Profil Sekolah</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $title2 === 'Profil Guru' ? 'active' : '' }}"
                                    href="{{ route('profil-guru.index') }}">
                                    <span class="nav-main-link-name">Profil Guru</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $title2 === 'berita' ? 'active' : '' }}"
                                    href="{{ route('berita.index') }}">
                                    <span class="nav-main-link-name">Berita Sekolah</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcanany
                <li class="nav-main-item {{ $title === 'Manajemen Kelas' ? 'open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu {{ $title === 'Manajemen Kelas' ? 'active' : '' }}"
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

                                <a class="nav-main-link {{ $title2 === 'periode' ? 'active' : '' }}"
                                    href="{{ $routePeriode }}">
                                    <span class="nav-main-link-name">Periode</span>
                                </a>

                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routeKelas = Auth::user()->hakAkses == 'Super Admin' ? route('data-kelas.index') : route('data-kelas-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $title2 === 'data-kelas' ? 'active' : '' }}"
                                    href="{{ $routeKelas }}">
                                    <span class="nav-main-link-name">Data Kelas</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routeMapel = Auth::user()->hakAkses == 'Super Admin' ? route('mapel.index') : route('mapel-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $title2 === 'Mata Pelajaran' ? 'active' : '' }}"
                                    href="{{ $routeMapel }}">
                                    <span class="nav-main-link-name">Mata Pelajaran</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routePengajar = Auth::user()->hakAkses == 'Super Admin' ? route('pengajaran.index') : route('pengajaran-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $title2 === 'Pengajar' ? 'active' : '' }}"
                                    href="{{ $routePengajar }}">
                                    <span class="nav-main-link-name">Pengajar</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routeJadwal = Auth::user()->hakAkses == 'Super Admin' ? route('penjadwalan.index') : route('penjadwalan-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $title2 === 'penjadwalan' ? 'active' : '' }}"
                                    href="{{ $routeJadwal }}">
                                    <span class="nav-main-link-name">Jadwal Pelajaran</span>
                                </a>
                            </li>
                            @can('guru')
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'Penilaian' ? 'active' : '' }}"
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
                                <a class="nav-main-link {{ $title2 === 'Penilaian' ? 'active' : '' }}"
                                    href="{{ $routeNilai }}">
                                    <span class="nav-main-link-name">Penilaian Siswa
                                    </span>
                                </a>
                            </li>
                        @endcanany
                        @can('siswa')
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $title2 === 'Jadwal' ? 'active' : '' }}"
                                    href="{{ route('jadwal.siswa') }}">
                                    <span class="nav-main-link-name">Jadwal</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $title2 === 'Penilaian' ? 'active' : '' }}"
                                    href="{{ route('penilaian.siswa') }}">
                                    <span class="nav-main-link-name">Nilai
                                    </span>
                                </a>
                            </li>
                        @endcan
                        @can('guru')
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $title2 === 'Jadwal' ? 'active' : '' }}"
                                    href="{{ route('jadwal.guru') }}">
                                    <span class="nav-main-link-name">Jadwal</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $title2 === 'Penilaian' ? 'active' : '' }}"
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
                        <a class="nav-main-link {{ $title === 'Absensi' ? 'active' : '' }}"
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
