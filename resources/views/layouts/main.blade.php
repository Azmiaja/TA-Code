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
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
    <link rel="stylesheet" id="css-main" href="assets/css/oneui.min.css">
    <link rel="stylesheet" href="assets/js/plugins/fullcalendar/main.min.css">
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
    <div id="page-container"
        class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        <nav id="sidebar" aria-label="Main Navigation">
            {{-- Sidebar header --}}
            <div class="content-header">
                <a class="fw-semibold text-dual" href="home">
                    <span class="smini-visible">
                        <i class="fa fa-circle-notch text-primary"></i>
                    </span>
                    <span class="smini-hide fs-6 tracking-wider">SDN Lemahbang</span>
                </a>
            </div>
            {{-- End Sidebar header --}}

            {{-- Sidebar menu --}}
            <div class="js-sidebar-scroll">
                <div class="content-side">
                    <ul class="nav-main">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ $title === 'Home' ? 'active' : '' }}" href="home">
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
                                        href="manajemen-pegawai">
                                        <span class="nav-main-link-name">Pegawai</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link {{ $title2 === 'siswa' ? 'active' : '' }}"
                                        href="manajemen-siswa">
                                        <span class="nav-main-link-name">Siswa</span>
                                    </a>
                                </li>
                            </ul>
                            {{-- End Sub menu manajemen user --}}
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-grid"></i>
                                <span class="nav-main-link-name">Manajemen Company</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_widgets_tiles.html">
                                        <span class="nav-main-link-name">Profil Sekolah</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_widgets_users.html">
                                        <span class="nav-main-link-name">Sejarah</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_widgets_stats.html">
                                        <span class="nav-main-link-name">Visi Misi</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_widgets_blog.html">
                                        <span class="nav-main-link-name">Berita Sekolah</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-briefcase"></i>
                                <span class="nav-main-link-name">Manajemen Kelas</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_ui_grid.html">
                                        <span class="nav-main-link-name">Pembagian Guru</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_ui_grid.html">
                                        <span class="nav-main-link-name">Pembagian Siswa</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_ui_grid.html">
                                        <span class="nav-main-link-name">Penjadwalan Pelajaran</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_ui_grid.html">
                                        <span class="nav-main-link-name">Penugasan Siswa</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_ui_grid.html">
                                        <span class="nav-main-link-name">Penilaian Siswa</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_ui_grid.html">
                                        <span class="nav-main-link-name">Laporan Nilai</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-wallet"></i>
                                <span class="nav-main-link-name">Manajemen Keuangan</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_tables_styles.html">
                                        <span class="nav-main-link-name">Pemberitahuan Pembayaran</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_tables_responsive.html">
                                        <span class="nav-main-link-name">Laporan Pembayaran</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-logout"></i>
                                <span class="nav-main-link-name">Log out</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="be_forms_elements.html">
                                        <span class="nav-main-link-name">Elements</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                        aria-haspopup="true" aria-expanded="false" href="#">
                                        <i class="nav-main-link-icon si si-note"></i>
                                        <span class="nav-main-link-name">Berita Sekolah</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link" href="be_forms_elements.html">
                                                <span class="nav-main-link-name">Elements</span>
                                            </a>
                                        </li>

                                        <li class="nav-main-heading">Develop</li>
                                        <li class="nav-main-item open">
                                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="true" href="#">
                                                <i class="nav-main-link-icon si si-wrench"></i>
                                                <span class="nav-main-link-name">Components</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_loaders.html">
                                                        <span class="nav-main-link-name">Loaders</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_image_cropper.html">
                                                        <span class="nav-main-link-name">Image Cropper</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_appear.html">
                                                        <span class="nav-main-link-name">Appear</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_charts.html">
                                                        <span class="nav-main-link-name">Charts</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link active" href="be_comp_calendar.html">
                                                        <span class="nav-main-link-name">Calendar</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_sliders.html">
                                                        <span class="nav-main-link-name">Sliders</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_carousel.html">
                                                        <span class="nav-main-link-name">Carousel</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_offcanvas.html">
                                                        <span class="nav-main-link-name">Offcanvas</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_syntax_highlighting.html">
                                                        <span class="nav-main-link-name">Syntax Highlighting</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_rating.html">
                                                        <span class="nav-main-link-name">Rating</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_maps_vector.html">
                                                        <span class="nav-main-link-name">Vector Maps</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_dialogs.html">
                                                        <span class="nav-main-link-name">Dialogs</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_notifications.html">
                                                        <span class="nav-main-link-name">Notifications</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_comp_gallery.html">
                                                        <span class="nav-main-link-name">Gallery</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="false" href="#">
                                                <i class="nav-main-link-icon si si-magic-wand"></i>
                                                <span class="nav-main-link-name">Layout</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link nav-main-link-submenu"
                                                        data-toggle="submenu" aria-haspopup="true"
                                                        aria-expanded="false" href="#">
                                                        <span class="nav-main-link-name">Page</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_page_default.html">
                                                                <span class="nav-main-link-name">Default</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_page_flipped.html">
                                                                <span class="nav-main-link-name">Flipped</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_page_native_scrolling.html">
                                                                <span class="nav-main-link-name">Native
                                                                    Scrolling</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link nav-main-link-submenu"
                                                        data-toggle="submenu" aria-haspopup="true"
                                                        aria-expanded="false" href="#">
                                                        <span class="nav-main-link-name">Dark Mode</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_dark_mode_on.html">
                                                                <span class="nav-main-link-name">On</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_dark_mode_off.html">
                                                                <span class="nav-main-link-name">Off</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link nav-main-link-submenu"
                                                        data-toggle="submenu" aria-haspopup="true"
                                                        aria-expanded="false" href="#">
                                                        <span class="nav-main-link-name">Main Content</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_content_main_full_width.html">
                                                                <span class="nav-main-link-name">Full Width</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_content_main_narrow.html">
                                                                <span class="nav-main-link-name">Narrow</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_content_main_boxed.html">
                                                                <span class="nav-main-link-name">Boxed</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link nav-main-link-submenu"
                                                        data-toggle="submenu" aria-haspopup="true"
                                                        aria-expanded="false" href="#">
                                                        <span class="nav-main-link-name">Header</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-heading">Fixed</li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_header_fixed_light.html">
                                                                <span class="nav-main-link-name">Light</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_header_fixed_dark.html">
                                                                <span class="nav-main-link-name">Dark</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-heading">Static</li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_header_static_light.html">
                                                                <span class="nav-main-link-name">Light</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_header_static_dark.html">
                                                                <span class="nav-main-link-name">Dark</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link nav-main-link-submenu"
                                                        data-toggle="submenu" aria-haspopup="true"
                                                        aria-expanded="false" href="#">
                                                        <span class="nav-main-link-name">Sidebar</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_sidebar_mini.html">
                                                                <span class="nav-main-link-name">Mini</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_sidebar_light.html">
                                                                <span class="nav-main-link-name">Light</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_sidebar_dark.html">
                                                                <span class="nav-main-link-name">Dark</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_sidebar_hidden.html">
                                                                <span class="nav-main-link-name">Hidden</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link nav-main-link-submenu"
                                                        data-toggle="submenu" aria-haspopup="true"
                                                        aria-expanded="false" href="#">
                                                        <span class="nav-main-link-name">Side Overlay</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_side_overlay_visible.html">
                                                                <span class="nav-main-link-name">Visible</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_side_overlay_mode_hover.html">
                                                                <span class="nav-main-link-name">Hover Mode</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link"
                                                                href="be_layout_side_overlay_no_page_overlay.html">
                                                                <span class="nav-main-link-name">No Page Overlay</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_layout_api.html">
                                                        <span class="nav-main-link-name">API</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="false" href="#">
                                                <i class="nav-main-link-icon si si-puzzle"></i>
                                                <span class="nav-main-link-name">Multi Level Menu</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="#">
                                                        <span class="nav-main-link-name">Link 1-1</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="#">
                                                        <span class="nav-main-link-name">Link 1-2</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link nav-main-link-submenu"
                                                        data-toggle="submenu" aria-haspopup="true"
                                                        aria-expanded="false" href="#">
                                                        <span class="nav-main-link-name">Sub Level 2</span>
                                                    </a>
                                                    <ul class="nav-main-submenu">
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link" href="#">
                                                                <span class="nav-main-link-name">Link 2-1</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link" href="#">
                                                                <span class="nav-main-link-name">Link 2-2</span>
                                                            </a>
                                                        </li>
                                                        <li class="nav-main-item">
                                                            <a class="nav-main-link nav-main-link-submenu"
                                                                data-toggle="submenu" aria-haspopup="true"
                                                                aria-expanded="false" href="#">
                                                                <span class="nav-main-link-name">Sub Level 3</span>
                                                            </a>
                                                            <ul class="nav-main-submenu">
                                                                <li class="nav-main-item">
                                                                    <a class="nav-main-link" href="#">
                                                                        <span class="nav-main-link-name">Link
                                                                            3-1</span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-main-item">
                                                                    <a class="nav-main-link" href="#">
                                                                        <span class="nav-main-link-name">Link
                                                                            3-2</span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-main-item">
                                                                    <a class="nav-main-link nav-main-link-submenu"
                                                                        data-toggle="submenu" aria-haspopup="true"
                                                                        aria-expanded="false" href="#">
                                                                        <span class="nav-main-link-name">Sub Level
                                                                            4</span>
                                                                    </a>
                                                                    <ul class="nav-main-submenu">
                                                                        <li class="nav-main-item">
                                                                            <a class="nav-main-link" href="#">
                                                                                <span class="nav-main-link-name">Link
                                                                                    4-1</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-main-item">
                                                                            <a class="nav-main-link" href="#">
                                                                                <span class="nav-main-link-name">Link
                                                                                    4-2</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="nav-main-item">
                                                                            <a class="nav-main-link nav-main-link-submenu"
                                                                                data-toggle="submenu"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false" href="#">
                                                                                <span class="nav-main-link-name">Sub
                                                                                    Level 5</span>
                                                                            </a>
                                                                            <ul class="nav-main-submenu">
                                                                                <li class="nav-main-item">
                                                                                    <a class="nav-main-link"
                                                                                        href="#">
                                                                                        <span
                                                                                            class="nav-main-link-name">Link
                                                                                            5-1</span>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="nav-main-item">
                                                                                    <a class="nav-main-link"
                                                                                        href="#">
                                                                                        <span
                                                                                            class="nav-main-link-name">Link
                                                                                            5-2</span>
                                                                                    </a>
                                                                                </li>
                                                                                <li class="nav-main-item">
                                                                                    <a class="nav-main-link nav-main-link-submenu"
                                                                                        data-toggle="submenu"
                                                                                        aria-haspopup="true"
                                                                                        aria-expanded="false"
                                                                                        href="#">
                                                                                        <span
                                                                                            class="nav-main-link-name">Sub
                                                                                            Level 6</span>
                                                                                    </a>
                                                                                    <ul class="nav-main-submenu">
                                                                                        <li class="nav-main-item">
                                                                                            <a class="nav-main-link"
                                                                                                href="#">
                                                                                                <span
                                                                                                    class="nav-main-link-name">Link
                                                                                                    6-1</span>
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="nav-main-item">
                                                                                            <a class="nav-main-link"
                                                                                                href="#">
                                                                                                <span
                                                                                                    class="nav-main-link-name">Link
                                                                                                    6-2</span>
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-main-heading">Pages</li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="false" href="#">
                                                <i class="nav-main-link-icon si si-layers"></i>
                                                <span class="nav-main-link-name">Generic</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_generic_blank.html">
                                                        <span class="nav-main-link-name">Blank</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_generic_blank_block.html">
                                                        <span class="nav-main-link-name">Blank with Block</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_generic_search.html">
                                                        <span class="nav-main-link-name">Search</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_generic_profile.html">
                                                        <span class="nav-main-link-name">Profile</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link"
                                                        href="be_pages_generic_profile_edit.html">
                                                        <span class="nav-main-link-name">Profile Edit</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_generic_inbox.html">
                                                        <span class="nav-main-link-name">Inbox</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_generic_invoice.html">
                                                        <span class="nav-main-link-name">Invoice</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link"
                                                        href="be_pages_generic_pricing_plans.html">
                                                        <span class="nav-main-link-name">Pricing Plans</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_generic_faq.html">
                                                        <span class="nav-main-link-name">FAQ</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_generic_team.html">
                                                        <span class="nav-main-link-name">Team</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_generic_contact.html">
                                                        <span class="nav-main-link-name">Contact</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_generic_support.html">
                                                        <span class="nav-main-link-name">Support</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link"
                                                        href="be_pages_generic_upgrade_plan.html">
                                                        <span class="nav-main-link-name">Upgrade Plan</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_sidebar_mini_nav.html">
                                                        <span class="nav-main-link-name">Sidebar with Mini Nav</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_dashboard_v1.html">
                                                        <span class="nav-main-link-name">Dashboard v1</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_maintenance.html">
                                                        <span class="nav-main-link-name">Maintenance</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_status.html">
                                                        <span class="nav-main-link-name">Status</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_installation.html">
                                                        <span class="nav-main-link-name">Installation</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_checkout.html">
                                                        <span class="nav-main-link-name">Checkout</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_coming_soon.html">
                                                        <span class="nav-main-link-name">Coming Soon</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="false" href="#">
                                                <i class="nav-main-link-icon si si-lock"></i>
                                                <span class="nav-main-link-name">Authentication</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_auth_all.html">
                                                        <span class="nav-main-link-name">All</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_signin.html">
                                                        <span class="nav-main-link-name">Sign In</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_signin2.html">
                                                        <span class="nav-main-link-name">Sign In 2</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_signin3.html">
                                                        <span class="nav-main-link-name">Sign In 3</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_signup.html">
                                                        <span class="nav-main-link-name">Sign Up</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_signup2.html">
                                                        <span class="nav-main-link-name">Sign Up 2</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_signup3.html">
                                                        <span class="nav-main-link-name">Sign Up 3</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_lock.html">
                                                        <span class="nav-main-link-name">Lock Screen</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_lock2.html">
                                                        <span class="nav-main-link-name">Lock Screen 2</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_lock3.html">
                                                        <span class="nav-main-link-name">Lock Screen 3</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_reminder.html">
                                                        <span class="nav-main-link-name">Pass Reminder</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_reminder2.html">
                                                        <span class="nav-main-link-name">Pass Reminder 2</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_auth_reminder3.html">
                                                        <span class="nav-main-link-name">Pass Reminder 3</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="false" href="#">
                                                <i class="nav-main-link-icon si si-fire"></i>
                                                <span class="nav-main-link-name">Error Pages</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="be_pages_error_all.html">
                                                        <span class="nav-main-link-name">All</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_error_400.html">
                                                        <span class="nav-main-link-name">400</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_error_401.html">
                                                        <span class="nav-main-link-name">401</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_error_403.html">
                                                        <span class="nav-main-link-name">403</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_error_404.html">
                                                        <span class="nav-main-link-name">404</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_error_500.html">
                                                        <span class="nav-main-link-name">500</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="op_error_503.html">
                                                        <span class="nav-main-link-name">503</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="false" href="#">
                                                <i class="nav-main-link-icon si si-cup"></i>
                                                <span class="nav-main-link-name">Get Started</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="gs_backend.html">
                                                        <span class="nav-main-link-name">Backend</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="gs_backend_boxed.html">
                                                        <span class="nav-main-link-name">Backend Boxed</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="gs_landing.html">
                                                        <span class="nav-main-link-name">Landing</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="gs_rtl_backend.html">
                                                        <span class="nav-main-link-name">RTL Backend</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="gs_rtl_backend_boxed.html">
                                                        <span class="nav-main-link-name">RTL Backend Boxed</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link" href="gs_rtl_landing.html">
                                                        <span class="nav-main-link-name">RTL Landing</span>
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
                            <img class="rounded-circle" src="assets/media/avatars/avatar10.jpg" alt="Header Avatar"
                                style="width: 21px;">
                            <span class="d-none d-sm-inline-block ms-2">Syahrul</span> {{-- Username --}}
                            <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                            aria-labelledby="page-header-user-dropdown">
                            <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                                <img class="img-avatar img-avatar48 img-avatar-thumb"
                                    src="assets/media/avatars/avatar10.jpg" alt="">
                                <p class="mt-2 mb-0 fw-medium">Syahrul Nur Hidayatullah</p> {{-- Nama Lengkap --}}
                                <p class="mb-0 text-muted fs-sm fw-medium">Super Admin</p> {{-- Role --}}
                            </div>
                            <div class="p-2">
                                <a class="dropdown-item d-flex align-items-center justify-content-between"
                                    href="be_pages_generic_profile.html">
                                    <span class="fs-sm fw-medium">Profile</span> {{-- Go to profile page --}}
                                    <span class="badge rounded-pill bg-primary ms-2">1</span>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                                        href="op_auth_signin.html">
                                        <span class="fs-sm fw-medium">Log Out</span> {{-- To log out --}}
                                    </a>
                                </a>
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
    <script src="assets/js/oneui.app.min.js"></script>
    <script src="assets/js/plugins/fullcalendar/main.min.js"></script>
    <script src="assets/js/pages/be_comp_calendar.min.js"></script>
</body>

</html>
