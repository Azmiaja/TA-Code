<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Informasi Akademik | {{ $title }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/js/plugins/fullcalendar/main.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/themes/material_red.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-9HQDQJJYW7"></script> --}}

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-9HQDQJJYW7');
    </script>
    <style>
        .ellipse {
            /* width: 300px; */
            display: -webkit-box;
            -webkit-line-clamp: 6;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }
    </style>
    @stack('style')

    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
</head>

<body>

    {{-- --------------------------- CONTENT ------------------------------------------------ --}}
    <div id="page-container"
        class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        <nav id="sidebar" aria-label="Main Navigation">
            {{-- Sidebar header --}}
            <div class="content-header">
                <a class="fw-semibold text-dual" href="#">
                    <span class="smini-visible" style="padding-top: 1.25rem;">
                        <img style="height: 35px; padding-left: .8rem;"
                            src="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
                    </span>
                    <span class="smini-hide fs-4 fw-bold tracking-wider"
                        style="padding-left: 1.25rem;">SIAKAD</span><br>
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
                                <a class="nav-main-link nav-main-link-submenu {{ $title === 'Manajemen Sekolah' ? 'active' : '' }}"
                                    data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                    <i class="nav-main-link-icon si si-bulb"></i>
                                    <span class="nav-main-link-name">Manajemen Sekolah</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ $title2 === 'Sekolah' ? 'active' : '' }}"
                                            href="{{ route('pegawai.index') }}">
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
                            <li class="nav-main-item">
                                <a class="nav-main-link {{ $title === 'Manajemen User' ? 'active' : '' }}"
                                    href="{{ route('user.index') }}">
                                    <i class="nav-main-link-icon si si-users"></i>
                                    <span class="nav-main-link-name">Manajemen User</span>
                                </a>
                            </li>
                            <li class="nav-main-item {{ $title === 'Manajemen User' ? 'open' : '' }}">
                                <a class="nav-main-link nav-main-link-submenu {{ $title === 'Manajemen User' ? 'active' : '' }}"
                                    data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="?#">
                                    <i class="nav-main-link-icon si si-users"></i>
                                    <span class="nav-main-link-name">Manajemen User</span>
                                </a>
                                {{-- Sub menu manajemen user --}}
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link {{ $title2 === 'Data User' ? 'active' : '' }}"
                                            href="{{ route('user.index') }}">
                                            <span class="nav-main-link-name">Data User</span>
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
                                {{-- End Sub menu manajemen user --}}
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
                    </ul>
                </div>
            </div>
            {{-- End Sidebar menu --}}
        </nav>
        {{-- Header --}}
        <header id="page-header">
            <div class="content-header">
                {{-- Button sidebar --}}
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none" data-toggle="layout"
                        data-action="sidebar_toggle">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-none d-lg-inline-block"
                        data-toggle="layout" data-action="sidebar_mini_toggle">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>
                {{-- End Button sidebar --}}
                <div class="d-flex align-items-center">
                    {{-- Profile user --}}
                    <div class="dropdown d-inline-block ms-2">
                        <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center"
                            id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="rounded-circle" src="{{ asset('assets/media/avatars/avatar10.jpg') }}"
                                alt="Header Avatar" style="width: 21px;">
                            <span class="d-none d-sm-inline-block ms-2">{{ Auth::user()->username }}</span>
                            {{-- Username --}}
                            <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                            aria-labelledby="page-header-user-dropdown">
                            <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                                <img class="img-avatar img-avatar48 img-avatar-thumb"
                                    src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                <p class="mt-2 mb-0 fw-medium" id="HD_idSiswa"
                                    data-id-siswa={{ Auth::user()->idSiswa }}>
                                    @if (Auth::user()->hakAkses == 'Guru' || Auth::user()->hakAkses == 'Admin' || Auth::user()->hakAkses == 'Super Admin')
                                        {{ ucwords(Auth::user()->pegawai->namaPegawai) }}
                                    @elseif (Auth::user()->hakAkses == 'Siswa')
                                        {{ Auth::user()->namaSiswa }}
                                    @endif
                                </p> {{-- Nama Lengkap --}}
                                <p class="mb-0
                                            text-muted fs-sm fw-medium">
                                    {{ Auth::user()->hakAkses }}</p>
                                {{-- Role --}}
                            </div>
                            <div class="p-2">
                                <button class="dropdown-item d-flex align-items-center justify-content-between"
                                    data-bs-toggle="modal" data-bs-target="#logoutAlert">
                                    <span class="fs-sm fw-medium">Log Out</span> {{-- To log out --}}
                                    <i class="si si-logout me-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- End Profile user --}}
                </div>
            </div>
        </header>
        {{-- End Header --}}
        <main id="main-container">
            <!-- Content -->
            @yield('content')
            <!-- End Content -->
        </main>

        <footer id="page-footer" class="bg-body-light">
            {{-- modal konfirmasi logout --}}
            <div class="modal fade" id="logoutAlert" tabindex="-1" aria-labelledby="logoutModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin logout?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="content py-3">
                <div class="row fs-sm">
                    <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                        <a class="fw-semibold" href="#" target="_blank">SDN LEMAHBANG</a> &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                    </div>
                    <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">

                    </div>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')

    <script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ckeditor5-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>

    <script>
        One.helpersOnLoad(['js-ckeditor5', 'js-flatpickr']);
    </script>
</body>

</html>
