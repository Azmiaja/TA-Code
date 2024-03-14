@extends('company_profil/layouts/app')
@section('app')
    <div class="row my-3 g-3">
        <div class="col-xxl-9 col-lg-8 col-12">
            <div class="row">
                {{-- Dokumentasi Terbaru --}}
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade">
                    <div class="carousel-indicators">
                        @foreach ($dock as $index => $item)
                            <button type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide-to="{{ $index }}" {{ $index === 0 ? 'class=active' : '' }}
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner rounded-3">
                        @foreach ($dock as $index => $item)
                            <div class="carousel-item ratio ratio-16x9 {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $item['gambar'] }}" class="rounded-3"
                                    style="width: 100%; height: 100%; object-fit: cover" alt="">
                            </div>
                        @endforeach
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
                    <h6 class="m-0 text-light fw-bold py-lg-4 py-3 text-wrap text-center">SELAMAT DATANG DI WEBSITE RESMI SD
                        NEGERI
                        LEMAHBANG</h6>
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
                        @foreach ($beritaTerbaru as $bTree)
                            <div class="col-12 col-xl-6">
                                <div
                                    class="d-flex block block-rounded block-link-pop shadow-sm p-2 m-0 position-relative h-100">
                                    <div class="ratio" style="max-width: 6rem; height: 6rem;">
                                        <img src="{{ $bTree['gambar'] }}" alt="Berita" class="rounded"
                                            style="width: 100%; height: 100%; object-fit: cover">
                                    </div>
                                    <div class="block-content w-100 align-items-center px-0 ms-2">
                                        <h6 class="my-0 fst-normal text-dark mb-1">
                                            {{ $bTree['judul'] }}
                                        </h6>
                                        <div class="fw-semibold text-dark fs-sm text-wrap">
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

        <div class="col-xxl-3 col-lg-4 col-12">
            {{-- Garis Judul --}}
            <div class="row mx-0 p-0 mb-3">
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
                <div class="block block-rounded bg-with mt-md-0 p-0 shadow-sm border-0 mb-3">
                    <div class="block-content p-2">
                        {{-- Foto Kepala Sekolah --}}
                        <div class="portrait-content">
                            @if ($gambarKepsek == null)
                                <img src="{{ asset('assets/media/avatars/avatar1.jpg') }}" class="rounded-top"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ $gambarKepsek }}" class="rounded-top"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <div class="card-body p-2">
                            {{-- Nama Kepala Sekolah --}}
                            <h6 class="card-title text-center fw-bold m-0 mb-0 py-1">
                                {{ $kepsek }}
                            </h6>
                            <p class="text-muted mb-0 text-center fs-sm fw-normal">
                                - {{ $jabatan }} -
                            </p>
                            <hr class="my-1 mb-3" style="border-width: 0.2rem;">
                            <div class="card-text text-justify ellipse-multi mb-1 fs-sm text-truncate">
                                {!! $sambutan !!}</div>
                        </div>

                    </div>
                    <div class="block-content block-content-full block-content-sm bg-body-light fs-sm text-center">
                        <a href="{{ route('sambutan') }}" class="fw-bold">Selengkapnya</a>
                    </div>
                </div>
            </div>
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
                <h5 class="p-0 m-0 mb-1">PESAN</h5>
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
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fa-solid fa-circle-check fs-3 me-3"></i>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                        @push('scripts')
                            <script>
                                $(document).ready(function() {
                                    setTimeout(function() {
                                        $(".alert").alert('close');
                                    }, 5000);
                                });
                            </script>
                        @endpush
                    @endif

                    <div class="card-body p-2">
                        <form action="{{ route('pesan.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-alt"
                                    placeholder="Masukkan nama lengkap Anda" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-alt"
                                    placeholder="Masukkan alamat email Anda" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="noHp" class="form-label">No Telepon<span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-alt"
                                    placeholder="Masukkan nomor telepon Anda" id="noHp" name="noHp" required>
                                <small id="noHpError" class="text-danger"></small>
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea id="pesan" class="form-control form-control-alt" name="pesan"
                                    placeholder="Tulis pesan atau pertanyaan Anda di sini" cols="30" rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-alt-primary float-end"><i
                                    class="fa-solid fa-paper-plane me-1"></i>Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
