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
            width: 140px;
            min-width: 140px;
        }

        .left-center {
            width: 15px
        }

        .right-end {
            width: 30px;
        }

        .right-center {
            width: 15px;
        }

        .right-title {
            width: 120px;
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

            table {
                page-break-inside: avoid;
                /* Hindari pemotongan tabel di dalam halaman */
            }


            .bg-0 {
                background-color: #dadde0;
                color: black
            }

            @page {
                size: A4;
                margin: 1.8cm 1cm 1.5cm 1.8cm;
                /* Anda bisa menyesuaikan margin sesuai kebutuhan */
            }
        }
    </style>
    <div class="content">
        <div class="row justify-content-end mb-4 g-4">
            <div class="col-md-3 mb-md-0 mb-3">
                <label for="periode_aktif" class="form-label fw-bold">Periode Aktif</label>
                <input type="text" readonly data-id="{{ $periode->idPeriode }}"
                    value="{{ $periode->semester }} {{ $periode->tahun }}" data-smt="{{ $periode->semester }}"
                    data-tahun="{{ $periode->tahun }}" class="form-control form-control-alt fw-semibold border-secondary"
                    id="periode_id">
            </div>
            <div class="col-md-3 mb-md-0 mb-3">
                <label for="kelas_diampu" class="form-label fw-bold">Kelas</label>
                <input type="text" readonly data-nama="{{ $kelas->namaKelas }}" data-fase="{{ $kelas->fase }}"
                    data-id="{{ $kelas->idKelas }}"
                    value="Kelas {{ $kelas->namaKelas }} ({{ $kelas_nama[$kelas->namaKelas - 1] ?? '' }})"
                    class="form-control form-control-alt fw-semibold border-secondary" id="kelas_diampu">
            </div>
        </div>
        {{-- <div class="row g-3 mb-4 justify-content-end">
            <div class="col-md-3 mb-md-0 mb-2">
                <label for="periode_id" class="form-label text-uppercase fw-bold fs-sm">Periode</label>
                <select class="form-select fw-medium" name="" id="periode_id">
                    <option value="{{ $periodeAktif->idPeriode }}" data-smt="{{ $periodeAktif->semester }}"
                        data-tahun="{{ $periodeAktif->tahun }}">
                        {{ $periodeAktif->semester }} {{ $periodeAktif->tahun }}
                    </option>
                    <option value="{{ $periodeLewat->idPeriode }}" data-smt="{{ $periodeLewat->semester }}"
                        data-tahun="{{ $periodeLewat->tahun }}">
                        {{ $periodeLewat->semester }} {{ $periodeLewat->tahun }}
                    </option>
                </select>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Rapor Siswa</h3>
                        <div class="block-options">
                            {{-- <button id="cetak_rp" type="button" class="btn btn-sm btn-primary">Cetak</button> --}}
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div
                            class="row bg-white border m-0 pb-3 rounded-4 g-3 mb-4 justify-content-center sticky-top-80 shadow-sm">
                            <div class="col-md-1">
                                <input type="text" readonly id="urut_siswa"
                                    class="text-center form-control form-control-lg border-dark">
                            </div>
                            <div class="col-md-5">
                                <select class="form-select form-select-lg border-dark" name="" id="data_siswa">
                                    <option value="">New Delhi</option>
                                    <option value="">Istanbul</option>
                                    <option value="">Jakarta</option>
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
                            <div class="col-md-2">
                                <button id="cetak_rp" type="button" class="btn btn-lg btn-primary w-100">Cetak</button>
                            </div>
                        </div>
                        <div class="mx-auto"
                            style="max-width:21.1cm; padding: 1.8cm 1cm 1.5cm 1.8cm; border: 1px dashed #4e4e4e;">
                            <div id="loading_spinner" class="text-center" style="display: none">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <div class="table-renponsive bg-white" id="ctk_rapor"></div>
                        </div>
                        @if ($periode ? $periode->semester == 'Ganjil' : '')
                            <div class="mx-auto mb-2" style="max-width:21.1cm;">
                                <small id="kode-tp" class="form-text text-muted"><span class="fw-bold">Catatan:
                                    </span>Pada periode semester <b>Ganjil</b> kolom Keterangan Kenaikan Kelas tidak akan di
                                    tampilakan!.</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function slectSiswa() {
                var periode = $('#periode_id').data('id');
                var kelas = $('#kelas_diampu').data('nama');
                $('#data_siswa').empty();
                // $('#urut_siswa').empty();
                $.ajax({
                    url: `{{ route('get-siswa.rapor') }}`,
                    type: 'GET',
                    data: {
                        idPeriode: periode,
                        namaKelas: kelas
                    },
                    success: function(data) {
                        var option;
                        $.each(data, function(i, siswa) {
                            option +=
                                `<option data-no="${i+1}" value="${siswa.idSiswa}">${siswa.namaSiswa}</option>`;
                        });
                        $('#data_siswa').append(option);
                        // $('#urut_siswa').val(no);
                        // console.log(no);
                    },
                    complete: function() {
                        $('#data_siswa').trigger('change');
                        $('#ortu_selected').trigger('change');
                    }
                });
            }

            function printDiv(idSiswa) {
                var periode = $('#periode_id').data('id');
                var periode_th = $('#periode_id').data('tahun');
                var periode_smt = $('#periode_id').data('smt');
                var kelas = $('#kelas_diampu').data('nama');
                var kelas_fs = $('#kelas_diampu').data('fase');
                var sekolah = {!! json_encode($sekolah) !!};

                var kls_romawi = ['I', 'II', 'III', 'IV', 'V', 'VI'];

                $('#ctk_rapor').empty();
                $('#loading_spinner').show();
                var tb;

                var kepsek = {!! json_encode($kepsek) !!};
                var guru_kelas = {!! json_encode($guru_kls) !!};

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
                                return '<u><pre>                   </pre></u>';
                            }
                        }

                        $('#ortu_selected').change(function() {
                            var ortu = getOrtu();
                            $(document).find('#ortu_ttd').html(
                                ortu); // Cetak nilai ortu setiap kali pilihan berubah
                        });

                        tb = `<table id="table_rapor" class="table_rapor table-sm table w-100 table-bordered border-dark mb-0">
                                    <tr class="border-0">
                                        <th colspan="4" class="p-0 pb-3 border-0">
                                            <h4 class="text-center text-uppercase mb-0" style="color: #000">Laporan Hasil
                                                Belajar<br>(Rapor)</h4>
                                        </th>
                                    </tr>
                                    <tr class="border-0">
                                        <th colspan="4" class="p-0 border-0">
                                            <table class="table table-borderless fw-normal">
                                                <tr>
                                                    <td class="m-0 p-0 pe-2 border-0" width="68%">
                                                        <div class="d-flex">
                                                            <div class="text-nowrap left-title">Nama Peserta Didik</div>
                                                            <div class="left-center">:</div>
                                                            <div class="left-end text-uppercase fw-bold">${siswa.namaSiswa}</div>
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
                                                            <div class="right-end">${kls_romawi[kelas - 1??'']}</div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="text-nowrap right-title">Fase</div>
                                                            <div class="right-center">:</div>
                                                            <div class="right-end">${kelas_fs}</div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="text-nowrap right-title">Semester</div>
                                                            <div class="right-center">:</div>
                                                            <div class="right-end">${periode_smt}</div>
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
                                    </tr>
                                </table>
                                <table class="table_rapor table-sm  table w-100 table-bordered border-dark">
                                    <tr class="text-center bg-0 border-dark">
                                        <th>No.</th>
                                        <th>Mata Pelajaran</th>
                                        <th width="9%" class="text-nowrap">Nilai Akhir</th>
                                        <th>Capaian Kompetensi</th>
                                    </tr>
                                `;

                        var mapel = data.mapel;
                        $.each(mapel, function(key, value) {
                            tb += `<tr class="align-middle">
                                        <td style="width:20px; min-width: 20px;" class="text-center">${key+1}</td>
                                        <td style="width:200px; min-width: 200px;">${value.mapel.namaMapel}</td>
                                        `;
                            var nilai = data.nilai.find(function(item) {
                                return item.idPengajaran === value.idPengajaran;
                            });
                            if (nilai) {
                                tb += `<td class="text-center" style="font-size:12pt;">${nilai.raport === 0 ? '' : nilai.raport}</td>
                                        <td class="p-0">
                                            <table class="table table-sm table11 m-0">
                                                <tr>
                                                    <td style="font-size:10pt; ${nilai.deskripsiCPtinggi === null ? 'padding: 15px' : ''}">${nilai.deskripsiCPtinggi === null ? '' : nilai.deskripsiCPtinggi}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:10pt; ${nilai.deskripsiCPrendah === null ? 'padding: 15px' : ''}">${nilai.deskripsiCPrendah === null ? '' : nilai.deskripsiCPrendah}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>`;
                            } else {
                                tb += `<td class="text-center"></td>
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

                        tb += `</table>
                        <table class="table_rapor table-sm  table w-100 table-bordered border-dark">
                                    <tr class="text-center bg-0 border-dark">
                                        <th>No.</th>
                                        <th>Ekstrakulikuler</th>
                                        <th>Keterangan</th>
                                    </tr>`;

                        var ekstra = data.kegiatan;
                        if (ekstra.length > 0) {
                            $.each(ekstra, function(key, value) {
                                tb += `<tr>
                                            <td style="width:20px; min-width: 20px;" class="text-center">${key +1}</td>
                                            <td style="width:240px; min-width: 240px;">${value.ekstra.ekstra}</td>
                                            <td>${value.deskripsi ?? ''}</td>
                                        </tr>`;
                            });
                        } else {
                            tb += `<tr>
                                        <td style="width:20px; min-width: 20px;" class="text-center">1</td>
                                        <td style="width:240px; min-width: 240px;"></td>
                                        <td></td>
                                    </tr>`;

                        }

                        tb += `</table>
                            <table class="table_rapor table-sm table w-100 table-bordered border-dark">
                                    <tr class="text-start bg-0 border-dark">
                                        <th>Catatan Guru</th>
                                    </tr>`;

                        var catatan = data.catatan;
                        if (catatan.length > 0) {
                            $.each(catatan, function(key, value) {
                                tb += `<tr>
                                            <td>${value.catatan_guru ?? ''}</td>
                                        </tr>`;
                            });
                        } else {
                            tb += `<tr>
                                        <td></td>
                                    </tr>`;
                        }

                        tb += `</table>`;
                        if (periode_smt == 'Genap') {
                            tb += `<table class="table_rapor table-sm table w-100 table-bordered border-dark">
                                    <tr class="text-start bg-0 border-dark">
                                        <th>Keterangan Kenaikan Kelas</th>
                                    </tr>`;
                            var keterangan = data.keterangan;
                            if ([keterangan].length > 0 && keterangan !== null) {
                                tb += `
                                <tr>
                                    <td>${keterangan.deskripsi ?? ''}</td>
                                </tr>`;
                            } else {
                                tb += `<tr>
                                        <td></td>
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

                        tb += `<table style="width:240px; min-width: 240px;"
                                    class="table_rapor table-sm table table-bordered border-dark">
                                    <tr class="text-start border-dark bg-0">
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
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <div class="flex-item">
                                                    <span>Mengetahui :</span><br>
                                                    <span>Orang Tua / Wali Murid,</span>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <span class="fw-bold" id="ortu_ttd"></span>
                                                </div>
                                                <div class="flex-item">
                                                    <br>
                                                    <span>Guru Kelas,</span>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <span class="fw-bold"><u>${guru_kelas.namaPegawai}</u></span><br>
                                                    <span>NIP.${guru_kelas.nip}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div class="flex-item">
                                                    <span>Mengetahui,</span><br>
                                                    <span>Kepala Sekolah</span>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                    <span class="fw-bold"><u>${[kepsek].length > 0 ? kepsek.namaPegawai : ''}</u></span><br>
                                                    <span>NIP.${[kepsek].length > 0 ? kepsek.nip : ''}</span>
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


            $(document).ready(function() {
                slectSiswa();
                // printDiv();
                $('#data_siswa').change(function(e) {
                    e.preventDefault();
                    var no = $('#data_siswa option:selected').data('no');
                    var id = $('#data_siswa option:selected').val();
                    $('#urut_siswa').val(no);
                    printDiv(id);

                });
                $('#cetak_rp').on('click', function() {
                    $("#ctk_rapor").printThis({
                        debug: false, // show the iframe for debugging
                        importCSS: true,
                        importStyle: true, // import style tags
                    });
                });

                // Event listener untuk mencetak nilai ortu setiap kali pilihan berubah

                // $('#table_rapor').DataTable({
                //     ajax: "{{ route('siswa.get-data') }}",
                //     columns: [{
                //             data: 'nomor',
                //             name: 'nomor',
                //             className: 'text-center'
                //         }, {
                //             data: 'nis',
                //             name: 'nis'
                //         }, {
                //             data: 'nama',
                //             name: 'nama'
                //         },  {
                //             data: 'jenisKelamin',
                //             name: 'jenisKelamin',
                //             className: 'text-center'
                //         }, 
                //         {
                //             data: null,
                //             className: 'text-center',
                //             render: function(data, type, row) {
                //                 return '<div class="btn-group">' +
                //                     '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editSiswa" value="' +
                //                     data.idSiswa + '">' +
                //                     '<i class="fa fa-fw fa-pencil-alt"></i></button></div>';
                //             }
                //         }
                //     ],
                //     dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                //         "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                //         "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                //     lengthMenu: [10, 25, 50, 100],
                // });
            });
        </script>
    @endpush
@endsection
