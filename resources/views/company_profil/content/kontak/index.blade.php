@extends('company_profil/layouts/app')
@section('app')
    <div class="row my-3 g-3">
        <div class="col-xxl-9 col-lg-8 col-12">
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
                <h3 class="p-0 m-0 mb-1 fw-bold">HUBUNGI KAMI</h3>
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

        <div class="col-xxl-3 col-lg-4 col-12">
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
            <div class="row m-0">
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
