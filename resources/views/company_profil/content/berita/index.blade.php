@extends('company_profil/layouts/app')
@section('app')
    @push('style')
        <style>
            .card-img-overlay {
                position: absolute;
                top: 40%;
                right: 0;
                bottom: 0;
                left: 0;
                padding: var(--bs-card-img-overlay-padding);
                border-radius: var(--bs-card-inner-border-radius);
            }

            .ellipse-berita-utama {
                display: -webkit-box;
                -webkit-line-clamp: 5;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: normal;
            }
        </style>
    @endpush
    <div class="row my-3 g-3">
        <div class="col-xxl-9 col-lg-8 col-12">
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
                <h3 class="p-0 m-0 mb-1 fw-bold">BERITA</h3>
                <div class="col-4 bg-city p-0">
                    <div class="line-lv1"></div>
                </div>
                <div class="col-8 bg-gray p-0">
                    <div class="line-lv2"></div>
                </div>
            </div>
            <div class="row m-0 mb-3">
                <div class="card rounded position-relative p-0" style="height: 500px;">
                    <img src="https://i.pinimg.com/originals/12/97/a4/1297a454d516f4f0952f471f7eafc323.jpg"
                        class="card-img object-fit-cover w-100" height="100%" alt="Berita Utama">
                    {{-- <svg class="bd-placeholder-img bd-placeholder-img-lg card-img" width="100%" height="100%"
                        xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Card image"
                        preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#868e96"></rect><text x="50%" y="50%" fill="#dee2e6"
                            dy=".3em">Content Berita</text>
                    </svg> --}}
                    <div class="card-img-overlay bg-dark bg-opacity-50 text-bg-dark rounded-0 rounded-bottom">
                        <h3 class="card-title fw-bold ellipse-tree">Lorem ipsum dolor, sit amet consectetur adipisicing
                            elit. Voluptatem eligendi sequi ipsam dignissimos illo, aperiam sit iure accusantium beatae
                            reprehenderit quasi, et iste rerum. Fugit!
                        </h3>
                        <p class="mb-1 text-justify ellipse-berita-utama">Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Quos soluta, minima eaque natus perferendis obcaecati consectetur, eius veniam reiciendis
                            repudiandae ducimus culpa dolorem fuga tempora sunt voluptatem eos odio vel, quae quod
                            consequatur pariatur. Neque, voluptatibus officiis provident animi culpa blanditiis quaerat
                            laborum rem nobis distinctio sit, necessitatibus porro fugit.</p>
                        <a href="{{ route('baca_berita') }}" class="stretched-link fw-bold"></a>
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-gray p-2 px-4" style="border-radius: 15px 0px 3px 0px">
                        <small class="text-gray-dark"><i class="fa-solid fa-calendar-day me-1"></i>02 Januari 2024
                        </small>
                    </div>
                </div>
            </div>
            <div class="row m-0 mb-lg-3">
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
            <div class="row m-0 mb-3 d-none d-lg-block">
                <div class="bg-white rounded shadow-sm p-2">
                    <select name="bulanBerita" id="bulanBerita" class="form-select">
                        <option value="Januari">Januari</option>
                    </select>
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
