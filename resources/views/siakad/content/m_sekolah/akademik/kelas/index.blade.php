@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Wali Kelas</h3>
                <div class="block-options">
                    <select name="pilih_periode" id="pilih_periode_guru" class="form-select form-select-sm">
                        @foreach ($periode as $item)
                            @php
                                $today = now();
                                $startDate = \Carbon\Carbon::parse($item->tanggalMulai);
                                $endDate = \Carbon\Carbon::parse($item->tanggalSelesai);

                                $selected = $startDate <= $today && $today <= $endDate ? 'selected' : '';
                            @endphp
                            <option value="{{ $item->idPeriode }}" {{ $selected }}>
                                Semester
                                {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                            </option>
                        @endforeach
                        <option value="">Semua Semester</option>
                    </select>
                </div>
            </div>
            <div class="block-content p-0">
                <div class="table-responsive m-4 m-md-0 p-md-4 p-0">
                    <div class="row pb-3 pt-1">
                        <div class="col-md text-md-end text-center">
                            <button class="btn btn-sm btn-alt-success" id="btn_tambahKelasGuru"><i
                                    class="fa fa-plus me-2"></i>Tambah
                                Wali Kelas</button>
                        </div>
                    </div>
                    <table id="tabel_waliKelas" class="table table-bordered table-vcenter w-100">
                        <thead class="bg-body-light align-middle">
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 10%;">Kelas</th>
                                <th style="width: 10%;">Fase</th>
                                <th>Nama Guru</th>
                                <th style="width: 12%;">NIP</th>
                                <th style="width: 22%;">Semester</th>
                                <th style="width: 10%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- conten --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Siswa Kelas</h3>
                <div class="block-options">
                    <select name="pilih_periode" id="pilih_periode_siswa" class="form-select form-select-sm">
                        @foreach ($periode as $item)
                            @php
                                $today = now();
                                $startDate = \Carbon\Carbon::parse($item->tanggalMulai);
                                $endDate = \Carbon\Carbon::parse($item->tanggalSelesai);

                                $selected = $startDate <= $today && $today <= $endDate ? 'selected' : '';
                            @endphp
                            <option value="{{ $item->idPeriode }}" {{ $selected }}>
                                Semester
                                {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                            </option>
                        @endforeach
                        <option value="">Semua Semester</option>
                    </select>
                </div>
            </div>
            <div class="block-content block-content-full p-0">
                <div class="table-responsive m-4 m-md-0 p-md-4 p-0">
                    <div class="row g-3 pb-3 pt-1">
                        <div class="col-md-6 text-md-start text-center">
                            <div class="btn-group" role="group" aria-label="Horizontal Alternate Info">
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas active"
                                    value="1">Kelas
                                    1</button>
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas" value="2">Kelas
                                    2</button>
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas" value="3">Kelas
                                    3</button>
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas" value="4">Kelas
                                    4</button>
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas" value="5">Kelas
                                    5</button>
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas" value="6">Kelas
                                    6</button>
                                <button type="button" class="btn btn-sm btn-danger btn_kelas" value="">Kelas
                                    (-)</button>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end text-center">
                            <button class="btn btn-sm btn-alt-success" id="btn_tambahKelasSiswa"><i
                                    class="fa fa-plus me-2"></i>Tambah Siswa Kelas</button>
                        </div>
                    </div>
                    <table id="tabel_siswaKelas" class="table table-bordered table-vcenter w-100">
                        <thead class="bg-body-light align-middle">
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 10%;">Kelas</th>
                                <th style="width: 10%;">Fase</th>
                                <th>Nama Siswa</th>
                                <th style="width: 12%;">NIS</th>
                                <th style="width: 22%;">Semester</th>
                                <th style="width: 10%;" class="text-center">Aksi</th>
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

    {{-- ==================================== MODAL GURU ============================================= --}}
    <div class="modal fade" id="modal_kelasGuru" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal-bagiKelasGuruLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="title-modal"></h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <form action="" id="form_waliKelas" method="post">
                            @csrf
                            <input type="hidden" name="_method" id="method_waliKelas" value="POST">
                            <input type="text" name="idKelas" class="id-kelas" hidden>
                            <div class="mb-3">
                                <label class="form-label" for="periode">Perode</label>
                                <select id="idPeriode" name="idPeriode" class="form-select" required>
                                    <option value="" disabled selected>Pilih Periode</option>
                                    @foreach ($periode as $item)
                                        <option value="{{ $item->idPeriode }}">
                                            Semester
                                            {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="idPegawai">Nama Guru</label>
                                <select name="idPegawai" id="idPegawai" class="form-select" required
                                    data-placeholder="Pilih Guru"></select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="namaKelas">Kelas</label>
                                <select name="namaKelas" id="namaKelas" class="form-select"
                                    data-placeholder="Pilih Kelas" required>
                                    <option value="" disabled selected>Pilih Kelas</option>
                                    <option value="1">Kelas 1</option>
                                    <option value="2">Kelas 2</option>
                                    <option value="3">Kelas 3</option>
                                    <option value="4">Kelas 4</option>
                                    <option value="5">Kelas 5</option>
                                    <option value="6">Kelas 6</option>
                                </select>
                            </div>
                            <div class="mb-4 text-end" id="bt_modalGuru">
                                {{-- button submit --}}
                            </div>
                        </form>
                    </div>
                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ==================================== MODAL SISWA ============================================= --}}
    <div class="modal fade" id="modal_kelasSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal-bagiKelasSiswaLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="title-modal-siswa"></h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <form action="" id="form_siswaKelas" method="post">
                            @csrf
                            <input type="hidden" name="_method" id="method_siswaKelas" value="POST">
                            <input type="text" name="idKelas" class="id-tr-kelas" hidden>
                            <div class="mb-3">
                                <label class="form-label" for="pilih_periode">Periode Semester</label>
                                <select name="pilih_periode" id="pilih_periode" class="form-select">
                                    <option value="" disabled selected>Pilih Periode</option>
                                    @foreach ($periode as $item)
                                        @php
                                            $today = now();
                                            $startDate = \Carbon\Carbon::parse($item->tanggalMulai);
                                            $endDate = \Carbon\Carbon::parse($item->tanggalSelesai);

                                            $selected = $startDate <= $today && $today <= $endDate ? 'selected' : '';
                                        @endphp
                                        <option value="{{ $item->idPeriode }}">
                                            Semester
                                            {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="idKelas">Kelas</label>
                                <select name="idKelas" id="idKelas" class="form-select"
                                    data-placeholder="Pilih Kelas"></select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="idSiswa">Nama Siswa</label>
                                <select name="idSiswa[]" multiple="multiple" id="idSiswa"
                                    class="form-select"></select>
                            </div>

                            <div class="mb-4 text-end" id="cn-btn-siswa">
                                {{-- button submit --}}
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
            $(document).ready(function() {
                const insertWaliKelas = $('#btn_tambahKelasGuru');
                const modalWaliKelas = $('#modal_kelasGuru');
                const modalWaliKelas_btn = $('#bt_modalGuru');
                const modalWaliKelas_title = $('#title-modal');
                const methodlWaliKelas = $('#method_waliKelas');
                const formWaliKelas = $('#form_waliKelas');
                const tabelWaliKelas = $('#tabel_waliKelas');

                const tabelSiswaKelas = $('#tabel_siswaKelas');
                const insertSiswaKelas = $('#btn_tambahKelasSiswa');
                const modalSiswaKelas = $('#modal_kelasSiswa');
                const modalSiswaKelas_title = $('#title-modal-siswa');
                const modalSiswaKelas_btn = $('#cn-btn-siswa');
                const methodlSiswaKelas = $('#method_siswaKelas');
                const formSiswaKelas = $('#form_siswaKelas');

                $('#pilih_periode_guru').on('change', function() {
                    tabelWaliKelas.DataTable().ajax.reload();
                });
                // Guru
                tabelWaliKelas.DataTable({
                    processing: true,
                    ajax: {
                        url: "{{ url('data-kelas/get/guru') }}",
                        data: function(d) {
                            d.periode_guru = $('#pilih_periode_guru').val();
                        }
                    },
                    columns: [{
                            data: 'nomor',
                            name: 'nomor',
                            className: 'text-center',
                        },
                        {
                            data: 'kelas',
                            name: 'kelas',
                        },
                        {
                            data: 'fase',
                            name: 'fase',
                            className: 'text-center',
                            render: function(data) {
                                var fase = data;
                                if (fase === 'A') {
                                    return '<span class="badge bg-primary">Fase A</span>';
                                } else if (fase === 'B') {
                                    return '<span class="badge bg-success">Fase B</span>';
                                } else if (fase === 'C') {
                                    return '<span class="badge bg-warning">Fase C</span>';
                                }
                                return '<em>null</em>';
                            },
                        },
                        {
                            data: 'namaGuru',
                            name: 'namaGuru'
                        },
                        {
                            data: 'nip',
                            name: 'nip'
                        },
                        {
                            data: 'semester',
                            name: 'semester',
                        },
                        {
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editGuru" value="' +
                                    data.idKelas + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusGuru" title="Delete" value="' +
                                    data.idKelas + '" data-nama-guru="' + data.namaGuru +
                                    '" data-nama-kelas="Kelas ' + data.namaKelas + '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    order: [
                        [1, 'asc']
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [6, 35, 50],
                });

                // Show Modal Insert Wali Kelas
                showModalInsert(
                    insertWaliKelas,
                    modalWaliKelas,
                    formWaliKelas,
                    `{{ route('data-kelas.store.guru') }}`,
                    methodlWaliKelas,
                    modalWaliKelas_title,
                    modalWaliKelas_btn,
                    'Tambah Wali Kelas',
                    `<button type="submit" class="btn btn-primary" >Simpan</button>`,
                );

                insertWaliKelas.click(function() {
                    $('#idPegawai').val(null).change();
                });

                insertSiswaKelas.click(function() {
                    $('#idKelas').val(null).change();
                    $('#idSiswa').val(null).change();
                });

                // Store & Update Guru
                insertOrUpdateData(
                    formWaliKelas,
                    function() {
                        modalWaliKelas.modal('hide');
                        tabelWaliKelas.DataTable().ajax.reload();
                    }
                );

                $(document).on('click', '#action-editGuru', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    modalWaliKelas.modal('show');
                    updateModals(
                        modalWaliKelas_title,
                        modalWaliKelas_btn,
                        'Ubah Wali Kelas',
                        `<button type="submit" class="btn btn-primary" >Simpan</button>`,
                    );
                    formWaliKelas.attr('action', `{{ url('data-kelas/update/guru/${id}') }}`);
                    methodlWaliKelas.val('PUT');

                    $.ajax({
                        type: "GET",
                        url: `{{ url('data-kelas/edit/guru/${id}') }}`,
                        success: function(response) {
                            $('#idPeriode').val(response.kelas.idPeriode);
                            $('#namaKelas').val(response.kelas.namaKelas);
                            $('#idPegawai').val(response.kelas.idPegawai).trigger('change');
                        }
                    });
                });

                $(document).on('click', '#action-hapusGuru', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-guru');
                    var kelas = $(this).data('nama-kelas');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus data <strong>${kelas}</strong> dengan wali kelas <strong>${nama}</strong>, akan menghapus data lain terkait kelas ini.`,
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: `{{ url('data-kelas/destroy/guru/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    tabelWaliKelas.DataTable().ajax.reload();
                                },
                            });
                        }
                    });
                });

                // Modal Guru Reset Form
                modalWaliKelas.on('hidden.bs.modal', function() {
                    resetForm(
                        formWaliKelas,
                        function() {
                            $('#idPegawai').val(null).change();
                        }
                    );
                });

                getSelectPegawai();

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

                // Select2 from wali kelas
                select2(
                    '#idPegawai',
                    modalWaliKelas,
                );

                // selet2 from kelas siswa
                select2('#idKelas', modalSiswaKelas);

                $('.btn_kelas').on('click', function() {
                    $('.btn_kelas').removeClass('active');
                    $(this).addClass('active');

                    // Muat ulang data tabel
                    tabelSiswaKelas.DataTable().ajax.reload();
                });

                $('#pilih_periode_siswa').on('change', function() {
                    tabelSiswaKelas.DataTable().ajax.reload();
                });

                // Siswa
                tabelSiswaKelas.DataTable({
                    processing: true,
                    ajax: {
                        url: "{{ url('data-kelas/get/siswa') }}",
                        data: function(d) {
                            d.kelas_nama = $('.btn_kelas.active').val();
                            d.periode_siswa = $('#pilih_periode_siswa').val();
                        }
                    },
                    columns: [{
                            data: 'nomor',
                            name: 'nomor',
                            className: 'text-center',
                        },
                        {
                            data: 'kelas',
                            name: 'kelas',
                        },
                        {
                            data: 'fase',
                            name: 'fase',
                            className: 'text-center',
                            render: function(data) {
                                var fase = data;
                                if (fase === 'A') {
                                    return '<span class="badge bg-primary">Fase A</span>';
                                } else if (fase === 'B') {
                                    return '<span class="badge bg-success">Fase B</span>';
                                } else if (fase === 'C') {
                                    return '<span class="badge bg-warning">Fase C</span>';
                                }
                                return '<em>null</em>';
                            },
                        },
                        {
                            data: 'namaSiswa',
                            name: 'namaSiswa'
                        },
                        {
                            data: 'nis',
                            name: 'nis'
                        },
                        {
                            data: 'semester',
                            name: 'semester',
                        },
                        {
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `<div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editSiswa" value="${data.idSiswa}"><i class="fa fa-fw fa-pencil-alt"></i></button>
                                    <button type="button" class="btn btn-sm btn-alt-danger" title="Delete" id="action-deleteSiswa" value="${data.idSiswa}" data-kelas="${data.kelas}" data-nama="${data.namaSiswa}"><i class="fa fa-fw fa-times"></i></button>
                                    </div>`;
                            }
                        }
                    ],
                    order: [
                        [3, 'asc']
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [25, 50, 100],
                });

                showModalInsert(
                    insertSiswaKelas,
                    modalSiswaKelas,
                    formSiswaKelas,
                    `{{ route('data-kelas.store.siswa') }}`,
                    methodlSiswaKelas,
                    modalSiswaKelas_title,
                    modalSiswaKelas_btn,
                    'Tambah Siswa Kelas',
                    `<button type="submit" class="btn btn-primary" >Simpan</button>`,
                );

                getSelectSiswa();

                modalSiswaKelas.on('hidden.bs.modal', function() {
                    resetForm(
                        formSiswaKelas,
                        function() {
                            $('#idSiswa').prop("disabled", false);
                            $('#idKelas').val(null).change();
                        }
                    );
                });

                select2Multiple('#idSiswa', modalSiswaKelas);

                function getSelectSiswa() {
                    $.ajax({
                        type: "GET",
                        url: `{{ route('form.kelas') }}`,
                        success: function(data) {
                            $('#idSiswa').html('');
                            $.each(data.siswa, function(i, item) {
                                $('#idSiswa').append(
                                    `<option value="${item.idSiswa}">${item.nis} - ${item.namaSiswa}</option>`
                                );
                            });
                        },
                    });
                }

                function getSelectKelas() {
                    $.ajax({
                        type: "GET",
                        url: `{{ route('form.kelas') }}`,
                        data: {
                            periode: $('#pilih_periode').val()
                        },
                        success: function(data) {
                            $('#idKelas').html('');
                            $.each(data.kelas, function(i, item) {
                                $('#idKelas').append(
                                    `<option value="${item.idKelas}">Kelas ${item.namaKelas} - ${item.guru.namaPegawai}</option>`
                                );
                            });
                        },
                    });
                }

                $('#pilih_periode').on('change', function() {
                    getSelectKelas();
                });

                // Store & Update Siswa
                insertOrUpdateData(
                    formSiswaKelas,
                    function() {
                        modalSiswaKelas.modal('hide');
                        tabelSiswaKelas.DataTable().ajax.reload();
                    }
                );

                $(document).on('click', '#action-editSiswa', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    modalSiswaKelas.modal('show');
                    updateModals(
                        modalSiswaKelas_title,
                        modalSiswaKelas_btn,
                        'Ubah Siswa Kelas',
                        `<button type="submit" class="btn btn-primary" >Simpan</button>`,
                    );
                    methodlSiswaKelas.val('PUT');
                    formSiswaKelas.attr('action', `{{ url('data-kelas/update/siswa/${id}') }}`);

                    $('#idSiswa').html('');
                    $('#idSiswa').prop("disabled", true);

                    getSelectKelas();


                    $.ajax({
                        type: "GET",
                        url: `{{ url('data-kelas/edit/siswa/${id}') }}`,
                        success: function(response) {
                            $('#pilih_periode').val(response.kelas[0].idPeriode).trigger('change');
                            $('#idSiswa').append(
                                `<option selected value="${response.idSiswa}">${response.namaSiswa}</option>`
                            );
                            setTimeout(function() {
                                $('#idKelas').val(response.kelas[0].idKelas).trigger(
                                    'change');
                            }, 1000);
                        },
                    });

                });

                $(document).on('click', '#action-deleteSiswa', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama');
                    var kelas = $(this).data('kelas');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus data <strong>${nama}</strong> dari <strong>${kelas}</strong>, akan menghapus data lain yang terkait.`,
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: `{{ url('data-kelas/destroy/siswa/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    tabelSiswaKelas.DataTable().ajax.reload();
                                },
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
