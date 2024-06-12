</main>
</div>
<!-- ======= Footer ======= -->

<footer class="footer">
    <section class="py-4 bg-gray navbar-dark">
        <div class="container overflow-hidden">
            <div class="row p-sm-0 p-2">
                <div class="col-xxl-9 col-md-8 col-12 m-0 p-0">
                    <div class="widget">
                        <div class="row m-0">
                            <div class="col-sm-auto pe-sm-2 pe-0 col-3 p-0">
                                <!-- Logo -->
                                <img src="{{ $logoSD }}" class="img-fluid" alt="logo SD" width="90">
                            </div>
                            <div class="col-sm-8 col-9 p-0 align-self-center">
                                <a href="{{ route('home') }}"
                                    class="navbar-brand py-auto d-inline-block text-lg-start text-center w-100">
                                    <h3 class="text-city fw-bold text-lg-nowrap text-wrap m-0 text-uppercase">
                                        {{ $namaSD }}<br>
                                        <p class="fw-semibold text-lg-nowrap text-wrap text-city-dark m-0 pt-2 text-uppercase"
                                            style="font-size: .8rem;">{{ $sloganSD }}</p>
                                    </h3>
                                </a>
                            </div>
                        </div>
                        <div class="row m-0 h-100 align-items-center">
                            <div class="p-0 m-0">
                                <ul class="nav-main m-0 justify-content-center justify-content-lg-end">
                                    <li class="nav-main-item">
                                        <a href="https://mail.google.com/mail/?view=cm&to={{ $emailSD }}"
                                            target="_blank" class="nav-link text-city-dark fw-semibold ">
                                            <i class="fa-solid fa-envelope text-city me-1"></i>
                                            <span style="font-size: .95rem;">{{ $emailSD }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a href="#" class="nav-link text-city-dark fw-semibold">
                                            <i class="fa-solid fa-phone text-city me-1"></i>
                                            <span style="font-size: .95rem;">{{ $telpSD }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a href="{{ $mapsLink }}" class="nav-link text-city-dark fw-semibold">
                                            <i class="fa-solid fa-location-dot text-city me-1"></i>
                                            <span style="font-size: .95rem;">{{ $alamatSD }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-4 col-12 m-0 p-0">
                    <div class="col-12 float-md-end float-sm-start p-0">
                        <div class="mb-2">
                            <i class="fa-solid fa-map-location-dot text-city me-1"></i>
                            <span class="fw-semibold" style="font-size: .95rem;">Maps</span>
                        </div>
                        <div class="m-0 maps-container">
                            {!! $mapsEmbed !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>



<!-- Template Main JS File -->
<script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>

<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>

@stack('scripts')

</body>

</html>
