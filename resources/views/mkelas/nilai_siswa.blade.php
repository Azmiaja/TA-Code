@extends('siakad.layouts.app')
@section('siakad')
    <div class="bg-body-light">
        <div class="content content-full">
            {{-- Page title pegawai --}}
            <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        @can('guru')
                            <a class="link-fx" href="{{ route('penilaian.guru') }}">{{ $sub_judul }}</a>
                        @endcan
                        @cannot('guru')
                            <a class="link-fx" href="{{ route('penilaian.index') }}">{{ $sub_judul }}</a>
                        @endcannot
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        @foreach ($mapel as $item)
                            {{ $item->mapel->namaMapel }} <input type="hidden" id="pengajaran_id"
                                value="{{ $item->idPengajaran }}">
                        @endforeach
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title" id="kelas_id"
                    data-id-kelas=@foreach ($kelas as $item)
                {{ $item->idKelas }} @endforeach>Penilaian
                    Siswa Kelas {{ $kelas_id }}</h3>
                <div class="row pt-1 m-0 float-end">
                    <div class="col p-0 align-self-center">
                        {{-- ATUR PERIODE --}}
                        <span class="form-control form-control-sm">
                            @foreach ($periode as $item)
                                {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                                <input type="hidden" id="periode" value="{{ $item->idPeriode }}">
                            @endforeach
                        </span>
                    </div>
                    <label class="col-auto col-form-label" for="semester">Periode</label>
                </div>
            </div>
            <div class="block-content block-content-full">
                {{-- <div class="row row-cols-lg-auto float-end">
                    <div class="col-12">
                        <button class="btn btn-alt-primary btn-sm" id="editNilai">Edit</button>
                        <button class="btn btn-alt-success btn-sm" id="simpanNilai">Simpan</button>
                    </div>
                </div> --}}
                <table id="tabel-nilai-siswa" style="width: 100%" class="table display table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Nama Siswa</th>
                            <th>Nilai UH</th>
                            <th>Nilai UTS</th>
                            <th>Nilai UAS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal --}}
        <div class="modal fade" id="modal-Nilai" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
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
                            <form action="POST" enctype="multipart/form-data" id="form_nilai">
                                <input type="text" name="idNilai" id="idNilai" hidden>
                                <input type="text" name="idSiswa" id="idSiswa" hidden>
                                <input type="text" name="idPeriode" id="idPeriode" hidden value="{{ $periode_id }}">
                                <input type="text" name="idPengajaran" id="idPengajaran" hidden
                                    value="{{ $pengajaran_id }}">
                                <input type="text" name="idKelas" id="idKelas" hidden value="{{ $kelas_id }}">
                                <div class="mb-4">
                                    <label class="form-label" for="namaSiswa">Nama Siswa</label>
                                    <input type="text" disabled class="form-control  nama-mapel" id="namaSiswa"
                                        name="namaSiswa">
                                </div>
                                <div class="mb-4">
                                    <div class="row g-4">
                                        <div class="col-4">
                                            <label class="form-label" for="nilaiUH">Nilai UH</label>
                                            <input type="text" id="nilaiUH" class="form-control"
                                                placeholder="Nilai UH">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label" for="nilaiUTS">Nilai UTS</label>
                                            <input type="text" id="nilaiUTS" class="form-control"
                                                placeholder="Nilai UTS">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label" for="nilaiUAS">Nilai UAS</label>
                                            <input type="text" id="nilaiUAS" class="form-control"
                                                placeholder="Nilai UAS">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4 text-end" id="btn-form">
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
            $(document).ready(function() {
                setTimeout(function() {
                    $('#alert-close').click();
                }, 180000);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(document).on('click', '#editNilai', function(e) {
                    e.preventDefault();
                    $('#modal-Nilai').modal('show');
                    $('#title-modal').text('Niali Siswa');
                    $("#btn-form").html(
                        `<button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-tambahNilai">Simpan</button>`
                    );
                    var id = $(this).val();
                    var idPengajaran = $("#idPengajaran").val();
                    var idPeriode = $("#periode").val();

                    console.log(idPengajaran);
                    console.log(idPeriode);

                    $.ajax({
                        type: "GET",
                        url: "{{ url('nilai_siswa/edit') }}/" + id + '/' + idPengajaran + '/' +
                            idPeriode,
                        success: function(response) {
                            console.log(response);

                            // Accessing data from the response
                            $('#namaSiswa').val(response.data.namaSiswa);
                            $('#idSiswa').val(response.data.idSiswa);

                            // Check if 'nilai' exists and is not empty
                            if (response.data.nilai && response.data.nilai.length > 0) {
                                // Accessing idNilai from the first element of the 'nilai' array
                                var idNilai = response.data.nilai[0].idNilai;
                                var nilaiUH = response.data.nilai[0].nilaiUH;
                                var nilaiUTS = response.data.nilai[0].nilaiUTS;
                                var nilaiUAS = response.data.nilai[0].nilaiUAS;
                                $('#idNilai').val(idNilai);
                                $('#nilaiUH').val(nilaiUH);
                                $('#nilaiUTS').val(nilaiUTS);
                                $('#nilaiUAS').val(nilaiUAS);
                            } else {
                                // Handle the case where 'nilai' is empty or undefined
                                $('#idNilai').val(null);
                                $('#nilaiUH').val(null);
                                $('#nilaiUTS').val(null);
                                $('#nilaiUAS').val(null);
                            }
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

                $(document).on('click', '#btn-tambahNilai', function(e) {
                    e.preventDefault();

                    var data = {
                        'idSiswa': $('#idSiswa').val(),
                        'idPeriode': $('#idPeriode').val(),
                        'idPengajaran': $('#idPengajaran').val(),
                        'nilaiUH': $('#nilaiUH').val(),
                        'nilaiUTS': $('#nilaiUTS').val(),
                        'nilaiUAS': $('#nilaiUAS').val(),
                        'idNilai': $('#idNilai').val(),
                    };

                    console.log(data);

                    $.ajax({
                        type: "POST",
                        url: "{{ url('nilai_siswa/up') }}",
                        data: data,
                        // contentType: false,
                        // processData: false,
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            $('#modal-Nilai').modal('hide');
                            $('#tabel-nilai-siswa').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });

                var table = $('#tabel-nilai-siswa').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{!! route('nilai.get-data') !!}',
                        type: "GET",
                        data: function(d) {
                            d.periode_id = $('#periode').val();
                            d.kelas_id = $("#kelas_id").data('id-kelas');
                            d.pengajaran_id = $('#pengajaran_id').val();

                            // console.log(d.periode_id);
                            // console.log(d.kelas_id);
                            // console.log(d.pengajaran_id);
                        }
                    },
                    order: [
                        [1, 'asc']
                    ],
                    columns: [{
                            data: null,
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row +
                                    1;
                            }
                        },
                        {
                            data: 'namaSiswa',
                            name: 'namaSiswa',
                            className: 'namaSiswa',
                            render: function(data, type, row) {
                                return data + '<input type="hidden" id="id-siswa" value="' + row
                                    .idSiswa + '">';
                            }
                        },

                        {
                            data: 'nilaiUH',
                            name: 'nilaiUH',
                            className: 'editable'
                        },
                        {
                            data: 'nilaiUTS',
                            name: 'nilaiUTS',
                            className: 'editable'
                        },
                        {
                            data: 'nilaiUAS',
                            name: 'nilaiUAS',
                            className: 'editable'
                        }, {
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return '<button class="btn btn-alt-primary btn-sm" value="' + data
                                    .idSiswa +
                                    '" id="editNilai"><i class="fa fa-solid fa-pencil-alt"></i></button>';
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'<'row float-end' <'col' f><'col text-end'B>>>>" +
                    "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                    "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25, 50],
                    buttons: [{
                        extend: 'print',
                        title: '<h2>Data Nilai Siswa</h2>',
                        className: 'btn-sm btn btn-alt-primary',
                        filename: 'Data Nilai Siswa',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                        },
                        messageTop: null,
                        messageBottom: null,
                        customize: function(win) {
                            $(win.document.body).css('text-align', 'center');
                        },

                    },
                    {
                        extend: 'excel',
                        title: 'Data Nilai Siswa',
                        className: 'btn-sm btn btn-alt-success',
                        sheetName: 'Data Nilai Siswa',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                        },
                        action: function(e, dt, button, config) {
                            var confirmation = window.confirm(
                                'Apakah Anda yakin ingin mengekspor data ke Excel?');

                            if (confirmation) {
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt,
                                    button, config);
                            }
                        },
                    }
                ],
                });


                $(document).on('click', '#btn-nilai', function() {
                    var idSiswa = $(this).data('row-id');
                    console.log(idSiswa);
                });
            });
        </script>
    @endpush
@endsection
