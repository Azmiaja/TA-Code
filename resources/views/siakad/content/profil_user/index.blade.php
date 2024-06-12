    @extends('siakad/layouts/app')
    @section('siakad')
        @include('siakad/layouts/partials/hero')
        <div class="content">
            <div class="row g-3">
                @include('siakad/content/profil_user/profil-menu')
                <div class="col-lg-9 col-md-8 col-12 order-md-1 order-0">
                    @cannot('siswa')
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Profil Saya</h3>
                            </div>
                            <div class="block-content block-content-full">
                                <div id="loading_spinner_pegawai" class="text-center" style="display: none;">
                                    <div class="spinner-border text-primary" role="status"></div>
                                </div>
                                <div class="row g-2" id="pegawai">
                                    {{-- data diri --}}
                                </div>
                            </div>
                        </div>
                    @endcannot
                    @can('siswa')
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Profil Saya</h3>
                            </div>
                            <div class="block-content block-content-full">
                                <div id="loading_spinner_siswa" class="text-center" style="display: none;">
                                    <div class="spinner-border text-primary" role="status"></div>
                                </div>
                                <div class="row g-2" id="siswa">

                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>

        </div>


        @cannot('siswa')
            <div class="modal fade" id="modal_fotoProfil" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                aria-labelledby="modal-modal_fotoProfil" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title" id="title-modal">Ubah Foto Profil Saya</h3>
                                <div class="block-options">
                                    <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                <form
                                    action="{{ route('profil_pengguna.update.foto-profil', ['id' => $auths->idPegawai ?: $auths->idSiswa]) }}"
                                    method="POST" id="form_editFotoProfil" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row">
                                        <div class="mb-2 text-center">
                                            <div class="ratio mx-auto mb-2 rounded-circle border border-5"
                                                style="width: 200px; height: 200px;">
                                                <img src="{!! asset('assets/media/avatars/avatar1.jpg') !!}" class="img-preview rounded-circle"
                                                    style="width: 100%; height: 100%; object-fit: cover;" alt="">
                                            </div>
                                            <span class="text-danger error-text gambar_error"></span>
                                        </div>
                                        <div class="mb-4 text-center">
                                            <input type="file" class="form-control d-none" name="gambar"
                                                accept=".jpg,.jpeg,.png,.svg" id="gambar" onchange="prevImg()">
                                            <button type="button" id="fileButton" class="btn btn-primary">Pilih
                                                File</button>
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
        @endcannot

        @include('siakad/content/profil_user/ch-password')
        @include('siakad/content/profil_user/edit-profil')

        @push('scripts')
            <script>
                function getDataPegawai() {
                    $('#pegawai').empty();
                    $('#loading_spinner_pegawai').show();
                    var htmlString;
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get.profil') }}",
                        dataType: "json",
                        success: function(data) {
                            moment.locale('id');

                            htmlString = `<div class="col-md-7 col-12">
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">NIP</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.nip ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Nama lengkap</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.namaPegawai ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Tempat lahir</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.tempatLahir ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Tanggal lahir</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${moment(data.tanggalLahir).format('DD MMMM YYYY') ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Jenis kelamin</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.jenisKelamin ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Alamat domisili</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.alamat ?? '-'}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-12">
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Agama</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.agama ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Telepon</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.noHp ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Kategori</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.jenisPegawai ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Jabatan</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.jabatan_pegawai ? data.jabatan_pegawai.jabatan :'-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Status</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.status ?? '-'}</div>
                                        </div>
                                    </div>`;


                        },
                        complete: function() {
                            $('#pegawai').html(htmlString);
                            $('#loading_spinner_pegawai').hide();
                        }
                    });
                }

                function getDataSiswa() {
                    $('#siswa').empty();
                    $('#loading_spinner_siswa').show();
                    var htmlString;
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get.profil') }}",
                        dataType: "json",
                        success: function(data) {
                            moment.locale('id');

                            htmlString = `<div class="col-md-6 col-12">
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">NISN</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.nisn ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">NIS</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.nis ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Nama lengkap</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.namaLengkap ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Nama panggilan</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.namaPanggilan ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Tempat lahir</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.tempatLahir ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Tanggal lahir</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${moment(data.tanggalLahir).format('DD MMMM YYYY') ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Jenis kelamin</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.jenisKelamin ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Alamat tinggal</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.alamat ?? '-'}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Agama</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.agama ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Nama ayah</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.namaAyah ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Pekerjaan ayah</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.pekerjaanAyah ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Nama ibu</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.namaIbu ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Pekerjaan ibu</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.pekerjaanIbu ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Nama wali</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.namaWali ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Pekerjaan wali</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.pekerjaanWali ?? '-'}</div>
                                        </div>
                                        <div class="d-flex flex-row mb-2 py-2">
                                            <div class="col-4 fw-semibold">Status</div>
                                            <div class="col-1 fw-semibold">:</div>
                                            <div class="col-7">${data.status ?? '-'}</div>
                                        </div>
                                    </div>`;


                        },
                        complete: function() {
                            $('#siswa').html(htmlString);
                            $('#loading_spinner_siswa').hide();
                        }
                    });
                }

                function getFoto() {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get.profil') }}",
                        dataType: "json",
                        success: function(data) {
                            var gambar = data.gambar ? (fileExists(`{!! asset('storage/${data.gambar}') !!}`) ?
                                    `{!! asset('storage/${data.gambar}') !!}` : `{!! asset('assets/media/avatars/avatar1.jpg') !!}`) :
                                `{!! asset('assets/media/avatars/avatar1.jpg') !!}`;
                            $('#gambar_pegawai').attr('src', gambar);
                            $('#foto_header').attr('src', gambar);
                            $('#dr_header').attr('src', gambar);
                            imgPrev.src = gambar;
                        }
                    });
                }

                function getDT() {
                    $('#name_ppw').empty();
                    $('#us_name').empty();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get.profil') }}",
                        dataType: "json",
                        success: function(data) {
                            $('#name_ppw').text(data.namaPegawai);
                            $('#us_name').text('@'+data.user[0].username);
                        }
                    });
                }

                $(document).ready(function() {
                    @cannot('siswa')
                        getDataPegawai();
                        getFoto();
                    @endcannot
                    @can('siswa')
                        getDataSiswa();
                    @endcan
                    const chPass = $('#btn_changepassword');
                    const chProfil = $('#btn_ubahprofil');
                    const btFotoProfil = $('#edit_fotoProfil');
                    const modal_chPass = $('#modal_ubahPassword');
                    const modal_chProfil = $('#modal_ubahProfil');
                    const modal_fotoProfil = $('#modal_fotoProfil');
                    const form_chPass = $('#form_change_password');
                    const form_editProfil = $('#form-editProfile');
                    const form_ediFotoProfil = $('#form_editFotoProfil');
                    const form_ediProfilSiswa = $('#form_editProfilSiswa');

                    function modalShow(button, modal, options) {
                        button.click(function(e) {
                            e.preventDefault();
                            modal.modal('show');
                            options();
                        });
                    }
                    modalShow(chPass, modal_chPass, function() {});
                    modalShow(chProfil, modal_chProfil, function() {});
                    modalShow(btFotoProfil, modal_fotoProfil, function() {});

                    function airDatepicker(input, modal) {
                        new AirDatepicker(input, {
                            container: modal,
                            autoClose: true,
                        });
                    }

                    airDatepicker('#tanggalLahir', '#modal_ubahProfil');

                    function modalReset(modal, options) {
                        modal.on('hidden.bs.modal', function() {
                            options();
                        });
                    }

                    modalReset(modal_chPass, function() {
                        form_chPass[0].reset();
                    });


                    function insertData(form, modal, options) {
                        form.submit(function(e) {
                            e.preventDefault();

                            $.ajax({
                                url: $(this).attr('action'),
                                method: $(this).attr('method'),
                                data: new FormData(this),
                                processData: false,
                                dataType: 'json',
                                contentType: false,
                                beforeSend: function() {
                                    $(document).find('span.error-text').text('');
                                },
                                success: function(data) {
                                    if (data.status == 0) {
                                        $.each(data.error, function(prefix, val) {
                                            $('span.' + prefix + '_error').text(val[0]);
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: data.status,
                                            title: 'Sukses',
                                            text: data.msg,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        modal.modal('hide');
                                        options();
                                    }
                                }
                            });
                        });
                    }

                    insertData(form_chPass, modal_chPass, function() {});
                    insertData(form_editProfil, modal_chProfil, function() {
                        @cannot('siswa')
                            getDataPegawai();
                            getDT();
                        @endcannot
                    });
                    insertData(form_ediFotoProfil, modal_fotoProfil, function() {
                        @cannot('siswa')
                            getFoto();
                        @endcannot
                    });
                    insertData(form_ediProfilSiswa, modal_chProfil, function() {
                        @can('siswa')
                            getDataSiswa();
                        @endcan
                    });

                    $('#fileButton').click(function() {
                        $('#gambar').click();
                    });
                });
                const gambar = document.querySelector('#gambar');
                const imgPrev = document.querySelector('.img-preview');
                const oFReader = new FileReader();


                function prevImg() {

                    imgPrev.style.display = 'block';

                    oFReader.readAsDataURL(gambar.files[0]);

                    oFReader.onload = function(oFREvent) {
                        imgPrev.src = oFREvent.target.result;
                    }
                }
            </script>
        @endpush
    @endsection
