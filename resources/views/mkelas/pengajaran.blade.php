@extends('siakad.layouts.app')
@section('siakad')
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
                        <button class="nav-link active data-kelas-tab" id="data-kelas-1-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" data-nama-kelas="1" role="tab" aria-controls="data-kelas"
                            aria-selected="true">Kelas
                            1</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link data-kelas-tab" id="data-kelas-2-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" data-nama-kelas="2"
                            aria-selected="false">Kelas
                            2</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link  data-kelas-tab" id="data-kelas-3-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" data-nama-kelas="3" role="tab" aria-controls="data-kelas"
                            aria-selected="true">Kelas
                            3</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link data-kelas-tab" id="data-kelas-4-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" data-nama-kelas="4"
                            aria-selected="false">Kelas
                            4</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link  data-kelas-tab" id="data-kelas-5-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" data-nama-kelas="5" role="tab" aria-controls="data-kelas"
                            aria-selected="true">Kelas
                            5</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link data-kelas-tab" id="data-kelas-6-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" data-nama-kelas="6"
                            aria-selected="false">Kelas
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
                                    <select name="idPengajaran" id="idPegawai" class="form-select guru-id">
                                        <option value="" disabled selected>-- Pilih Pengajar --</option>
                                    </select>
                                </div>
                                <div class="mb-4" id="multi-mapel">
                                    <label class="form-label" for="idMapel">Mapel</label>
                                    <select name="idMapel" id="idMapel_select" multiple="multiple"
                                        class="form-select mapel-id">
                                        <option value="" disabled selected>-- Pilih Mapel --</option>
                                    </select>
                                </div>
                                <div class="mb-4 mapel-two">
                                    <label class="form-label" for="idMapel">Mapel</label>
                                    <select name="idMapel" id="idMapel_select_two" class="form-select mapel-id">
                                        <option value="" disabled selected>-- Pilih Mapel --</option>
                                    </select>
                                </div>
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
                    $('#idKelas').val('');
                }

                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    loadOptionPengajaran();

                    function pengajaranSelec2(selector, placeholder, dropdownParent) {
                        $(selector).select2({
                            placeholder,
                            allowClear: true,
                            width: "100%",
                            cache: false,
                            dropdownParent,
                            theme: "bootstrap",
                        });
                    }

                    pengajaranSelec2('#idPegawai', "Pilih Pengajar", $('#modal-Pengajar'));
                    pengajaranSelec2('#idMapel_select', '', $('#modal-Pengajar'));
                    pengajaranSelec2('#idMapel_select_two', 'Pilih Mapel', $('#modal-Pengajar'));


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
                                // console.log(d.nama_kls);
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
                        $('.mapel-two').prop('hidden', true);
                        $('#multi-mapel').prop('hidden', false);
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
                            url: "{{ url('pengajar/store') }}",
                            data: data,
                            dataType: "json",
                            success: function(response) {
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

                        $('.guru-id').val(null).trigger('change');
                        $('#idMapel_select_two').val(null).trigger('change');
                        $('.periode-id').val('');
                        $('.kelas-id').val('')
                        $('#idKelas').val('');

                        $('.mapel-two').prop('hidden', false);
                        $('#multi-mapel').prop('hidden', true);

                        $.ajax({
                            type: "GET",
                            url: "{{ url('pengajar/edit') }}/" + id,
                            success: function(response) {
                                // console.log(response);
                                $('.guru-id').val(response.pengajar.idPegawai);
                                $('.periode-id').val(response.pengajar.idPeriode).trigger('change');
                                $('.id-pengajar').val(response.pengajar.idPengajaran);

                                var selectPengajar = $(".guru-id");
                                var optionPengajar = selectPengajar.find("option[value='" + response
                                    .pengajar.idPegawai + "']");
                                selectPengajar.val(optionPengajar.val()).trigger('change');

                                var selectMapel = $("#idMapel_select_two");
                                var optionMapel = selectMapel.find("option[value='" + response.pengajar
                                    .idMapel + "']");
                                selectMapel.val(optionMapel.val()).trigger('change');


                                $.ajax({
                                    type: 'GET',
                                    url: "{{ url('pengajar/get-form') }}", // Sesuaikan dengan URL yang benar
                                    data: {
                                        periode_id: response.pengajar.idPeriode
                                    },
                                    success: function(classesData) {
                                        // Setelah data kelas berhasil dimuat, baru atur nilai pada elemen select kelas
                                        $('.kelas-id').val(response.pengajar
                                            .idKelas).trigger('change');

                                        console.log(response.pengajar.idKelas);
                                        // $('.id-tr-kelas').val(response.tr_kelas.idtrKelas);
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

                    $(document).on('click', '#btn-edtPengajar', function(e) {
                        e.preventDefault();
                        var idPengajaran = $('.id-pengajar').val();
                        var data = {
                            'idPegawai': $('.guru-id').val(),
                            'idMapel': $('#idMapel_select_two').val(),
                            'idPeriode': $('.periode-id').val(),
                            'idKelas': $('.kelas-id').val(),
                        };
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "PUT",
                            url: "{{ url('pengajar/update') }}/" + idPengajaran,
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
