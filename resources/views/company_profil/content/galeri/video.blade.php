@extends('company_profil/content/galeri/index')
@section('galeri')
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
                <div class="row g-3">
                    <div class="col-lg-4 col-md-6">
                        <a class="block block-rounded block-link-pop overflow-hidden m-0 popup-youtube"
                            href="https://www.youtube.com/watch?v=oGOO94rRzCQ">
                            <div class="ratio ratio-16x9">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/oGOO94rRzCQ?si=r3QvehVXB8RYyFyS&amp;controls=0"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                            <div class="block-content">
                                <p class="fs-sm fw-medium mb-2">
                                    02 Januari 2024
                                </p>
                                <p class="fs-sm text-muted ellipse text-justify">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quisquam quia iure minima
                                    nulla atque ipsum! Eveniet eligendi amet quia rerum magnam veritatis. Dolores nostrum
                                    dicta incidunt, pariatur praesentium assumenda ducimus.
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <a class="block block-rounded block-link-pop overflow-hidden m-0 popup-youtube"
                            href="https://www.youtube.com/watch?v=oMUf-sW_19o">
                            <div class="ratio ratio-16x9">
                                <iframe width="560" height="315"
                                    src="https://www.youtube.com/embed/oMUf-sW_19o?si=3CaSTxRs3R70lX1F&amp;controls=0"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                            <div class="block-content">
                                <p class="fs-sm fw-medium mb-2">
                                    02 Januari 2024
                                </p>
                                <p class="fs-sm text-muted ellipse text-justify">
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quisquam quia iure minima
                                    nulla atque ipsum! Eveniet eligendi amet quia rerum magnam veritatis. Dolores nostrum
                                    dicta incidunt, pariatur praesentium assumenda ducimus.
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
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
