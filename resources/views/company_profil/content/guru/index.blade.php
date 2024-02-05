@extends('company_profil/layouts/app')
@section('app')
    <div class="row my-2 g-3">
        <div class="col-xxl-9 col-lg-8 col-12">

            @yield('guru')

        </div>

        <div class="col-xxl-3 col-lg-4 col-12">
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
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
                        <div class="col-md-12">
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
                        <div class="col-md-12">
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
    </div>
@endsection
