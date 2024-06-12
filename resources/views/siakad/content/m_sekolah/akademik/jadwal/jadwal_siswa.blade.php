@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    @push('style')
        <style>
            #tabel-JPSiswa caption {
                font-family: 'Times New Roman', Times, serif;
            }

            @media print {
                table {
                    page-break-inside: avoid;
                    width: 100%;
                    color: #000;
                    font-size: 12pt;
                }

                table thead,
                table tbody,
                table tfoot {
                    /* border: 1px solid #000; */
                    color: #000;
                }

                table thead .table-light,
                table tbody,
                table tfoot {
                    background-color: #fff;
                    border: 1px solid #000;
                    color: #000;
                }



                body {
                    background-color: #fff;
                    font-family: 'Times New Roman', Times, serif;
                    font-size: 12pt;
                    width: 100%;
                }
            }
        </style>
    @endpush
    <div class="content">
        <div class="alert alert-primary pb-0" role="alert">
            @php
                $kelas_nama = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
            @endphp
            <div class="row text-uppercase fs-sm fw-bold">
                <div class="col-lg-5">
                    <ul class="list-unstyled mb-0">
                        <li class="row">
                            <div class="col-3"><strong class="d-block">Nama</strong></div>
                            <div class="col-9 fw-medium">: {{ $siswa->namaSiswa }}</div>
                        </li>
                        <li class="row">
                            <div class="col-3"><strong class="d-block">NISN</strong></div>
                            <div class="col-9 fw-medium">: {{ $siswa->nisn }}</div>
                        </li>
                        <li class="row">
                            <div class="col-3"><strong class="d-block">NIS</strong></div>
                            <div class="col-9 fw-medium">: {{ $siswa->nis }}</div>
                        </li>
                        <li class="row">
                            <div class="col-3"><strong class="d-block">Kelas</strong></div>
                            <div class="col-9 fw-medium">: {{ $kelas->namaKelas }}
                                ({{ $kelas_nama[$kelas->namaKelas - 1] ?? '' }})</div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-7">
                    <ul class="list-unstyled">
                        <li class="row">
                            <div class="col-lg-5 col-3"><strong class="d-block">Wali Kelas</strong></div>
                            <div class="col-lg-7 col-9 fw-medium">: {{ $kelas->guru->namaPegawai }}</div>
                        </li>
                        <li class="row">
                            <div class="col-lg-5 col-3"><strong class="d-block">Fase</strong></div>
                            <div class="col-lg-7 col-9 fw-medium">: {{ $kelas->fase }}</div>
                        </li>
                        <li class="row">
                            <div class="col-lg-5 col-3"><strong class="d-block">Semester</strong></div>
                            <div class="col-lg-7 col-9 fw-medium">: {{ $periode->semester }}</div>
                        </li>
                        <li class="row">
                            <div class="col-lg-5 col-3"><strong class="d-block">Tahun Pelajaran</strong></div>
                            <div class="col-lg-7 col-9 fw-medium">: {{ $periode->tahun }}</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Jadwal Pelajaran</h3>
                <div class="block-options">
                    <button class="btn btn-primary btn-sm" id="btn_print_jadwal">
                        <i class="fa fa-print me-2"></i>Cetak</button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive" id="tab_full">
                    <div id="loading_spinner" class="text-center" style="display: none">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <table id="tb_jadwal" class="table table-striped w-100 align-middle text-center table-bordered">
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function getTb() {
                $('#loading_spinner').show();
                $('#tb_jadwal').empty();
                $.ajax({
                    url: `{!! route('get.data-jadwal.siswa') !!}`,
                    type: 'GET',
                    data: {
                        idPeriode: {!! json_encode($periode->idPeriode) !!},
                        kelas: {!! json_encode($kelas->namaKelas) !!},
                    },
                    success: function(data) {
                        // console.log(data.data);
                        var kelas = {!! json_encode($kelas->namaKelas) !!};
                        var periode = {!! json_encode($periode->tahun) !!};
                        var tabel = `<thead class="text-center fw-bold ">
                                        <tr class=" border-0">
                                            <th colspan="7" class="text-center text-uppercase border-0">
                                                <h4>Jadwal Pelajaran Kelas ${kelas}</br>
                                                SD Negeri Lemahbang</br>
                                                Tahun Pelajaran ${periode}
                                                </h4>
                                            </th>
                                        </tr>
                                        <tr class="table-light align-middle">
                                            <th width="14%">Waktu</th>
                                            <th width="14%">Senin</th>
                                            <th width="14%">Selasa</th>
                                            <th width="14%">Rabu</th>
                                            <th width="14%">Kamis</th>
                                            <th width="14%">Jumat</th>
                                            <th width="14%">Sabtu</th>
                                        </tr>
                                    </thead>
                                <tbody>`;

                        $.each(data.data, function(key, value) {
                            // console.log(value);
                            tabel += `<tr>
                            <td class="fs-sm fw-semibold">${value.waktu}</td>
                            <td class="fs-sm fw-semibold text-uppercase">${value.Senin}</td>
                            <td class="fs-sm fw-semibold text-uppercase">${value.Selasa}</td>
                            <td class="fs-sm fw-semibold text-uppercase">${value.Rabu}</td>
                            <td class="fs-sm fw-semibold text-uppercase">${value.Kamis}</td>
                            <td class="fs-sm fw-semibold text-uppercase">${value.Jumat}</td>
                            <td class="fs-sm fw-semibold text-uppercase">${value.Sabtu}</td>
                            </tr>`;
                        });
                        $('#tb_jadwal').html(tabel);

                    },
                    complete: function() {
                        $('#loading_spinner').hide();
                    }

                });
            }
            $(document).ready(function() {
                getTb();
                $('#btn_print_jadwal').click(function() {
                    $('#tb_jadwal').printThis({
                        debug: false, // show the iframe for debugging
                        importCSS: true,
                        importStyle: true,
                    });
                    // $('.buttons-print').click();
                });
            });
        </script>
    @endpush
@endsection
