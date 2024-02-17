@extends('company_profil/layouts/app')
@section('app')
    <div class="row my-3 g-3">
        <div class="col-xxl-9 col-lg-8 col-12">
            <div class="row">
                {{-- Dokumentasi Terbaru --}}
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade" style="max-height: 500px;">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner rounded-3" style="max-height: 500px;">
                        <div class="carousel-item active border">
                        <img src="{{ asset('assets/media/img/tmb.svg') }}"
                                class="object-fit-cover w-100" alt="Carousel Image 1">
                        </div>
                        <div class="carousel-item rounded-3">
                            <img src="{{ asset('assets/media/img/tmb.svg') }}"
                                class="object-fit-cover w-100" alt="Carousel Image 2">
                        </div>
                        <div class="carousel-item rounded-3">
                            <img src="{{ asset('assets/media/img/tmb.svg') }}"
                                class="object-fit-cover w-100" alt="Carousel Image 3">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="row m-0 my-3">
                <div class="rounded bg-city d-flex justify-content-center align-items-center">
                    <h4 class="change-size m-0 text-light fw-bold py-lg-4 py-3">SELAMAT DATANG DI WEBSITE RESMI SD NEGERI
                        LEMAHBANG</h4>
                </div>
            </div>
            <div class="row m-0">
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
                <div class="col-12 p-0">
                    <div class="row g-3">
                        {{-- Konten Berita --}}
                        <div class="col-xl-6 col-12">
                            <div class="d-flex rounded shadow-sm p-3 bg-white">
                                <img src="https://i.pinimg.com/originals/87/64/1a/87641ac11458c4259239b791593cf661.jpg"
                                    alt="Berita" class="flex-shrink-0 me-3 object-fit-cover rounded" width="100"
                                    height="100">
                                <div class="w-100 position-relative">
                                    <p class="fw-medium my-0 fst-normal text-dark ellipse-two">Lorem ipsum dolor sit amet
                                        consectetur, adipisicing elit. Nostrum, itaque aliquid quos ratione cumque
                                        blanditiis impedit possimus est atque incidunt.</p>
                                    <small class="ellipse text-justify mb-4">Lorem
                                        ipsum, dolor sit amet
                                        consectetur adipisicing
                                        elit. Ex facilis cumque delectus expedita libero nihil cupiditate blanditiis
                                        quibusdam maiores fuga quae iusto ipsum vel atque praesentium sapiente corporis
                                        vero, neque quas maxime ea et pariatur sint id? Explicabo, dignissimos nostrum! Rem
                                        sunt dignissimos rerum odio, itaque velit iusto dolorem laborum?</small>
                                    <small class="text-gray-dark position-absolute bottom-0"><i
                                            class="fa-solid fa-calendar-day me-1"></i>02 Januari 2024
                                    </small>
                                    <a href="#" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="d-flex rounded shadow-sm p-3 bg-white">
                                <img src="https://i.pinimg.com/originals/87/64/1a/87641ac11458c4259239b791593cf661.jpg"
                                    alt="Berita" class="flex-shrink-0 me-3 object-fit-cover rounded" width="100"
                                    height="100">
                                <div class="w-100 position-relative">
                                    <p class="fw-medium my-0 fst-normal text-dark ellipse-two">Lorem ipsum dolor sit amet
                                        consectetur, adipisicing elit. Nostrum, itaque aliquid quos ratione cumque
                                        blanditiis impedit possimus est atque incidunt.</p>
                                    <small class="ellipse text-justify mb-4">Lorem
                                        ipsum, dolor sit amet
                                        consectetur adipisicing
                                        elit. Ex facilis cumque delectus expedita libero nihil cupiditate blanditiis
                                        quibusdam maiores fuga quae iusto ipsum vel atque praesentium sapiente corporis
                                        vero, neque quas maxime ea et pariatur sint id? Explicabo, dignissimos nostrum! Rem
                                        sunt dignissimos rerum odio, itaque velit iusto dolorem laborum?</small>
                                    <small class="text-gray-dark position-absolute bottom-0"><i
                                            class="fa-solid fa-calendar-day me-1"></i>02 Januari 2024
                                    </small>
                                    <a href="#" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xxl-3 col-lg-4 col-12">
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
                <h5 class="p-0 m-0 mb-1">SAMBUTAN KEPALA SEKOLAH</h5>
                <div class="col-4 bg-city p-0">
                    <div class="line-lv1"></div>
                </div>
                <div class="col-8 bg-gray p-0">
                    <div class="line-lv2"></div>
                </div>
            </div>
            <div class="row m-0">
                {{-- Sambutan Kepala Sekolah --}}
                <div class="card bg-with mt-md-0 p-2 shadow-sm border-0 mb-3">
                    {{-- Foto Kepala Sekolah --}}
                    <img src="https://i.pinimg.com/originals/87/64/1a/87641ac11458c4259239b791593cf661.jpg"
                        alt="Sambutan Kepala Sekolah" class="d-block w-100 rounded-top">
                    <div class="card-body p-2">
                        {{-- Nama Kepala Sekolah --}}
                        <h4 class="card-title border-dark border-bottom border-2 text-center fw-bold m-0 mb-2 py-1">SRI
                            ASTUTI,
                            S.Pd.</h4>
                        <p class="card-text text-justify ellipse-multi mb-1">Lorem ipsum dolor sit amet consectetur
                            adipisicing
                            elit. Quaerat enim
                            quo
                            blanditiis
                            vero est non amet aliquid, deserunt quas quam assumenda perferendis praesentium tempora
                            architecto,
                            quibusdam quos voluptatum debitis doloribus doloremque, iure dicta impedit atque illo. Saepe
                            necessitatibus quis nihil autem excepturi sapiente aliquam, officia ex doloremque quia
                            corporis vero
                            esse, harum odit, optio nam quos! Debitis aspernatur sunt at? Quam quis dolore doloremque
                            facilis
                            qui ab obcaecati blanditiis ullam, incidunt illo rerum eum! Dolorum libero reprehenderit
                            ullam
                            repellat ad?</p>
                        <a href="#" class="fw-bold">Selengkapnya...</a>
                    </div>
                </div>
            </div>
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
                <h5 class="p-0 m-0 mb-1">KESAN PESAN</h5>
                <div class="col-4 bg-city p-0">
                    <div class="line-lv1"></div>
                </div>
                <div class="col-8 bg-gray p-0">
                    <div class="line-lv2"></div>
                </div>
            </div>
            <div class="row m-0">
                {{-- Kesan Pesan --}}
                <div class="card bg-with mt-md-0 p-2 shadow-sm border-0 mb-3">
                    <div class="card-body p-2">
                        <form action="#" method="post">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-alt"
                                    placeholder="Masukkan nama lengkap Anda" id="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-alt"
                                    placeholder="Masukkan alamat email Anda" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="noHp" class="form-label">No Telepon<span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control form-control-alt"
                                    placeholder="Masukkan nomor telepon Anda" id="noHp" required>
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea id="pesan" class="form-control form-control-alt" placeholder="Tulis pesan atau pertanyaan Anda di sini"
                                    cols="30" rows="5"></textarea>
                            </div>
                            <button class="btn btn-alt-primary float-end"><i
                                    class="fa-solid fa-paper-plane me-1"></i>Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
