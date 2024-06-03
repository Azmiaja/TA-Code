@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <style>
        .wid-hed {
            width: 350px;
            padding: 0 10px;
        }

        .wid-hed-2 {
            width: 130px;
            padding: 0 10px;

        }

        .table_rapor {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        .table11 td {
            border: 1px solid black;
        }

        /* Remove outside border */
        .table11 {
            border-collapse: collapse;
        }

        .table11 tr:first-child td {
            border-top: none;
        }

        .table11 tr td:first-child {
            border-left: none;
        }

        .table11 tr:last-child td {
            border-bottom: none;
        }

        .table11 tr td:last-child {
            border-right: none;
        }

        .bg-0 {
            background-color: #dadde0;
            color: black
        }

        table,
        td,
        table th {
            color: black;
            font-size: 11pt;

        }

        table h4 {
            font-size: 14pt;
        }

        table {
            font-size: 11pt;
        }

        .left-title {
            width: 130px;
            min-width: 130px;
        }

        .left-center {
            width: 10px
        }

        .right-end {
            width: 90px;
        }

        .right-center {
            width: 10px;
        }

        .right-title {
            width: 110px;
            min-width: 110px;
        }

        .sticky-top-80 {
            position: sticky;
            top: 70px;
        }

        @media print {

            body {
                background-color: white;
                font-family: 'Times New Roman', Times, serif;
                color: #000;
                -webkit-print-color-adjust: exact;
                /* Khusus untuk browser WebKit seperti Chrome */
                print-color-adjust: exact;
                /* Properti standar */
                /* font-size: 10pt; */
            }

            .tb_tb {
                page-break-inside: avoid;
                /* Hindari pemotongan tabel di dalam halaman */
            }

            thead {
                display: table-header-group;
            }


            .bg-0 {
                background-color: #dadde0;
                color: black
            }

            @page {
                /* size: A4; */
                margin: 1.8cm 1cm 1.8cm 1cm;
                /* Anda bisa menyesuaikan margin sesuai kebutuhan */
            }
        }
    </style>
    <div class="content">
        <div class="row g-3">
            <div class="col-lg-9 col-12 order-lg-1 order-2">
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <div
                            class="row bg-white border m-0 pb-3 rounded-4 g-3 mb-4 justify-content-center sticky-top-80 shadow-sm">
                            <div class="col-md-1">
                                <input type="text" readonly id="urut_siswa"
                                    class="text-center form-control form-control-lg border-dark">
                            </div>
                            <div class="col-md-5">
                                <select class="form-select form-select-lg border-dark" name="" id="data_siswa">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-lg border-dark" name="" id="ortu_selected">
                                    <option value="" selected>Default</option>
                                    <option value="Ayah">Ayah</option>
                                    <option value="Ibu">Ibu</option>
                                    <option value="Wali">Wali Murid</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex">
                                <button id="cetak_rp" type="button" title="Cetak Rapor"
                                    class="btn btn-lg btn-primary w-100"><i class="fa-solid fa-print"></i></button>
                                <button id="setting_rp" type="button" title="Setting"
                                    class="btn btn-lg btn-alt-info w-100 ms-2"><i class="fa-solid fa-gear"></i></button>
                            </div>
                        </div>
                        <div class="mx-auto" style="padding: 1.2cm .4cm 1.2cm .4cm; border: 1px dashed #4e4e4e;">
                            <div id="loading_spinner" class="text-center" style="display: none">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <div class="table-renponsive bg-white" id="ctk_rapor"></div>
                        </div>
                        <div class="mx-auto mb-2 alert-periode d-none" style="max-width:21.1cm;">
                            <small id="kode-tp" class="form-text text-muted"><span class="fw-bold">Catatan:
                                </span>Pada periode semester <b>Ganjil</b> kolom Keterangan Kenaikan Kelas tidak akan di
                                tampilakan!.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-12 order-lg-2 order-1">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h4 class="block-title">Kelas</h4>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="row g-3">
                            <div class="col-lg-12 col-3">
                                <label for="" class="form-label">Periode</label>
                                <select class="form-select form-select-lg" name="" id="periode">
                                    @foreach ($periode as $item)
                                        <option data-tahun="{{ $item->tahun }}" data-smt="{{ $item->semester }}"
                                            {{ $item->status == 'Aktif' ? 'selected' : '' }} value="{{ $item->idPeriode }}"
                                            data-tgmulai="{{ $item->tanggalMulai }}">
                                            {{ $item->semester }} {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 col-3">
                                <label for="" class="form-label">Kelas</label>
                                <select class="form-select form-select-lg" name="" id="kelas">
                                </select>
                            </div>
                            <div class="col-lg-12 col-3">
                                <label for="" class="form-label">Wali Kelas</label>
                                <input type="text" disabled class="form-control" name="" id="wali_kelas"
                                    aria-describedby="helpId" placeholder="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal option --}}
    <div class="modal fade" id="modal_option" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalMapeltLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Pengaturan Rapor</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm form-container">
                        <div class="mb-3">
                            <label for="tgl_rapor" class="form-label">Tanggal Rapor</label>
                            <input type="text" readonly class="form-control" name="" id="tgl_rapor" />
                        </div>
                        <div id="form_mapel"></div>
                        <div class="mb-3 text-end">
                            <button type="button" name="" id="sv_rapor" class="btn btn-primary">
                                Simpan
                            </button>
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
            function getSelectKelas() {
                $('#kelas').empty();
                $.ajax({
                    type: "GET",
                    url: `{{ route('form.kelas') }}`,
                    data: {
                        periode: $('#periode option:selected').val()
                    },
                    success: function(data) {
                        $.each(data.kelas, function(i, item) {
                            $('#kelas').append(
                                `<option value="${item.namaKelas}" data-id="${item.idKelas}" data-nip="${item.guru.nip}" data-wakel="${item.guru.namaPegawai}" data-fase="${item.fase}" data-idguru="${item.guru.idPegawai}">Kelas ${item.namaKelas}</option>`
                            );
                            if (i === 0) {
                                $('#kelas').find('option').attr('selected', 'selected');
                                let selectedWakel = $('#kelas').find('option:selected').data('wakel');
                                let nip = $('#kelas').find('option:selected').data('nip');
                                $('#wali_kelas').val(selectedWakel);

                            }
                        });
                    },
                    complete: function() {
                        getMapel();

                    }
                });
            }

            function slectSiswa() {
                var periode = $('#periode option:selected').val();
                var kelas = $('#kelas option:selected').val();
                $('#data_siswa').empty();
                var option = '';
                $.ajax({
                    url: `{{ route('get-siswa.rapor') }}`,
                    type: 'GET',
                    data: {
                        idPeriode: periode,
                        namaKelas: kelas
                    },
                    success: function(data) {
                        $.each(data, function(i, siswa) {
                            option +=
                                `<option data-no="${i+1}" value="${siswa.idSiswa}">${siswa.namaSiswa}</option>`;
                        });
                        // $('#urut_siswa').val(no);
                        // console.log(no);
                    },
                    complete: function() {
                        $('#data_siswa').append(option);
                        $('#data_siswa').trigger('change');
                        $('#ortu_selected').trigger('change');
                    }
                });
            }

            var mapel_data_mulok = [];
            var mapel_data_seni = [];
            var mapel_data = [];

            function updateMapelData() {
                mapel_data = $('.input-mapel:checked').map(function() {
                    return $(this).val();
                }).get();

                mapel_data_seni = $('.input-mapel-seni:checked').map(function() {
                    return $(this).val();
                }).get();

                mapel_data_mulok = $('.input-mapel-mulok:checked').map(function() {
                    return $(this).val();
                }).get();
            }

            function getMapel() {
                var kelas = $('#kelas option:selected').data('id');
                var periode = $('#periode option:selected').val();
                $('#form_mapel').empty();
                var form_mapel = `<div class="mb-3">
                                        <label class="form-label">Mata Pelajaran Rapor</label>`;
                $.ajax({
                    url: `{{ route('get-data.rapor.mapel') }}`,
                    type: 'GET',
                    data: {
                        idPeriode: periode,
                        idKelas: kelas,
                    },
                    success: function(data) {
                        var mapel = data.filter(function(item) {
                            return item.mapel.kategori === '-';
                        });
                        $.each(mapel, function(key, value) {

                            form_mapel += `<div class="form-check">
                                          <input class="form-check-input input-mapel" type="checkbox" checked value="${value.mapel.idMapel}" id="mapel_check_${value.mapel.idMapel}" data-position="${key}">
                                          <label class="form-check-label" for="mapel_check_${value.mapel.idMapel}">
                                            ${value.mapel.namaMapel}
                                          </label>
                                        </div>`;
                        });

                        var mapel_seni = data.filter(function(item) {
                            return item.mapel.kategori === 'seni pilihan';
                        });
                        form_mapel += `</div>
                        <div class="mb-3">
                            <label class="form-label">Seni Pilihan</label>`;


                        $.each(mapel_seni, function(i, seni) {
                            form_mapel += `<div class="form-check">
                                          <input class="form-check-input input-mapel-seni" type="checkbox" checked value="${seni.mapel.idMapel}" id="mapel_seni_check_${seni.mapel.idMapel}" data-position="${i}">
                                          <label class="form-check-label" for="mapel_seni_check_${seni.mapel.idMapel}">
                                            ${seni.mapel.namaMapel}
                                          </label>
                                        </div>`;
                        });

                        form_mapel += `</div>
                        <div class="mb-3">
                            <label class="form-label">Muata Lokal</label>`;

                        var mapel_mulok = data.filter(function(item) {
                            return item.mapel.kategori === 'mulok';
                        });
                        $.each(mapel_mulok, function(j, mulok) {
                            form_mapel += `<div class="form-check">
                                          <input class="form-check-input input-mapel-mulok" type="checkbox" checked value="${mulok.mapel.idMapel}" id="mapel_mulok_check_${mulok.mapel.idMapel}" data-position="${j}">
                                          <label class="form-check-label" for="mapel_mulok_check_${mulok.mapel.idMapel}">
                                            ${mulok.mapel.namaMapel}
                                          </label>
                                        </div>`;
                        });

                        form_mapel += `</div>`;


                    },
                    complete: function() {
                        $('#form_mapel').append(form_mapel);
                        updateMapelData();
                        slectSiswa();
                    }
                });

            }

            function printDiv(idSiswa, data_mp, data_seni, data_mulok, tanggal) {
                var periode = $('#periode option:selected').val();
                var periode_th = $('#periode option:selected').data('tahun');
                var periode_smt = $('#periode option:selected').data('smt');
                var kelas = $('#kelas option:selected').val();
                var kelas_fs = $('#kelas option:selected').data('fase');
                var sekolah = {!! json_encode($sekolah) !!};

                var kls_romawi = ['I', 'II', 'III', 'IV', 'V', 'VI'];
                var kls_nama = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];

                $('#ctk_rapor').empty();
                $('#loading_spinner').show();
                var tb;

                var guru_kelas = $('#kelas').find('option:selected').data('wakel');
                var gr_nip = $('#kelas').find('option:selected').data('nip');

                // console.log(sekolah);

                $.ajax({
                    url: `{{ route('get-data.rapor') }}`,
                    type: 'GET',
                    data: {
                        idPeriode: periode,
                        namaKelas: kelas,
                        idSiswa: idSiswa
                    },
                    success: function(data) {
                        var tgl = tanggal;
                        // var mapel_data = [];

                        var siswa = data.siswa;


                        function getOrtu() {
                            var cange = $('#ortu_selected').find('option:selected').val();
                            if (cange == 'Ayah') {
                                return `<u>${siswa.namaAyah}</u>`;
                            } else if (cange == 'Ibu') {
                                return `<u>${siswa.namaIbu}</u>`;
                            } else if (cange == 'Wali') {
                                return `<u>${siswa.namaWali}</u>`;
                            } else {
                                return '<pre>........................</pre>';
                            }
                        }

                        $('#ortu_selected').change(function() {
                            var ortu = getOrtu();
                            $(document).find('#ortu_ttd').html(
                                ortu); // Cetak nilai ortu setiap kali pilihan berubah
                        });



                        tb = `<table id="table_rapor" class="table_rapor table-sm table w-100 table-bordered border-dark">
                                    <tr class="border-0">
                                        <th colspan="4" class="p-0 pb-3 border-0">
                                            <h4 class="text-center text-uppercase mb-0" style="color: #000">Laporan Hasil
                                                Belajar<br>(Rapor)</h4>
                                        </th>
                                    </tr>
                                    <tr class="border-0">
                                        <th class="border-0" style="width: 4.22ch; min-width: 4.22ch;"></th>
                                        <th colspan="2" class="p-0 border-0">
                                            <table class="table table-borderless fw-normal mb-0">
                                                <tr>
                                                    <td class="m-0 p-0 pe-2 border-0" width="68%">
                                                        <div class="d-flex">
                                                            <div class="text-nowrap left-title">Nama Peserta Didik</div>
                                                            <div class="left-center">:</div>
                                                            <div class="left-end text-uppercase">${siswa.namaSiswa}</div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="text-nowrap left-title">NISN/NIS</div>
                                                            <div class="left-center">:</div>
                                                            <div class="left-end">${siswa.nisn}/${siswa.nis}</div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="text-nowrap left-title">Nama Sekolah</div>
                                                            <div class="left-center">:</div>
                                                            <div class="left-end">${sekolah.namaSekolah ?? '-'}</div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="text-nowrap left-title">Alamat Sekolah</div>
                                                            <div class="left-center">:</div>
                                                            <div class="left-end">${sekolah.alamat ?? '-'}</div>
                                                        </div>
                                                    </td>
                                                    <td class="m-0 p-0 border-0">
                                                        <div class="d-flex">
                                                            <div class="text-nowrap right-title">Kelas</div>
                                                            <div class="right-center">:</div>
                                                            <div class="right-end text-uppercase">${kls_romawi[kelas - 1??'']} (${kls_nama[kelas - 1??'']})</div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="text-nowrap right-title">Fase</div>
                                                            <div class="right-center">:</div>
                                                            <div class="right-end">${kelas_fs}</div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="text-nowrap right-title">Semester</div>
                                                            <div class="right-center">:</div>
                                                            <div class="right-end text-uppercase">${periode_smt === 'Genap' ? 'II' : 'I'}/${periode_smt}</div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="text-nowrap right-title">Tahun Pelajaran</div>
                                                            <div class="right-center">:</div>
                                                            <div class="right-end">${periode_th}</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </th>
                                        <th class="border-0" style="width: 4.22ch; min-width: 4.22ch;"></th>
                                    </tr>
                                </table>
                                <table class="table_rapor table-sm  table w-100 table-bordered border-dark mb-0">
                                    <thead>
                                        <tr class="text-center bg-0 border-dark align-middle" style="border-bottom: none;">
                                            <th style="text-transform: none; border-bottom: none;">No</th>
                                            <th style="text-transform: none; border-bottom: none;">Mata Pelajaran</th>
                                            <th style="text-transform: none; border-bottom: none;" class="text-center">Nilai Akhir</th>
                                            <th style="text-transform: none; border-bottom: none;">Capaian Kompetensi</th>
                                        </tr>
                                    </thead>
                                `;

                        // var mapel_data = [7, 8, 13];
                        var mapel = data.mapel.filter(function(item) {
                            return item.mapel.kategori === '-' && data_mp.includes(item.idMapel
                                .toString());
                        });
                        var number = 0;

                        if (mapel.length > 0) {
                            $.each(mapel, function(key, value) {
                                // console.log(value);
                                number++;

                                tb += `<tr class="align-middle">
                                        <td style="width:4.22ch; min-width: 4.22ch;" class="text-center">${key+1}</td>
                                        <td style="width:22.78ch; min-width: 22.78ch;">${value.mapel.namaMapel}</td>
                                        `;
                                var nilai = data.nilai.find(function(item) {
                                    return item.idPengajaran === value.idPengajaran;
                                });
                                if (nilai && nilai.deskripsiCPtinggi && nilai.deskripsiCPrendah) {
                                    tb += `<td class="text-center" style="width:9.22ch; min-width: 9.22ch; font-size:12pt;">${nilai.raport === 0 ? '' : nilai.raport}</td>
                                        <td class="p-0">
                                            <table class="table table-sm table11 m-0">
                                                <tr>
                                                    <td class="py-2 lh-1" style="font-size:10pt;">Ananda <span class="text-uppercase">${siswa.namaSiswa}</span> ${nilai.deskripsiCPtinggi === null ? '' : nilai.deskripsiCPtinggi}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 lh-1" style="font-size:10pt;">Ananda <span class="text-uppercase">${siswa.namaSiswa}</span> ${nilai.deskripsiCPrendah === null ? '' : nilai.deskripsiCPrendah}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>`;
                                } else {
                                    tb += `<td class="text-center" style="width:9.22ch; min-width: 9.22ch;"></td>
                                        <td class="p-0">
                                            <table class="table table-sm table11 m-0">
                                                <tr>
                                                    <td style="padding: 15px"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>`;

                                }
                                // console.log(nilai);
                            });
                        } else {
                            tb += `<tr class="align-middle">
                                        <td style="width:4.22ch; min-width: 4.22ch;" class="text-center">${number+1}</td>
                                        <td style="width:22.78ch; min-width: 22.78ch;"></td>
                                        <td class="text-center" style="width:9.22ch; min-width: 9.22ch;"></td>
                                        <td class="p-0">
                                            <table class="table table-sm table11 m-0">
                                                <tr>
                                                    <td style="padding: 15px"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>`;
                        }

                        var mapel_seni = data.mapel.filter(function(item) {
                            return item.mapel.kategori === 'seni pilihan' && data_seni.includes(item
                                .idMapel
                                .toString());
                        });

                        if (mapel_seni.length > 0) {
                            tb += `<tr>
                                <td class="text-center">${mapel.length == 0 ? number+2: number+1}</td>
                                <td colspan="3">Seni (Pilihan)</td>
                            </tr>`;
                            $.each(mapel_seni, function(j, seni) {
                                var nilai = data.nilai.find(function(item) {
                                    return item.idPengajaran === seni.idPengajaran;
                                });
                                var alfabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g'];
                                tb += `<tr class="align-middle">
                                        <td style="width:4.22ch; min-width: 4.22ch;" class="text-center">${alfabet[j+1 -1 ?? '']}</td>
                                        <td style="width:22.78ch; min-width: 22.78ch;">${seni.mapel.namaMapel}</td>
                                        `;

                                if (nilai && nilai.deskripsiCPtinggi && nilai.deskripsiCPrendah) {
                                    tb += `<td class="text-center" style="width:9.22ch; min-width: 9.22ch; font-size:12pt;">${nilai.raport === 0 ? '' : nilai.raport}</td>
                                        <td class="p-0">
                                            <table class="table table-sm table11 m-0">
                                                <tr>
                                                    <td class="py-2 lh-1" style="font-size:10pt;">Ananda <span class="text-uppercase">${siswa.namaSiswa}</span> ${nilai.deskripsiCPtinggi === null ? '' : nilai.deskripsiCPtinggi}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 lh-1" style="font-size:10pt;">Ananda <span class="text-uppercase">${siswa.namaSiswa}</span> ${nilai.deskripsiCPrendah === null ? '' : nilai.deskripsiCPrendah}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>`;
                                } else {
                                    tb += `<td class="text-center" style="width:9.22ch; min-width: 9.22ch;"></td>
                                        <td class="p-0">
                                            <table class="table table-sm table11 m-0">
                                                <tr>
                                                    <td style="padding: 15px"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>`;

                                }

                            });
                        }

                        tb += ` </table>`;

                        var mapel_mulok = data.mapel.filter(function(item) {
                            return item.mapel.kategori === 'mulok' && data_mulok.includes(item
                                .idMapel
                                .toString());
                        });
                        if (mapel_mulok.length > 0) {
                            tb += `<table class="table_rapor tb_tb table-sm table w-100 table-bordered border-dark mt-0">
                                <tr class="border-0">
                                    <th colspan="4" class="h6 text-uppercase border-0">Muatan Lokal</th>
                                </tr>
                                <tr class="text-center bg-0 border-dark align-middle">
                                    <th>No</th>
                                    <th>Mata Pelajaran</th>
                                    <th class="text-center">Nilai Akhir</th>
                                    <th>Capaian Kompetensi</th>
                                </tr>`;

                            $.each(mapel_mulok, function(k, mulok) {
                                tb += `<tr class="align-middle">
                                        <td style="width:4.22ch; min-width: 4.22ch;" class="text-center">${mapel.length > 0 ? (mapel_seni.length == 0 ? number + 1 : number+2) : number+3}</td>
                                        <td style="width:22.78ch; min-width: 22.78ch;">${mulok.mapel.namaMapel}</td>
                                        `;

                                var nilai = data.nilai.find(function(item) {
                                    return item.idPengajaran === mulok.idPengajaran;
                                });

                                if (nilai && nilai.deskripsiCPtinggi && nilai.deskripsiCPrendah) {
                                    tb += `<td class="text-center" style="width:9.22ch; min-width: 9.22ch; font-size:12pt;">${nilai.raport === 0 ? '' : nilai.raport}</td>
                                        <td class="p-0">
                                            <table class="table table-sm table11 m-0">
                                                <tr>
                                                    <td class="py-2 lh-1" style="font-size:10pt;">Ananda <span class="text-uppercase">${siswa.namaSiswa}</span> ${nilai.deskripsiCPtinggi === null ? '' : nilai.deskripsiCPtinggi}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 lh-1" style="font-size:10pt;">Ananda <span class="text-uppercase">${siswa.namaSiswa}</span> ${nilai.deskripsiCPrendah === null ? '' : nilai.deskripsiCPrendah}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>`;
                                } else {
                                    tb += `<td class="text-center" style="width:10.22ch; min-width: 10.22ch;"></td>
                                        <td class="p-0">
                                            <table class="table table-sm table11 m-0">
                                                <tr>
                                                    <td style="padding: 15px"></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 15px"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>`;

                                }
                            });
                        }

                        tb += `</table>
                        <table class="table_rapor table-sm tb_tb table w-100 table-bordered border-dark align-middle ${mapel_mulok.length == 0 ? 'mt-3' : ''}">
                                    <tr class="text-center bg-0 border-dark">
                                        <th>No</th>
                                        <th>Ekstrakulikuler</th>
                                        <th>Predikat</th>
                                        <th>Keterangan</th>
                                    </tr>`;

                        var ekstra = data.kegiatan.sort(function(a, b) {
                            if (a.ekstra.status === "wajib" && b.ekstra.status === "pilihan") {
                                return -1;
                            }
                            if (a.ekstra.status === "pilihan" && b.ekstra.status === "wajib") {
                                return 1;
                            }
                            return 0; // Tidak ada perubahan jika statusnya sama
                        });
                        if (ekstra.length > 0) {
                            $.each(ekstra, function(key, value) {
                                var predikat = ['Sangat Berkembang', 'Berkembang',
                                    'Cukup Berkembang',
                                    'Mulai Berkembang'
                                ];
                                tb += `<tr>
                                            <td style="width: 4.22ch; min-width:  4.22ch;" class="text-center">${key +1}</td>
                                            <td style="width:22.78ch; min-width: 22.78ch;">${value.ekstra.ekstra}</td>
                                            <td class="text-center" style="width:9.22ch; min-width: 9.22ch; font-size:9.7pt;">${predikat[value.predikat-1 ?? '']}</td>
                                            <td class="py-2 lh-1" >${value.deskripsi ?? ''}</td>
                                        </tr>`;
                            });
                        } else {
                            tb += `<tr>
                                        <td style="width: 4.22ch; min-width:  4.22ch;" class="text-center">1</td>
                                        <td style="width:22.78ch; min-width: 22.78ch;"></td>
                                        <td style="width:9.22ch; min-width: 9.22ch;"></td>
                                        <td class="py-2"></td>
                                    </tr>`;

                        }

                        tb += `</table>
                            <table class="table_rapor tb_tb table-sm table w-100 table-bordered border-dark">
                                    <tr class="text-start bg-0 border-dark">
                                        <th>Catatan Guru</th>
                                    </tr>`;

                        var catatan = data.catatan;
                        if ([catatan].length > 0 && catatan !== null) {
                            tb += `<tr>
                                        <td class="py-2 lh-1">${catatan.catatan_guru ?? ''}</td>
                                    </tr>`;
                        } else {
                            tb += `<tr>
                                        <td class="py-2"></td>
                                    </tr>`;
                        }

                        tb += `</table>`;

                        if (periode_smt == 'Genap') {
                            tb += `<table class="table_rapor tb_tb table-sm table w-100 table-bordered border-dark">
                                    <tr class="text-start bg-0 border-dark">
                                        <th>Keterangan Kenaikan Kelas</th>
                                    </tr>`;
                            var keterangan = data.keterangan;
                            if ([keterangan].length > 0 && keterangan !== null) {
                                tb += `
                                <tr>
                                    <td class="py-2 lh-1">${keterangan.deskripsi ?? ''}</td>
                                </tr>`;
                            } else {
                                tb += `<tr>
                                        <td class="py-2"></td>
                                    </tr>`;
                            }
                            tb += `</table>`;
                        }


                        var absen = data.absen;
                        let totSakit = absen.filter(function(presensi) {
                            return presensi.presensi === 'S';
                        }).length;
                        let totIzin = absen.filter(function(presensi) {
                            return presensi.presensi === 'I';
                        }).length;
                        let totAlfa = absen.filter(function(presensi) {
                            return presensi.presensi === 'A';
                        }).length;

                        tb += `<table style="width:40ch; min-width: 40ch; margin-left: 4.22ch;"
                                    class="table_rapor table-sm table table-bordered border-dark">
                                    <tr class="text-center border-dark bg-0">
                                        <th colspan="3">Ketidakhadiran</th>
                                    </tr>
                                    <tr>
                                        <td width="60%" class="py-0 border-end-0">Sakit</td>
                                        <td width="4%" class="py-0 border-0">:</td>
                                        <td class="py-0 border-start-0">${totSakit} hari</td>
                                    </tr>
                                    <tr>
                                        <td width="60%" class="py-0 border-end-0">Izin</td>
                                        <td width="4%" class="py-0 border-0">:</td>
                                        <td class="py-0 border-start-0">${totIzin} hari</td>
                                    </tr>
                                    <tr>
                                        <td width="60%" class="py-0 border-end-0">Tanpa Keterangan</td>
                                        <td width="4%" class="py-0 border-0">:</td>
                                        <td class="py-0 border-start-0">${totAlfa} hari</td>
                                    </tr>
                                </table>
                                <table class="table_rapor table table-borderless">
                                    <tr>
                                        <td style="width: 4.22ch; min-width: 4.22ch;"></td>
                                        <td colspan="2">
                                            <div class="d-flex justify-content-between">
                                                <div class="flex-item text-center">
                                                    <br>
                                                    <span>Orang Tua/Wali,</span>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <span id="ortu_ttd"></span>
                                                </div>
                                                <div class="flex-item text-center">
                                                    <span id="tanggal_rapor">${tgl}</span><br>
                                                    <span>Wali Kelas ${kls_romawi[kelas - 1??'']} <span class="text-uppercase">(${kls_nama[kelas - 1??'']})</span></span>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <span><u>${guru_kelas}</u></span><br>
                                                    <span>NIP. ${gr_nip}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 4.22ch; min-width: 4.22ch;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="d-flex justify-content-center">
                                                <div class="flex-item text-center">
                                                    <span>Mengetahui,</span><br>
                                                    <span>Kepala Sekolah</span>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <span><u>${[sekolah].length > 0 ? sekolah.kepsek : ''}</u></span><br>
                                                    <span>NIP. ${[sekolah].length > 0 ? sekolah.nip : ''}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>`;

                        // console.log([kepsek].length);


                    },
                    complete: function() {
                        $('#loading_spinner').hide();
                        $('#ctk_rapor').append(tb);
                        $('#ortu_selected').trigger('change');
                    }
                });
            }

            $('#setting_rp').click(function() {
                $('#modal_option').modal('show');
                new AirDatepicker('#tgl_rapor', {
                    container: '#modal_option',
                    autoClose: true,
                    dateFormat: "dd MMMM yyyy",
                }).selectDate(new Date());
            });

            $("#periode").change(function() {
                getSelectKelas();
            });

            $('#kelas, #periode').change(function() {
                // $('#wali_kelas').val('');
                let selectedWakel = $('#kelas').find('option:selected').data('wakel');
                let nip = $('#kelas').find('option:selected').data('nip');
                $('#wali_kelas').val(selectedWakel);
                slectSiswa();
                // getMapel();
            });

            $('#data_siswa').change(function(e) {
                moment.locale('id');
                e.preventDefault();
                var no = $('#data_siswa option:selected').data('no');
                $('#urut_siswa').val(no);
                var id = $('#data_siswa option:selected').val();
                printDiv(id, mapel_data, mapel_data_seni, mapel_data_mulok, moment().format('DD MMMM YYYY'));
            });

            $('#sv_rapor').click(function() {
                var tgl = $('#tgl_rapor').val();

                updateMapelData();
                $('#modal_option').modal('hide');
                var id = $('#data_siswa option:selected').val();
                printDiv(id, mapel_data, mapel_data_seni, mapel_data_mulok, tgl);

            });

            $('#cetak_rp').on('click', function() {
                $("#ctk_rapor").printThis({
                    debug: false, // show the iframe for debugging
                    importCSS: true,
                    importStyle: true, // import style tags
                });
            });

            $(document).ready(function() {
                getSelectKelas();

                if ($('#periode option:selected').data('smt') === 'Ganjil') {
                    $('.alert-periode').removeClass('d-none');
                }
            });
        </script>
    @endpush
@endsection
