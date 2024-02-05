</main>
</div>
<!-- ======= Footer ======= -->

<footer class="footer">
    <section class="py-4 bg-gray navbar-dark">
        <div class="container overflow-hidden">
            <div class="row p-0">
                <div class="col-12 col-md-6 p-0">
                    <div class="widget">
                        <div class="row m-0 mb-3">
                            <div class="col-sm-2 col-3 p-0">
                                <!-- Logo -->
                                <img src="{{ asset('assets/media/favicons/logo_sd.png') }}" class="img-fluid"
                                    alt="logo SD" width="80">
                            </div>
                            <div class="col-sm-8 col-9 p-0 align-self-center">
                                <a href="#"
                                    class="navbar-brand py-auto d-inline-block text-lg-start text-center w-100">
                                    <h3 class="text-city fw-bold text-lg-nowrap text-wrap m-0">SD NEGERI
                                        LEMAHBANG<br>
                                        <p class="fw-semibold text-lg-nowrap text-wrap text-city-dark m-0 pt-2"
                                            style="font-size: .8rem;">SEDAN ABANG JAYA</p>
                                    </h3>
                                </a>
                            </div>
                        </div>
                        <div class="row m-0 h-100 align-items-center">
                            <div class="p-0 m-0">
                                <ul class="nav-main m-0 justify-content-center justify-content-lg-end">
                                    <li class="nav-main-item">
                                        <a href="https://mail.google.com/mail/?view=cm&to=sdnlemahbang@yahoo.co.id"
                                            target="_blank" class="nav-link text-city-dark fw-semibold ">
                                            <i class="fa-solid fa-envelope text-city me-1"></i>
                                            <span style="font-size: .95rem;">sdnlemahbang@yahoo.co.id</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a href="#" class="nav-link text-city-dark fw-semibold">
                                            <i class="fa-solid fa-phone text-city me-1"></i>
                                            <span style="font-size: .95rem;">085855477650</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a href="#" class="nav-link text-city-dark fw-semibold">
                                            <i class="fa-solid fa-location-dot text-city me-1"></i>
                                            <span style="font-size: .95rem;">9CCX+GGV,
                                                Lemahbang, Kec. Bendo, Kabupaten Magetan, Jawa Timur 63384</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 p-0">
                    <div class="widget float-md-end float-sm-start p-0">
                        <div class="mb-2">
                            <i class="fa-solid fa-map-location-dot text-city me-1"></i>
                            <span class="fw-semibold" style="font-size: .95rem;">Maps</span>
                        </div>
                        <div class="d-inline m-0"
                            href="#">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.505701694225!2d111.4488059!3d-7.628635599999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7995bd2a2b4efd%3A0xffeb923623a43b48!2sSDN%20Lemahbang!5e0!3m2!1sid!2sid!4v1706896602378!5m2!1sid!2sid"
                                width="380" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>

{{-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a> --}}

<script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/oneui.app.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/purecounter/purecounter.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

@stack('scripts')

<script>
    $(document).ready(function() {
                $('.popup-maps').magnificPopup({
                    type: 'iframe',
                });
            });
</script>


</body>

</html>
