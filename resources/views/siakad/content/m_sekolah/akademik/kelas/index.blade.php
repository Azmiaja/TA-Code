@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    {{-- <div class="dropdown">
        <button type="button" class="btn btn-sm btn-alt-success dropdown-toggle" id="dropdown-align-alt-primary"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-plus mx-2"></i>Tambah Data
        </button>
        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-align-alt-primary">
            <a class="dropdown-item" id="btn-tambahKelasGuru" href="javascript:void(0)">Tambah Guru</a>
            <a class="dropdown-item" id="btn-tambahKelasSiswa" href="javascript:void(0)">Tambah Siswa</a>
        </div>
    </div> --}}
    <div class="content">
        <div class="row m-0 pb-4 justify-content-end">
            <div class="col-sm-4 p-0">
                {{-- ATUR PERIODE --}}
                <select class="form-select" id="periode" name="semester">
                    @foreach ($periode as $item)
                        @php
                            $today = now();
                            $startDate = \Carbon\Carbon::parse($item->tanggalMulai);
                            $endDate = \Carbon\Carbon::parse($item->tanggalSelesai);
                            $selected = $today >= $startDate && $today <= $endDate ? 'selected' : '';
                        @endphp

                        <option value="{{ $item->idPeriode }}" {{ $selected }}>
                            Semester {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Wali Kelas</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-success" id="btn_tambahKelasGuru"><i
                            class="fa fa-plus me-2"></i>Tambah Wali Kelas</button>
                </div>
            </div>
            <div class="block-content p-0">
                <div class="table-responsive m-4 m-md-0 p-md-4 p-0">
                    <table id="tabel_waliKelas" class="table table-bordered table-vcenter w-100">
                        <thead class="bg-body-light align-middle">
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 10%;">Kelas</th>
                                <th style="width: 10%;">Fase</th>
                                <th>Nama Guru</th>
                                <th style="width: 15%;">NIP</th>
                                <th style="width: 20%;">Semester</th>
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
                <h3 class="block-title">Data Siswa Kelas</h3>
            </div>
            <ul class="nav nav-tabs nav-tabs-alt bg-body-light" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="tab_kelas_1" data-bs-toggle="tab" data-bs-target="#btab_kelas_1"
                        role="tab" aria-controls="btab_kelas_1" aria-selected="true">Kelas 1</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab_kelas_2" data-bs-toggle="tab" data-bs-target="#btab_kelas_2"
                        role="tab" aria-controls="btab_kelas_2" aria-selected="true">Kelas 2</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab_kelas_3" data-bs-toggle="tab" data-bs-target="#btab_kelas_3"
                        role="tab" aria-controls="btab_kelas_3" aria-selected="true">Kelas 3</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab_kelas_4" data-bs-toggle="tab" data-bs-target="#btab_kelas_4"
                        role="tab" aria-controls="btab_kelas_4" aria-selected="true">Kelas 4</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab_kelas_5" data-bs-toggle="tab" data-bs-target="#btab_kelas_5"
                        role="tab" aria-controls="btab_kelas_5" aria-selected="true">Kelas 5</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab_kelas_6" data-bs-toggle="tab" data-bs-target="#btab_kelas_6"
                        role="tab" aria-controls="btab_kelas_6" aria-selected="true">Kelas 6</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab_siswa" data-bs-toggle="tab" data-bs-target="#btab_siswa" role="tab"
                        aria-controls="btab_siswa" aria-selected="false">Siswa</button>
                </li>
            </ul>
            <div class="block-content tab-content p-0">
                <div class="tab-pane active" id="btab_kelas_1" role="tabpanel" aria-labelledby="tab_kelas_1" tabindex="0">
                    <h1>Kelas 1</h1>
                </div>
                <div class="tab-pane" id="btab_kelas_2" role="tabpanel" aria-labelledby="tab_kelas_2" tabindex="0">
                    <h1>Kelas 2</h1>
                </div>
                <div class="tab-pane" id="btab_kelas_3" role="tabpanel" aria-labelledby="tab_kelas_3" tabindex="0">
                    <h1>Kelas 3</h1>
                </div>
                <div class="tab-pane" id="btab_kelas_4" role="tabpanel" aria-labelledby="tab_kelas_4" tabindex="0">
                    <h1>Kelas 4</h1>
                </div>
                <div class="tab-pane" id="btab_kelas_5" role="tabpanel" aria-labelledby="tab_kelas_5" tabindex="0">
                    <h1>Kelas 5</h1>
                </div>
                <div class="tab-pane" id="btab_kelas_6" role="tabpanel" aria-labelledby="tab_kelas_6" tabindex="0">
                    <h1>Kelas 6</h1>
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
                        <table id="tabel-PeriodeSiswa" class="table table-bordered table-vcenter w-100">
                            <thead class="bg-body-light align-middle">
                                <tr>
                                    <th style="max-width: 5%;" class="text-center">No</th>
                                    <th style="width: auto">Kelas</th>
                                    <th>Semester</th>
                                    <th>Nama Siswa</th>
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
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="data-guru-tab" data-bs-toggle="tab"
                                data-bs-target="#data-guru" role="tab" aria-controls="data-guru"
                                aria-selected="true" onclick="reloadGuru()">Guru</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="data-siswa-tab" data-bs-toggle="tab"
                                data-bs-target="#data-siswa" role="tab" aria-controls="data-siswa"
                                onclick="reloadSiswa()" aria-selected="false">Siswa</button>
                        </li>
                        <li class="nav-item ms-auto">

                        </li>
                    </ul>
                    <div class="block-content tab-content overflow-hidden">
                        <div class="tab-pane fade show active" id="data-guru" role="tabpanel"
                            aria-labelledby="data-guru-tab" tabindex="0">

                            {{-- <tbody>
                                    @foreach ($guru as $item)
                                        <tr>
                                            <td class="text-center fs-sm">{{ $loop->iteration }}</td>
                                            <td class="fs-sm">{{ $item->namaPegawai }}</td>
                                            <td class="fs-sm">{{ $item->nip }}</td>
                                            <td class="fs-sm">{{ $item->jenisKelamin }}</td>
                                            <td class="fs-sm">{{ $item->kelas->namaKelas ?? 'N/A' }}</td>
                                            <td class="fs-sm text-center">
                                                <span
                                                    class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill {{ $item->status === 'Aktif' ? 'bg-success-light text-success' : 'bg-danger-light text-danger' }}">
                                                    {{ $item->status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-alt-primary" title="Edit"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalEdit{{ $item->idPeriode }}"><i
                                                            class="fa fa-fw fa-pencil-alt"></i></button>
                                                    <button type="button" class="btn btn-sm btn-alt-danger" title="Delete"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deletModal{{ $item->idPeriode }}">
                                                        <i class="fa fa-fw fa-times"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-alt-info" title="Info Detail"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $item->idPeriode }}">
                                                        <i class="fa fa-fw fa-info"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody> --}}
                            </table>
                        </div>
                        <div class="tab-pane fade" id="data-siswa" role="tabpanel" aria-labelledby="data-siswa-tab"
                            tabindex="0">

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

    @include('siakad/content/m_sekolah/akademik/kelas/modal-walikelas')

    {{-- ==================================== MODAL SISWA ============================================= --}}
    <div class="modal fade" id="modal-bagiKelasSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal-bagiKelasSiswaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="title-modal-siswa">Judul Modal</h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <input type="text" name="idKelas" class="id-tr-kelas" hidden>
                        <div class="mb-4">
                            <label class="form-label" for="periode">Perode</label>
                            <select name="periode" id="periode_klas_siswa" class="form-select pilih-periode-siswa">
                                <option value="" disabled selected>-- Pilih Periode --</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="namaKelas">Kelas</label>
                            <select name="namaKelas" id="namaKelas_siswa" class="form-select pilih-kelas-siswa">
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                <!-- Data akan ditambahkan dengan Ajax di sini -->
                            </select>

                        </div>
                        <div class="mb-4" id="namesis">
                            <label class="form-label" for="idSiswa">Nama Siswa</label>
                            <select name="idSiswa" multiple="multiple" id="idSiswa" class="form-select pilih-siswa">
                                <option value="" disabled selected>-- Pilih Siswa --</option>
                            </select>
                        </div>
                        <div class="mb-4 namesis-two">
                            <label class="form-label" for="idSiswa">Nama Siswa</label>
                            <select name="idSiswa" id="idSiswa-two" class="form-select pilih-siswa">
                                <option value="" disabled selected>-- Pilih Siswa --</option>
                            </select>
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

    <script>
        function reloadSiswa() {
            $('#tabel-PeriodeSiswa').DataTable().columns.adjust().draw();
        }

        function reloadGuru() {
            $('#tabel-PeriodeGuru').DataTable().columns.adjust().draw();
        }

        function loadDropdownOptions() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'GET',
                url: "{{ url('data-kelas/kelas/form') }}",
                success: function(data) {
                    $('.pilih-periode').empty();
                    $('.pilih-periode').append(
                        '<option value="" disabled selected>-- Pilih Periode --</option>');

                    $('.pilih-guru').empty();
                    $('.pilih-guru').append(
                        '<option value="" disabled selected>-- Pilih Guru --</option>');

                    $('.pilih-siswa').empty();


                    $.each(data.periode, function(key, value) {
                        // console.log(value.idKelas);
                        $('.pilih-periode').append('<option value="' + value.idPeriode +
                            '">' + value.formattedTanggalMulai + '</option>');
                    });

                    $.each(data.guru, function(key, value) {
                        // console.log(value.idKelas);
                        $('.pilih-guru').append('<option value="' + value.idPegawai +
                            '">' + value.namaPegawai + '</option>');
                    });

                    $.each(data.siswa, function(key, value) {
                        $('.pilih-siswa').append('<option value="' + value.idSiswa +
                            '">' + value.namaSiswa + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            $.ajax({
                type: 'GET',
                url: "{{ url('pengajar/get-form') }}",
                success: function(data) {
                    // PERIODE
                    $('.pilih-periode-siswa').empty();
                    $('.pilih-periode-siswa').append(
                        '<option value="" disabled selected>-- Pilih Periode --</option>');

                    $.each(data.periode, function(key, value) {
                        $('.pilih-periode-siswa').append('<option value="' + value.idPeriode +
                            '">Semester ' + value.formattedTanggalMulai + '</option>');
                    });

                    $('.pilih-periode-siswa').on('change', function() {
                        var selectedPeriodeId = $(this).val();

                        // Fetch classes based on the selected period
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('pengajar/get-form') }}", // You need to define a route for this
                            data: {
                                periode_id: selectedPeriodeId
                            },
                            success: function(classesData) {
                                // Populate the classes dropdown based on the fetched data
                                $('.pilih-kelas-siswa').empty();
                                // $('.pilih-kelas-siswa').append(
                                //     '<option value="" disabled selected>-- Pilih Kelas --</option>'
                                // );

                                $.each(classesData.kelas, function(key, value) {
                                    $('.pilih-kelas-siswa').append(
                                        '<option value="' + value
                                        .idKelas +
                                        '">Kelas ' + value.namaKelas +
                                        '</option>');
                                });
                            },
                        });
                    });
                }
            });
        }

        function clearform() {
            $('.pilih-periode').val('');
            $('.pilih-periode-siswa').val('');
            $('.pilih-kelas').val('');
            $('.pilih-kelas-siswa').val('');
            $('#idSiswa').val('');
            $('.pilih-siswa').val('');
            $('#idPegawai').val('');
        }


        $(document).ready(function() {
            const insertWaliKelas = $('#btn_tambahKelasGuru');
            const modalWaliKelas = $('#modal_kelasGuru');
            const modalWaliKelas_btn = $('#bt_modalGuru');
            const modalWaliKelas_title = $('#title-modal');
            const methodlWaliKelas = $('#method_waliKelas');
            const formWaliKelas = $('#form_waliKelas');
            const tabelWaliKelas = $('#tabel_waliKelas');

            function updateModal_waliKelas(title, button) {
                modalWaliKelas_title.text(title);
                modalWaliKelas_btn.html(button);
            }

            insertWaliKelas.click(function(e) {
                modalWaliKelas.modal('show');
                updateModal_waliKelas('Tambah Wali Kelas',
                    `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> <button type="submit" class="btn btn-primary" id="btn-tbhGuru">Simpan</button>`
                );
                formWaliKelas.attr('action', `{{ route('data-kelas.store') }}`);
            });

            function resetForm() {
                formWaliKelas.trigger('reset');
                $('#idPegawai').val(null).change();
            }
            modalWaliKelas.on('hidden.bs.modal', function() {
                resetForm();
            });

            // Select2 from wali kelas
            $('#idPegawai').select2({
                width: "100%",
                cache: false,
                dropdownParent: modalWaliKelas,
                theme: "bootstrap",
                placeholder: "Pilih Guru",
                allowClear: true,
                selectOnClose: true
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
                                `<option value="${item.idPegawai}">${item.namaPegawai}</option>`
                            );
                        });
                    },
                });
            }

            // function initSelect2(selector, placeholder, dropdownParent) {
            //     $(selector).select2({
            //         placeholder,
            //         allowClear: true,
            //         width: "100%",
            //         cache: false,
            //         dropdownParent,
            //         theme: "bootstrap",
            //     });
            // }

            // initSelect2('#idPrgawai', "Pilih Guru", $('#modal-bagiKelasGuru'));
            // initSelect2('#idSiswa', '', $('#modal-bagiKelasSiswa'));
            // initSelect2('#idSiswa-two', '', $('#modal-bagiKelasSiswa'));

            // getPeriode();
            // loadDropdownOptions()
            function getPeriode() {
                $.ajax({
                    type: "GET",
                    url: `{{ route('get.kelas.options') }}`,
                    success: function(data) {
                        $('#periode_klas').html('');
                        $('#periode_klas').html(
                            '<option disabled selected>-- Pilih Periode --</option>');
                        $.each(data, function(i, item) {
                            console.log(item.semester);
                            $('#periode_klas').append(
                                `<option value="${item.idPeriode}">Semester ${item.semester}</option>`
                            );
                        });
                    },
                });
            }
            // Guru
            tabelWaliKelas.DataTable({
                ordering: false,
                ajax: "{{ url('periode/guru/get-data') }}",
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
                        data: 'nipGuru',
                        name: 'nipGuru'
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
                                data.idKelas + '" data-nama-guru="' + data.namaGuru + '">' +
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
                lengthMenu: [5, 25, 50],
                buttons: [{
                        extend: 'print',
                        title: '<h2>Data Guru Kelas</h2>',
                        className: 'btn-sm btn btn-alt-primary',
                        filename: 'Data Guru Kelas',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                        },
                        messageTop: null,
                        messageBottom: null,
                        customize: function(win) {
                            $(win.document.body).css('text-align', 'center');
                        },

                    },
                    {
                        extend: 'excel',
                        title: 'Data Guru Kelas',
                        className: 'btn-sm btn btn-alt-success',
                        sheetName: 'Data Guru Kelas',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                        },
                        action: function(e, dt, button, config) {
                            var confirmation = window.confirm(
                                'Apakah Anda yakin ingin mengekspor data ke Excel?');

                            if (confirmation) {
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(this,
                                    e, dt,
                                    button, config);
                            }
                        },
                    }
                ],
            });

            // Siswa
            $('#tabel-PeriodeSiswa').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('periode/siswa/get-data') }}",
                    data: function(d) {
                        d.periode_id = $('#periode').val();
                    }
                },
                columns: [{
                        data: null,
                        name: 'nomor',
                        className: 'text-center',
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row +
                                1;
                        }
                    },
                    {
                        data: 'namaKelas',
                        name: 'namaKelas',
                        render: function(data, type, row) {
                            return 'kelas ' + data;
                        },
                        searchable: true
                    },
                    {
                        data: 'formattedTanggalMulai',
                        name: 'formattedTanggalMulai'
                    },
                    {
                        data: 'namaSiswa',
                        name: 'namaSiswa'
                    },
                    {
                        data: null,
                        className: 'text-center',
                        searchable: false,
                        render: function(data, type, row) {
                            return '<div class="btn-group">' +
                                '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editSiswa" value="' +
                                row.idtrKelas + '">' +
                                '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusSiswa" title="Delete" value="' +
                                data.idtrKelas + '" data-nama-siswa="' + data
                                .namaSiswa + '">' +
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
                lengthMenu: [10, 25, 50, 100],
                buttons: [{
                        extend: 'print',
                        title: '<h2>Data Siswa Kelas</h2>',
                        className: 'btn-sm btn btn-alt-primary',
                        filename: 'Data Siswa Kelas',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                        },
                        messageTop: null,
                        messageBottom: null,
                        customize: function(win) {
                            $(win.document.body).css('text-align', 'center');
                        },

                    },
                    {
                        extend: 'excel',
                        title: 'Data Siswa Kelas',
                        className: 'btn-sm btn btn-alt-success',
                        sheetName: 'Data Siswa Kelas',
                        exportOptions: {
                            columns: [0, 1, 2, 3],
                        },
                        action: function(e, dt, button, config) {
                            var confirmation = window.confirm(
                                'Apakah Anda yakin ingin mengekspor data ke Excel?');

                            if (confirmation) {
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(this,
                                    e, dt,
                                    button, config);
                            }
                        },
                    }
                ],
            });


            // FUNGSI PERIODE
            $('#periode').change(function() {
                $('#tabel-PeriodeGuru').DataTable().ajax.reload();
                $('#tabel-PeriodeSiswa').DataTable().ajax.reload();
            });

            function reloadSiswa() {
                $('#tabel-PeriodeSiswa').DataTable().ajax.reload();
            }

            // CRUD DATA GURU

            // $(document).on('click', '#btn-tambahKelasGuru', function(e) {
            //     e.preventDefault();
            //     $("#modal-bagiKelasGuru").modal('show');
            //     $("#title-modal").text('Tambah Guru Kelas');
            //     $("#cn-btn").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        //                         <button type="submit" class="btn btn-primary" id="btn-tbhGuru">Simpan</button>`);
            //     $('.pilih-periode').val('');
            //     $('.pilih-kelas').val('');
            //     $('.pilih-guru').val(null).trigger('change');
            //     // getPeriode();

            // });

            formWaliKelas.submit(function(e) {
                e.preventDefault();
                var periode = $('#periode_klas').val();
                var guru = $('#idPegawai').val();
                var kelas = $('#namaKelas').val();

                $.ajax({
                    type: "POST",
                    url: formWaliKelas.attr('action'),
                    data: {
                        idPeriode: periode,
                        idPegawai: guru,
                        namaKelas: kelas,
                    },
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            icon: response.status,
                            title: response.status,
                            text: response.message,
                        });
                        modalWaliKelas.modal('hide');
                        tabelWaliKelas.DataTable().ajax.reload();

                    },
                });
            });

            $(document).on('click', '#action-editGuru', function(e) {
                e.preventDefault();
                var id = $(this).val();
                $("#modal-bagiKelasGuru").modal('show');
                $("#title-modal").text('Edut Guru Kelas');
                $("#cn-btn").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-edtGuru">Simpan</button>`);

                $.ajax({
                    type: "GET",
                    url: "{{ url('data-kelas/edit/guru') }}/" + id,
                    success: function(response) {
                        $('.pilih-periode').val(response.kelas.idPeriode);
                        // $('.pilih-guru').val(response.kelas.idPegawai);
                        $('.pilih-kelas').val(response.kelas.namaKelas);
                        $('.id-kelas').val(response.kelas.idKelas);

                        var selectGuru = $(".pilih-guru");
                        var optionGuru = selectGuru.find("option[value='" + response
                            .kelas
                            .idPegawai + "']");
                        selectGuru.val(optionGuru.val()).trigger('change');
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

            $(document).on('click', '#btn-edtGuru', function(e) {
                e.preventDefault();
                var id = $('.id-kelas').val();
                var data = {
                    'idPeriode': $('.pilih-periode').val(),
                    'idPegawai': $('.pilih-guru').val(),
                    'namaKelas': $('.pilih-kelas').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PUT",
                    url: "{{ url('data-kelas/update/guru') }}/" + id,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $(".btn-block-option").click();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#tabel-PeriodeGuru').DataTable().ajax.reload();
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

            $(document).on('click', '#action-hapusGuru', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var nama = $(this).data('nama-guru');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Menghapus data ' + nama + '',
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
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                    .attr('content')
                            }
                        });
                        $.ajax({
                            type: "DELETE",
                            url: "/data-kelas/destroy/guru/" + id,
                            dataType: 'json',
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: response.message,
                                });
                                $('#tabel-PeriodeGuru').DataTable().ajax
                                    .reload();
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Data kelas gagal dihapus.' +
                                        xhr
                                        .responseJSON.message,
                                });
                            }
                        });
                    }
                });
            });

            // CRUD DATA SISWA

            $(document).on('click', '#btn-tambahKelasSiswa', function(e) {
                e.preventDefault();
                $("#modal-bagiKelasSiswa").modal('show');
                $("#title-modal-siswa").text('Tambah Siswa Kelas');
                $("#cn-btn-siswa").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-tbhSiswa">Simpan</button>`);
                $('#idSiswa').val(null).trigger('change');
                $('.pilih-kelas-siswa').val('');
                $('.pilih-periode-siswa').val('');

                $('.namesis-two').prop('hidden', true);
                $('#namesis').prop('hidden', false);
            });

            $(document).on('click', '#btn-tbhSiswa', function(e) {
                e.preventDefault();
                var data = {
                    'idKelas': $('.pilih-kelas-siswa').val(),
                    'idSiswa': $('.pilih-siswa').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('data-kelas.store.siswa') }}",
                    data: data,
                    // contentType: false,
                    // processData: false,
                    dataType: "json",
                    success: function(response) {
                        $(".btn-block-option").click();

                        Swal.fire({
                            icon: response.status,
                            title: response.status,
                            text: response.message,
                        });
                        $('#tabel-PeriodeSiswa').DataTable().ajax.reload();
                        loadDropdownOptions();
                        $('.pilih-kelas-siswa').val('');
                        $('.pilih-siswa').val('');
                        $('.pilih-periode-siswa').val('');

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

            $(document).on('click', '#action-editSiswa', function(e) {
                e.preventDefault();
                var id = $(this).val();
                $("#modal-bagiKelasSiswa").modal('show');
                $("#title-modal-siswa").text('Edit Siswa Kelas');
                $("#cn-btn-siswa").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-edtSiswa">Simpan</button>`);

                $('.namesis-two').prop('hidden', false);
                $('#namesis').prop('hidden', true);

                $.ajax({
                    type: "GET",
                    url: "{{ url('data-kelas/edit/siswa') }}/" + id,
                    success: function(response) {
                        $('#idSiswa-two').val(response.tr_kelas.idSiswa);
                        $('.pilih-periode-siswa').val(response.tr_kelas.kelas.idPeriode)
                            .trigger('change');

                        var selectSiswa = $("#idSiswa-two");
                        var optionSiswa = selectSiswa.find("option[value='" + response.tr_kelas
                            .idSiswa + "']");
                        selectSiswa.val(optionSiswa.val()).trigger('change');

                        // Ajax untuk mengambil data kelas
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('pengajar/get-form') }}", // Sesuaikan dengan URL yang benar
                            data: {
                                periode_id: response.tr_kelas.kelas.idPeriode
                            },
                            success: function(classesData) {
                                // Setelah data kelas berhasil dimuat, baru atur nilai pada elemen select kelas
                                $('.pilih-kelas-siswa').val(response.tr_kelas
                                    .idKelas).trigger('change');
                                $('.id-tr-kelas').val(response.tr_kelas.idtrKelas);
                            },
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

            $(document).on('click', '#btn-edtSiswa', function(e) {
                e.preventDefault();
                var id = $('.id-tr-kelas').val();
                var data = {
                    'idSiswa': $('#idSiswa-two').val(),
                    'idKelas': $('.pilih-kelas-siswa').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PUT",
                    url: "{{ url('data-kelas/update/siswa') }}/" + id,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $(".btn-block-option").click();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#tabel-PeriodeSiswa').DataTable().ajax.reload();
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

            $(document).on('click', '#action-hapusSiswa', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var nama = $(this).data('nama-siswa');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Menghapus data ' + nama + '',
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
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                    .attr('content')
                            }
                        });
                        $.ajax({
                            type: "DELETE",
                            url: "/data-kelas/destroy/siswa/" + id,
                            dataType: 'json',
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: response.message,
                                });
                                $('#tabel-PeriodeSiswa').DataTable().ajax
                                    .reload();
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Data siswa gagal dihapus.',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
