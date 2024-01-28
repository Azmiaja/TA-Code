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
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .ellipse-2 {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }

        .zoom-effect {
            position: relative;
        }

        .zoom-effect img {
            transition: transform 0.5s ease;
            opacity: 1;
        }

        .zoom-effect:hover img {
            transform: scale(1.08);
            opacity: 0.7;
        }

        .red-effect {
            color: black;
            transition: color 0.2s ease;
        }

        .red-effect:hover {
            color: red;
        }

        .tx-effect {
            color: rgb(255, 255, 255);
            transition: color 0.2s ease;
        }

        .tx-effect:hover {
            color: rgb(206, 206, 206);
        }

        .img-opz {
            opacity: 50%;
            transition: 0.5s ease;
        }

        .img-opz:hover {
            opacity: 100%;
        }

        #hero {
            width: 100%;
            height: 100vh;
            background-size: cover;
            position: relative;
            padding-top: 82px;
        }
    </style>

</head>

<body class="m-0 p-0">
    <nav class="navbar navbar-expand-lg sticky-top navbar-dark py-3 bg-secondary">
        <div class="container">
            <a class="fw-semibold fs-4 tracking-wider text-light me-3" href="#">SDN LEMAHBANG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myList"
                aria-controls="myList" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- List of links -->
            <div class="collapse navbar-collapse" id="myList">
                <ul class="navbar-nav ms-auto gap-3">
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
                        <ul class="dropdown-menu dropdown-menu bg-secondary">
                            <li><a class="nav-link" href="#">Profil</a></li>
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
    </nav>
    <!-- End Header -->
