@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title periode --}}
                    <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            @canany(['super.admin', 'admin'])
                                <li class="breadcrumb-item">
                                    <a class="link-fx" href="javascript:void(0)">{{ $title }}</a>
                                </li>
                            @endcanany
                            @canany(['siswa', 'guru'])
                                <li class="breadcrumb-item">
                                    <a class="link-fx" href="javascript:void(0)">{{ $title3 }}</a>
                                </li>
                            @endcanany
                            <li class="breadcrumb-item" aria-current="page">
                                {{ $title2 }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        @canany(['super.admin', 'admin'])
            <div class="block block-rounded">
                <div class="block-header border-bottom border-2 border-alt-secondary block-header-default">
                    <h3 class="block-title">Data Nilai Siswa</h3>
                </div>
                <div class="row p-0 m-0">
                    <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                        {{-- @foreach ($kelas as $item)
                        <li class="nav-item">
                            <button class="nav-link data-kelas-tab" id="data-kelas-{{ $item->namaKelas }}-tab"
                                data-bs-toggle="tab" data-bs-target="#data-kelas" data-nama-kelas="{{ $item->namaKelas }}"
                                role="tab" aria-controls="data-kelas" aria-selected="true">Kelas
                                {{ $item->namaKelas }}</button>
                        </li>
                    @endforeach --}}
                        <li class="nav-item">
                            <button class="nav-link data-kelas-tab active" id="data-kelas-1-tab" data-bs-toggle="tab"
                                data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" data-nama-kelas="1"
                                aria-selected="false">Kelas
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
                            <table id="tabelNilai" style="width: 100%;"
                                class="table tabel-responsive table-bordered table-striped table-vcenter js-dataTable-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th>Mata Pelajaran</th>
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
        @can('siswa')
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Nilai Semester </h3>
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
                <div class="block-content block-content-full">
                    <input type="hidden" id="siswa_id" value="{{ Auth::user()->idSiswa }}">
                    <table id="tb_nilai" style="width: 100%;" class="table table-bordered table-striped table-vcenter">
                        <thead class="fw-bold">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Mapel</th>
                                <th class="text-center" style="width: 12%;">Nilai UH</th>
                                <th class="text-center" style="width: 12%;">Nilai UTS</th>
                                <th class="text-center" style="width: 12%;">Nilai UAS</th>
                                <th style="width: 30%;">Guru Pengajar</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- content --}}
                        </tbody>
                    </table>
                </div>
            </div>
        @endcan
        @can('guru')
            <div class="block block-rounded">
                <div class="block-header border-bottom border-2 border-alt-secondary block-header-default">
                    <h3 class="block-title">Data Nilai Siswa</h3>
                </div>
                <div class="row p-0 m-0">
                    <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link data-kelas-tab active" id="data-kelas-1-tab" data-bs-toggle="tab"
                                data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" data-nama-kelas="1"
                                aria-selected="false">Kelas
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
                        <div class="tab-pane fade show active" id="data-kelas" role="tabpanel"
                            aria-labelledby="data-kelas-tab" tabindex="0">
                            <table id="tabelMapel" style="width: 100%;"
                                class="table tabel-responsive table-bordered table-striped table-vcenter js-dataTable-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th>Mata Pelajaran</th>
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
        @endcan
    </div>

    @push('scripts')
        @canany(['super.admin', 'admin'])
            <script>
                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $(document).on('click', '.data-kelas-tab', function(e) {
                        e.preventDefault();
                        $('#tabelNilai').DataTable().ajax.reload();
                    });

                    $('#periode').change(function() {
                        $('#tabelNilai').DataTable().ajax.reload();
                        $('#tb_nilai').DataTable().ajax.reload();
                    });

                    // var tableHeader = generateKategori();

                    $('#tabelNilai').DataTable({
                        processing: true,
                        serverSide: true,
                        // ajax: "{{ url('pengajar/get-data') }}",
                        ajax: {
                            url: "{{ url('penilaian/get-data') }}",
                            type: "GET",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
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
                                data: 'mapel.namaMapel',
                                name: 'mapel.namaMapel',
                            },
                            {
                                data: null,
                                className: 'text-center',
                                searchable: false,
                                render: function(data, type, row) {
                                    return '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-alt-primary" title="Beri Nilai ' +
                                        data.mapel.namaMapel + '" id="action-nilai" data-id-mapel="' +
                                        data.idPengajaran + '" data-slug="' + data.mapel.namaMapel + '">' +
                                        '<i class="fa fa-fw fa-eye"></i></button>' +
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




                    $(document).on('click', '#action-nilai', function() {
                        // Dapatkan id mapel dari atribut data-id-mapel
                        var idMapel = $(this).data('id-mapel');
                        var slug = $(this).data('slug');
                        var kelas_id = $(".data-kelas-tab.active").data('nama-kelas');
                        var periode_id = $('#periode').val();


                        // Bentuk URL rute dengan menggunakan variabel
                        var url = "{{ url('manajemen-kelas/nilai_siswa') }}/" + slug + "/" + idMapel + "/" +
                            kelas_id + "/" + periode_id;

                        // Redirect ke halaman lain
                        window.location.href = url;

                    });

                    // Siswa 

                });
            </script>
        @endcanany
        @can('guru')
            <script>
                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $(document).on('click', '.data-kelas-tab', function(e) {
                        e.preventDefault();
                        $('#tabelMapel').DataTable().ajax.reload();
                    });

                    $('#periode').change(function() {
                        $('#tabelMapel').DataTable().ajax.reload();
                    });

                    $('#tabelMapel').DataTable({
                        // processing: true,
                        // serverSide: true,
                        ajax: {
                            url: '{{ route('get-mapel.guru') }}',
                            type: "GET",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: function(d) {
                                d.periode = $('#periode').val();
                                d.kelas = $(".data-kelas-tab.active").data('nama-kelas');
                                d.nama = '{{ ucwords(Auth::user()->pegawai->idPegawai) }}';
                                console.log(d.nama);
                                console.log(d.kelas);
                                console.log(d.periode);
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
                                data: 'namaMapel',
                                name: 'namaMapel',
                            },
                            {
                                data: null,
                                className: 'text-center',
                                searchable: false,
                                render: function(data, type, row) {
                                    return '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-alt-primary" title="Beri Nilai ' +
                                        data.namaMapel + '" id="action-nilai" data-id-mapel="' +
                                        data.idPengajaran + '" data-slug="' + data.namaMapel + '">' +
                                        '<i class="fa fa-fw fa-eye"></i></button>' +
                                        '</div>';
                                }
                            }

                        ],
                        order: [
                            [1, 'asc']
                        ],
                        dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'<'row float-end' <'col' f><'col text-end'B>>>>" +
                            "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                            "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        lengthMenu: [10, 25],
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
                                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt,
                                            button, config);
                                    }
                                },
                            }
                        ],
                    });

                    $(document).on('click', '#action-nilai', function() {
                        // Dapatkan id mapel dari atribut data-id-mapel
                        var idMapel = $(this).data('id-mapel');
                        var slug = $(this).data('slug');
                        var kelas_id = $(".data-kelas-tab.active").data('nama-kelas');
                        var periode_id = $('#periode').val();


                        // Bentuk URL rute dengan menggunakan variabel
                        var url = "{{ url('manajemen-kelas/nilai_siswa_guru') }}/" + slug + "/" + idMapel + "/" +
                            kelas_id + "/" + periode_id;

                        // Redirect ke halaman lain
                        window.location.href = url;

                    });
                });
            </script>
        @endcan
        @can('siswa')
            <script>
                $(document).ready(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#periode').change(function() {
                        $('#tb_nilai').DataTable().ajax.reload();
                    });
                    $('#tb_nilai').DataTable({
                        processing: true,
                        // serverSide: true,
                        // ajax: "{{ url('pengajar/get-data') }}",
                        ajax: {
                            url: '{!! route('siswa_nilai.get') !!}',
                            type: "GET",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: function(d) {
                                d.periode_id = $('#periode').val();
                                d.siswa_id = $('#siswa_id').val();
                                console.log(d.periode_id);
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
                                data: 'namaMapel',
                                name: 'namaMapel',
                            },
                            {
                                data: 'nilaiUH',
                                name: 'nilaiUH',
                                className: 'text-center'
                            },
                            {
                                data: 'nilaiUTS',
                                name: 'nilaiUTS',
                                className: 'text-center'
                            },
                            {
                                data: 'nilaiUAS',
                                name: 'nilaiUAS',
                                className: 'text-center'
                            },
                            {
                                data: 'namaPegawai',
                                name: 'namaPegawai',
                            }

                        ],
                        order: [
                            [0, 'asc']
                        ],
                        dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                            "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                            "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        lengthMenu: [10, 25, 50],
                        
                    });
                });
            </script>
        @endcan
    @endpush
@endsection
