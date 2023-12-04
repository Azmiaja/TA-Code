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
                    <button class="btn btn-sm btn-alt-success" id="tambah-jadwal"><i class="fa fa-plus mx-2"></i>Tambah
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header border-bottom border-2 border-alt-secondary block-header-default">
                <h3 class="block-title">Jadwal Pelajaran</h3>
            </div>
            <div class="row p-0 m-0">
                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="data-kelas1-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas1" role="tab" aria-controls="data-kelas1"
                            aria-selected="true">Kelas
                            1</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="data-siswa-tab" data-bs-toggle="tab" data-bs-target="#data-siswa"
                            role="tab" aria-controls="data-siswa" aria-selected="false">Kelas
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
                        <table id="tabel-JPkelas1" style="width: 100%;"
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
                        <input type="text" name="idMapel" id="idMapel" class="id-pengajar" hidden>
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
                                <option value="" disabled selected>-- Pilih MApel --</option>
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
                                <option value="Jum'at">Jum'at</option>
                                <option value="Sabtu">Sabtu-</option>
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
    </div>

    @push('scripts')
        <script>
            function loadDropdownOptionsJadwal() {
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

                        $.each(data.periode, function(key, value) {
                            $('.pilih-periode').append('<option value="' + value.idPeriode + '">' + value
                                .formattedTanggalMulai + '</option>');
                        });

                        
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }

            $(document).ready(function() {
                loadDropdownOptionsJadwal();

                $('#periode').change(function() {
                    $('#tabel-JPkelas1').DataTable().ajax.reload();
                });
                $('#tabel-JPkelas1').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ url('penjadwalan/get-data') }}",
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
                            data: 'hari',
                            name: 'hari',
                        },
                        {
                            data: 'namaMapel',
                            name: 'namaMapel'
                        },
                        {
                            data: 'namaPegawai',
                            name: 'namaPegawai',
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
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editPengajar" value="' +
                                    data.idPengajaran + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger"  id="action-hapusPengajar" title="Delete" value="' +
                                    data.idPengajaran + '" data-nama-pengajar="' + data.namaPegawai +
                                    '">' +
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
                // $('.tabel-JPkelas2').DataTable({});
                // $('.tabel-JPkelas3').DataTable({});
                // $('.tabel-JPkelas4').DataTable({});
                // $('.tabel-JPkelas5').DataTable({});
                // $('.tabel-JPkelas6').DataTable({});

                $(document).on('click', '#tambah-jadwal', function(e) {
                    e.preventDefault();
                    $("#modal-Jadwal").modal('show');
                    $("#title-modal").text('Tambah Jadawa');
                    $("#cn-btn").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-tbhJadwal">Simpan</button>`);
                    $('.pilih-periode').val('');
                    $('.pilih-kelas').val('');
                    $('.pilih-hari').val('');
                    $('.pilih-guru').val('');
                    $('.jamMulai').val('');
                    $('.jamSelesai').val('');
                });

                $(document).on('click', '#btn-tbhJadwal', function(e) {
                    e.preventDefault();
                    var data = {
                        'idPengajaran': $('.pilih-guru').val(),
                        'hari': $('.pilih-hari').val(),
                        'jamMulai': $('.jamMulai').val(),
                        'jamSelesai': $('.jamSelesai').val(),
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('penjadwalan.store') }}",
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
                            $('#tabel-JPkelas1').DataTable().ajax.reload();
                            // loadOptionPengajaran();
                            $('.pilih-periode').val('');
                            $('.pilih-kelas').val('');
                            $('.pilih-hari').val('');
                            $('.pilih-guru').val('');
                            $('.jamMulai').val('');
                            $('.jamSelesai').val('');
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

            });
        </script>
    @endpush
@endsection
