<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/oneui.min.css') }}">

    <link href="{{ asset('assets/css/carousel.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">

    <style>
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
            border: solid rgba(0, 0, 0, .15);
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
    </style>

    <script src="{{ asset('assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
</head>

<body class="m-0 p-0">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container">
                <a class="navbar-brand fw-medium" href="#">SDN Lemahbang</a>
                {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}
                <div class="navbar">
                    <ul class="navbar-nav ms-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            @if ($title !== 'Berita Sekolah')
                                <a class="btn btn-lg btn-outline-secondary nav-link link-light " aria-current="page"
                                    href="login">
                                    <i class="fa-solid fa-right-to-bracket me-2 opacity-50"></i>
                                    <span class="text-login">Login</span>
                                </a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('landing')
    </main>

    <!-- FOOTER -->
    <footer id="page-footer" class="container-fluid">
        <div class="container py-3">
            <div class="row fs-sm">
                <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end float-end">
                     <a class="fw-semibold" href="#">Back to top</a>
                </div>
                <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                    <a class="fw-semibold" href="{{ route('landingpage') }}" target="_blank">SDN Lemahbang</a> &copy;
                    <span data-toggle="year-copy">2023</span>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
