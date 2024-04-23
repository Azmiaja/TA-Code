@extends('company_profil/content/galeri/index')
@section('galeri')
    @php
        use Carbon\Carbon;
    @endphp
    <div class="row m-0 mb-3">
        {{-- Garis Judul --}}
        <div class="row m-0 p-0 mb-3">
            <h3 class="p-0 m-0 mb-1 fw-bold">FOTO</h3>
            <div class="col-4 bg-city p-0">
                <div class="line-lv1"></div>
            </div>
            <div class="col-8 bg-gray p-0">
                <div class="line-lv2"></div>
            </div>
        </div>
        <div class="row m-0 p-0 mb-3">
            <div class="col-12 p-0">
                <div class="row g-3">
                    @foreach ($dock as $b)
                        @php
                            $gambar = $b->media
                                ? (file_exists(public_path('storage/' . $b->media))
                                    ? asset('storage/' . $b->media)
                                    : asset('assets/media/img/empty-image.jpg'))
                                : asset('assets/media/img/empty-image.jpg');
                        @endphp
                        <div class="col-lg-4 col-md-6">
                            {{-- <div class="block block-rounded"> --}}
                            <a class=" block block-rounded block-link-pop overflow-hidden popup-link m-0 h-100"
                                href="{{ $gambar }}">
                                <div class="ratio ratio-16x9">
                                    <img class="object-fit-cover" src="{{ $gambar }}"
                                        alt="Foto-{{ $b->idDokumentasi }}">
                                </div>
                                <div class="block-content p-3">
                                    <p class="fw-medium mx-0 mb-2">
                                        {{ Carbon::parse($b->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') }}
                                    </p>
                                    <p class="fs-sm text-muted text-justify m-0">
                                        {{ $b->judul }}
                                    </p>
                                </div>
                            </a>
                            {{-- </div> --}}
                        </div>
                    @endforeach
                </div>
                <div class="pagination justify-content-center mt-5">
                    {{ $dock->links() }}
                </div>
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
