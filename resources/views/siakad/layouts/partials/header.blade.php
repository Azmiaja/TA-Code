<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Informasi Akademik | {{ $judul }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/favicons/logo-tutwuri.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2-bootstrap-5-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/apexcharts/dist/apexcharts.css') }}">
    {{-- <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/air-datepicker/dist/air-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/magnific-popup/magnific-popup.css') }}">

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

        .swal-confirm-right {
            float: right; // Mengatur tombol konfirmasi ke kanan
        }

        .swal-cancel-left {
            float: left; // Mengatur tombol batal ke kiri
        }
    </style>
    @stack('style')

    <script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/apexcharts/dist/apexcharts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

</head>

<body>

    {{-- --------------------------- CONTENT ------------------------------------------------ --}}
    <div id="page-container"
        class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
        @include('siakad/layouts/partials/sidebar')
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
                            <div class="ratio" style="width: 21px; height: 21px;">
                                @canany(['super.admin', 'admin', 'guru'])
                                    @if (Auth::user()->pegawai->gambar)
                                        <img class="rounded-circle"
                                            src="{{ asset('storage/' . Auth::user()->pegawai->gambar) }}"
                                            alt="Header Avatar" style="width: 100%; height: 100%; object-fit: cover">
                                    @else
                                        <img class="rounded-circle border border-3 border-white"
                                            style="width: 100%; height: 100%; object-fit: cover"
                                            src="{{ asset('assets/media/avatars/avatar1.jpg') }}" alt="">
                                    @endif
                                @endcanany
                                @can('siswa')
                                    <img class="rounded-circle" src="{{ asset('assets/media/avatars/avatar0.jpg') }}"
                                        alt="Header Avatar" style="width: 100%; height: 100%; object-fit: cover">
                                @endcan
                            </div>
                            @can('siswa')
                                <span
                                    class="d-none d-sm-inline-block ms-2">{{ Auth::user()->siswa->panggilan ?: Auth::user()->username }}</span>
                            @endcan
                            @cannot('siswa')
                                <span
                                    class="d-none d-sm-inline-block ms-2">{{ implode(' ', array_slice(str_word_count(Auth::user()->pegawai->namaPegawai, 1), 0, 2)) }}</span>
                            @endcannot
                            {{-- Username --}}
                            <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                            aria-labelledby="page-header-user-dropdown">
                            <div class="p-3 text-center  bg-body-light border-bottom rounded-top">
                                <div class="ratio mx-auto" style="width: 70px; height: 70px;">
                                    @cannot('siswa')
                                        @if (Auth::user()->pegawai->gambar)
                                            <img class="rounded-circle border border-3 border-white"
                                                style="width: 100%; height: 100%; object-fit: cover"
                                                src="{{ asset('storage/' . Auth::user()->pegawai->gambar) }}"
                                                alt="">
                                        @else
                                            <img class="rounded-circle border border-3 border-white"
                                                style="width: 100%; height: 100%; object-fit: cover"
                                                src="{{ asset('assets/media/avatars/avatar1.jpg') }}" alt="">
                                        @endif
                                    @endcannot
                                    @can('siswa')
                                        <img class="rounded-circle border border-3 border-white"
                                            style="width: 100%; height: 100%; object-fit: cover"
                                            src="{{ asset('assets/media/avatars/avatar1.jpg') }}" alt="">
                                    @endcan

                                </div>
                                <p class="mt-2 mb-0 fw-medium" id="HD_idSiswa"
                                    data-id-siswa={{ Auth::user()->idSiswa }}>
                                    @cannot('siswa')
                                        {{ Auth::user()->pegawai->namaPegawai }}
                                    @endcannot
                                    @can('siswa')
                                        {{ Auth::user()->siswa->namaSiswa }}
                                    @endcan
                                </p> {{-- Nama Lengkap --}}
                                <p class="mb-0 text-muted fs-sm fw-medium">
                                    {{ Auth::user()->hakAkses }}</p>
                                @can('siswa')
                                        @php
                                            $app = Auth::user()->siswa->idSiswa;
                                            $periode = \App\Models\Periode::where('status', 'Aktif')
                                                ->orderBy('tanggalMulai', 'desc')
                                                ->first();
                                            $kelas = \App\Models\Kelas::where('idPeriode', $periode->idPeriode)
                                                ->whereHas('siswa', function ($query) use ($app) {
                                                    $query->where('siswa.idSiswa', $app); // Menambahkan alias pada kolom idSiswa
                                                })
                                                ->select('namaKelas')
                                                ->first();
                                        @endphp
                                    <p class="mb-0 text-muted fs-sm fw-semibold">Kelas {{ $kelas->namaKelas }}</p>
                                @endcan
                                {{-- Role --}}
                            </div>
                            <div class="p-2">
                                <a href="{{ route('profil_pengguna.index') }}"
                                    class="dropdown-item d-flex align-items-center justify-content-between">
                                    <span class="fs-sm fw-medium">Profil</span> {{-- To log out --}}
                                    <i class="fa-regular fa-user me-1"></i>
                                </a>
                                <button class="dropdown-item d-flex align-items-center justify-content-between"
                                    data-bs-toggle="modal" data-bs-target="#logoutAlert" id="logoutBtn">
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
