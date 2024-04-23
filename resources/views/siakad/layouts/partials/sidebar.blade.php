<nav id="sidebar" aria-label="Main Navigation" class="" style="background-color: #004E8B;">
    {{-- Sidebar header --}}
    <div class="content-header p-0 shadow-sm" style="background-color: #004E8B;">
        <a class="fw-bold text-dual d-flex" href="#">
            @php
                use App\Models\Sekolah;
                use App\Models\Pengajaran;
                use App\Models\Periode;
                use App\Models\Kelas;
                $data = Sekolah::first();
            @endphp
            {{-- {{ $data->logo }} --}}
            <div class="smini-visible d-inline-block">
                <img height="45" style="margin-left: .35rem;"
                    src="{{ $data->logo ? asset('storage/' . $data->logo) : asset('assets/media/img/tut-wuri.png') }}">
            </div>
            <div class="row m-0 px-2 smini-hide tracking-wider fw-normal">
                <p class="p-0 m-0 fw-bold" style="padding: 0;">SIAKAD</p>
                <em class="p-0 m-0 fs-sm">SD Negeri Lemahbang</em>
            </div>
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
                    @canany(['super.admin', 'admin'])
                        <a class="nav-main-link {{ Request::routeIs('dashboard.index') ? 'active' : '' }}"
                            href="{{ route('dashboard.index') }}">
                            <i class="nav-main-link-icon si si-grid"></i>
                            <span class="nav-main-link-name">Dashboard</span>
                        </a>
                    @endcanany
                    @can('guru')
                        <a class="nav-main-link {{ Request::routeIs('gg.beranda.index') ? 'active' : '' }}"
                            href="{{ route('gg.beranda.index') }}">
                            <i class="nav-main-link-icon si si-home"></i>
                            <span class="nav-main-link-name">Beranda</span>
                        </a>
                    @endcan
                    @can('siswa')
                        <a class="nav-main-link {{ Request::routeIs('ss.beranda.index') ? 'active' : '' }}"
                            href="{{ route('ss.beranda.index') }}">
                            <i class="nav-main-link-icon si si-home"></i>
                            <span class="nav-main-link-name">Beranda</span>
                        </a>
                    @endcan
                </li>
                @can('siswa')
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('absen-siswa.index') ? 'active' : '' }}"
                            href="{{ route('absen-siswa.index') }}">
                            <i class="nav-main-link-icon si si-check"></i>
                            <span class="nav-main-link-name">Catatan Kehadiran</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('ss.beranda.index') ? 'active' : '' }}"
                            href="{{ route('ss.beranda.index') }}">
                            <i class="nav-main-link-icon si si-list"></i>
                            <span class="nav-main-link-name">Nilai</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('jadwal.siswa') ? 'active' : '' }}"
                            href="{{ route('jadwal.siswa') }}">
                            <i class="nav-main-link-icon si si-event"></i>
                            <span class="nav-main-link-name">Jadwal</span>
                        </a>
                    </li>
                @endcan
                @can('guru')
                    <li
                        class="nav-main-item {{ Request::routeIs('presensi.index', 'rekapitulasi.index', 'rekap.index') ? 'open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu {{ Request::routeIs('presensi.index', 'rekapitulasi.index', 'rekap.index') ? 'active' : '' }}"
                            data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="?#">
                            <i class="nav-main-link-icon si si-check"></i>
                            <span class="nav-main-link-name">Presensi Siswa</span>
                        </a>
                        @php
                            $periode = Periode::where('status', 'Aktif')->orderBy('tanggalMulai', 'desc')->first();
                            $kelas = Pengajaran::where('idPegawai', Auth::user()->pegawai->idPegawai)
                                ->where('idPeriode', $periode->idPeriode ?? '')
                                ->whereHas('kelas', function ($query) {
                                    $query->orderBy('namaKelas', 'asc');
                                })
                                ->with('kelas')
                                ->select('idKelas')
                                ->distinct()
                                ->get();
                            $pegawai = Kelas::where('idPegawai', Auth::user()->pegawai->idPegawai)
                                ->where('idPeriode', $periode->idPeriode)
                                ->first();
                        @endphp
                        <ul class="nav-main-submenu">
                            @if ($kelas)
                                <li class="nav-main-item p-0">
                                    @foreach ($kelas as $item)
                                        <a id="btn_side_kelas_{{ $item->idKelas }}"
                                            data-periode="{{ $item->kelas->idPeriode }}"
                                            data-kelas="{{ $item->kelas->namaKelas }}"
                                            class="nav-main-link {{ $item->idKelas === $s_idKelas ? 'active' : '' }}"
                                            href="{{ route('presensi.index', ['name' => $item->kelas->namaKelas]) }}">
                                            <span class="nav-main-link-name">Kelas {{ $item->kelas->namaKelas }}</span>
                                        </a>
                                    @endforeach
                                </li>
                            @endif
                            @if ($pegawai)
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ Request::routeIs('rekap.index') ? 'active' : '' }}"
                                        href="{{ route('rekap.index') }}">
                                        <span class="nav-main-link-name">Rekapitulasi</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('ss.beranda.index') ? 'active' : '' }}"
                            href="{{ route('ss.beranda.index') }}">
                            <i class="nav-main-link-icon si si-grid"></i>
                            <span class="nav-main-link-name">Kategori Nilai</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('ss.beranda.index') ? 'active' : '' }}"
                            href="{{ route('ss.beranda.index') }}">
                            <i class="nav-main-link-icon si si-list"></i>
                            <span class="nav-main-link-name">Penilaian</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('ss.beranda.index') ? 'active' : '' }}"
                            href="{{ route('ss.beranda.index') }}">
                            <i class="nav-main-link-icon si si-event"></i>
                            <span class="nav-main-link-name">Jadwal</span>
                        </a>
                    </li>
                @endcan
                @canany(['super.admin'])
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('user.index') ? 'active' : '' }}"
                            href="{{ route('user.index') }}">
                            <i class="nav-main-link-icon si si-users"></i>
                            <span class="nav-main-link-name">Pengguna</span>
                        </a>
                    </li>
                @endcanany
                @canany(['super.admin', 'admin'])
                    <li
                        class="nav-main-item {{ Request::routeIs('sekolah.index', 'pegawai.index', 'siswa.index', 'periode.index', 'kelas.index', 'mapel.index', 'pengajaran.index', 'penjadwalan.index', 'data_siswa.index') ? 'open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu {{ Request::routeIs('sekolah.index', 'pegawai.index', 'siswa.index', 'periode.index', 'kelas.index', 'mapel.index', 'pengajaran.index', 'penjadwalan.index', 'data_siswa.index') ? 'active' : '' }}"
                            data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="?#">
                            <i class="nav-main-link-icon si si-bulb"></i>
                            <span class="nav-main-link-name">Master Data</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item p-0">
                                <a class="nav-main-link {{ Request::routeIs('sekolah.index') ? 'active' : '' }}"
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
                                <a class="nav-main-link {{ Request::routeIs('siswa.index') ? 'active' : '' }}"
                                    href="{{ route('siswa.index') }}">
                                    <span class="nav-main-link-name">Siswa</span>
                                </a>
                            </li>
                            <li
                                class="nav-main-item {{ Request::routeIs('periode.index', 'kelas.index', 'data_siswa.index', 'mapel.index', 'pengajaran.index', 'penjadwalan.index') ? 'open' : '' }}">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                    aria-expanded="false" href="#">
                                    <span class="nav-main-link-name">Akademik</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ Request::routeIs('periode.index') ? 'active' : '' }}"
                                            href="{{ route('periode.index') }}">
                                            <span class="nav-main-link-name">Periode</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ Request::routeIs('mapel.index') ? 'active' : '' }}"
                                            href="{{ route('mapel.index') }}">
                                            <span class="nav-main-link-name">Mata Pelajaran</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ Request::routeIs('kelas.index') ? 'active' : '' }}"
                                            href="{{ route('kelas.index') }}">
                                            <span class="nav-main-link-name">Kelas</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ Request::routeIs('data_siswa.index') ? 'active' : '' }}"
                                            href="{{ route('data_siswa.index') }}">
                                            <span class="nav-main-link-name">Data Siswa</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ Request::routeIs('pengajaran.index') ? 'active' : '' }}"
                                            href="{{ route('pengajaran.index') }}">
                                            <span class="nav-main-link-name">Pengajar</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ Request::routeIs('penjadwalan.index') ? 'active' : '' }}"
                                            href="{{ route('penjadwalan.index') }}">
                                            <span class="nav-main-link-name">Penjadwalan</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-main-heading">Profil Sekolah</li>
                    <li
                        class="nav-main-item {{ Request::routeIs('berita.index', 'tentang.index', 'profil.index', 'galeri.index', 'profil-guru.index', 'kontak.index', 'dokumentasi.index', 'pesan.index') ? 'open' : '' }}">
                        <a class="nav-main-link nav-main-link-submenu {{ Request::routeIs('berita.index', 'profil.index', 'tentang.index', 'galeri.index', 'profil-guru.index', 'kontak.index', 'dokumentasi.index', 'pesan.index') ? 'active' : '' }}"
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
                        </ul>
                    </li>
                    <li class="nav-main-heading">Akademik</li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('re-presensi.index') ? 'active' : '' }}"
                            href="{{ route('re-presensi.index') }}">
                            <i class="nav-main-link-icon si si-note"></i>
                            <span class="nav-main-link-name">Presensi</span>
                        </a>
                    </li>
                @endcanany
                {{-- <li class="nav-main-item {{ $judul === 'Manajemen Kelas' ? 'open' : '' }}">
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
                                    $routePeriode =
                                        Auth::user()->hakAkses == 'Super Admin'
                                            ? route('periode.index')
                                            : route('periode-admin.index');
                                @endphp

                                <a class="nav-main-link {{ $sub_judul === 'periode' ? 'active' : '' }}"
                                    href="{{ $routePeriode }}">
                                    <span class="nav-main-link-name">Periode</span>
                                </a>

                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routeKelas =
                                        Auth::user()->hakAkses == 'Super Admin'
                                            ? route('kelas.index')
                                            : route('data-kelas-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $sub_judul === 'data-kelas' ? 'active' : '' }}"
                                    href="{{ $routeKelas }}">
                                    <span class="nav-main-link-name">Data Kelas</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routeMapel =
                                        Auth::user()->hakAkses == 'Super Admin'
                                            ? route('mapel.index')
                                            : route('mapel-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $sub_judul === 'Mata Pelajaran' ? 'active' : '' }}"
                                    href="{{ $routeMapel }}">
                                    <span class="nav-main-link-name">Mata Pelajaran</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routePengajar =
                                        Auth::user()->hakAkses == 'Super Admin'
                                            ? route('pengajaran.index')
                                            : route('pengajaran-admin.index');
                                @endphp
                                <a class="nav-main-link {{ $sub_judul === 'Pengajar' ? 'active' : '' }}"
                                    href="{{ $routePengajar }}">
                                    <span class="nav-main-link-name">Pengajar</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                @php
                                    $routeJadwal =
                                        Auth::user()->hakAkses == 'Super Admin'
                                            ? route('penjadwalan.index')
                                            : route('penjadwalan-admin.index');
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
                                    $routeNilai =
                                        Auth::user()->hakAkses == 'Super Admin'
                                            ? route('penilaian.index')
                                            : route('penilaian-admin.index');
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
                </li> --}}
            </ul>
        </div>
    </div>
    {{-- End Sidebar menu --}}
</nav>
