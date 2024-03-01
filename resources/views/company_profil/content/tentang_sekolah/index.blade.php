@extends('company_profil/layouts/app')
@section('app')
    @php
        use Carbon\Carbon;
    @endphp
    <div class="row my-2 g-3">
        <div class="col-xxl-9 col-lg-8 col-12">

            @yield('tentang')

        </div>

        <div class="col-xxl-3 col-lg-4 col-12">
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
                <h5 class="p-0 m-0 mb-1">TENTANG</h5>
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
                        <a class="nav-main-link {{ Request::routeIs('profil') ? 'active' : '' }}"
                            href="{{ route('profil') }}">
                            <span class="nav-main-link-name"><i class="fa-brands fa-slack mx-2"></i>Profil</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('sejarah') ? 'active' : '' }}"
                            href="{{ route('sejarah') }}">
                            <span class="nav-main-link-name"><i class="fa-brands fa-slack mx-2"></i>Sejarah</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('visi_misi') ? 'active' : '' }}"
                            href="{{ route('visi_misi') }}">
                            <span class="nav-main-link-name"><i class="fa-brands fa-slack mx-2"></i>Visi dan Misi</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('struktur_org') ? 'active' : '' }}"
                            href="{{ route('struktur_org') }}">
                            <span class="nav-main-link-name"><i class="fa-brands fa-slack mx-2"></i>Struktur
                                Organisasi</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ Request::routeIs('keuangan') ? 'active' : '' }}"
                            href="{{ route('keuangan') }}">
                            <span class="nav-main-link-name"><i class="fa-brands fa-slack mx-2"></i>Keuangan</span>
                        </a>
                    </li>
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
                                        <img src="{{ $bTree['gambar'] }}" alt="Berita" class="rounded" style="width: 100%; height: 100%; object-fit: cover">
                                    </div>
                                    <div class="block-content w-100 align-items-center px-0 ms-2">
                                        <h6 class="my-0 fst-normal text-dark mb-1">
                                            {{ $bTree['judul'] }}
                                        </h6>
                                        <div class="fw-semibold text-dark fs-sm text-wrap">
                                            <a class="link-effect link-primary d-lg-none d-md-inline"
                                                href="#">{{ $bTree['penulis'] }}</a>
                                            <span class="">
                                                {{ $bTree['tanggal'] }} &bull;</span>
                                            <span class="text-muted">
                                                {{ $bTree['waktu'] }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('baca_berita', ['slug' => $bTree['slug'], 'id' => $bTree['id']]) }}"
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
