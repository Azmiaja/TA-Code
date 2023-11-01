<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Sistem Informasi Akademik | {{ $title }}</title>
    <meta name="description"
        content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest  | This is the demo of OneUI! You need to purchase a license for legal use! | DEMO">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:title" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework | DEMO">
    <meta property="og:site_name" content="OneUI">
    <meta property="og:description"
        content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest  | This is the demo of OneUI! You need to purchase a license for legal use! | DEMO">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/dropzone/min/dropzone.min.css') }}">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9HQDQJJYW7"></script>
    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-9HQDQJJYW7');
    </script>
</head>

<body>
    <div id="page-container"
        class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        <nav id="sidebar" aria-label="Main Navigation">
            {{-- Sidebar header --}}
            <div class="content-header">
                <a class="fw-semibold text-dual" href="home">
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
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ $title === 'Home' ? 'active' : '' }}"
                                href="{{ route('home') }}">
                                <i class="nav-main-link-icon si si-home"></i>
                                <span class="nav-main-link-name">Home</span>
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
                                    <a class="nav-main-link {{ $title2 === 'pegawai' ? 'active' : '' }}"
                                        href="{{ route('muser.pegawai') }}">
                                        <span class="nav-main-link-name">Pegawai</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'siswa' ? 'active' : '' }}"
                                        href="{{ route('muser.siswa') }}">
                                        <span class="nav-main-link-name">Siswa</span>
                                    </a>
                                </li>
                            </ul>
                            {{-- End Sub menu manajemen user --}}
                        </li>
                        <li class="nav-main-item {{ $title === 'Manajemen Company' ? 'open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu {{ $title === 'Manajemen Company' ? 'active' : '' }}"
                                data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-grid"></i>
                                <span class="nav-main-link-name">Manajemen Company</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'profil' ? 'active' : '' }}"
                                        href="{{ route('mcompany.profil') }}">
                                        <span class="nav-main-link-name">Profil Sekolah</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'sejarah' ? 'active' : '' }}"
                                        href="{{ route('mcompany.sejarah') }}">
                                        <span class="nav-main-link-name">Sejarah</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'visimisi' ? 'active' : '' }}"
                                        href="{{ route('mcompany.visimisi') }}">
                                        <span class="nav-main-link-name">Visi Misi</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'berita' ? 'active' : '' }}"
                                        href="{{ route('mcompany.berita') }}">
                                        <span class="nav-main-link-name">Berita Sekolah</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item {{ $title === 'Manajemen Kelas' ? 'open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu {{ $title === 'Manajemen Kelas' ? 'active' : '' }}"
                                data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-briefcase"></i>
                                <span class="nav-main-link-name">Manajemen Kelas</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'bagiguru' ? 'active' : '' }}"
                                        href="{{ route('mkelas.bagiguru') }}">
                                        <span class="nav-main-link-name">Pembagian Guru</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'bagisiswa' ? 'active' : '' }}"
                                        href="{{ route('mkelas.bagisiswa') }}">
                                        <span class="nav-main-link-name">Pembagian Siswa</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'penjadwalan' ? 'active' : '' }}"
                                        href="{{ route('mkelas.penjadwalan') }}">
                                        <span class="nav-main-link-name">Penjadwalan Pelajaran</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'penugasan' ? 'active' : '' }}"
                                        href="{{ route('mkelas.penugasan') }}">
                                        <span class="nav-main-link-name">Penugasan Siswa</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'penilaian' ? 'active' : '' }}"
                                        href="{{ route('mkelas.penilaian') }}">
                                        <span class="nav-main-link-name">Penilaian Siswa</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'laporan' ? 'active' : '' }}"
                                        href="{{ route('mkelas.laporan') }}">
                                        <span class="nav-main-link-name">Laporan Nilai</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item {{ $title === 'Manajemen Keuangan' ? 'open' : '' }}">
                            <a class="nav-main-link nav-main-link-submenu {{ $title === 'Manajemen Keuangan' ? 'active' : '' }}"
                                data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-wallet"></i>
                                <span class="nav-main-link-name">Manajemen Keuangan</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'pemberitahuan' ? 'active' : '' }}"
                                        href="{{ route('mkeuangan.pemberitahuan') }}">
                                        <span class="nav-main-link-name">Pemberitahuan Pembayaran</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'laporan' ? 'active' : '' }}"
                                        href="{{ route('mkeuangan.laporan') }}">
                                        <span class="nav-main-link-name">Laporan Pembayaran</span>
                                    </a>
                                </li>
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
                            <span class="d-none d-sm-inline-block ms-2">Syahrul</span> {{-- Username --}}
                            <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                            aria-labelledby="page-header-user-dropdown">
                            <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                                <img class="img-avatar img-avatar48 img-avatar-thumb"
                                    src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
                                <p class="mt-2 mb-0 fw-medium">Syahrul Nur Hidayatullah</p> {{-- Nama Lengkap --}}
                                <p class="mb-0 text-muted fs-sm fw-medium">Super Admin</p> {{-- Role --}}
                            </div>
                            <div class="p-2">
                                <a class="dropdown-item d-flex align-items-center justify-content-between"
                                    href="be_pages_generic_profile.html">
                                    <span class="fs-sm fw-medium">Profile</span> {{-- Go to profile page --}}
                                    <span class="badge rounded-pill bg-primary ms-2">1</span>
                                </a>
                                <button class="dropdown-item d-flex align-items-center justify-content-between"
                                    data-bs-toggle="modal" data-bs-target="#logoutAlert"">
                                    <span class="fs-sm fw-medium">Log Out</span> {{-- To log out --}}
                                    <i class="si si-logout me-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- End Profile user --}}
                    <div class="dropdown d-inline-block ms-2">
                        {{-- Button notification --}}
                        <button type="button" class="btn btn-sm btn-alt-secondary"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-fw fa-bell"></i>
                            <span class="text-primary">•</span>
                        </button>
                        {{-- End Button notification --}}
                        {{-- Notification dropdown --}}
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 border-0 fs-sm"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-2 bg-body-light border-bottom text-center rounded-top">
                                {{-- Notification view --}}
                                <h5 class="dropdown-header text-uppercase">Notifications</h5>
                                {{-- End Notification view --}}
                            </div>
                            <div class="p-2 border-top text-center">
                                <a class="d-inline-block fw-medium" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-arrow-down me-1 opacity-50"></i> Load More..
                                </a>
                            </div>
                        </div>
                        {{-- End Notification dropdown --}}
                    </div>
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
                            <form action="/logout" method="post">
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
                        <a class="fw-semibold" href="home" target="_blank">SDN LEMAHBANG</a> &copy;
                        <span data-toggle="year-copy"></span>
                    </div>
                    <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">

                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_comp_calendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        One.helpersOnLoad(['jq-select2', 'jq-maxlength', 'js-ckeditor']);
    </script>
</body>

</html>
