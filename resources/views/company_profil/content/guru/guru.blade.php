@extends('company_profil/content/guru/index')
@section('guru')
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
            <div class="row g-3">
                <div class="col-lg-4 col-md-6">
                    <a class="block block-rounded block-link-pop overflow-hidden popup-link m-0"
                        href="https://i.pinimg.com/564x/1b/ea/3c/1bea3cd355ba7556bb6a07a46ba42987.jpg">
                        <div class="portrait-content">
                            <img class="object-fit-cover w-100 h-100"
                                src="https://i.pinimg.com/564x/1b/ea/3c/1bea3cd355ba7556bb6a07a46ba42987.jpg"
                                alt="">
                        </div>
                        <div class="block-content">
                            <h6 class="fw-bold mb-2">
                                Achmad Fachri Azmi Dwinika Adi
                            </h6>
                            <p class="text-muted">
                                Developers
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a class="block block-rounded block-link-pop overflow-hidden popup-link m-0"
                        href="https://i.pinimg.com/564x/1b/ea/3c/1bea3cd355ba7556bb6a07a46ba42987.jpg">
                        <div class="portrait-content">
                            <img class="object-fit-cover w-100 h-100"
                                src="https://i.pinimg.com/564x/1b/ea/3c/1bea3cd355ba7556bb6a07a46ba42987.jpg"
                                alt="">
                        </div>
                        <div class="block-content">
                            <h6 class="fw-bold mb-2">
                                Achmad Fachri Azmi Dwinika Adi
                            </h6>
                            <p class="text-muted">
                                Developers
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