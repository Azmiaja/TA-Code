@extends('layouts.landing')
@section('landing')
    <div class="container-fluid p-0" id="profilSekolah" data-bs-spy="scroll" data-bs-target="#profilSekolah"
        data-bs-offset="0">
        <div id="gambarSlide" class="carousel slide m-0" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#gambarSlide" data-bs-slide-to="0" class="active" aria-current="true"
                    aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#gambarSlide" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#gambarSlide" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner ">
                <div class="carousel-item active ">
                    <img class="d-block carousel-img" src="assets/media/photos/sdnlemahbang.png" alt="">
                </div>
                <div class="carousel-item ">
                    <img class="d-block carousel-img" src="assets/media/photos/sdnlemahbang.png" alt="">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>SDN Lemahbang</h1>
                            <p>Ds. Lemahbang, Kec. Bendo, Kabupaten Magetan, Jawa Timur, Kode Pos 63384</p>
                            <p><a class="btn btn-lg btn-primary" href="#profilSekolah-1">Learn more</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <img class="d-block carousel-img" src="assets/media/photos/sdnlemahbang.png" alt="">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#gambarSlide" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#gambarSlide" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    {{-- Content --}}
    {{-- Profil --}}
    <div class="container-fluid m-0 mx-auto py-5" id="profilSekolah-1">
        <div class="container">
            <div class="row">
                <div class="col-md-7 align-self-center">
                    <h2 class="featurette-heading fw-medium lh-1">PROFIL SEKOLAH
                        <hr>
                    </h2>
                    <div class="lead">
                        @foreach ($profil as $row)
                            {!! $row->deskripsiProfil !!}
                        @endforeach
                    </div>

                </div>
                <div class="col-md-5">
                    @foreach ($profil as $row)
                        <img src="{{ Storage::url($row->gambarProfil) }}" alt=""
                            class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
                            width="500" height="500">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{-- Sejarah --}}
    <div class="container-fluid mx-auto py-5 bg-gray-lighter">
        <div class="container">
            <div class="row">
                <div class="col-md-7 order-md-2 align-self-center">
                    <h2 class="featurette-heading fw-medium lh-1">SEJARAH
                        <hr>
                    </h2>
                    <div class="lead">
                        @foreach ($profil as $row)
                            {!! $row->deskripsiSejarah !!}
                        @endforeach

                    </div>
                </div>
                <div class="col-md-5 order-md-1">
                    @foreach ($profil as $row)
                        <img src="{{ Storage::url($row->gambarSejarah) }}" alt=""
                            class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
                            width="500" height="500">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{-- Visi Misi --}}
    <div class="container-fluid mx-auto py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-7 align-self-center">
                    <h2 class="featurette-heading fw-medium lh-1">VISI MISI
                        <hr>
                    </h2>
                    <div class="lead">
                        @foreach ($profil as $row)
                            {!! $row->visiMisi !!}
                        @endforeach
                    </div>
                </div>
                <div class="col-md-5">
                    @foreach ($profil as $row)
                        <img src="{{ Storage::url($row->gambarVisiMisi) }}" alt=""
                            class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
                            width="500" height="500">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{-- Berita --}}
    <div class="container-fluid mx-auto py-5 bg-gray-lighter">
        <div class="container">
            <div class="row">
                <div class="col-md-7 order-md-2 align-self-center">
                    <h2 class="featurette-heading fw-medium lh-1">BERITA SEKOLAH
                        <hr>
                    </h2>
                    <div class="row row-cols-2">
                        @foreach ($berita as $row)
                            <a href="{{ route('lihatberita', [$row->idBerita, Str::slug($row->judulBerita)]) }}"
                                class="zoom-effect text-decoration-none m-0 p-0">
                                <div class="p-0 m-0">
                                    <div class="block-content p-0">
                                        <div class="row items-push m-0">
                                            <div class="col-4 options-container p-0" style="width: 112px; height: 112px;">
                                                <img class="options-item object-fit-cover"
                                                    src="{{ Storage::url($row->gambar) }}" height="112" width="112"
                                                    alt="">
                                            </div>
                                            <div class="col-8 m-0 d-md-flex align-items-center">
                                                <div>
                                                    <div class="fs-sm fw-medium my-1">
                                                        <span
                                                            class="text-muted">{{ \Carbon\Carbon::parse($row->waktuBerita)->format('d-m-Y') }}</span>
                                                    </div>
                                                    <p class="fw-medium link-dark">{{ $row->judulBerita }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-5 order-md-1 animated fadeIn">
                    <div class="options-container fx-item-zoom-in" style="width: 500px; height: 500px;">
                        @foreach ($beritaUtama as $row)
                            <img class="options-item object-fit-cover" src="{{ Storage::url($row->gambar) }}"
                                alt="" width="500" height="500">>
                            <div class="options-overlay bg-black-50">
                                <div class="options-overlay-content p-4">
                                    <h3 class="h4 text-white mb-2">{{ $row->judulBerita }}</h3>
                                    <h4 class="h6 text-white-75 fw-normal mb-3 ellipse-2">{!! $row->isiBerita !!}</h4>
                                    <a class="btn btn-sm btn-alt-danger"
                                        href="{{ route('lihatberita', [$row->idBerita, Str::slug($row->judulBerita)]) }}">
                                        Read
                                        More..
                                    </a>
                                    <div class="my-3">
                                        <span
                                            class="text-white-75">{{ \Carbon\Carbon::parse($row->waktuBerita)->format('d-m-Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
