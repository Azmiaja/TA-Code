@extends('layouts.main')
@section('content')
    {{-- header --}}
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title berita --}}
                    <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <a class="link-fx" href="javascript:void(0)">{{ $title }}</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                {{ $title2 }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-6 text-end">
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-alt-success dropdown-toggle"
                            id="dropdown-align-alt-primary" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="fa fa-plus mx-2"></i>
                            Tambah Data
                        </button>
                        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-align-alt-primary">
                            <a class="dropdown-item" id="btn-tambahUserPegawai" href="javascript:void(0)">Tambah User
                                Pegawai</a>
                            <a class="dropdown-item" id="btn-tambahUserSiswa" href="javascript:void(0)">Tambah User
                                Siswa</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- conent --}}
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="data-pegawai-tab" onclick="reloadPegawaiTb()"
                                data-bs-toggle="tab" data-bs-target="#data-pegawai" role="tab"
                                aria-controls="data-pegawai" aria-selected="true">Pegawai</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="data-siswa-tab" onclick="reloadSiswaTb()" data-bs-toggle="tab"
                                data-bs-target="#data-siswa" role="tab" aria-controls="data-siswa"
                                aria-selected="false">Siswa</button>
                        </li>
                    </ul>
                    <div class="block-content tab-content overflow-hidden">
                        <div class="tab-pane fade show active" id="data-pegawai" role="tabpanel"
                            aria-labelledby="data-pegawai-tab" tabindex="0">
                            {{-- tabel user pegawau --}}
                            <table id="tabel-userPegawai" style="width: 100%"
                                class="table tabel-responsive table-bordered table-striped table-vcenter js-dataTable-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;" class="text-center">No</th>
                                        <th style="width: auto">Nama</th>
                                        <th>Username</th>
                                        <th>Hak Akses</th>
                                        <th style="width: 15%;" class="text-center">Status</th>
                                        <th style="width: 10%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- conten --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="data-siswa" role="tabpanel" aria-labelledby="data-siswa-tab"
                            tabindex="0">
                            {{-- tabel user siswa --}}
                            <table id="tabel-userSiswa"
                                class="table table-bordered table-striped table-vcenter js-dataTable-responsive"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;" class="text-center">No</th>
                                        <th style="width: auto">Nama</th>
                                        <th>Username</th>
                                        <th>Hak Akses</th>
                                        <th style="width: 10%;" class="text-center">Status</th>
                                        <th style="width: 10%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- conten --}}
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="btabs-animated-fade-settings" role="tabpanel"
                            aria-labelledby="btabs-animated-fade-settings-tab" tabindex="0">
                            <h4 class="fw-normal">Settings Content</h4>
                            <p>Content fades in..</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL PEGAWAI --}}
    <div class="modal fade" id="modal-UserPegawai" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal-tambahUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="modal-title-pegawai"></h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" onclick="clearPegawaiForm()" class="btn-block-option"
                                data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <input type="text" hidden id="for-id-pegawai">
                        <div class="mb-4 sh-uspeg">
                            <label class="form-label" for="idPegawai">Nama Pegawai</label>
                            <input type="text" class="form-control nama-pegawai" disabled id="nama-pegawai">
                            <select class="form-select pegawai-id" id="idPegawai" name="idPegawai" required>
                                <option value="" disabled selected>-- Pilih Pegawai --</option>
                                @foreach ($pegawaiList as $ls)
                                    <option data-nip="{{ $ls->nip }}" data-tanggal-lahir="{{ $ls->tanggalLahir }}"
                                        value="{{ $ls->idPegawai }}">{{ $ls->namaPegawai }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" class="form-control username" id="username" required
                                        name="username" placeholder="Masukan Username">
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" class="form-control password" id="password" required
                                        name="password" placeholder="Masukan Password">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="hakAkses">Hak Akses</label>
                            <select name="hakAkses" required id="hakAkses" class="form-select hak-akses">
                                <option value="" selected>-- Pilih Hak Akses --</option>
                                <option value="Guru">Guru</option>
                                <option value="Admin">Admin</option>
                                <option value="Super Admin">Super Admin</option>
                            </select>

                        </div>
                        <div class="mb-4 text-end" id="bt-form-pegawai">
                            {{-- btn form --}}
                        </div>
                    </div>

                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL SISWA --}}
    <div class="modal fade z-1" id="modal-UsrSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal-tambahUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="modal-title-siswa"></h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" onclick="clearSiswaForm()" class="btn-block-option"
                                data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <input type="text" hidden id="for-id-siswa">
                        <div class="mb-4 sh-ussis">
                            <label class="form-label" for="idSiswa">Nama Siswa</label>
                            <input type="text" class="form-control nama-siswa" disabled id="nama-siswa">
                            <select class="form-select id-siswa" id="idSiswa" name="idSiswa">
                                <option value="" disabled selected>-- Pilih Siswa --</option>
                                @foreach ($siswaList as $ls)
                                    <option value="{{ $ls->idSiswa }}" data-nisn="{{ $ls->nisn }}"
                                        data-tanggal-lahir="{{ $ls->tanggalLahir }}">{{ $ls->namaSiswa }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" class="form-control username-siswa" id="username_siswa"
                                        required name="username" placeholder="Masukan Username">
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" class="form-control password-siswa" id="password_siswa"
                                        required name="password" placeholder="Masukan Password">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4" hidden>
                            <label class="form-label" for="hakAkses">Hak Akses</label>
                            <select name="hakAkses" required id="hakAkses" class="form-select hak-akses-siswa">
                                <option value="" selected>-- Pilih Hak Akses --</option>
                                <option id="ops_siswa" value="Siswa">Siswa</option>
                            </select>

                        </div>
                        <div class="mb-4 text-end" id="bt-form-siswa">
                            {{-- content button --}}
                        </div>
                    </div>

                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // clear form siswa
            function clearSiswaForm() {
                $('.username-siswa').val('');
                $('.password-siswa').val('');
                $('.hak-akses-siswa').val('');
                $('#idSiswa').val(null).trigger('change');
            }

            // clear form siswa
            function clearPegawaiForm() {
                $('.username').val('');
                $('.password').val('');
                $('.hak-akses').val('');
                $('#idPegawai').val(null).trigger('change');
            }

            // reload tabel siswa
            function reloadSiswaTb() {
                $('#tabel-userSiswa').DataTable().ajax.reload();
            }

            // reload tabel pegawai
            function reloadPegawaiTb() {
                $('#tabel-userPegawai').DataTable().ajax.reload();
            }

            // Fungsi untuk memformat tanggal menjadi ddmmYY
            function formatDate(inputDate) {
                var date = new Date(inputDate);
                var day = date.getDate().toString().padStart(2, '0');
                var month = (date.getMonth() + 1).toString().padStart(2, '0');
                var year = date.getFullYear().toString().substring(2);

                return day + month + year;
            }

            $(document).ready(function() {
                // =========================== SISWA ============================
                // CONFIG USER PASS SISWA
                $('#idSiswa').on('change', function() {
                    // Mendapatkan nilai nisn dan tanggalLahir dari data atribut
                    var nisn = $(this).find(':selected').data('nisn');
                    var tanggalLahir = $(this).find(':selected').data('tanggal-lahir');

                    // Format tanggal lahir menjadi ddmmYY
                    var formattedDate = formatDate(tanggalLahir);

                    // Mengisi nilai pada input username dan password
                    $('.username-siswa').val(nisn);
                    $('.password-siswa').val(formattedDate);
                    $('#ops_siswa').prop('selected', true);
                });

                // tabel siswa
                $('#tabel-userSiswa').DataTable({
                    ajax: "{{ route('get-user.siswa') }}",
                    columns: [{
                            data: 'nomor',
                            bame: 'nomor',
                            className: 'text-center fw-medium',
                            searchable: false,
                        }, {
                            data: 'namaSiswa',
                            name: 'namaSiswa'
                        }, {
                            data: 'username',
                            name: 'username'
                        }, {
                            data: 'hakAkses',
                            name: 'hakAkses'
                        }, {
                            data: 'status',
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row) {
                                var statusClass = row.status === 'Aktif' ?
                                    'bg-success-light text-success' : 'bg-danger-light text-danger';
                                return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${statusClass}">${row.status}</span>`;
                            }
                        },
                        {
                            data: null,
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editUsrSiswa" value="' +
                                    data.idSiswa + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusUsrSiswa" title="Delete" value="' +
                                    data.idSiswa + '" data-nama-siswa="' + data.namaSiswa + '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25, 50, 100],
                    responsive: true

                });

                // show modal tambah siswa
                $(document).on('click', '#btn-tambahUserSiswa', function(e) {
                    e.preventDefault();
                    $("#modal-UsrSiswa").modal("show");
                    $("#nama-siswa").prop('hidden', true);
                    $("#idSiswa").prop('hidden', false);
                    $("#modal-title-siswa").text('Tambah User Siswa');
                    $("#bt-form-siswa").html(`<button type="button" class="btn btn-secondary" onclick="clearSiswaForm()" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"
                                id="btn-tbhSubmitSiswa">Simpan</button>`);

                });

                // show modal edit siswa
                $(document).on('click', '#action-editUsrSiswa', function(e) {
                    e.preventDefault();
                    $("#modal-UsrSiswa").modal("show");
                    $("#modal-title-siswa").text('Edit User Siswa');
                    $("#nama-siswa").prop('hidden', false);
                    $("#idSiswa").prop('disabled', true);
                    $("#bt-form-siswa").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"
                                id="btn-edtSubmitSiswa">Simpan</button>`);

                    var idSiswa = $(this).val();
                    var url = "{{ url('user/edit/siswa') }}/" + idSiswa
                    // console.log(url);
                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function(response) {
                            // console.log(response.user.idSiswa);
                            $('.nama-siswa').val(response.user.namaSiswa);
                            $('.username-siswa').val(response.user.username);
                            $('.password-siswa').val();
                            $('.hak-akses-siswa').val(response.user.hakAkses);
                            $('#for-id-siswa').val(response.user.idSiswa);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });

                // store data siswa
                $(document).on('click', '#btn-tbhSubmitSiswa', function(e) {
                    e.preventDefault();
                    var idSiswa = $('#idSiswa').val();
                    var data = {
                        'username': $('.username-siswa').val(),
                        'password': $('.password-siswa').val(),
                        'hakAkses': $('.hak-akses-siswa').val(),
                    }
                    // console.log(data);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "PUT",
                        url: "{{ url('user/siswa/store') }}/" + idSiswa,
                        data: data,
                        dataType: "json",

                        success: function(response) {
                            $(".btn-block-option").click();
                            $("#data-siswa-tab").click();
                            // console.log(response);
                            Swal.fire({
                                icon: response.status,
                                title: response.status,
                                text: response.message,
                            });

                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });

                // update data siswa
                $(document).on('click', '#btn-edtSubmitSiswa', function(e) {
                    e.preventDefault();
                    var idSiswa = $('#for-id-siswa').val();
                    var username = $('.username-siswa').val();
                    var password = $('.password-siswa').val();
                    var hakAkses = $('.hak-akses-siswa').val();
                    // Validasi data
                    if (!username || !hakAkses) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Semua kolom harus diisi.',
                        });
                        return;
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var url = "{{ url('user/update/siswa') }}/" + idSiswa;
                    // console.log(idSiswa);

                    $.ajax({
                        type: "PUT",
                        url: url,
                        dataType: "json",
                        data: {
                            'username': username,
                            'password': password,
                            'hakAkses': hakAkses,
                        },
                        success: function(response) {
                            $(".btn-block-option").click();
                            Swal.fire({
                                icon: response.status,
                                title: response.status,
                                text: response.message,
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });

                // delete data siswa
                $(document).on('click', '#action-hapusUsrSiswa', function(e) {
                    e.preventDefault();

                    var idSiswa = $(this).val();
                    var namaSiswa = $(this).data('nama-siswa');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Menghapus data ' + namaSiswa + '',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'DELETE',
                                url: "{{ url('user/destroy/siswa') }}/" + idSiswa,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });

                                    $('#tabel-userSiswa').DataTable().ajax.reload();
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: xhr.responseJSON.message,
                                    });
                                }
                            });
                        }
                    });
                });

                // ============================== PEGAWAI =============================
                // CONFIG USER PASS Pegawai
                $('#idPegawai').on('change', function() {
                    // Mendapatkan nilai nisn dan tanggalLahir dari data atribut
                    var nip = $(this).find(':selected').data('nip');
                    var tanggalLahir = $(this).find(':selected').data('tanggal-lahir');

                    // Format tanggal lahir menjadi ddmmYY
                    var formattedDate = formatDate(tanggalLahir);

                    // Mengisi nilai pada input username dan password
                    $('.username').val(nip);
                    $('.password').val(formattedDate);
                });

                // tabel user pegawai
                $('#tabel-userPegawai').DataTable({
                    ajax: "{{ route('get-user.pegawai') }}",
                    columns: [{
                            data: 'nomor',
                            bame: 'nomor',
                            className: 'text-center fw-medium',
                            searchable: false,
                        }, {
                            data: 'namaPegawai',
                            name: 'namaPegawai'
                        }, {
                            data: 'username',
                            name: 'username'
                        }, {
                            data: 'hakAkses',
                            name: 'hakAkses'
                        }, {
                            data: 'status',
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row) {
                                var statusClass = row.status === 'Aktif' ?
                                    'bg-success-light text-success' : 'bg-danger-light text-danger';
                                return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${statusClass}">${row.status}</span>`;
                            }
                        },
                        {
                            data: null,
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editUsrPegawai" value="' +
                                    data.idUser + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusUsrPegawai" title="Delete" value="' +
                                    data.idUser + '" data-nama-user="' + data.namaPegawai + '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25, 50, 100],
                    responsive: true

                });

                // SHOW MODAL tambah
                $(document).on('click', '#btn-tambahUserPegawai', function(e) {
                    e.preventDefault();
                    $("#modal-UserPegawai").modal("show");
                    $("#modal-title-pegawai").text('Tambah User Pegawai');
                    $("#nama-pegawai").prop('hidden', true);
                    $("#idPegawai").prop('hidden', false);
                    $("#bt-form-pegawai").html(`<button type="button" class="btn btn-secondary" onclick="clearPegawaiForm()" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"
                            id="btn-submitTbhUsrPegawai">Simpan</button>`);
                });

                // STORE DATA 
                $(document).on('click', '#btn-submitTbhUsrPegawai', function(e) {
                    e.preventDefault();
                    // Mendapatkan nilai dari input
                    var idPegawai = $('.pegawai-id').val();
                    var username = $('.username').val();
                    var password = $('.password').val();
                    var hakAkses = $('.hak-akses').val();

                    // Validasi data
                    if (!idPegawai || !username || !password || !hakAkses) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Semua kolom harus diisi.',
                        });
                        return; // Menghentikan proses jika ada data yang kosong
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.store') }}",
                        data: {
                            'idPegawai': idPegawai,
                            'username': username,
                            'password': password,
                            'hakAkses': hakAkses,
                        },
                        dataType: "json",
                        success: function(response) {
                            $(".btn-block-option").click();
                            $("#data-pegawai-tab").click();
                            Swal.fire({
                                icon: response.status,
                                title: response.status,
                                text: response.message,
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });

                // SHOW MODAL EDIT
                $(document).on('click', '#action-editUsrPegawai', function(e) {
                    e.preventDefault();
                    $("#modal-UserPegawai").modal("show");
                    $("#modal-title-pegawai").text('Edit User Pegawai');
                    $("#nama-pegawai").prop('hidden', false);
                    $("#idPegawai").prop('disabled', true);
                    $("#bt-form-pegawai").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"
                            id="btn-submitEdtUsrPegawai">Simpan</button>`);
                    var idUser = $(this).val();
                    $.ajax({
                        type: "GET",
                        url: "{{ url('user/edit/pegawai') }}/" + idUser,
                        success: function(response) {
                            $('.nama-pegawai').val(response.user.pegawai.namaPegawai);
                            $('.username').val(response.user.username);
                            $('.password').val();
                            $('.hak-akses').val(response.user.hakAkses);
                            $('#for-id-pegawai').val(response.user.idUser);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });

                // update data user pegawai
                $(document).on('click', '#btn-submitEdtUsrPegawai', function(e) {
                    e.preventDefault();
                    var idUser = $('#for-id-pegawai').val();
                    var username = $('.username').val();
                    var password = $('.password').val();
                    var hakAkses = $('.hak-akses').val();

                    // Validasi data
                    if (!username || !hakAkses) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Semua kolom harus diisi.',
                        });
                        return; // Menghentikan proses jika ada data yang kosong
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "PUT",
                        url: "{{ url('user/update/pegawai') }}/" + idUser,
                        dataType: "json",
                        data: {
                            'username': username,
                            'password': password,
                            'hakAkses': hakAkses,
                        },
                        success: function(response) {
                            $(".btn-block-option").click();
                            Swal.fire({
                                icon: response.status,
                                title: response.status,
                                text: response.message,
                            });
                            $('#tabel-userPegawai').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });
                // END UPDATE

                // DELETE
                $(document).on('click', '#action-hapusUsrPegawai', function(e) {
                    e.preventDefault();
                    var idUser = $(this).val();
                    var namaUser = $(this).data('nama-user');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Menghapus data ' + namaUser + '',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'DELETE',
                                url: "{{ url('user/destroy/pegawai') }}/" + idUser,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });

                                    $('#tabel-userPegawai').DataTable().ajax.reload();
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: xhr.responseJSON.message,
                                    });
                                }
                            });
                        }
                    });
                });

                // select2UsrSiswa();
                $('#idSiswa').select2({
                    placeholder: "Pilih Siswa",
                    allowClear: true,
                    width: "100%",
                    cache: false,
                    dropdownParent: $('#modal-UsrSiswa'),
                    theme: "bootstrap",
                });

                $('#idPegawai').select2({
                    placeholder: "Pilih Pegawai",
                    allowClear: true,
                    width: "100%",
                    cache: false,
                    dropdownParent: $('#modal-UserPegawai'),
                    theme: "bootstrap"
                });

            });
        </script>
    @endpush
@endsection
