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
    @push('scripts')
        <script>
            var spans = document.querySelectorAll('#isiKonten p span');

            spans.forEach(function(span) {
                span.style.removeProperty('color');
            });
        </script>
    @endpush
    @php
        use Carbon\Carbon;
    @endphp
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
                    <div class="card rounded position-relative p-0" style="height: 500px;">
                        @if ($beritaSatuTerbaru->gambar)
                            <img src="{{ asset('storage/' . $beritaSatuTerbaru->gambar) }}"
                                class="card-img object-fit-cover w-100" height="100%" alt="Berita Utama">
                        @else
                            <img src="{{ asset('assets/media/img/tmb.svg') }}" class="card-img object-fit-cover w-100"
                                height="100%" alt="Berita Utama">
                        @endif
                        <div class="card-img-overlay bg-dark bg-opacity-50 text-bg-dark rounded-0 rounded-bottom">
                            <h3 class="card-title fw-bold ellipse-tree">{{ $beritaSatuTerbaru->judulBerita }}
                            </h3>
                            <div id="isiKonten" class="mb-1 text-justify ellipse-berita-utama">{!! $beritaSatuTerbaru->isiBerita !!}</div>
                            <a href="{{ route('baca_berita') }}" class="stretched-link fw-bold"></a>
                        </div>
                        <div class="position-absolute bottom-0 end-0 bg-white p-2 px-4"
                            style="border-radius: 15px 0px 3px 0px">
                            <small class="fs-sm"><i class="fa-solid fa-calendar-day me-1"></i><span
                                    class="fw-semibold text-dark">
                                    <a class="link-effect"
                                        href="#">{{ implode(' ', array_slice(str_word_count($beritaSatuTerbaru->penulis, 1), 0, 2)) }}</a>
                                    on
                                    {{ Carbon::parse($beritaSatuTerbaru->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') }}
                                    <span class="d-sm-inline d-none"> &bull;
                                        {{ Carbon::parse($beritaSatuTerbaru->waktu)->locale('id_ID')->isoFormat('HH:mm') }}</span></span>
                            </small>
                        </div>
                    </div>
                @endif

                {{-- @endforeach --}}
            </div>
            <div class="row m-0 mb-lg-3">
                <div class="col-12 p-0">
                    <div class="row g-3 mb-lg-0 mb-3 d-block d-lg-none">
                        {{-- Konten Berita --}}
                        @foreach ($beritaTerbaru as $bTree)
                            <div class="col-md-12">
                                <div class="d-flex rounded shadow-sm p-2 bg-white">
                                    @if ($bTree->gambar)
                                        <img src="{{ asset('storage/' . $bTree->gambar) }}" alt="Berita"
                                            class="flex-shrink-0 me-3 object-fit-cover rounded" width="100"
                                            height="100">
                                    @else
                                        <img src="{{ asset('assets/media/img/tmb.svg') }}" alt="Berita"
                                            class="flex-shrink-0 me-3 object-fit-cover rounded" width="100"
                                            height="100">
                                    @endif
                                    <div class="w-100 position-relative">
                                        <p class="fw-medium my-0 mb-4 fst-normal text-dark">{{ $bTree->judulBerita }}</p>
                                        {{-- <small class="ellipse text-justify mb-4">Lorem
                                            ipsum, dolor sit amet
                                            consectetur adipisicing
                                            elit. Ex facilis cumque delectus expedita libero nihil cupiditate blanditiis
                                            quibusdam maiores fuga quae iusto ipsum vel atque praesentium sapiente corporis
                                            vero, neque quas maxime ea et pariatur sint id? Explicabo, dignissimos nostrum!
                                            Rem
                                            sunt dignissimos rerum odio, itaque velit iusto dolorem laborum?</small> --}}
                                        <small class="text-primary position-absolute bottom-0" style="font-size: 0.8rem;">
                                            <i class="fa-solid fa-calendar-day me-1"></i>
                                            <span class="fw-semibold text-dark">
                                                <a class="link-effect d-xxl-none d-xl-none d-lg-none d-md-inline d-sm-inline d-none"
                                                    href="#">{{ implode(' ', array_slice(str_word_count($bTree->penulis, 1), 0, 2)) }}</a>
                                                <span
                                                    class="d-xxl-none d-xl-none d-lg-none d-md-inline d-sm-inline d-none">on</span>
                                                {{ Carbon::parse($bTree->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') }}
                                                <span
                                                    class="d-xxl-none d-xl-inline d-lg-none d-md-inline d-sm-inline d-none">&bull;</span>
                                                <span class="d-sm-inline d-none">
                                                    {{ Carbon::parse($bTree->waktu)->locale('id_ID')->isoFormat('HH:mm') }}</span>
                                            </span>
                                        </small>

                                        <a href="#" class="stretched-link"></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row g-3">
                        {{-- Konten Berita --}}
                        @foreach ($berita as $b)
                            <div class="col-xl-6 col-12">
                                <div class="d-flex rounded shadow-sm p-2 bg-white">
                                    @if ($b->gambar)
                                        <img src="{{ asset('storage/' . $b->gambar) }}" alt="Berita"
                                            class="flex-shrink-0 me-3 object-fit-cover rounded" width="100"
                                            height="100">
                                    @else
                                        <img src="{{ asset('assets/media/img/tmb.svg') }}" alt="Berita"
                                            class="flex-shrink-0 me-3 object-fit-cover rounded" width="100"
                                            height="100">
                                    @endif
                                    <div class="w-100 position-relative">
                                        <p class="fw-medium my-0 fst-normal text-justify text-dark mb-4">
                                            {{ $b->judulBerita }}</p>
                                        {{-- <small class="ellipse text-justify mb-4"><p class="lead">{!! $b->isiBerita !!}</p></small> --}}
                                        <small class="text-primary position-absolute bottom-0" style="font-size: 0.8rem;">
                                            <i class="fa-solid fa-calendar-day me-1"></i>
                                            <span class="fw-semibold text-dark">
                                                <a class="link-effect d-xxl-inline d-xl-none d-lg-inline d-md-inline d-sm-inline d-none"
                                                    href="#">{{ implode(' ', array_slice(str_word_count($b->penulis, 1), 0, 2)) }}</a>
                                                <span
                                                    class="d-xxl-inline d-xl-none d-lg-inline d-md-inline d-sm-inline d-none">on</span>
                                                {{ Carbon::parse($b->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') }}
                                                <span class="d-sm-inline d-none">&bull;
                                                    {{ Carbon::parse($b->waktu)->locale('id_ID')->isoFormat('HH:mm') }}</span>
                                            </span>
                                        </small>
                                        <a href="#" class="stretched-link"></a>
                                    </div>
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
                <div class="row m-0 mb-3 g-1 bg-white rounded shadow-sm p-2">
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
                        <button type="submit" class="btn btn-alt-danger" title="Enter"><i class="fa-solid fa-paper-plane"></i></button>
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
                                <div class="d-flex rounded shadow-sm p-2 bg-white">
                                    @if ($bTree->gambar)
                                        <img src="{{ asset('storage/' . $bTree->gambar) }}" alt="Berita"
                                            class="flex-shrink-0 me-3 object-fit-cover rounded" width="100"
                                            height="100">
                                    @else
                                        <img src="{{ asset('assets/media/img/tmb.svg') }}" alt="Berita"
                                            class="flex-shrink-0 me-3 object-fit-cover rounded" width="100"
                                            height="100">
                                    @endif
                                    <div class="w-100 position-relative">
                                        <p class="fw-medium my-0 mb-4 fst-normal text-dark">{{ $bTree->judulBerita }}</p>
                                        {{-- <small class="ellipse text-justify mb-4">Lorem
                                            ipsum, dolor sit amet
                                            consectetur adipisicing
                                            elit. Ex facilis cumque delectus expedita libero nihil cupiditate blanditiis
                                            quibusdam maiores fuga quae iusto ipsum vel atque praesentium sapiente corporis
                                            vero, neque quas maxime ea et pariatur sint id? Explicabo, dignissimos nostrum!
                                            Rem
                                            sunt dignissimos rerum odio, itaque velit iusto dolorem laborum?</small> --}}
                                        <small class="text-primary position-absolute bottom-0" style="font-size: 0.8rem;">
                                            <i class="fa-solid fa-calendar-day me-1"></i>
                                            <span class="fw-semibold text-dark">
                                                <a class="link-effect d-xxl-none d-xl-none d-lg-none d-md-inline d-sm-inline d-none"
                                                    href="#">{{ implode(' ', array_slice(str_word_count($bTree->penulis, 1), 0, 2)) }}</a>
                                                <span
                                                    class="d-xxl-none d-xl-none d-lg-none d-md-inline d-sm-inline d-none">on</span>
                                                {{ Carbon::parse($bTree->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') }}
                                                <span
                                                    class="d-xxl-none d-xl-inline d-lg-none d-md-inline d-sm-inline d-none">&bull;</span>
                                                <span class="d-sm-inline d-none">
                                                    {{ Carbon::parse($bTree->waktu)->locale('id_ID')->isoFormat('HH:mm') }}</span>
                                            </span>
                                        </small>

                                        <a href="#" class="stretched-link"></a>
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
