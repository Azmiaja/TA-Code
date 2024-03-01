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
                height: auto;
            }

            @media (max-width: 1400px) {
                .ellipse-berita-utama {
                    display: -webkit-box;
                    -webkit-line-clamp: 6;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: normal;
                }
            }

            @media (min-width: 1400px) {
                .ellipse-berita-utama {
                    display: -webkit-box;
                    -webkit-line-clamp: 6;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: normal;
                }
            }

            @media (max-width: 1200px) {
                .ellipse-berita-utama {
                    display: -webkit-box;
                    -webkit-line-clamp: 5;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: normal;
                }
            }

            @media (max-width: 992px) {

                .ellipse-berita-utama {
                    display: -webkit-box;
                    -webkit-line-clamp: 4;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: normal;
                }

                .card-title {
                    font-size: 1.25rem;
                }
            }

            @media (max-width: 768px) {
                .ellipse-berita-utama {
                    display: -webkit-box;
                    -webkit-line-clamp: 4;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: normal;
                }

                .card-title {
                    font-size: 0.9rem;
                }

                #isiKonten {
                    font-size: 0.6rem;
                }

            }

            @media (max-width: 576px) {
                .ellipse-berita-utama {
                    display: -webkit-box;
                    -webkit-line-clamp: 4;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: normal;
                }

                .card-title {
                    font-size: 0.8rem;
                }

                #isiKonten {
                    font-size: 0.6rem;
                }

            }

            @media (max-width: 410px) {
                .ellipse-berita-utama {
                    display: -webkit-box;
                    -webkit-line-clamp: 4;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: normal;
                }

                .card-title {
                    font-size: 0.6rem;
                }

                #isiKonten {
                    font-size: 0.6rem;
                }

            }
        </style>
    @endpush
    @push('scripts')
        <script>
            var spans = document.querySelectorAll('#isiKonten p span');

            spans.forEach(function(span) {
                span.style.removeProperty('color');
                var parentParagraph = span.parentNode; // Ambil elemen induk (p)
                var content = document.createTextNode(span.textContent); // Buat teks dari konten span
                parentParagraph.replaceWith(content);
            });
        </script>
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
                @if ($beritaSatuTerbaru)
                    <div class="card border-0 rounded-3 position-relative p-0">
                        <div class="ratio ratio-16x9">
                            <img src="{{ $beritaSatuTerbaru['gambar'] }}" class="card-img rounded-3"
                                style="width: 100%; height: 100%; object-fit: cover" alt="Berita Utama">
                        </div>
                        <div class="card-img-overlay p-3 bg-dark bg-opacity-50 text-bg-dark rounded-0 rounded-bottom">
                            <h3 class="card-title fw-bold ellipse-tree" style="height: 32%;">
                                {{ $beritaSatuTerbaru['judul'] }}</h3>
                            <div id="isiKonten" class="col-12 ellipse-berita-utama text-justify">
                                {!! $beritaSatuTerbaru['isi'] !!}</div>
                            <a href="{{ route('baca_berita', ['slug' => $beritaSatuTerbaru['slug'], 'id' => $beritaSatuTerbaru['id']]) }}"
                                class="stretched-link fw-bold"></a>
                        </div>
                        <div class="position-absolute bottom-0 end-0 bg-white p-2 px-4 d-md-block d-sm-block d-none tag"
                            style="border-radius: 15px 0px .25rem 0px">
                            <span class="fw-semibold text-dark fs-sm">
                                <a class="link-effect" href="#">{{ $beritaSatuTerbaru['penulis'] }}</a>
                                <span>{{ $beritaSatuTerbaru['tanggal'] }} &bull;</span>
                                <span class="text-muted">
                                    {{ $beritaSatuTerbaru['waktu'] }}</span>
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row m-0 mb-lg-3">
                <div class="col-12 p-0">
                    <div class="row g-3 mb-lg-0 mb-3 d-block d-lg-none">
                        <form action="{{ route('berita') }}" method="GET">
                            <div class="row m-0 mb-3 g-md-1 g-0 bg-white rounded shadow-sm p-2 justify-content-between">
                                <div class="col-4">
                                    <select name="tahunBerita" class="form-select" required>
                                        <option value="" selected>Tahun</option>
                                        @foreach ($ambilTahun as $tahun)
                                            @php
                                                // Parse tanggal menggunakan createFromFormat
                                                $carbonDate = \Carbon\Carbon::createFromFormat('Y', $tahun->tahun)->startOfMonth();
                                            @endphp

                                            <option value="{{ $carbonDate->format('Y') }}"
                                                {{ request('tahunBerita') == $carbonDate->format('Y') ? 'selected' : '' }}>
                                                {{ $carbonDate->format('Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <select name="bulanBerita" class="form-select" required>
                                        <option value="" selected>Bulan</option>
                                        @foreach ($ambilBulan as $bulan)
                                            @php
                                                // Parse tanggal menggunakan createFromFormat
                                                $carbonDate = \Carbon\Carbon::createFromFormat('m', $bulan->bulan)->startOfMonth();
                                            @endphp

                                            <option value="{{ $carbonDate->format('m') }}"
                                                {{ request('bulanBerita') == $carbonDate->format('m') ? 'selected' : '' }}>
                                                {{ $carbonDate->locale('id_ID')->isoFormat('MMMM') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-alt-danger px-md-4 px-3" title="Enter"><i
                                            class="fa-solid fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </form>
                        {{-- Konten Berita --}}
                        @foreach ($beritaTerbaru as $bTree)
                            <div class="col-md-12">
                                <div class="d-flex block block-rounded shadow-sm p-2 m-0 position-relative h-100">
                                    <div class="ratio" style="max-width: 6rem; height: 6rem;">
                                        <img src="{{ $bTree['gambar'] }}" alt="Berita" class="rounded"
                                            style="width: 100%; height: 100%; object-fit: cover">
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
                                    <a href="{{ route('baca_berita', ['slug' => $bTree['slug']]) }}"
                                        class="stretched-link"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row g-3">
                        {{-- Konten Berita --}}
                        @foreach ($berita as $bTree)
                            <div class="col-xl-6 col-12">
                                <div class="d-flex block block-rounded shadow-sm p-2 m-0 position-relative -100">
                                    <div class="ratio" style="max-width: 6rem; height: 6rem;">
                                        <img src="{{ $bTree['gambar'] }}" alt="Berita" class="rounded"
                                            style="width: 100%; height: 100%; object-fit: cover">
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
                                    <a href="{{ route('baca_berita', ['slug' => $bTree['slug']]) }}"
                                        class="stretched-link"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-lg-4 col-12 d-none d-lg-block">
            {{-- <div class="row m-0 mb-3 "> --}}
            <form action="{{ route('berita') }}" method="GET">
                <div class="row m-0 mb-3 g-1 bg-white rounded shadow-sm p-2 justify-content-between">
                    <div class="col-4 ">
                        <select name="tahunBerita" id="tahunBerita" class="form-select" required>
                            <option value="" selected>Tahun</option>
                            @foreach ($ambilTahun as $tahun)
                                @php
                                    // Parse tanggal menggunakan createFromFormat
                                    $carbonDate = \Carbon\Carbon::createFromFormat('Y', $tahun->tahun)->startOfMonth();
                                @endphp

                                <option value="{{ $carbonDate->format('Y') }}"
                                    {{ request('tahunBerita') == $carbonDate->format('Y') ? 'selected' : '' }}>
                                    {{ $carbonDate->format('Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 ">
                        <select name="bulanBerita" id="bulanBerita" class="form-select" required>
                            <option value="" selected>Bulan</option>
                            @foreach ($ambilBulan as $bulan)
                                @php
                                    // Parse tanggal menggunakan createFromFormat
                                    $carbonDate = \Carbon\Carbon::createFromFormat('m', $bulan->bulan)->startOfMonth();
                                @endphp

                                <option value="{{ $carbonDate->format('m') }}"
                                    {{ request('bulanBerita') == $carbonDate->format('m') ? 'selected' : '' }}>
                                    {{ $carbonDate->locale('id_ID')->isoFormat('MMMM') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto ">
                        <button type="submit" class="btn btn-alt-danger" title="Enter"><i
                                class="fa-solid fa-paper-plane"></i></button>
                    </div>
                </div>
            </form>
            {{-- </div> --}}
            <div class="row m-0 mb-3">
                <div class="col-12 p-0">
                    <div class="row g-3">
                        {{-- Konten Berita --}}
                        @foreach ($beritaTerbaru as $bTree)
                            <div class="col-md-12">
                                <div class="d-flex block block-rounded shadow-sm p-2 m-0 position-relative">
                                    <div class="ratio" style="max-width: 6rem; height: 6rem;">
                                        <img src="{{ $bTree['gambar'] }}" alt="Berita" class="rounded"
                                            style="width: 100%; height: 100%; object-fit: cover">
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
                                    <a href="{{ route('baca_berita', ['slug' => $bTree['slug']]) }}"
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
