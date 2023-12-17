@extends('layouts.landing')
@section('landing')
    <!-- ======= Hero Section ======= -->
    <section id="hero" style="background: url('{{ Storage::url($profil->first()->gambarProfil) }}') top center no-repeat;" class="d-flex align-items-center">

        <div class="container" data-aos="zoom-out" data-aos-delay="100">
            <div class="row">
                <div class="col-xl-6">
                    <h1>Sekolah Dasar Negeri Lemahbang</h1>
                    <h2 id="slogan">{!! $profil->first()->slogan !!}</h2>
                    <a href="#profil" class="btn-get-started scrollto">Get Started</a>
                </div>
            </div>
        </div>

    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Counts Section ======= -->
        <section id="counts" class="counts">
            <div class="container" data-aos="fade-up">

                <div class="row justify-content-center">

                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-emoji-smile"></i>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $siswa }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Jumlah Siswa</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                        <div class="count-box">
                            <i class="bi bi-briefcase"></i>
                            <span data-purecounter-start="0" data-purecounter-end="6" data-purecounter-duration="1"
                                class="purecounter"></span>
                            <p>Jumlah Kelas</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                        <div class="count-box">
                            <i class="bi bi-people"></i>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $guru }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Guru Pengajar</p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Counts Section -->

        <!-- ======= About Section ======= -->
        <section id="profil" class="about section-bg">
            <div class="container" data-aos="fade-up">

                <div class="row no-gutters">

                    <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0 align-self-center">
                        <div class="section-title">
                            <h2>PROFIL SEKOLAH</h2>
                            <p>{!! $profil->first()->deskripsiProfil !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 text-center" data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ Storage::url($profil->first()->gambarProfil) }}" alt="" class="img-fluid">
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->



        <!-- ======= Tabs Section ======= -->
        <section id="sejarah" class="tabs">
            <div class="container" data-aos="fade-up">

                <div class="row no-gutters">

                    <div class="col-lg-6 order-1 order-lg-2 mt-3 mt-lg-0 align-self-center">
                        <div class="section-title">
                            <h2>SEJARAH SEKOLAH</h2>
                            <p> {!! $profil->first()->deskripsiSejarah !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 order-2 order-lg-1 text-center" data-aos="fade-up" data-aos-delay="200">
                        <img src="{{ Storage::url($profil->first()->gambarSejarah) }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </section><!-- End Tabs Section -->

        <!-- ======= Services Section ======= -->
        <section id="visi" class="services section-bg ">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>VISI</h2>
                    <p>{!! $profil->first()->visi !!}</p>
                </div>

            </div>
        </section><!-- End Services Section -->

        <!-- ======= Portfolio Section ======= -->
        <section id="misi" class="portfolio">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>MISI</h2>
                    <p>{!! $profil->first()->misi !!}</p>
                </div>


            </div>
        </section><!-- End Portfolio Section -->

        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="team testimonials section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>GURU</h2>
                    <p>Tenaga Pengajar Sekolah Dasar Negeri Lemahbang tahun
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                    </p>
                </div>

                <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">
                        @foreach ($pguru as $pg)
                            <div class="swiper-slide">
                                <div class="card p-3 mx-auto" style="width: 15rem;">
                                        <img src="{{ Storage::url($pg->gambarPP) }}" class="card-img-top" alt="...">
                                    <div class="card-body pt-2 p-0">
                                        <h3 class="text-dark fw-bold fs-6 m-0">{{ $pg->guru->namaPegawai }}</h3>
                                        <small class="text-secondary">{{ $pg->jabatan }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination"></div>
                </div>


            </div>
        </section><!-- End Testimonials Section -->

        <!-- ======= Contact Section ======= -->
        <section id="berita" class="portfolio">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>BERITA</h2>
                    <p>Update berita SD Negeri Lemahbang pada tahun
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                    </p>
                </div>

                <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

                    @foreach ($berita as $bt)
                        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                            <div class="portfolio-wrap text-center" style="height: 300px">
                                <img src="{{ Storage::url($bt->gambar) }}" class="" height="300" alt="">
                                <div class="portfolio-info text-start">
                                    <h4>{{ $bt->judulBerita }}</h4>
                                    <p>{{ \Carbon\Carbon::parse($bt->waktuBerita)->format('d-m-Y') }}</p>
                                    <a href="{{ route('lihatberita', [$bt->idBerita, Str::slug($bt->judulBerita)]) }}"
                                        class="mt-1 btn btn-sm" style="background: #2b4e68; color: #fff;">More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->
@endsection
