@extends('company_profil/content/galeri/index')
@section('galeri')
    @php
        use Carbon\Carbon;
    @endphp
    <div class="row m-0 mb-3">
        {{-- Garis Judul --}}
        <div class="row m-0 p-0 mb-3">
            <h3 class="p-0 m-0 mb-1 fw-bold">VIDEO</h3>
            <div class="col-4 bg-city p-0">
                <div class="line-lv1"></div>
            </div>
            <div class="col-8 bg-gray p-0">
                <div class="line-lv2"></div>
            </div>
        </div>
        <div class="row m-0 p-0 mb-3">
            <div class="col-12 p-0">
                @if ($video)
                    <div class="row g-3">
                        @foreach ($video as $vd)
                            <div class="col-lg-4 col-md-6">
                                <a class="block block-rounded block-link-pop overflow-hidden m-0 popup-youtube h-100"
                                    href="https://www.youtube.com/watch?v={{ $vd->media }}">
                                    <div class="ratio ratio-16x9">
                                        <iframe width="560" height="315"
                                            src="https://www.youtube.com/embed/{{ $vd->media }}?controls=0&showinfo=0&modestbranding=1">
                                        </iframe>
                                    </div>
                                    <div class="block-content p-3">
                                        <h6 class="fw-medium mx-0 mb-2">
                                            {{ Carbon::parse($vd->waktu)->locale('id_ID')->isoFormat('Do MMMM YYYY') }}</h6>
                                        <p class="fs-sm text-muted text-justify m-0">
                                            {{ $vd->judul }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="pagination justify-content-center mt-5">
                        {{ $video->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.popup-youtube').magnificPopup({
                    type: 'iframe',
                });
            });
        </script>
    @endpush
@endsection
