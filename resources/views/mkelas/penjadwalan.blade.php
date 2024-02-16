@extends('siakad.layouts.app')
@section('siakad')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title --}}
                    <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            @canany(['super.admin', 'admin'])
                                <li class="breadcrumb-item">
                                    <a class="link-fx" href="javascript:void(0)">{{ $judul }}</a>
                                </li>
                            @endcanany
                            @canany(['siswa', 'guru'])
                                <li class="breadcrumb-item">
                                    <a class="link-fx" href="javascript:void(0)">{{ $judul3 }}</a>
                                </li>
                            @endcanany
                            <li class="breadcrumb-item" aria-current="page">
                                {{ $sub_judul }}
                            </li>
                        </ol>
                    </nav>
                </div>
                @canany(['super.admin', 'admin'])
                    <div class="col-6 text-end">
                        <button class="btn btn-sm btn-alt-success" id="tambah-jadwal"><i class="fa fa-plus mx-2"></i>Tambah
                            Data</button>
                    </div>
                @endcanany
            </div>
        </div>
    </div>

    <div class="content">
        @canany(['super.admin', 'admin'])
            <div class="block block-rounded">
                <div class="block-header border-bottom border-2 border-alt-secondary block-header-default">
                    <h3 class="block-title">Jadwal Pelajaran</h3>
                </div>
                <div class="row p-0 m-0">
                    <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active data-kelas-tab" id="data-kelas-1-tab" data-bs-toggle="tab"
                                data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" aria-selected="true"
                                data-nama-kelas="1">Kelas
                                1</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link data-kelas-tab" id="data-kelas-2-tab" data-bs-toggle="tab"
                                data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" aria-selected="false"
                                data-nama-kelas="2">Kelas
                                2</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link  data-kelas-tab" id="data-kelas-3-tab" data-bs-toggle="tab"
                                data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" aria-selected="true"
                                data-nama-kelas="3">Kelas
                                3</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link data-kelas-tab" id="data-kelas-4-tab" data-bs-toggle="tab"
                                data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" aria-selected="false"
                                data-nama-kelas="4">Kelas
                                4</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link  data-kelas-tab" id="data-kelas-5-tab" data-bs-toggle="tab"
                                data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" aria-selected="true"
                                data-nama-kelas="5">Kelas
                                5</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link data-kelas-tab" id="data-kelas-6-tab" data-bs-toggle="tab"
                                data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" aria-selected="false"
                                data-nama-kelas="6">Kelas
                                6</button>
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
                        <div class="tab-pane fade show active" id="data-kelas" role="tabpanel" aria-labelledby="data-kelas-tab"
                            tabindex="0">
                            <table id="tabel-JPkelas" style="width: 100%;"
                                class="table tabel-responsive table-bordered table-striped table-vcenter js-dataTable-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th style="width: 15%;">Hari</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Nama Pengajar</th>
                                        <th>Lama Waktu</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th class="text-center" style="width: 10%;">Aksi</th>
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
        @endcanany

        @canany(['guru', 'siswa'])
            <div class="block block-rounded">
                <div class="block-header border-bottom border-2 border-alt-secondary block-header-default">
                    <h3 class="block-title">Jadwal Pelajaran</h3>
                    <div class="block-options">
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
                    </div>
                </div>
                <div class="block-content py-3">
                    @can('siswa')
                        <input type="hidden" id="kelas_name"
                            value="{{ ucwords(Auth::user()->tr_kelas->first()->kelas->namaKelas) }}">
                    @endcan
                    <table id="tabel-JPSiswa" style="width: 100%;"
                        class="table tabel-responsive table-bordered table-striped table-vcenter js-dataTable-responsive">
                        <thead class="bg-gray">
                            <tr>
                                <th>Waktu</th>
                                <th>Senin</th>
                                <th>Selasa</th>
                                <th>Rabu</th>
                                <th>Kamis</th>
                                <th>Jumat</th>
                                <th>Sabtu</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- conten --}}
                        </tbody>
                    </table>
                </div>
            </div>
        @endcanany
    </div>

    {{-- MODAL INSERT --}}
    <div class="modal fade" id="modal-Jadwal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalMapeltLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="title-modal">Tambah Data</h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <input type="hidden" name="idJadwal" id="idJadwal">
                        <div class="mb-4">
                            <label class="form-label" for="idPeriode">Semester</label>
                            <select name="idPeriode" id="idPeriode" class="form-select pilih-periode">
                                <option value="" disabled selected>-- Pilih Periode --</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="idKelas">Kelas</label>
                            <select name="idKelas" id="idKelas" class="form-select pilih-kelas">
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="idPengajaran">Mapel</label>
                            <select name="idPengajaran" id="idPengajaran" class="form-select pilih-mapel">
                                <option value="" disabled selected>-- Pilih Mapel --</option>
                            </select>
                        </div>
                        {{-- isian form --}}
                        <div class="mb-4">
                            <label class="form-label" for="hari">Hari</label>
                            <select name="hari" id="hari" class="form-select pilih-hari">
                                <option value="" disabled selected>-- Pilih Hari --</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="jamMulai">Jam Mulai</label>
                            <input type="time" class="form-control jam-mulai" id="jamMulai" name="jamMulai">
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="jamSelesai">Jam Selesai</label>
                            <input type="time" class="form-control jam-selesai" id="jamSelesai" name="jamSelesai">
                        </div>
                        <div class="mb-4 text-end" id="cn-btn">
                            {{-- conten button --}}
                        </div>
                    </div>
                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @cannot('guru')
            <script>
                // form selection opsi
                function loadDropdownOptionsJadwal() {
                    // Periode
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('penjadwalan/get-form') }}",
                        success: function(data) {
                            $('.pilih-periode').empty();
                            $('.pilih-periode').append(
                                '<option value="" disabled selected>-- Pilih Periode --</option>');

                            $.each(data.periode, function(key, value) {
                                // console.log(value);
                                $('.pilih-periode').append('<option value="' + value.idPeriode + '">Semester ' +
                                    value.formattedTanggalMulai + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });

                    // Kelas berdasarkan periode
                    $('.pilih-periode').on('change', function() {
                        var selectedPeriodeId = $(this).val();

                        // Fetch classes based on the selected period
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('penjadwalan/get-form') }}", // You need to define a route for this
                            data: {
                                periode_id: selectedPeriodeId
                            },
                            success: function(classesData) {
                                // console.log(classesData);
                                // Populate the classes dropdown based on the fetched data
                                $('#idKelas').empty();
                                $('#idKelas').append(
                                    '<option value="" disabled selected>-- Pilih Kelas --</option>'
                                );

                                $.each(classesData.kelas, function(key, value) {
                                    $('#idKelas').append('<option value="' + value
                                        .idKelas +
                                        '">Kelas ' + value.namaKelas +
                                        '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    });

                    // mapel berdaarkan kelas 
                    $('#idKelas').on('change', function() {
                        var selectedKelasId = $(this).val();

                        $.ajax({
                            type: 'GET',
                            url: "{{ url('penjadwalan/get-form') }}", // You need to define a route for this
                            data: {
                                kelas_id: selectedKelasId
                            },
                            success: function(classesData) {
                                // console.log(classesData);
                                // Populate the classes dropdown based on the fetched data
                                $('#idPengajaran').empty();
                                $('#idPengajaran').append(
                                    '<option value="" disabled selected>-- Pilih Mapel --</option>'
                                );

                                $.each(classesData.pengajaran, function(key, value) {
                                    // console.log(value);
                                    $('#idPengajaran').append(
                                        '<option value="' +
                                        value.idPengajaran +
                                        '">' +
                                        value.mapel.namaMapel +
                                        '</option>'
                                    );
                                });
                            }
                        });
                    });
                }

                // clear form
                function clearFormJadawl() {
                    $('#idPeriode').val('');
                    $('#idKelas').val('');
                    $('#idPengajaran').val('');
                    $('#hari').val('');
                    $('#jamMulai').val('');
                    $('#jamSelesai').val('');
                }
                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#btn-close').click(function() {
                        clearFormJadawl();
                    });
                    loadDropdownOptionsJadwal();

                    $('#periode').change(function() {
                        $('#tabel-JPkelas').DataTable().ajax.reload();
                        $('#tabel-JPSiswa').DataTable().ajax.reload();
                    });

                    $(document).on('click', '.data-kelas-tab', function(e) {
                        e.preventDefault();
                        $('#tabel-JPkelas').DataTable().ajax.reload();
                    });

                    $('#tabel-JPkelas').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ url('penjadwalan/get-data') }}",
                            data: function(d) {
                                d.periode_id = $('#periode').val();
                                d.kelas_id = $(".data-kelas-tab.active").data('nama-kelas');
                                // console.log(d.kelas_id);
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
                                data: 'hari',
                                name: 'hari',
                            },
                            {
                                data: 'pengajaran.mapel.namaMapel',
                                name: 'pengajaran.mapel.namaMapel'
                            },
                            {
                                data: 'pengajaran.guru.namaPegawai',
                                name: 'pengajaran.guru.namaPegawai',
                            },
                            {
                                data: "durasi_total_in_minutes",
                                render: function(data, type, row) {
                                    return Math.round(data) + ' Menit';
                                }
                            },
                            {
                                data: 'jamMulai',
                                name: 'jamMulai',
                            },
                            {
                                data: 'jamSelesai',
                                name: 'jamSelesai',
                            },
                            {
                                data: null,
                                className: 'text-center',
                                searchable: false,
                                render: function(data, type, row) {
                                    return '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editJadwal" value="' +
                                        data.idJadwal + '">' +
                                        '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                        '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusJadwal" title="Delete" value="' +
                                        data.idJadwal + '" data-nama-jadwal=" Hari ' + data.hari +
                                        ' Mapel ' + data
                                        .namaMapel +
                                        '">' +
                                        '<i class="fa fa-fw fa-times"></i></button>' +
                                        '</div>';
                                }
                            }
                        ],
                        order: [
                            [1, 'desc']
                        ],
                        dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                            "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                            "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        lengthMenu: [10, 25],
                    });

                    $(document).on('click', '#tambah-jadwal', function(e) {
                        e.preventDefault();
                        $("#modal-Jadwal").modal('show');
                        $("#title-modal").text('Tambah Jadawal');
                        $("#cn-btn").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="btn-tbhJadwal">Simpan</button>`);

                    });

                    $(document).on('click', '#action-editJadwal', function(e) {
                        e.preventDefault();
                        $("#modal-Jadwal").modal('show');
                        $("#title-modal").text('Edit Jadawal');
                        $("#cn-btn").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="btn-edtJadwal">Simpan</button>`);

                        var id = $(this).val();
                        $.ajax({
                            type: "GET",
                            url: "{{ url('penjadwalan/edit') }}/" + id,
                            success: function(response) {
                                $('#idPeriode').val(response.jadwal.pengajaran.periode.idPeriode);
                                loadKelasDropdown(response.jadwal.pengajaran.periode.idPeriode, response
                                    .jadwal.pengajaran.kelas.idKelas, response.jadwal.pengajaran
                                    .mapel.idMapel);


                                // $('#idPengajaran').val(response.jadwal.pengajaran.mapel.idMapel);
                                $('#hari').val(response.jadwal.hari);
                                $('#jamMulai').val(response.jadwal.jamMulai);
                                $('#jamSelesai').val(response.jadwal.jamSelesai);
                                $('#idJadwal').val(response.jadwal.idJadwal);

                                // loadDropdownOptionsJadwal();
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

                    function loadKelasDropdown(periodeId, selectedKelasId, selectedPengajarId) {
                        // Fetch classes based on the selected period
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('penjadwalan/get-form') }}",
                            data: {
                                periode_id: periodeId
                            },
                            success: function(classesData) {
                                // Populate the classes dropdown based on the fetched data
                                $('#idKelas').empty();
                                $('#idKelas').append(
                                    '<option value="" disabled selected>-- Pilih Kelas --</option>'
                                );

                                $.each(classesData.kelas, function(key, value) {
                                    var selected = (value.idKelas == selectedKelasId) ? 'selected' : '';
                                    $('#idKelas').append('<option value="' + value.idKelas + '" ' +
                                        selected +
                                        '>Kelas ' + value.namaKelas +
                                        '</option>');
                                });

                                // Setelah memuat opsi kelas, panggil fungsi untuk memuat opsi pengajaran
                                loadPengajaranDropdown(selectedKelasId, selectedPengajarId);
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }

                    // Fungsi untuk memuat opsi dropdown Pengajaran
                    function loadPengajaranDropdown(selectedKelasId, selectedPengajarId) {
                        // Fetch teaching based on the selected class
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('penjadwalan/get-form') }}",
                            data: {
                                kelas_id: selectedKelasId
                            },
                            success: function(classesData) {
                                // Populate the teaching dropdown based on the fetched data
                                $('#idPengajaran').empty();
                                $('#idPengajaran').append(
                                    '<option value="" disabled>-- Pilih Mapel --</option>'
                                );

                                $.each(classesData.pengajaran, function(key, value) {
                                    var selected = (value.mapel.idMapel == selectedPengajarId) ?
                                        'selected' : '';
                                    $('#idPengajaran').append('<option value="' + value.idPengajaran +
                                        '" ' +
                                        selected +
                                        '>' + value.mapel.namaMapel +
                                        '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }

                    $(document).on('click', '#btn-tbhJadwal', function(e) {
                        e.preventDefault();
                        var data = {
                            'idPengajaran': $('#idPengajaran').val(),
                            'hari': $('#hari').val(),
                            'jamMulai': $('#jamMulai').val(),
                            'jamSelesai': $('#jamSelesai').val(),
                        }
                        $.ajax({
                            type: "POST",
                            url: "{{ url('penjadwalan/store') }}",
                            data: data,
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                });
                                $('#tabel-JPkelas').DataTable().ajax.reload();
                                $('#modal-Jadwal').modal('hide');
                                clearFormJadawl();
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

                    $(document).on('click', '#btn-edtJadwal', function(e) {
                        e.preventDefault();
                        var id = $('#idJadwal').val();
                        var data = {
                            'idPengajaran': $('#idPengajaran').val(),
                            'hari': $('#hari').val(),
                            'jamMulai': $('#jamMulai').val(),
                            'jamSelesai': $('#jamSelesai').val(),
                        }
                        $.ajax({
                            type: "PUT",
                            url: "{{ url('penjadwalan/update') }}/" + id,
                            data: data,
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                });
                                $('#tabel-JPkelas').DataTable().ajax.reload();
                                $('#modal-Jadwal').modal('hide');
                                clearFormJadawl();
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

                    $(document).on('click', '#action-hapusJadwal', function(e) {
                        e.preventDefault();
                        var id = $(this).val();
                        var nama = $(this).data('nama-jadwal');

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
                                $.ajax({
                                    type: "DELETE",
                                    url: "{{ url('penjadwalan/destroy') }}/" + id,
                                    dataType: 'json',
                                    success: function(response) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Dihapus!',
                                            text: response.message,
                                        });
                                        $('#tabel-JPkelas').DataTable().ajax.reload();
                                    },
                                    error: function(xhr, status, error) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Data gagal dihapus.',
                                        });
                                    }
                                });
                            }
                        });
                    });


                    $('#tabel-JPSiswa').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{!! route('get-jadwal.siswa') !!}',
                            data: function(d) {
                                d.idPeriode = $('#periode').val();
                                d.kelas = $("#kelas_name").val();
                                // console.log(d.kelas_id);
                            }
                        },
                        columns: [{
                                data: 'waktu',
                                name: 'waktu'
                            },
                            {
                                data: 'Senin',
                                name: 'Senin'
                            },
                            {
                                data: 'Selasa',
                                name: 'Selasa'
                            },
                            {
                                data: 'Rabu',
                                name: 'Rabu'
                            },
                            {
                                data: 'Kamis',
                                name: 'Kamis'
                            },
                            {
                                data: 'Jumat',
                                name: 'Jumat'
                            },
                            {
                                data: 'Sabtu',
                                name: 'Sabtu'
                            },
                        ],
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'print',
                            title: '<h2>Jadwal Pelajaran</h2>',
                            className: 'btn-alt-primary',
                            filename: 'Jadwal Pelajaran',
                            exportOptions: {
                                columns: ':visible',
                            },
                            messageTop: null,
                            messageBottom: null,
                            customize: function(win) {
                                $(win.document.body).css('text-align', 'center');
                            },
                        }],
                        paging: false,
                        ordering: true,
                        searching: false,
                        info: false,
                        responsive: true
                    });

                    $('.buttons-print span').append('<i class="fa-solid ms-1 fa-print"></i>');

                });
            </script>
        @endcannot
        @can('guru')
            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: '{!! route('get-jadwalP.guru') !!}',
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                        }
                    });

                    $('#periode').change(function() {
                        $('#tabel-JPSiswa').DataTable().ajax.reload();
                    });

                    $('#tabel-JPSiswa').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{!! route('get-jadwalP.guru') !!}',
                            data: function(d) {
                                d.id_periode = $('#periode').val();
                                d.id_nama = '{{ ucwords(Auth::user()->pegawai->idPegawai) }}';
                                // console.log(d.id_nama);
                            }
                        },
                        columns: [{
                                data: 'waktu',
                                name: 'waktu'
                            },
                            {
                                data: 'senin',
                                name: 'senin'
                            },
                            {
                                data: 'selasa',
                                name: 'selasa'
                            },
                            {
                                data: 'rabu',
                                name: 'rabu'
                            },
                            {
                                data: 'kamis',
                                name: 'kamis'
                            },
                            {
                                data: 'jumat',
                                name: 'jumat'
                            },
                            {
                                data: 'sabtu',
                                name: 'sabtu'
                            },
                        ],
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'print',
                            title: '<h2>Jadwal Pelajaran</h2>',
                            className: 'btn-alt-primary',
                            filename: 'Jadwal Pelajaran',
                            exportOptions: {
                                columns: ':visible',
                            },
                            messageTop: null,
                            messageBottom: null,
                            customize: function(win) {
                                $(win.document.body).css('text-align', 'center');
                            },
                        }],
                        paging: false,
                        ordering: true,
                        searching: false,
                        info: false,
                        responsive: true
                    });

                    $('.buttons-print span').append('<i class="fa-solid ms-1 fa-print"></i>');
                });
            </script>
        @endcan
    @endpush
    @push('style')
        <style>
        </style>
    @endpush
@endsection
