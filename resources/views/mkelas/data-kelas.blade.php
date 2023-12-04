@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title periode --}}
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
                    {{-- ================================== BUTTON AKTIVITAS TAMBAH DATA ======================================== --}}
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-alt-success dropdown-toggle"
                            id="dropdown-align-alt-primary" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-plus mx-2"></i>Tambah Data
                        </button>
                        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-align-alt-primary">
                            <a class="dropdown-item" id="btn-tambahKelasGuru" href="javascript:void(0)">Tambah Guru</a>
                            <a class="dropdown-item" id="btn-tambahKelasSiswa" href="javascript:void(0)">Tambah Siswa</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="data-guru-tab" data-bs-toggle="tab"
                                data-bs-target="#data-guru" role="tab" aria-controls="data-guru" aria-selected="true"
                                onclick="reloadGuru()">Guru</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="data-siswa-tab" data-bs-toggle="tab" data-bs-target="#data-siswa"
                                role="tab" aria-controls="data-siswa" onclick="reloadSiswa()"
                                aria-selected="false">Siswa</button>
                        </li>
                        <li class="nav-item ms-auto">
                            <div class="row pt-1 m-0 text-end">
                                <div class="col p-0 align-self-center">
                                    {{-- ATUR PERIODE --}}
                                    <select class="form-select form-select-sm" id="periode" name="semester">
                                        @foreach ($periode as $item)
                                            @php
                                                $today = now();
                                                $startDate = \Carbon\Carbon::parse($item->tanggalMulai);
                                                $endDate = \Carbon\Carbon::parse($item->tanggalSelesai);
                                                $selected = $today >= $startDate && $today <= $endDate ? 'selected' : '';
                                            @endphp

                                            <option value="{{ $item->idPeriode }}" {{ $selected }}>
                                                {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <label class="col-auto col-form-label" for="semester">Periode</label>
                            </div>
                        </li>
                    </ul>
                    <div class="block-content tab-content overflow-hidden">
                        <div class="tab-pane fade show active" id="data-guru" role="tabpanel"
                            aria-labelledby="data-guru-tab" tabindex="0">
                            <table id="tabel-PeriodeGuru" style="width: 100%;"
                                class="table tabel-responsive table-bordered table-striped table-vcenter js-dataTable-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;" class="text-center">No</th>
                                        <th style="width: auto">Kelas</th>
                                        <th>Semester</th>
                                        <th>Nama Guru</th>
                                        {{-- <th>Guru Kelas</th> --}}
                                        <th style="width: 15%;" class="text-center">Status</th>
                                        <th style="width: 10%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- conten --}}
                                </tbody>
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
                            <table id="tabel-PeriodeSiswa" style="width: 100%;"
                                class="table tabel-responsive table-bordered table-striped table-vcenter">
                                <thead>
                                    <tr>
                                        <th style="max-width: 5%;" class="text-center">No</th>
                                        <th style="width: auto">Kelas</th>
                                        <th>Semester</th>
                                        <th>Nama Siswa</th>
                                        {{-- <th>Guru Kelas</th> --}}
                                        <th style="width: 15%;" class="text-center">Status</th>
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

    {{-- ==================================== MODAL GURU ============================================= --}}
    <div class="modal fade" id="modal-bagiKelasGuru" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal-bagiKelasGuruLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="title-modal">Judul Modal</h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <input type="text" name="idKelas" class="id-kelas" hidden>
                        <div class="mb-4">
                            <label class="form-label" for="periode">Perode</label>
                            <select name="periode" id="periode" class="form-select pilih-periode">
                                <option value="" disabled selected>-- Pilih Periode --</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="idPrgawai">Nama Guru</label>
                            <select name="idPrgawai" id="idPrgawai" class="form-select pilih-guru">
                                <option value="" disabled selected>-- Pilih Guru --</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="namaKelas">Kelas</label>
                            <select name="namaKelas" id="namaKelas" class="form-select pilih-kelas">
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                <option value="1">Kelas 1</option>
                                <option value="2">Kelas 2</option>
                                <option value="3">Kelas 3</option>
                                <option value="4">Kelas 4</option>
                                <option value="5">Kelas 5</option>
                                <option value="6">Kelas 6</option>
                            </select>
                        </div>
                        <div class="mb-4 text-end" id="cn-btn">
                            {{-- button submit --}}
                        </div>
                    </div>

                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <label class="form-label" for="namaKelas">Kelas</label>
                            <select name="namaKelas" id="namaKelas" class="form-select pilih-kelas-siswa">
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                <!-- Data akan ditambahkan dengan Ajax di sini -->
                            </select>

                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="idSiswa">Nama Siswa</label>
                            <select name="idSiswa" id="idSiswa" class="form-select pilih-siswa">
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
                    $('.pilih-siswa').append(
                        '<option value="" disabled selected>-- Pilih Siswa --</option>');

                    $('.pilih-kelas-siswa').empty();
                    $('.pilih-kelas-siswa').append(
                        '<option value="" disabled selected>-- Pilih Kelas --</option>');
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

                    $.each(data.kelas, function(key, value) {
                        // console.log(value.idKelas);
                        $('.pilih-kelas-siswa').append('<option value="' + value.idKelas +
                            '">Kelas ' + value.namaKelas +
                            ' Semester ' + value.periode.formattedTanggalMulai + '</option>');
                    });

                    $.each(data.siswa, function(key, value) {
                        // console.log(value.idKelas);
                        $('.pilih-siswa').append('<option value="' + value.idSiswa +
                            '">' + value.namaSiswa + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            loadDropdownOptions()
            // Guru
            $('#tabel-PeriodeGuru').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('periode/guru/get-data') }}",
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
                        }
                    },
                    {
                        data: 'periode.formattedTanggalMulai',
                        name: 'periode.formattedTanggalMulai',
                    },
                    {
                        data: 'guru.namaPegawai',
                        name: 'guru.namaPegawai'
                    },
                    {
                        data: 'guru.status',
                        name: 'guru.status',
                        className: 'text-center',
                        render: function(data, type, row) {
                            var statusClass = row.guru.status === 'Aktif' ?
                                'bg-success-light text-success' : 'bg-danger-light text-danger';

                            return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${statusClass}">
                    ${row.guru.status}
                </span>`;
                        }
                    }, {
                        data: null,
                        render: function(data, type, row) {
                            return '<div class="btn-group">' +
                                '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editGuru" value="' +
                                data.idKelas + '">' +
                                '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusGuru" title="Delete" value="' +
                                data.idKelas + '" data-nama-guru="' + data.guru.namaPegawai + '">' +
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
                    "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                lengthMenu: [10, 25],
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
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        render: function(data, type, row) {
                            var statusClass = row.status === 'Aktif' ?
                                'bg-success-light text-success' : 'bg-danger-light text-danger';

                            return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${statusClass}">
                    ${row.status}
                </span>`;
                        }
                    }, {
                        data: null,
                        className: 'text-center',
                        searchable: false,
                        render: function(data, type, row) {
                            return '<div class="btn-group">' +
                                '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editSiswa" value="' +
                                row.idtrKelas + '">' +
                                '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusSiswa" title="Delete" value="' +
                                data.idtrKelas + '" data-nama-siswa="' + data.namaSiswa + '">' +
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
                    "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                lengthMenu: [10, 25],
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

            $(document).on('click', '#btn-tambahKelasGuru', function(e) {
                e.preventDefault();
                $("#modal-bagiKelasGuru").modal('show');
                $("#title-modal").text('Tambah Guru Kelas');
                $("#cn-btn").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-tbhGuru">Simpan</button>`);
                $('.pilih-periode').val('');
                $('.pilih-guru').val('');
                $('.pilih-kelas').val('');

            });

            $(document).on('click', '#btn-tbhGuru', function(e) {
                e.preventDefault();
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
                    type: "POST",
                    url: "{{ route('data-kelas.store') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        $(".btn-block-option").click();

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#tabel-PeriodeGuru').DataTable().ajax.reload();
                        loadDropdownOptions();
                        $('.pilih-periode').val('');
                        $('.pilih-guru').val('');
                        $('.pilih-kelas').val('');

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
                        $('.pilih-guru').val(response.kelas.idPegawai);
                        $('.pilih-kelas').val(response.kelas.namaKelas);
                        $('.id-kelas').val(response.kelas.idKelas);
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
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                                $('#tabel-PeriodeGuru').DataTable().ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Data kelas gagal dihapus. Kelas memiliki siswa.',
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
                $('.pilih-siswa').val('');
                $('.pilih-kelas').val('');

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
                    dataType: "json",
                    success: function(response) {
                        $(".btn-block-option").click();

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#tabel-PeriodeSiswa').DataTable().ajax.reload();
                        loadDropdownOptions();
                        $('.pilih-kelas-siswa').val('');
                        $('.pilih-siswa').val('');

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

                $.ajax({
                    type: "GET",
                    url: "{{ url('data-kelas/edit/siswa') }}/" + id,
                    success: function(response) {
                        $('.pilih-siswa').val(response.tr_kelas.idSiswa);
                        $('.pilih-kelas-siswa').val(response.tr_kelas.idKelas);
                        $('.id-tr-kelas').val(response.tr_kelas.idtrKelas);
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
                    'idSiswa': $('.pilih-siswa').val(),
                    'idKelas': $('.pilih-kelas-siswa').val(),
                }
                console.log(id);
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
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                                $('#tabel-PeriodeSiswa').DataTable().ajax.reload();
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
