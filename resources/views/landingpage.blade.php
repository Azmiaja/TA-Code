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
                                    <p>{{ \Carbon\Carbon::parse($bt->waktu)->format('d-m-Y') }}</p>
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

<div class="row">
    {{-- Data Profil --}}
    <div class="col-12">
        @foreach ($profil as $slogan)
            <div class="block block-rounded block-link-pop overflow-hidden">
                <div class="block-content p-4">
                    <div class="position-relative">
                        <div class="position-absolute top-0 end-0 block-options">
                            <button type="button" class="btn-block-option" title="Edit Slogan"><i
                                    class="fa fa-fw fa-pencil-alt" data-bs-toggle="modal"
                                    data-bs-target="#modalSlogan{{ $slogan->idProfil }}"></i></button>
                        </div>
                    </div>
                    <h4 class="mb-1">
                        Slogan
                    </h4>
                    <div class="fs-sm text-muted">
                        {!! $slogan->slogan !!}
                    </div>
                </div>
            </div>

            {{-- Modal edit VisiMisi --}}
            <div class="modal fade" id="modalSlogan{{ $slogan->idProfil }}" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Edit Slogan</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                <form action="{{ route('profil.updateSlogan', $slogan) }}"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="idProfil" value="{{ $slogan->idProfil }}" hidden>
                                    <div class="mb-4">
                                        <label class="form-label" for="slogan">Slogan</label>
                                        <textarea id="js-ckeditor5-classic-edit-slogan" class="form-control" name="slogan">{{ $slogan->slogan }}</textarea>
                                    </div>
                                    <div class="mb-4 text-end">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary"
                                            data-bs-dismiss="modal">Simpan</button>
                                    </div>
                                </form>
                            </div>
                            <div class="block-content block-content-full bg-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="col-12">
        @foreach ($profil as $profils)
            <div class="block block-rounded block-link-pop overflow-hidden">
                <div class="row m-0">
                    <div class="col-4 p-2">
                        <img class="img-fluid" src="{{ Storage::url($profils->gambarProfil) }}" alt=""
                            height="300">
                    </div>
                    <div class="col-8">
                        <div class="block-content">
                            <div class="position-relative">
                                <div class="position-absolute top-0 end-0 block-options">
                                    <button type="button" class="btn-block-option" title="Edit Profil"><i
                                            class="fa fa-fw fa-pencil-alt" data-bs-toggle="modal"
                                            data-bs-target="#modalEditProfil{{ $profils->idProfil }}"></i></button>
                                </div>
                            </div>
                            <h4 class="mb-1">
                                Profil
                            </h4>
                            <p class="fs-sm fw-medium mb-2">Update at
                                <span
                                    class="text-muted">{{ \Carbon\Carbon::parse($profils->timestampProfil)->format('d-m-Y H:i') }}</span>
                            </p>
                            <div class="fs-sm text-muted">
                                {!! $profils->deskripsiProfil !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Modal edit profil --}}
            <div class="modal fade" id="modalEditProfil{{ $profils->idProfil }}" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Edit Peofil</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                <form action="{{ route('profil.updateProfil', $profils) }}"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="idProfil" value="{{ $profils->idProfil }}"
                                        hidden>
                                    <div class="mb-4">
                                        <label class="form-label" for="gambarProfil">Gambar</label>
                                        <div class="row ms-1 mb-2 p-0">
                                            <div class="col-auto border rounded-2">
                                                <div class="m-3">
                                                    <img src="{{ Storage::url($profils->gambarProfil) }}"
                                                        alt="{{ $profils->gambarProfil }}" height="150">
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-danger">*Ukuran gambar tidak boleh lebih dari 2
                                            MB.</small>
                                        <input class="form-control" type="file" name="gambarProfil"
                                            id="gambarProfil" accept=".jpg, .jpeg, .svg, .png">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="deskripsiProfil">Deskripsi</label>
                                        <textarea id="js-ckeditor5-classic-edit-profil" class="form-control" name="deskripsiProfil">{{ $profils->deskripsiProfil }}</textarea>
                                    </div>
                                    <input type="datetime-local" id="timestamp" name="timestampProfil"
                                        class="form-control" hidden>
                                    <div class="mb-4 text-end">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary"
                                            data-bs-dismiss="modal">Simpan</button>
                                    </div>
                                </form>
                            </div>
                            <div class="block-content block-content-full bg-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Data Sejarah --}}
    <div class="col-12">
        @foreach ($profil as $sejarah)
            <div class="block block-rounded block-link-pop overflow-hidden">
                <div class="row m-0">
                    <div class="col-4 p-2">
                        <img class="img-fluid" src="{{ Storage::url($sejarah->gambarSejarah) }}" alt=""
                            height="300">
                    </div>
                    <div class="col-8">
                        <div class="block-content">
                            <div class="position-relative">
                                <div class="position-absolute top-0 end-0 block-options">
                                    <button type="button" class="btn-block-option" title="Edit Sejarah"><i
                                            class="fa fa-fw fa-pencil-alt" data-bs-toggle="modal"
                                            data-bs-target="#modalEditSejarah{{ $sejarah->idProfil }}"></i></button>
                                </div>
                            </div>
                            <h4 class="mb-1">
                                Sejarah
                            </h4>
                            <p class="fs-sm fw-medium mb-2">Update at
                                <span
                                    class="text-muted">{{ \Carbon\Carbon::parse($sejarah->timestampSejarah)->format('d-m-Y H:i') }}</span>
                            </p>
                            <div class="fs-sm text-muted">
                                {!! $sejarah->deskripsiSejarah !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Modal edit Sejarah --}}
            <div class="modal fade" id="modalEditSejarah{{ $sejarah->idProfil }}" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Edit Sejarah</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                <form action="{{ route('profil.updateSejarah', $sejarah) }}"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="idProfil" value="{{ $sejarah->idProfil }}"
                                        hidden>
                                    <div class="mb-4">
                                        <label class="form-label" for="gambarSejarah">Gambar</label>
                                        <div class="row ms-1 mb-2 p-0">
                                            <div class="col-auto border rounded-2">
                                                <div class="m-3">
                                                    <img id="prev_gambar_sejarah"
                                                        src="{{ Storage::url($sejarah->gambarSejarah) }}"
                                                        alt="{{ $sejarah->gambarSejarah }}" height="150">
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-danger">*Ukuran gambar tidak boleh lebih dari 2
                                            MB.</small>
                                        <input class="form-control" type="file" name="gambar"
                                            id="gambarSejarah" accept=".jpg, .jpeg, .svg, .png">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label" for="deskripsiSejarah">Deskripsi</label>
                                        <textarea id="js-ckeditor5-classic-edit-sejarah" class="form-control" name="deskripsiSejarah">{{ $sejarah->deskripsiSejarah }}</textarea>
                                    </div>
                                    <input type="datetime-local" id="timestamp2" name="timestampSejarah"
                                        class="form-control" hidden>
                                    <div class="mb-4 text-end">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary"
                                            data-bs-dismiss="modal">Simpan</button>
                                    </div>
                                </form>
                            </div>
                            <div class="block-content block-content-full bg-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Data Visi Misi --}}
    <div class="col-12">
        @foreach ($profil as $visi)
            <div class="block block-rounded block-link-pop overflow-hidden">
                <div class="block-content p-4">
                    <div class="position-relative">
                        <div class="position-absolute top-0 end-0 block-options">
                            <button type="button" class="btn-block-option" title="Edit Visi"><i
                                    class="fa fa-fw fa-pencil-alt" data-bs-toggle="modal"
                                    data-bs-target="#modalVisi{{ $visi->idProfil }}"></i></button>
                        </div>
                    </div>
                    <h4 class="mb-1">
                        Visi
                    </h4>
                    <p class="fs-sm fw-medium mb-2">Update at
                        <span
                            class="text-muted">{{ \Carbon\Carbon::parse($visi->timestampVisi)->format('d-m-Y H:i') }}</span>
                    </p>
                    <div class="fs-sm text-muted">
                        {!! $visi->visi !!}
                    </div>
                </div>
            </div>
            {{-- Modal edit VisiMisi --}}
            <div class="modal fade" id="modalVisi{{ $visi->idProfil }}" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Edit Visi</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                <form action="{{ route('profil.updateVisi', $visi) }}"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="idProfil" value="{{ $visi->idProfil }}" hidden>
                                    <div class="mb-4">
                                        <label class="form-label" for="visi">Deskripsi</label>
                                        <textarea id="js-ckeditor5-classic-edit-visi" class="form-control" name="visi">{{ $visi->visi }}</textarea>
                                    </div>
                                    <input type="datetime-local" id="timestamp33" name="timestampVisi"
                                        class="form-control" hidden>
                                    <div class="mb-4 text-end">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary"
                                            data-bs-dismiss="modal">Simpan</button>
                                    </div>
                                </form>
                            </div>
                            <div class="block-content block-content-full bg-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="col-12">
        @foreach ($profil as $misi)
            <div class="block block-rounded block-link-pop overflow-hidden">
                <div class="block-content p-4">
                    <div class="position-relative">
                        <div class="position-absolute top-0 end-0 block-options">
                            <button type="button" class="btn-block-option" title="Edit Misi"><i
                                    class="fa fa-fw fa-pencil-alt" data-bs-toggle="modal"
                                    data-bs-target="#modalEditMisi{{ $misi->idProfil }}"></i></button>
                        </div>
                    </div>
                    <h4 class="mb-1">
                        Misi
                    </h4>
                    <p class="fs-sm fw-medium mb-2">Update at
                        <span
                            class="text-muted">{{ \Carbon\Carbon::parse($misi->timestampMisi)->format('d-m-Y H:i') }}</span>
                    </p>
                    <div class="fs-sm text-muted">
                        {!! $misi->misi !!}
                    </div>
                </div>
            </div>
            {{-- Modal edit Misi --}}
            <div class="modal fade" id="modalEditMisi{{ $misi->idProfil }}" data-bs-backdrop="static"
                data-bs-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Edit Misi</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                <form action="{{ route('profil.updateMisi', $misi) }}"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="text" name="idProfil" value="{{ $misi->idProfil }}" hidden>
                                    <div class="mb-4">
                                        <label class="form-label" for="Misi">Deskripsi</label>
                                        <textarea id="js-ckeditor5-classic-edit-misi" class="form-control" name="misi">{{ $misi->misi }}</textarea>
                                    </div>
                                    <input type="datetime-local" id="timestamp4" name="timestampMisi"
                                        class="form-control" hidden>
                                    <div class="mb-4 text-end">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary"
                                            data-bs-dismiss="modal">Simpan</button>
                                    </div>
                                </form>
                            </div>
                            <div class="block-content block-content-full bg-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
