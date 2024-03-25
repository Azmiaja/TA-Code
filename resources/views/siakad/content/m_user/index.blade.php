@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="block block-rounded">
            <ul class="nav nav-tabs nav-tabs-alt bg-body-light" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="tab_pegawai" data-bs-toggle="tab" data-bs-target="#btab_pegawai"
                        role="tab" aria-controls="btab_pegawai" aria-selected="true">Pegawai</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab_siswa" data-bs-toggle="tab" data-bs-target="#btab_siswa" role="tab"
                        aria-controls="btab_siswa" aria-selected="false">Siswa</button>
                </li>
            </ul>
            <div class="block-content tab-content p-0">
                <div class="tab-pane active" id="btab_pegawai" role="tabpanel" aria-labelledby="tab_pegawai" tabindex="0">
                    <div class="table-responsive m-4 m-md-0 p-md-4 p-0">
                        <div class="row">
                            <div class="col-12 text-md-end text-center mb-3">
                                <button class="btn btn-sm btn-alt-success" id="btn-tambahUserPegawai"><i
                                        class="fa fa-plus me-2"></i>Tambah User
                                    Pegawai</button>
                            </div>
                        </div>
                        <table id="tabel-userPegawai" class="table w-100 table-bordered align-middle">
                            <thead class="bg-body-light align-middle">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Nama</th>
                                    <th style="width: 20%;">Username</th>
                                    <th style="width: 15%;">Hak Akses</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- conten --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="btab_siswa" role="tabpanel" aria-labelledby="tab_siswa" tabindex="0">
                    <div class="table-responsive m-4 m-md-0 p-md-4 p-0">
                        <div class="row">
                            <div class="col-12 text-md-end text-center mb-3">
                                <button class="btn btn-sm btn-alt-success" id="btn-tambahUserSiswa"><i
                                        class="fa fa-plus me-2"></i>Tambah User
                                    Siswa</button>
                            </div>
                        </div>
                        <table id="tabel-userSiswa" class="table w-100 table-bordered align-middle">
                            <thead class="bg-body-light align-middle">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Nama</th>
                                    <th style="width: 10%;">Kelas</th>
                                    <th style="width: 20%;">Username</th>
                                    <th style="width: 15%;">Hak Akses</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- conten --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- MODAL PEGAWAI --}}
    @include('siakad/content/m_user/modal-pegawai')
    {{-- MODAL SISWA --}}
    @include('siakad/content/m_user/modal-siswa')


    @push('scripts')
        <script>
            $(document).ready(function() {
                const tabelSiswa = $('#tabel-userSiswa');
                const tabelPegawai = $('#tabel-userPegawai');
                const btnInsertUsSiswa = $('#btn-tambahUserSiswa');
                const btnInsertUsPegawai = $('#btn-tambahUserPegawai');
                const modalSiswa = $('#modal-UsrSiswa');
                const modalSiswa_title = $('#modal-title-siswa');
                const modalPegawai = $('#modal-UserPegawai');
                const modalPegawai_title = $('#modal-title-pegawai');
                const formSiswa = $('#form_user_siswa');
                const formPegawai = $('#form_user_pegawai');
                const formSiswa_btn = $('#bt-form-siswa');
                const formPegawai_btn = $('#bt-form-pegawai');
                const form_method = $('#method');
                const form_method_siswa = $('#method_siswa');
                const tabSiswa = $('#tab_siswa');
                const tabPegawai = $('#tab_pegawai');
                // loadDropdownOptions();
                // =========================== SISWA ============================

                // tabel siswa
                tabelSiswa.DataTable({
                    ajax: "{{ route('get-user.siswa') }}",
                    columns: [{
                            data: 'nomor',
                            bame: 'nomor',
                            className: 'text-center fw-semibold',
                            searchable: false,
                        }, {
                            data: 'namaSiswa',
                            name: 'namaSiswa'
                        }, {
                            data: 'kelas',
                            name: 'kelas',
                            className: 'text-center'
                        }, {
                            data: 'username',
                            name: 'username'
                        }, {
                            data: 'hakAkses',
                            name: 'hakAkses',
                            className: 'text-center'
                        }, {
                            data: 'status',
                            className: 'text-center',
                            searchable: false,
                        },
                        {
                            data: null,
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editUsrSiswa" value="' +
                                    data.idUserSiswa + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusUsrSiswa" title="Delete" value="' +
                                    data.idUserSiswa + '" data-nama-siswa="' + data.siswa.namaSiswa +
                                    '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25, 50, 100],
                });

                var sudahDijalankan = false;

                function loadTabelSiswa() {
                    if (!sudahDijalankan) {
                        tabelSiswa.DataTable().draw();
                        tabelSiswa.DataTable().columns.adjust().responsive.recalc();

                        sudahDijalankan = true;
                    }
                }

                tabSiswa.click(function() {
                    loadTabelSiswa();
                });

                function getSelect() {
                    $.ajax({
                        type: "GET",
                        url: `{{ route('siswa.select') }}`,
                        success: function(data) {
                            $('#idSiswa').html('');
                            $.each(data, function(i, item) {
                                $('#idSiswa').append(
                                    `<option value="${item.idSiswa}">${item.nis} - ${item.namaSiswa}</option>`
                                );
                            });
                        },
                    });
                }

                modalSiswa.on('hidden.bs.modal', function() {
                    // Reset form
                    resetForm(formSiswa, function() {
                        $('#idSiswa').val(null).change();
                        $('#idSiswa').prop("disabled", false);
                        $('#uss_display').prop("hidden", true);
                        $('#pass_display').prop("hidden", true);
                    });
                });

                modalPegawai.on('hidden.bs.modal', function() {
                    resetForm(formPegawai, function() {
                        $('#idPegawai').val(null).change();
                        $('#idPegawai').prop("disabled", false);
                        $('#uss_display_pegawai').prop("hidden", true);
                        $('#pass_display_pegawai').prop("hidden", true);
                        $('#role_display').prop("hidden", false);

                    });
                    // Reset form
                    resetForm()
                });

                btnInsertUsSiswa.click(function(e) {
                    e.preventDefault();

                    modalSiswa.modal('show');
                    updateModals(
                        modalSiswa_title,
                        formSiswa_btn,
                        'Tambah User Siswa',
                        `<button type="submit" class="btn btn-primary">Simpan</button>`
                    );

                    formSiswa.attr('action', '{{ route('user.siswa.store') }}');
                    form_method_siswa.val('POST');

                    getSelect();

                    $('#kls_display').prop("hidden", true);
                });

                select2Multiple('#idSiswa', modalSiswa);

                // Store dan Update Data User Siswa
                insertOrUpdateData(
                    formSiswa,
                    function() {
                        modalSiswa.modal('hide');
                        tabelSiswa.DataTable().ajax.reload();
                    }
                );

                // show modal edit siswa
                $(document).on('click', '#action-editUsrSiswa', function(e) {
                    e.preventDefault();

                    modalSiswa.modal('show');
                    updateModals(
                        modalSiswa_title,
                        formSiswa_btn,
                        'Ubah User Siswa',
                        `<button type="submit" class="btn btn-primary">Simpan</button>`
                    );
                    form_method_siswa.val("PUT");

                    $('#idSiswa').prop("disabled", true);
                    $('#uss_display').prop("hidden", false);
                    $('#pass_display').prop("hidden", false);
                    $('#kls_display').prop("hidden", false);
                    // $('#idSiswa').html('');

                    var idSiswa = $(this).val();
                    formSiswa.attr('action', `{{ url('user/update/siswa/${idSiswa}') }}`);
                    var url = `{{ url('user/edit/siswa/${idSiswa}') }}`;
                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function(response) {
                            $('#username_siswa').val(response.user.username);
                            $('#kelas_siswa').val(response.kelas);
                            $('#password_siswa').val();
                            $('#idSiswa').append(
                                `<option selected value="${response.user.idSiswa}">${response.user.siswa.nis} - ${response.user.siswa.namaSiswa}</option>`
                            );

                            $('#reset_password_siswa').click(function() {
                                var tgtLahir = response.user.siswa.tanggalLahir;
                                var parsedDate = moment(tgtLahir);
                                var formattedDate = parsedDate.format('DDMMYY');
                                $('#password_siswa').val(formattedDate).change();
                            });

                        },
                    });
                });

                // delete data siswa
                $(document).on('click', '#action-hapusUsrSiswa', function(e) {
                    e.preventDefault();

                    var idSiswa = $(this).val();
                    var namaSiswa = $(this).data('nama-siswa');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus User <strong>${namaSiswa}</strong>`,
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        reverseButton: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'DELETE',
                                url: `{{ url('user/destroy/siswa/${idSiswa}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });

                                    tabelSiswa.DataTable().ajax.reload();
                                },
                            });
                        }
                    });
                });

                // ============================== PEGAWAI =============================
                // tabel user pegawai
                tabelPegawai.DataTable({
                    ajax: "{{ route('get-user.pegawai') }}",
                    columns: [{
                            data: 'nomor',
                            bame: 'nomor',
                            className: 'text-center fw-semibold',
                            searchable: false,
                        }, {
                            data: 'namaPegawai',
                            name: 'namaPegawai'
                        }, {
                            data: 'username',
                            name: 'username'
                        }, {
                            data: 'hakAkses',
                            name: 'hakAkses',
                            className: 'text-center'
                        }, {
                            data: 'status',
                            className: 'text-center',
                            searchable: false,
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

                });

                var sudahDijalankanPegawai = false;

                function loadTabelPegawai() {
                    if (!sudahDijalankanPegawai) {
                        tabelPegawai.DataTable().draw();
                        tabelPegawai.DataTable().columns.adjust().responsive.recalc();

                        sudahDijalankanPegawai = true;
                    }
                }

                tabPegawai.click(function() {
                    loadTabelPegawai();
                });

                function updateModalPegawai(title, button) {
                    modalPegawai_title.text(title);
                    formPegawai_btn.html(button);
                }


                select2Multiple('#idPegawai', modalPegawai);

                function getSelectPegawai() {
                    $.ajax({
                        type: "GET",
                        url: `{{ route('pegawai.select') }}`,
                        success: function(data) {
                            $('#idPegawai').html('');
                            $.each(data, function(i, item) {
                                $('#idPegawai').append(
                                    `<option value="${item.idPegawai}">${item.nip} - ${item.namaPegawai}</option>`
                                );
                            });
                        },
                    });
                }

                // SHOW MODAL tambah
                btnInsertUsPegawai.click(function(e) {
                    e.preventDefault();

                    modalPegawai.modal('show');
                    updateModals(
                        modalPegawai_title,
                        formPegawai_btn,
                        'Tambah User Pegawai',
                        `<button type="submit" class="btn btn-primary">Simpan</button>`
                    );

                    getSelectPegawai();

                    formPegawai.attr('action', '{{ route('user.pegawai.store') }}');
                    form_method.val('POST');

                });

                insertOrUpdateData(
                    formPegawai,
                    function() {
                        modalPegawai.modal('hide');
                        tabelPegawai.DataTable().ajax.reload();
                    }
                );

                // SHOW MODAL EDIT
                $(document).on('click', '#action-editUsrPegawai', function(e) {
                    e.preventDefault();
                    modalPegawai.modal("show");
                    updateModals(
                        modalPegawai_title,
                        formPegawai_btn,
                        'Ubah User Pegawai',
                        `<button type="submit" class="btn btn-primary">Simpan</button>`
                    );
                    form_method.val("PUT");

                    $('#idPegawai').prop("disabled", true);
                    $('#uss_display_pegawai').prop("hidden", false);
                    $('#pass_display_pegawai').prop("hidden", false);
                    $('#role_display').prop("hidden", true);

                    var idPegawai = $(this).val();
                    formPegawai.attr('action', `{{ url('user/update/pegawai/${idPegawai}') }}`);

                    $.ajax({
                        type: "GET",
                        url: `{{ url('user/edit/pegawai/${idPegawai}') }}`,
                        success: function(response) {
                            $('#username_pegawai').val(response.user.username);
                            $('#hak_akses').val(response.user.hakAkses);
                            $('#password_pegawai').val();
                            $('#idPegawai').append(
                                `<option selected value="${response.user.idPegawai}">${response.user.pegawai.nip} - ${response.user.pegawai.namaPegawai}</option>`
                            );

                            $('#reset_password_pegawai').click(function() {
                                var tgtLahir = response.user.pegawai.tanggalLahir;
                                var parsedDate = moment(tgtLahir);
                                var formattedDate = parsedDate.format('DDMMYY');
                                $('#password_pegawai').val(formattedDate).change();
                            });

                        },
                    });
                });

                // DELETE
                $(document).on('click', '#action-hapusUsrPegawai', function(e) {
                    e.preventDefault();
                    var idUser = $(this).val();
                    var namaUser = $(this).data('nama-user');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: 'Menghapus data <b>' + namaUser + '</b>',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        reverseButtons:  true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'DELETE',
                                url: `{{ url('user/destroy/pegawai/${idUser}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });

                                    tabelPegawai.DataTable().ajax.reload();
                                },
                            });
                        }
                    });
                });

            });
        </script>
    @endpush
@endsection
