<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>SDN Lemahbang</title>
    <link rel="shortcut icon" href="assets/media/favicons/logo-tutwuri.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/logo-tutwuri">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/logo-tutwuri.png">
    <link rel="stylesheet" id="css-main" href="assets/css/oneui.min.css">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9HQDQJJYW7"></script>
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
    <div id="page-container" class="sidebar side-scroll page-header-fixed page-header main-content-boxed">
        <nav id="sidebar" aria-label="Main Navigation">
            <div class="content-header">
                <a class="fw-semibold text-dual" href="index.html">
                    <span class="smini-visible">
                        <img style="height: 35px; padding-left: .8rem;" src="assets/media/favicons/logo-tutwuri.png">
                    </span>
                    <span class="smini-hide fs-5 tracking-wider" style="padding-left: 1.25rem">
                        SDN LEMAHBANG
                    </span>
                </a>
                <div>
                    <a class="d-lg-none btn btn-sm ms-1" data-toggle="layout" data-action="sidebar_close"
                        href="javascript:void(0)">
                        <i class="fa fa-fw fa-times"></i>
                    </a>
                </div>
            </div>
            {{-- navbar 2 --}}
            <div class="js-sidebar-scroll">
                <div class="content-side">
                    <ul class="nav-main nav-main-hover">
                        <li class="nav-main-item">
                            <a class="nav-main-link active" href="#carouselExampleSlidesOnly" data-toggle="layout"
                                data-action="sidebar_close">
                                <i class="nav-main-link-icon si si-home"></i>
                                <span class="nav-main-link-name">Home</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="#section-berita" data-toggle="layout"
                                data-action="sidebar_close">
                                <i class="nav-main-link-icon si si-camera"></i>
                                <span class="nav-main-link-name">Berita</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="#section-profile" data-toggle="layout"
                                data-action="sidebar_close">
                                <i class="nav-main-link-icon si si-book-open"></i>
                                <span class="nav-main-link-name">Profil</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="#section-sejarah" data-toggle="layout"
                                data-action="sidebar_close">
                                <i class="nav-main-link-icon si si-flag"></i>
                                <span class="nav-main-link-name">Sejarah</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="#section-visimisi" data-toggle="layout"
                                data-action="sidebar_close">
                                <i class="nav-main-link-icon si si-fire"></i>
                                <span class="nav-main-link-name">Visi Misi</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="login">
                                <i class="nav-main-link-icon si si-login"></i>
                                <span class="nav-main-link-name">Login</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        {{-- navbar 2 end --}}
        <header id="page-header">
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <a class="fw-semibold fs-5 tracking-wider text-dual me-3" href="index.html">
                        SDN LEMAHBANG
                    </a>
                </div>
                {{-- navbar 1 --}}
                <div class="d-flex align-items-center">
                    <div class="d-none d-lg-block">
                        <ul class="nav-main nav-main-horizontal nav-main-hover">
                            <li class="nav-main-item">
                                <a class="nav-main-link active" href="#carouselExampleSlidesOnly">
                                    <i class="nav-main-link-icon si si-home"></i>
                                    <span class="nav-main-link-name">Home</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="#section-berita">
                                    <i class="nav-main-link-icon si si-camera"></i>
                                    <span class="nav-main-link-name">Berita</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="#section-profile">
                                    <i class="nav-main-link-icon si si-book-open"></i>
                                    <span class="nav-main-link-name">Profil</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="#section-sejarah">
                                    <i class="nav-main-link-icon si si-flag"></i>
                                    <span class="nav-main-link-name">Sejarah</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="#section-visimisi">
                                    <i class="nav-main-link-icon si si-fire"></i>
                                    <span class="nav-main-link-name">Visi Misi</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="login">
                                    <i class="nav-main-link-icon si si-login"></i>
                                    <span class="nav-main-link-name">Login</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    {{-- navbar 1 end --}}
                    <button type="button" class="btn btn-sm d-lg-none ms-1" data-toggle="layout"
                        data-action="sidebar_toggle">
                        <i class="fs-5 fa fa-fw fa-bars"></i>
                    </button>
                </div>
            </div>
            <div id="page-header-search" class="overlay-header bg-body-extra-light">
                <div class="content-header">
                    <form class="w-100" method="POST">
                        <div class="input-group input-group-sm">
                            <button type="button" class="btn btn-alt-danger" data-toggle="layout"
                                data-action="header_search_off">
                                <i class="fa fa-fw fa-times-circle"></i>
                            </button>
                            <input type="text" class="form-control" placeholder="Search or hit ESC.."
                                id="page-header-search-input" name="page-header-search-input">
                        </div>
                    </form>
                </div>
            </div>
            <div id="page-header-loader" class="overlay-header bg-primary-lighter">
                <div class="content-header">
                    <div class="w-100 text-center">
                        <i class="fa fa-fw fa-circle-notch fa-spin text-primary"></i>
                    </div>
                </div>
            </div>
        </header>
        <main id="main-container">
            <div id="carouselExampleSlidesOnly" class="carousel slide section" data-bs-ride="carousel"
                style="height: 95vh;">
                <div class="carousel-inner">
                    <div class="carousel-item active"
                        style="background-image: url('assets/media/photos/sdnlemahbang.png'); height: 95vh;">
                        <div class="bg-primary-dark-op py-10 overflow-hidden">
                            <div class="content content-full text-center">
                                <h1 class="display-4 fw-semibold text-white mb-2">
                                    Sekolah Dasar Negeri Lemahbang
                                </h1>
                                <p class="fs-3 fw-normal text-white-50 mb-5">
                                    Desa Lemahbang, Kecamatan Bendo, Kabupaten Magetan, Jawa Timur. Kode pos 63384
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item"
                        style="background-image: url('assets/media/photos/sdnlemahbang.png'); height: 95vh;">
                        <div class="bg-primary-dark-op py-10 overflow-hidden">
                            <div class="content content-full text-center">
                                <h1 class="display-4 fw-semibold text-white mb-2">
                                    Sekolah Dasar Negeri Lemahbang
                                </h1>
                                <p class="fs-3 fw-normal text-white-50 mb-5">
                                    Desa Lemahbang, Kecamatan Bendo, Kabupaten Magetan, Jawa Timur. Kode pos 63384
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item"
                        style="background-image: url('assets/media/photos/sdnlemahbang.png'); height: 95vh;">
                        <div class="bg-primary-dark-op py-10 overflow-hidden">
                            <div class="content content-full text-center">
                                <h1 class="display-4 fw-semibold text-white mb-2">
                                    Sekolah Dasar Negeri Lemahbang
                                </h1>
                                <p class="fs-3 fw-normal text-white-50 mb-5">
                                    Desa Lemahbang, Kecamatan Bendo, Kabupaten Magetan, Jawa Timur. Kode pos 63384
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-body-extra-light section" id="section-profile">
                <div class="content content-full">
                    <div class="py-5 text-center push">
                        <h2 class="h1 mb-2">
                            Profil Sekolah
                        </h2>
                        <h3 class="fw-normal text-muted mb-0">
                            Subtitle
                        </h3>
                    </div>
                    <div class="text-center">
                        <p>
                            Subtitle
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-body-light section" id="section-sejarah">
                <div class="content content-full">
                    <div class="py-5 text-center push">
                        <h2 class="h1 mb-2">
                            Sejarah
                        </h2>
                        <h3 class="fw-normal text-muted mb-0">
                            Subtitle
                        </h3>
                    </div>
                    <div class="text-center">
                        <p>
                            Subtitle
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-body-extra-light section" id="section-visimisi">
                <div class="content content-full">
                    <div class="py-5 text-center push">
                        <h2 class="h1 mb-2">
                            Visi - Misi
                        </h2>
                        <h3 class="fw-normal text-muted mb-0">
                            Subtitle
                        </h3>
                    </div>
                    <div class="text-center">
                        <p>
                            Your content..
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-body-light section" id="section-berita">
                <div class="content content-full">
                    <div class="py-5 text-center push">
                        <h2 class="h1 mb-2">
                            Berita
                        </h2>
                        <h3 class="fw-normal text-muted mb-0">
                            Subtitle
                        </h3>
                    </div>
                    <div class="text-center">
                        <p>
                            Your content..
                        </p>
                    </div>
                </div>
            </div>
        </main>
        <footer id="page-footer" class="bg-body-extra-light">
            <div class="content py-4">
                <div class="row items-push fs-sm border-bottom pt-4">
                    <div class="col-sm-6 col-md-4">
                        <h3>Dokumentasi</h3>
                        <ul class="list list-simple-mini">
                            <li>
                                <a class="fw-semibold" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Link #1
                                </a>
                            </li>
                            <li>
                                <a class="fw-semibold" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Link #2
                                </a>
                            </li>
                            <li>
                                <a class="fw-semibold" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Link #3
                                </a>
                            </li>
                            <li>
                                <a class="fw-semibold" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Link #4
                                </a>
                            </li>
                            <li>
                                <a class="fw-semibold" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Link #5
                                </a>
                            </li>
                            <li>
                                <a class="fw-semibold" href="javascript:void(0)">
                                    <i class="fa fa-fw fa-link text-primary-lighter me-1"></i> Link #6
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <h3>Contact</h3>
                        <div class="fs-sm mb-4">
                            Email : sdnlemahbang@magetan.sch.id<br>
                            Temp : (0351)112233<br>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                    <a class="fw-semibold" href="#" target="_blank">SDN LEMAHBANG</a>
                    &copy; <span data-toggle="year-copy"></span>
                </div>
            </div>
        </footer>
        <button type="button" class="btn btn-danger btn-floating btn-lg" id="btn-back-to-top"
            data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Top">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>
    <script src="assets/js/oneui.app.min.js"></script>
</body>

</html>
