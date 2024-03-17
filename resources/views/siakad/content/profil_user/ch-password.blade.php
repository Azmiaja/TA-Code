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
<div class="modal fade" id="modal_ubahPassword" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modal-modal_ubahPassword" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title" id="title-modal">Ubah Password</h3>
                    <div class="block-options">
                        <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <form id="form_change_password" action="{{ route('update.password') }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row">
                            @can('siswa')
                                <div class="mb-3">
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
                            <div class="mb-3">
                                <label class="form-label" for="current_password">
                                    Password Sekarang</label>
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password" placeholder="Masukan password saat ini..">
                                <span class="text-danger error-text current_password_error"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Masukan password baru..">
                                <span class="text-danger error-text password_error"></span>

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
                                                    (@$!%*?&).
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Konfirmasi
                                    Password
                                </label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Masukan konfirmasi password..">
                                <span class="text-danger error-text password_confirmation_error"></span>
                            </div>
                            <div class="mb-4 text-end">
                                <button type="submit" class="btn btn-alt-primary">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="block-content block-content-full bg-body">
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

            password.addEventListener("blur", () => {
                passwordAlert.classList.add("d-none");
            });
        });
    </script>
@endpush
