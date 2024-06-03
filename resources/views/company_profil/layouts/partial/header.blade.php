<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $namaSD }} | {{ $title }}</title>

    <!-- Google Fonts -->
    <link
        href="{{ asset('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i') }}"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ $logoSD }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ $logoSD }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $logoSD }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/oneui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/ckeditor5-classic/build/ckeditor.css') }}">

    @stack('style')

    <style>
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

        .maps-container {
            width: 100%;
            display: flex;
        }

        .maps-container iframe {
            width: 100%;
            height: 200px;
        }

        .ck-content .image-style-align-left {
            margin-right: var(--ck-image-style-spacing);
        }

        .ck-content .image-style-align-right {
            margin-left: var(--ck-image-style-spacing);
        }

        .ck-content .image-style-side {
            margin-left: var(--ck-image-style-spacing);
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
                                <img src="{{ $logoSD }}" class="img-fluid" alt="logo SD" width="90">
                            </div>
                            <div class="col-sm-8 col-9 p-0 align-self-center">
                                <a href="{{ route('home') }}"
                                    class="navbar-brand py-auto d-inline-block text-lg-start text-center w-100">
                                    <h3 class="text-city fw-bold text-lg-nowrap text-wrap m-0 text-uppercase">
                                        {{ $namaSD }}<br>
                                        <p class="fw-semibold text-lg-nowrap text-wrap text-city-dark m-0 pt-2 text-uppercase"
                                            style="font-size: .8rem;">{{ $sloganSD }}</p>
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
                                        <a href="https://mail.google.com/mail/?view=cm&to={{ $emailSD }}"
                                            target="_blank" class="nav-link text-city-dark fw-semibold ">
                                            <i class="fa-solid fa-envelope text-city me-1"></i>
                                            <span class="d-none d-md-inline"
                                                style="font-size: .95rem;">{{ $emailSD }}</span>
                                        </a>
                                    </li>
                                    <div class="vr text-city" style="width: 2px;"></div>
                                    <li class="nav-main-item">
                                        <a href="#" class="nav-link text-city-dark fw-semibold">
                                            <i class="fa-solid fa-phone text-city me-1"></i>
                                            <span class="d-none d-md-inline"
                                                style="font-size: .95rem;">{{ $telpSD }}</span>
                                        </a>
                                    </li>
                                    <div class="vr text-city" style="width: 2px;"></div>
                                    <li class="nav-main-item">
                                        <a href="{{ $mapsLink }}" target="_blank"
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
                                    <a class="nav-main-link {{ Request::routeIs('berita', 'baca_berita') ? 'active' : '' }}"
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
                                        {{-- <li class="nav-main-item">
                                            <a class="nav-main-link" href="#">
                                                <span class="nav-main-link-name">Siswa</span>
                                            </a>
                                        </li> --}}
                                    </ul>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ Request::routeIs('kontak') ? 'active' : '' }}"
                                        href="{{ route('kontak') }}">
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
