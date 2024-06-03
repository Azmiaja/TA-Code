@extends('company_profil/layouts/app')
@section('app')
    @php
        use Carbon\Carbon;
    @endphp
    <div class="row my-2 g-3">
        <div class="col-xxl-9 col-lg-8 col-12">

            @yield('guru')

        </div>

        <div class="col-xxl-3 col-lg-4 col-12">
            {{-- Garis Judul --}}
            <div class="row mx-0 p-0 mb-3" style="margin-top: 6px;">
                <h5 class="p-0 m-0 mb-1">KATEGORI</h5>
                <div class="col-4 bg-city p-0">
                    <div class="line-lv1"></div>
                </div>
                <div class="col-8 bg-gray p-0">
                    <div class="line-lv2"></div>
                </div>
            </div>
            <div class="row m-0 mb-3">
                <ul class="navbar-nav">
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('kt_guru') ? 'active' : '' }}"
                            href="{{ route('kt_guru') }}">
                            <span class="nav-main-link-name"><i class="fa-brands fa-slack mx-2"></i>Guru</span>
                        </a>
                    </li>
                    {{-- <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('sejarah') ? 'active' : '' }}" href="{{ route('sejarah') }}">
                            <span class="nav-main-link-name"><i class="fa-brands fa-slack mx-2"></i>Sejarah</span>
                        </a>
                    </li> --}}
                </ul>
            </div>

            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
                <h5 class="p-0 m-0 mb-1">BERITA TERBARU</h5>
                <div class="col-4 bg-city p-0">
                    <div class="line-lv1"></div>
                </div>
                <div class="col-8 bg-gray p-0">
                    <div class="line-lv2"></div>
                </div>
            </div>
            <div class="row m-0 mb-3">
                <div class="col-12 p-0">
                    <div class="row g-3">
                        {{-- Konten Berita --}}
                        @foreach ($beritaTerbaru as $bTree)
                            <div class="col-md-12">
                                <div class="d-flex block block-rounded shadow-sm p-2 m-0 position-relative">
                                    <div class="ratio" style="max-width: 6rem; height: 6rem;">
                                        <img src="{{ $bTree['gambar'] }}" alt="Berita" class="rounded"
                                            style="width: 100%; height: 100%; object-fit: cover">
                                    </div>
                                    <div class="w-100 align-items-start p-1 ms-2">
                                        <h6 class="my-0 fst-normal text-dark mb-2" style="text-align: justify;">
                                            {{ $bTree['judul'] }}
                                        </h6>
                                        <div class="fw-medium text-dark fs-sm text-wrap">
                                            <span class="">
                                                {{ $bTree['tanggal'] }} &bull;</span>
                                            <span class="text-muted">
                                                {{ $bTree['waktu'] }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('baca_berita', ['slug' => $bTree['slug']]) }}"
                                        class="stretched-link"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
