@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title --}}
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
                    <button class="btn btn-sm btn-alt-success" id="tambah-pengajar"><i class="fa fa-plus mx-2"></i>Tambah
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header border-bottom border-2 border-alt-secondary block-header-default">
                <h3 class="block-title">Data Pengajar</h3>
            </div>
            <div class="row p-0 m-0">
                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active data-kelas-tab" id="data-kelas-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas1" data-nama-kelas="1" role="tab" aria-controls="data-kelas1"
                            aria-selected="true">Kelas
                            1</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link data-kelas-tab" id="data-siswa-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas1" role="tab" aria-controls="data-siswa" data-nama-kelas="2"
                            aria-selected="false">Kelas
                            2</button>
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
                    <div class="tab-pane fade show active" id="data-kelas1" role="tabpanel"
                        aria-labelledby="data-kelas1-tab" tabindex="0">
                        <table id="tabelPengajar" style="width: 100%"
                            class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th>Nama Pengajar</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Semester</th>
                                    <th class="text-center" style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Content --}}
                            </tbody>
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

        {{-- MODAL INSERT --}}
        <div class="modal fade" id="modal-Pengajar" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
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
                            <form action="POST" enctype="multipart/form-data" id="form-pengajaran">
                                <input type="text" name="idMapel" id="idMapel" class="id-pengajar" hidden>
                                <div class="mb-4">
                                    <label class="form-label" for="idPeriode">Periode</label>
                                    <select name="idPeriode" id="idPeriode" class="form-select periode-id">
                                        <option value="" disabled selected>-- Pilih Periode --</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="idKelas">Kelas</label>
                                    <select name="idKelas" id="idKelas" class="form-select kelas-id">
                                        <option value="" disabled selected>-- Pilih Kelas --</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="idPengajaran">Nama Pengajar</label>
                                    <select name="idPengajaran" id="idPengajaran" class="form-select guru-id">
                                        <option value="" disabled selected>-- Pilih Pengajar --</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="idMapel">Mapel</label>
                                    <select name="idMapel" id="idMapel" class="form-select mapel-id">
                                        <option value="" disabled selected>-- Pilih Mapel --</option>
                                    </select>
                                </div>
                                {{-- <div class="mb-4">
                                    <label class="form-label" for="idPeriode">Semester</label>
                                    <select name="idPeriode" id="idPeriode" class="form-select periode-id">
                                        <option value="" disabled selected>-- Pilih Periode --</option>
                                    </select>
                                </div> --}}
                                <div class="mb-4 text-end" id="cn-btn">
                                    {{-- conten button --}}
                                </div>
                            </form>
                        </div>
                        <div class="block-content block-content-full bg-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function loadOptionPengajaran() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'GET',
                    url: "{{ url('pengajar/get-form') }}",
                    success: function(data) {
                        // PERIODE
                        $('.periode-id').empty();
                        $('.periode-id').append(
                            '<option value="" disabled selected>-- Pilih Periode --</option>');

                        $.each(data.periode, function(key, value) {
                            $('.periode-id').append('<option value="' + value.idPeriode +
                                '">Semester ' + value.formattedTanggalMulai + '</option>');
                        });
                        $('.periode-id').on('change', function() {
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
                                    $('#idKelas').empty();
                                    $('#idKelas').append(
                                        '<option value="" disabled selected>-- Pilih Kelas --</option>'
                                    );

                                    $.each(classesData.kelas, function(key, value) {
                                        $('#idKelas').append('<option value="' + value
                                            .idKelas +
                                            '">Kelas ' + value.namaKelas + ' ' +
                                            value.guru.namaPegawai +
                                            '</option>');
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.error(xhr.responseText);
                                }
                            });
                        });
                        // console.log(data);
                        // $('#idKelas').empty();
                        // $('#idKelas').append(
                        //     '<option value="" disabled selected>-- Pilih Kelas --</option>');

                        // $.each(data.kelas, function(key, value) {
                        //     // console.log(value.idKelas);
                        //     $('#idKelas').append('<option value="' + value.Kelas +
                        //         '">Kelas ' + value.namaKelas + '</option>');
                        // });

                        $('.guru-id').empty();
                        $('.guru-id').append(
                            '<option value="" disabled selected>-- Pilih Pengajar --</option>');

                        $.each(data.pegawai, function(key, value) {
                            // console.log(value.idKelas);
                            $('.guru-id').append('<option value="' + value.idPegawai +
                                '">' + value.namaPegawai + '</option>');
                        });

                        // MAPEL
                        $('.mapel-id').empty();
                        $('.mapel-id').append(
                            '<option value="" disabled selected>-- Pilih Mapel --</option>');

                        $.each(data.mapel, function(key, value) {
                            $('.mapel-id').append('<option value="' + value.idMapel +
                                '">' + value.namaMapel + '</option>');
                        });


                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            function clearForm() {
                $('.guru-id').val('');
                $('.mapel-id').val('');
                $('.periode-id').val('');
            }

            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                loadOptionPengajaran();

                $(document).on('click', '.data-kelas-tab', function(e) {
                    e.preventDefault();
                    $('#tabelPengajar').DataTable().ajax.reload();
                });
                // FUNGSI PERIODE
                $('#periode').change(function() {
                    $('#tabelPengajar').DataTable().ajax.reload();
                });
                $('#tabelPengajar').DataTable({
                    processing: true,
                    serverSide: true,
                    // ajax: "{{ url('pengajar/get-data') }}",
                    ajax: {
                        url: "{{ url('pengajar/get-data') }}",
                        type: "GET",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        data: function(d) {
                            d.periode_id = $('#periode').val();
                            d.nama_kls = $(".data-kelas-tab.active").data('nama-kelas');
                            console.log(d.nama_kls);
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
                            data: 'guru.namaPegawai',
                            name: 'guru.namaPegawai',
                        },
                        {
                            data: 'mapel.namaMapel',
                            name: 'mapel.namaMapel'
                        },
                        {
                            data: 'periode.semester',
                            name: 'periode.formattedTanggalMulai',
                        }, {
                            data: null,
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editPengajar" value="' +
                                    data.idPengajaran + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger"  id="action-hapusPengajar" title="Delete" value="' +
                                    data.idPengajaran + '" data-nama-pengajar="' + data.guru
                                    .namaPegawai + '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    // order: [
                    //     [1, 'asc']
                    // ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25],
                });

                $(document).on('click', '#tambah-pengajar', function(e) {
                    e.preventDefault();
                    $("#modal-Pengajar").modal('show');
                    $("#title-modal").text('Tambah Pengajar');
                    $("#cn-btn").html(
                        `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-tbhPengajar">Simpan</button>`
                    );
                    clearForm();

                });

                $(document).on('click', '#btn-tbhPengajar', function(e) {
                    e.preventDefault();
                    var data = {
                        'idPegawai': $('.guru-id').val(),
                        'idMapel': $('.mapel-id').val(),
                        'idPeriode': $('.periode-id').val(),
                        'idKelas': $('.kelas-id').val(),
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('pengajaran.store') }}",
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
                            $('#tabelPengajar').DataTable().ajax.reload();
                            loadOptionPengajaran();
                            $('.guru-id').val('');
                            $('.mapel-id').val('');
                            $('.periode-id').val('');
                            $('.kelas-id').val('');
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

                $(document).on('click', '#action-editPengajar', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    $("#modal-Pengajar").modal('show');
                    $("#title-modal").text('Edut Pengajar');
                    $("#cn-btn").html(
                        `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-edtPengajar">Simpan</button>`
                    );

                    $.ajax({
                        type: "GET",
                        url: "{{ url('pengajar/edit') }}/" + id,
                        success: function(response) {
                            // console.log(response);
                            $('.guru-id').val(response.pengajar.idPegawai);
                            $('.mapel-id').val(response.pengajar.idMapel);
                            $('.periode-id').val(response.pengajar.idPeriode);
                            $('.id-pengajar').val(response.pengajar.idPengajaran);
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

                $(document).on('click', '#btn-edtPengajar', function(e) {
                    e.preventDefault();
                    var id = $('.id-pengajar').val();
                    var data = {
                        'idPegawai': $('.guru-id').val(),
                        'idMapel': $('.mapel-id').val(),
                        'idPeriode': $('.periode-id').val(),
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "PUT",
                        url: "{{ url('pengajar/update') }}/" + id,
                        data: data,
                        dataType: "json",
                        success: function(response) {
                            $(".btn-block-option").click();
                            clearForm();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            $('#tabelPengajar').DataTable().ajax.reload();

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

                $(document).on('click', '#action-hapusPengajar', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-pengajar');

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
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            });
                            $.ajax({
                                type: "DELETE",
                                url: "/pengajar/destroy/" + id,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });
                                    $('#tabelPengajar').DataTable().ajax.reload();
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
            });
        </script>
    @endpush
@endsection
