<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Login - Siakad SDN Lemahbang</title>

    <link rel="shortcut icon" href="{{ asset('assets/media/img/tut-wuri.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/img/tut-wuri.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/media/img/tut-wuri.png') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.min.css') }}">
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-9HQDQJJYW7"></script> --}}
</head>

<body>
    <div id="page-container">
        <main id="main-container">
            <div class="bg-image">
                <div class="row g-0 bg-primary-dark-op">
                    <div class="hero-static col-lg-4 d-none d-lg-flex flex-column justify-content-center">
                        <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                            <div class="w-100">
                                <a class="link-fx fw-semibold fs-2 text-white" href="#">
                                    Selamat Datang di,
                                </a>
                                <p class="text-white-75 me-xl-8 mt-2">
                                    Website Resmi Sistem Informasi Akademik SDN Lemahbang.
                                </p>
                            </div>
                        </div>
                        <div class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center fs-sm">
                            <p class="fw-medium text-white-50 mb-0">
                                <strong>SDN Lemahbang</strong> &copy; <span data-toggle="year-copy"></span>
                            </p>
                        </div>
                    </div>
                    <div class="hero-static col-lg-8 d-flex flex-column align-items-center bg-body-extra-light">
                        <div class="p-3 w-100 d-lg-none text-center">
                            <a class="link-fx fw-semibold fs-3 text-dark" href="#">
                                Sistem Informasi Akademik <br>SDN Lemahbang
                            </a>
                        </div>
                        <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                            <div class="w-100">
                                <div class="text-center mb-5">
                                    <div>
                                        <img class="img-fluid" width="120"
                                            src="{{ asset('assets/media/img/tut-wuri.png') }}">
                                    </div>
                                    <h1 class="fw-bold mb-2">
                                        Login
                                    </h1>
                                    <p class="fw-medium text-muted">
                                        Masukkan Username dan Password Anda.
                                    </p>
                                </div>
                                <div class="row g-0 justify-content-center">
                                    <div class="col-sm-8 col-xl-4">
                                        {{-- form login --}}
                                        <form class="js-validation-signin" action="/authenticate" autocomplete="off"
                                            method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <input type="text"
                                                    class="form-control form-control-lg form-control-alt py-3"
                                                    id="username" name="username" placeholder="Username" required>
                                            </div>
                                            <div class="mb-4">
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-alt py-3"
                                                    id="password" name="password" placeholder="Password" required>
                                            </div>
                                            <div class="justify-content-center align-items-center mb-4">
                                                <div class="col-12 text-center">
                                                    <button type="submit" class="btn btn-lg btn-alt-primary">
                                                        <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> LOGIN
                                                    </button>
                                                </div>
                                                <div class="col-12 text-center mt-3">
                                                    <p class="pt-3"><a href="/">Back to home page</a></p>
                                                </div>
                                            </div>
                                        </form>
                                        @if (session('error'))
                                            <div class="alert alert-danger d-flex align-items-center fade show mb-3"
                                                role="alert">
                                                <i class="fa-solid fa-circle-exclamation fs-3 me-3"></i>
                                                <div>
                                                    {{ session('error') }}
                                                </div>
                                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            @push('scripts')
                                                <script>
                                                    $(document).ready(function() {
                                                        setTimeout(function() {
                                                            $(".alert").alert('close');
                                                        }, 5000);
                                                    });
                                                </script>
                                            @endpush
                                        @endif
                                        {{-- @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="px-4 py-3 w-100 d-lg-none d-flex flex-column flex-sm-row justify-content-between fs-sm text-center text-sm-start">
                            <p class="fw-medium text-black-50 py-2 mb-0">
                                <strong>SDN Lemahbang</strong> &copy; <span data-toggle="year-copy"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="assets/js/oneui.app.min.js"></script>
    <script src="assets/js/lib/jquery.min.js"></script>
</body>

</html>
