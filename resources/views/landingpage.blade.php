@extends('layouts.landing')
@section('landing')
    <main>
        <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                    aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active ">
                    <img class="d-block carousel-img" src="assets/media/photos/sdnlemahbang.png" alt="">
                    <div class="container">
                        <div class="carousel-caption text-start">
                            <h1>Example headline.</h1>
                            <p class="opacity-75">Some representative placeholder content for the first slide of the
                                carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="#">Sign up today</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <img class="d-block carousel-img" src="assets/media/photos/sdnlemahbang.png" alt="">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>Another example headline.</h1>
                            <p>Some representative placeholder content for the second slide of the carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item ">
                    <img class="d-block carousel-img" src="assets/media/photos/sdnlemahbang.png" alt="">
                    <div class="container">
                        <div class="carousel-caption text-end">
                            <h1>One more for good measure.</h1>
                            <p>Some representative placeholder content for the third slide of this carousel.</p>
                            <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="container marketing mb-5">
            <!-- START THE FEATURETTES -->

            <hr class="featurette-divider">

            {{-- Profil --}}
            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">PROFIL SEKOLAH <span {{-- class="text-body-secondary">It’ll blow your mind.</span></h2> --}} <p
                            class="lead"></br>
                            SDN Lemahbang merupakan salah satu sekolah dasar di wilayah Jawa Timur tepatnya di Desa
                            Lemahbang Kecamatan Bendo.
                            </p>

                </div>
                <div class="col-md-5">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                        height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500"
                        preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="var(--bs-secondary-bg)" /><text x="50%" y="50%"
                            fill="var(--bs-secondary-color)" dy=".3em">500x500</text>
                    </svg>
                </div>
            </div>

            <hr class="featurette-divider">

            {{-- Sejarah --}}
            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading fw-normal lh-1">SEJARAH <span {{-- class="text-body-secondary">See for yourself.</span></h2> --}} <p
                            class="lead"></br>
                            "Selamat datang di Sekolah Dasar Negeri Lemahbang - Menciptakan Masa Depan Bersama Sejak 01
                            Januari 1910 ."

                            "Kami adalah [Nama Sekolah], sebuah institusi pendidikan dengan sejarah panjang dalam
                            memberikan pendidikan berkualitas kepada anak-anak sejak [Tahun Pendirian]."

                            "Dengan lebih dari [Jumlah Tahun] tahun pengalaman dalam pendidikan dasar, [Nama Sekolah]
                            telah membantu ribuan siswa mencapai potensi terbaik mereka."

                            "Kami bangga menjadi bagian dari komunitas pendidikan [Lokasi] sejak [Tahun Pendirian], dan
                            kami terus berkomitmen untuk memberikan lingkungan belajar yang inspiratif."
                            </p>
                </div>
                <div class="col-md-5 order-md-1">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500"
                        height="500" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 500x500"
                        preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="var(--bs-secondary-bg)" /><text x="50%" y="50%"
                            fill="var(--bs-secondary-color)" dy=".3em">500x500</text>
                    </svg>
                </div>
            </div>

            <hr class="featurette-divider">

            {{-- Visi Misi --}}
            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">VISI MISI <span {{-- class="text-body-secondary">Checkmate.</span></h2> --}} <p class="lead">
                            </p>
                </div>
                <div class="col-md-5">
                    <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
                        width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img"
                        aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="var(--bs-secondary-bg)" /><text x="50%" y="50%"
                            fill="var(--bs-secondary-color)" dy=".3em">500x500</text>
                    </svg>
                </div>
            </div>

            <hr class="featurette-divider">

            {{-- Sejarah --}}
            <div class="row featurette align-items-center">
                <div class="col-md-7 order-md-2">
                    <div class="row row-cols-2">
                        @foreach ($berita as $row)
                            <div class="card col-6 p-2 rounded-0 border-0">
                                <a href="{{ route('lihatberita', [$row->idBerita, Str::slug($row->judulBerita)]) }}"
                                    class="zoom-effect red-effect text-decoration-none">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{ Storage::url($row->gambar) }}" alt="{{ $row->gambar }}"
                                                style="width: 7rem; height: 7rem;" class="m-0 rounded-1 object-fit-cover">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body py-1 align-self-stretch" style="height: 7rem;">
                                                <div class="card-text fw-medium text-secondary"><small
                                                        class="text-body-secondary">{{ $row->tanggalBerita }}</small></div>
                                                <p class="fw-medium lh-sm">
                                                    {{ $row->judulBerita }}</p>

                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-5 order-md-1">
                    {{-- <svg class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
                        width="500" height="500" xmlns="http://www.w3.org/2000/svg" role="img"
                        aria-label="Placeholder: 500x500" preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="var(--bs-secondary-bg)" /><text x="50%" y="50%"
                            fill="var(--bs-secondary-color)" dy=".3em">500x500</text>
                    </svg> --}}
                    @foreach ($beritaUtama as $row)
                        <a href="{{ route('lihatberita', [$row->idBerita, Str::slug($row->judulBerita)]) }}"
                            class="text-decoration-none">
                            <div class="card ratio ratio-1x1 text-bg-dark border-0 rounded-2 position-relative">
                                <img src="{{ Storage::url($row->gambar) }}"
                                    class="rounded-1 object-fit-cover opacity-50" alt="...">
                                <div class="card-img-overlay position-absolute top-100 start-50 translate-middle">
                                    <h3 class="fw-bold mb-2">{{ $row->judulBerita }}</h3>
                                    <div class="fs-6 ellipse-2 lh-1 mb-3">
                                        {!! $row->isiBerita !!}</div>
                                    <div class=""><small>{{ $row->tanggalBerita }}</small></div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- line pemisah Berita --}}
            <div class="row py-5">
                <div class="col-auto">
                    <h3>BERITA SEKOLAH</h3>
                </div>
                <div class="col-lg">
                    <hr class="border border-secondary border-2">
                </div>
            </div>

            <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-3">
                @foreach ($berita as $row)
                    <div class="col">
                        <div class="card shadow-sm">
                            <a href="{{ route('lihatberita', [$row->idBerita, Str::slug($row->judulBerita)]) }}">
                                <img class="card-img-top object-fit-cover zoom-hover" height="250px"
                                    src="{{ Storage::url($row->gambar) }}" alt="{{ $row->gambar }}">
                            </a>

                            <div class="card-body">
                                <div class="card-text fw-bold">{{ $row->judulBerita }}</div>
                                <small class="text-body-secondary">{{ $row->tanggalBerita }}</small>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalBerita{{ $row->idBerita }}">Read More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- /END THE FEATURETTES -->

        </div><!-- /.container -->

    </main>
@endsection
