<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDN Lemahbang</title>

    <!-- Google Fonts -->
    <link
        href="{{ asset('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i') }}"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    {{-- <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"> --}}
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/oneui.css') }}">

    @stack('style')

    <style>
        .opacity-50 {
            opacity: 0.50 !important;
        }

        .object-fit-cover {
            -o-object-fit: cover !important;
            object-fit: cover !important;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        @media (max-width: 500px) {
            .text-login {
                display: none;
            }

        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            : solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }

        .ellipse {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .ellipse-two {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .ellipse-tree {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .ellipse-multi {
            display: -webkit-box;
            -webkit-line-clamp: 10;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .text-justify {
            text-align: justify;
            text-justify: inter-word;
        }

        .nav-main-dark .nav-main-link,
        .sidebar-dark #sidebar .nav-main-link,
        .page-header-dark #page-header .nav-main-link {
            color: #ced4da;
        }

        .nav-main-dark .nav-main-link:hover,
        .nav-main-dark .nav-main-link:focus,
        .sidebar-dark #sidebar .nav-main-link:hover,
        .sidebar-dark #sidebar .nav-main-link:focus,
        .page-header-dark #page-header .nav-main-link:hover,
        .page-header-dark #page-header .nav-main-link:focus {
            color: #fff;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .nav-main-dark .nav-main-submenu .nav-main-link,
        .sidebar-dark #sidebar .nav-main-submenu .nav-main-link,
        .page-header-dark #page-header .nav-main-submenu .nav-main-link {
            color: #ced4da;
        }

        @media (min-width: 992px) {

            .nav-main-dark.nav-main-horizontal .nav-main-submenu,
            .sidebar-dark #sidebar .nav-main-horizontal .nav-main-submenu,
            .page-header-dark #page-header .nav-main-horizontal .nav-main-submenu {
                background-color: #db3954 !important;
                box-shadow: none;
            }

            .nav-main-dark.nav-main-horizontal.nav-main-hover .nav-main-item:hover>.nav-main-link-submenu,
            .sidebar-dark #sidebar .nav-main-horizontal.nav-main-hover .nav-main-item:hover>.nav-main-link-submenu,
            .page-header-dark #page-header .nav-main-horizontal.nav-main-hover .nav-main-item:hover>.nav-main-link-submenu {
                color: #fff;
            }

            .nav-main-dark.nav-main-horizontal.nav-main-hover .nav-main-item:hover>.nav-main-link-submenu>.nav-main-link-icon,
            .sidebar-dark #sidebar .nav-main-horizontal.nav-main-hover .nav-main-item:hover>.nav-main-link-submenu>.nav-main-link-icon,
            .page-header-dark #page-header .nav-main-horizontal.nav-main-hover .nav-main-item:hover>.nav-main-link-submenu>.nav-main-link-icon {
                color: #fff;
            }

            .nav-main-dark.nav-main-horizontal.nav-main-hover .nav-main-submenu .nav-main-item:hover .nav-main-link,
            .sidebar-dark #sidebar .nav-main-horizontal.nav-main-hover .nav-main-submenu .nav-main-item:hover .nav-main-link,
            .page-header-dark #page-header .nav-main-horizontal.nav-main-hover .nav-main-submenu .nav-main-item:hover .nav-main-link {
                background-color: transparent;
            }
        }

        @media (max-width: 1200px) {
            .change-size {
                font-size: 1rem;
            }

            .img-size {
                width: 144px;
                height: 144px;
            }

            .img-size-side {
                width: 144px;
                height: 144px;
            }
        }

        @media (min-width: 995px) {
            .change-size {
                font-size: .8rem;
            }

            .img-size {
                width: 80px;
                height: 80px;
            }

            .img-size-side {
                width: 80px;
                height: 80px;
            }
        }

        @media (max-width: 450px) {
            .change-size {
                font-size: .6rem;
            }

            .img-size {
                width: 100px;
                height: 100px;
            }

            .img-size-side {
                width: 100px;
                height: 100px;
            }
        }

        .line-lv1 {
            width: 100%;
            height: 4px;
        }

        .line-lv2 {
            width: 100%;
            height: 4px;
        }

        .portrait-content {
            aspect-ratio: 3/4;
            width: 100%;
        }
    </style>

</head>

<body class="m-0 p-0">
    <div id="page-container" class="page-header">
        <header class="header py-4 bg-gray-lighter">
            <div class="container p-md-0">
                <div class="row m-0">
                    <div class="col-lg-6 col-12 p-0">
                        <div class="row m-0">
                            <div class="col-sm-2 col-3 p-0">
                                <!-- Logo -->
                                <img src="{{ asset('assets/media/favicons/logo_sd.png') }}" class="img-fluid"
                                    alt="logo SD" width="80">
                            </div>
                            <div class="col-sm-8 col-9 p-0 align-self-center">
                                <a href="#"
                                    class="navbar-brand py-auto d-inline-block text-lg-start text-center w-100">
                                    <h3 class="text-city fw-bold text-lg-nowrap text-wrap m-0">SD NEGERI
                                        LEMAHBANG<br>
                                        <p class="fw-semibold text-lg-nowrap text-wrap text-city-dark m-0 pt-2"
                                            style="font-size: .8rem;">SEDAN ABANG JAYA</p>
                                    </h3>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 p-0 ">
                        <div class="row m-0 h-100 align-items-center">
                            <div class="p-0 m-0">
                                <ul class="nav-main d-flex m-0 justify-content-center justify-content-lg-end gap-4">
                                    <li class="nav-main-item">
                                        <a href="https://mail.google.com/mail/?view=cm&to=sdnlemahbang@yahoo.co.id"
                                            target="_blank" class="nav-link text-city-dark fw-semibold ">
                                            <i class="fa-solid fa-envelope text-city me-1"></i>
                                            <span class="d-none d-md-inline"
                                                style="font-size: .95rem;">sdnlemahbang@yahoo.co.id</span>
                                        </a>
                                    </li>
                                    <div class="vr text-city" style="width: 2px;"></div>
                                    <li class="nav-main-item">
                                        <a href="#" class="nav-link text-city-dark fw-semibold">
                                            <i class="fa-solid fa-phone text-city me-1"></i>
                                            <span class="d-none d-md-inline"
                                                style="font-size: .95rem;">085855477650</span>
                                        </a>
                                    </li>
                                    <div class="vr text-city" style="width: 2px;"></div>
                                    <li class="nav-main-item">
                                        <a href="https://maps.app.goo.gl/SMZRCAUbTwKY6ihq5" target="_blank"
                                            class="nav-link text-city-dark fw-semibold">
                                            <i class="fa-solid fa-location-dot text-city me-1"></i>
                                            <span class="d-none d-md-inline" style="font-size: .95rem;">Lokasi</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main id="main-container">
            <div class="bg-city sticky-top shadow-sm">
                <div class="bg-black-10">
                    <div class="container py-3">
                        <!-- Toggle Main Navigation -->
                        <div class="d-lg-none">
                            <!-- Class Toggle, functionality initialized in Helpers.oneToggleClass() -->
                            <button type="button"
                                class="btn w-100 btn-alt-secondary d-flex justify-content-between align-items-center"
                                data-toggle="class-toggle" data-target="#navigasi" data-class="d-none">
                                Menu
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <!-- END Toggle Main Navigation -->

                        <!-- Main Navigation -->
                        <div id="navigasi" class="d-none d-lg-block mt-2 mt-lg-0">
                            <ul class="nav-main nav-main-dark nav-main-horizontal nav-main-hover gap-3">
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ Request::routeIs('home') ? 'active' : '' }}"
                                        href="{{ route('home') }}">
                                        <span class="nav-main-link-name">Beranda</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ Request::routeIs('berita') ? 'active' : '' }}"
                                        href="{{ route('berita') }}">
                                        <span class="nav-main-link-name">Berita</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link nav-main-link-submenu {{ Request::routeIs(['profil', 'sejarah', 'visi_misi', 'struktur_org', 'keuangan']) ? 'active' : '' }}"
                                        data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                                        <span class="nav-main-link-name">Tentang</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link {{ Request::routeIs('profil') ? 'active' : '' }}"
                                                href="{{ route('profil') }}">
                                                <span class="nav-main-link-name">Profil</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link {{ Request::routeIs('sejarah') ? 'active' : '' }}"
                                                href="{{ route('sejarah') }}">
                                                <span class="nav-main-link-name">Sejarah</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link {{ Request::routeIs('visi_misi') ? 'active' : '' }}"
                                                href="{{ route('visi_misi') }}">
                                                <span class="nav-main-link-name">Visi dan Misi</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link {{ Request::routeIs('struktur_org') ? 'active' : '' }}"
                                                href="{{ route('struktur_org') }}">
                                                <span class="nav-main-link-name">Struktur Organisasi</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link {{ Request::routeIs('keuangan') ? 'active' : '' }}"
                                                href="{{ route('keuangan') }}">
                                                <span class="nav-main-link-name">Keuangan</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link nav-main-link-submenu {{ Request::routeIs(['galeri_foto', 'galeri_video']) ? 'active' : '' }}"
                                        data-toggle="submenu" aria-haspopup="true" aria-expanded="true"
                                        href="#">
                                        <span class="nav-main-link-name">Galeri</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link {{ Request::routeIs('galeri_foto') ? 'active' : '' }}"
                                                href="{{ route('galeri_foto') }}">
                                                <span class="nav-main-link-name">Foto</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link {{ Request::routeIs('galeri_video') ? 'active' : '' }}"
                                                href="{{ route('galeri_video') }}">
                                                <span class="nav-main-link-name">Video</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link nav-main-link-submenu {{ Request::routeIs(['kt_guru']) ? 'active' : '' }}"
                                        data-toggle="submenu" aria-haspopup="true" aria-expanded="true"
                                        href="#">
                                        <span class="nav-main-link-name">Kategori</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link {{ Request::routeIs('kt_guru') ? 'active' : '' }}"
                                                href="{{ route('kt_guru') }}">
                                                <span class="nav-main-link-name">Guru</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="#">
                                                <span class="nav-main-link-name">Siswa</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ Request::routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">
                                        <span class="nav-main-link-name">Hubungi Kami</span>
                                    </a>
                                </li>
                                <li class="nav-main-item ms-auto">
                                    <a class="nav-main-link" href="{{ route('login') }}">
                                        <i class="fa-solid fa-right-to-bracket me-1"></i>
                                        <span class="nav-main-link-name">Login</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- END Main Navigation -->
                    </div>
                </div>
            </div>
            {{-- <nav class="navbar navbar-expand-lg navbar-dark sticky-top py-1 bg-modern">
        <div class="container p-md-0">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myList"
                aria-controls="myList" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- List of links -->
            <div class="collapse navbar-collapse" id="myList">
                <ul class="navbar-nav gap-2 ">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Berita</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Tentang
                        </a>
                        <ul class="dropdown-menu dropdown-menu rounded-0 border-0 p-0">
                            <li><a class="nav-link py-0" href="#">Profil</a></li>
                            <li><a class="nav-link" href="#">Sejarah</a></li>
                            <li><a class="nav-link" href="#">Visi dan Misi</a></li>
                            <li><a class="nav-link" href="#">Struktur Organisasi</a></li>
                            <li><a class="nav-link" href="#">Keuangan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Galeri
                        </a>
                        <ul class="dropdown-menu dropdown-menu bg-secondary">
                            <li><a class="nav-link" href="#">Foto</a></li>
                            <li><a class="nav-link" href="#">Video</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu dropdown-menu bg-secondary">
                            <li><a class="nav-link" href="#">Guru</a></li>
                            <li><a class="nav-link" href="#">Siswa</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Hubungi Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> --}}

            <!-- End Header -->
