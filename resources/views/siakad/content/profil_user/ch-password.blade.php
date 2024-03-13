@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    @push('style')
        <style>
            .wrong .fa-check {
                display: none;
            }

            .good .fa-times {
                display: none;
            }
        </style>
    @endpush
    <div class="content">
        <div class="row g-3">
            @include('siakad/content/profil_user/profil-menu')
            <div class="col-lg-9 col-md-8 col-12 order-md-1 order-0">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Ubah Password</h3>
                    </div>
                    <div class="block-content">
                        <form id="form_change_password" action="{{ route('update.password') }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    @if (session('success'))
                                        <div class="alert alert-success d-flex align-items-center fade show mb-3"
                                            role="alert">
                                            <i class="fa-solid fa-circle-check fs-3 me-3"></i>
                                            <div>
                                                {{ session('success') }}
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
                                    @can('siswa')
                                        <div class="row mb-3">
                                            <div class="alert alert-info alert-dismissible" role="alert">
                                                <h3 class="alert-heading h4 my-2">Penting</h3>
                                                <ul>
                                                    <li><small class="mb-0">Ubah password akun Anda dengan aman dan hati-hati.
                                                            Mintalah bantuan orang tua/wali Anda.</small></li>
                                                    <li> <small class="mb-0">Jangan bagikan password Anda kepada siapapun,
                                                            termasuk teman dekat. </small></li>
                                                    <li><small class="mb-0">Gunakan password yang kuat dan mudah diingat,
                                                            seperti kombinasi huruf besar, huruf kecil, dan angka.</small></li>
                                                    <li><small class="mb-0">Simpan password Anda di tempat yang aman, seperti
                                                            buku catatan pribadi.</small></li>
                                                    <li> <small class="mb-0">Ingatlah untuk selalu berhati-hati saat
                                                            menggunakan internet.</small></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endcan
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label" for="current_password">
                                            Password Sekarang</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="current_password"
                                                name="current_password" placeholder="Masukan password saat ini..">
                                            @error('current_password')
                                                <div class="text-danger fs-sm">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label" for="password">Password Baru</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Masukan password baru..">
                                            @error('password')
                                                <div class="text-danger fs-sm">{{ $message }}</div>
                                            @enderror

                                            <div class="valid-feedback">Good</div>
                                            <div class="invalid-feedback">Wrong</div>

                                            <div class="mt-2 alert alert-warning p-3 mb-0 d-none" role="alert"
                                                id="password-alert">
                                                <ul class="list-unstyled mb-0 ">
                                                    <li class="requirements leng fs-sm">
                                                        <div class="row p-0 m-0">
                                                            <div class="col-1 m-0 p-0">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                <i class="fas fa-times text-danger me-3"></i>
                                                            </div>
                                                            <div class="col-11 m-0 p-0">
                                                                Kata sandi Anda harus terdiri dari minimal 8 karakter.
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="requirements big-letter fs-sm">
                                                        <div class="row p-0 m-0">
                                                            <div class="col-1 m-0 p-0">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                <i class="fas fa-times text-danger me-3"></i>
                                                            </div>
                                                            <div class="col-11 m-0 p-0">
                                                                Kata sandi Anda harus terdiri dari setidaknya 1 huruf besar.
                                                            </div>
                                                        </div>
                                                    </li>
                                                    </li>
                                                    <li class="requirements num fs-sm">
                                                        <div class="row p-0 m-0">
                                                            <div class="col-1 m-0 p-0">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                <i class="fas fa-times text-danger me-3"></i>
                                                            </div>
                                                            <div class="col-11 m-0 p-0">
                                                                Kata sandi Anda harus terdiri dari minimal 1 angka.
                                                            </div>
                                                        </div>
                                                    </li>
                                                    </li>
                                                    <li class="requirements special-char fs-sm">
                                                        <div class="row p-0 m-0">
                                                            <div class="col-1 m-0 p-0">
                                                                <i class="fas fa-check text-success me-2"></i>
                                                                <i class="fas fa-times text-danger me-3"></i>
                                                            </div>
                                                            <div class="col-11 m-0 p-0">
                                                                Kata sandi Anda harus memiliki setidaknya 1 karakter khusus
                                                                (@!./\$#%*).
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label" for="password_confirmation">Konfirmasi
                                            Password
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" placeholder="Masukan konfirmasi password..">
                                            @error('password_confirmation')
                                                <div class="text-danger fs-sm">{{ $message }}</div>
                                            @enderror

                                            <div class="valid-feedback">Good</div>
                                            <div class="invalid-feedback">Wrong</div>
                                        </div>
                                    </div>
                                    <div class="mb-4 float-end">
                                        <button type="submit" class="btn btn-alt-primary">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", (event) => {
                const password = document.getElementById("password");
                const confirmPassword = document.getElementById("password_confirmation");
                const passwordAlert = document.getElementById("password-alert");
                const requirements = document.querySelectorAll(".requirements");
                const leng = document.querySelector(".leng");
                const bigLetter = document.querySelector(".big-letter");
                const num = document.querySelector(".num");
                const specialChar = document.querySelector(".special-char");

                requirements.forEach((element) => element.classList.add("wrong"));

                password.addEventListener("focus", () => {
                    passwordAlert.classList.remove("d-none");
                    if (!password.classList.contains("is-valid")) {
                        password.classList.add("is-invalid");
                    }
                });

                password.addEventListener("input", () => {
                    const value = password.value;
                    const isLengthValid = value.length >= 8;
                    const hasUpperCase = /[A-Z]/.test(value);
                    const hasNumber = /\d/.test(value);
                    const hasSpecialChar = /[!@#$%^&*()\[\]{}\\|;:'",<.>/?`~]/.test(value);

                    leng.classList.toggle("good", isLengthValid);
                    leng.classList.toggle("wrong", !isLengthValid);
                    bigLetter.classList.toggle("good", hasUpperCase);
                    bigLetter.classList.toggle("wrong", !hasUpperCase);
                    num.classList.toggle("good", hasNumber);
                    num.classList.toggle("wrong", !hasNumber);
                    specialChar.classList.toggle("good", hasSpecialChar);
                    specialChar.classList.toggle("wrong", !hasSpecialChar);

                    const isPasswordValid = isLengthValid && hasUpperCase && hasNumber && hasSpecialChar;

                    if (isPasswordValid) {
                        password.classList.remove("is-invalid");
                        password.classList.add("is-valid");

                        requirements.forEach((element) => {
                            element.classList.remove("wrong");
                            element.classList.add("good");
                        });

                        passwordAlert.classList.remove("alert-warning");
                        passwordAlert.classList.add("alert-success");
                    } else {
                        password.classList.remove("is-valid");
                        password.classList.add("is-invalid");

                        passwordAlert.classList.add("alert-warning");
                        passwordAlert.classList.remove("alert-success");
                    }
                });

                confirmPassword.addEventListener("input", () => {
                    const isPasswordMatch = confirmPassword.value === password.value;

                    if (isPasswordMatch) {
                        confirmPassword.classList.remove("is-invalid");
                        confirmPassword.classList.add("is-valid");

                        requirements.forEach((element) => {
                            element.classList.remove("wrong");
                            element.classList.add("good");
                        });
                    } else {
                        confirmPassword.classList.remove("is-valid");
                        confirmPassword.classList.add("is-invalid");
                    }
                });

                password.addEventListener("blur", () => {
                    passwordAlert.classList.add("d-none");
                });
            });
        </script>
    @endpush
@endsection
