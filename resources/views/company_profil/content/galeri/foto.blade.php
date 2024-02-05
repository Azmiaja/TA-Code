@extends('company_profil/content/galeri/index')
@section('galeri')
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
                    <div class="col-lg-4 col-md-6">
                        <a class="block block-rounded block-link-pop overflow-hidden popup-link m-0"
                            href="https://i.pinimg.com/originals/12/97/a4/1297a454d516f4f0952f471f7eafc323.jpg">
                            <div class="ratio ratio-16x9">
                                <img class="img-fluid"
                                    src="https://i.pinimg.com/originals/12/97/a4/1297a454d516f4f0952f471f7eafc323.jpg"
                                    alt="">
                            </div>
                            <div class="block-content">
                                <p class="fs-sm fw-medium mb-2">
                                    02 Januari 2024
                                </p>
                                <p class="fs-sm text-muted ellipse text-justify">
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quisquam, omnis alias natus ab
                                    aliquid magnam laborum suscipit. Illum, nihil cumque.
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <a class="block block-rounded block-link-pop overflow-hidden popup-link m-0"
                            href="https://i.pinimg.com/564x/2c/ab/78/2cab78a8830951815f5f04a433cf4a4d.jpg">
                            <div class="ratio ratio-16x9">
                                <img class="img-fluid"
                                    src="https://i.pinimg.com/564x/2c/ab/78/2cab78a8830951815f5f04a433cf4a4d.jpg"
                                    alt="">
                            </div>
                            <div class="block-content">
                                <p class="fs-sm fw-medium mb-2">
                                    02 Januari 2024
                                </p>
                                <p class="fs-sm text-muted ellipse text-justify">
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quisquam, omnis alias natus ab
                                    aliquid magnam laborum suscipit. Illum, nihil cumque.
                                </p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <a class="block block-rounded block-link-pop overflow-hidden popup-link m-0"
                            href="https://i.pinimg.com/originals/12/97/a4/1297a454d516f4f0952f471f7eafc323.jpg">
                            <div class="ratio ratio-16x9">
                                <img class="img-fluid"
                                    src="https://i.pinimg.com/originals/12/97/a4/1297a454d516f4f0952f471f7eafc323.jpg"
                                    alt="">
                            </div>
                            <div class="block-content">
                                <p class="fs-sm fw-medium mb-2">
                                    02 Januari 2024
                                </p>
                                <p class="fs-sm text-muted ellipse text-justify">
                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quisquam, omnis alias natus ab
                                    aliquid magnam laborum suscipit. Illum, nihil cumque.
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
