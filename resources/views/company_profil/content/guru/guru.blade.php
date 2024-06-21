@extends('company_profil/content/guru/index')
@section('guru')
    @push('style')
        <style>
            .aspect-ratio-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        </style>
    @endpush
    <div class="row m-0 mb-3">
        {{-- Garis Judul --}}
        <div class="row m-0 p-0 mb-3">
            <h3 class="p-0 m-0 mb-1 fw-bold">GURU</h3>
            <div class="col-4 bg-city p-0">
                <div class="line-lv1"></div>
            </div>
            <div class="col-8 bg-gray p-0">
                <div class="line-lv2"></div>
            </div>
        </div>
        <div class="row m-0 p-0 mb-3">
            <div class="col-12 p-0">
                @if ($hasilGabungan)
                    <div class="row g-3">
                        @foreach ($hasilGabungan as $item)
                            <div class="col-lg-3 col-md-6 col-6">
                                <a class="block block-rounded block-link-pop overflow-hidden popup-link m-0 h-100"
                                    href="{{ $item['gambar'] }}">
                                    <div class="portrait-content">
                                        <img class="aspect-ratio-img" src="{{ $item['gambar'] }}" alt="">
                                    </div>
                                    <div class="block-content border-top border-3 border-danger p-2">
                                        <h6 class="fw-bold mb-1">
                                            {{ $item['namaPegawai'] }}
                                        </h6>
                                        <p class="text-muted mb-0">
                                            {{ $item['namaJabatan'] }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.popup-link').magnificPopup({
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });
            });
        </script>
    @endpush
@endsection
