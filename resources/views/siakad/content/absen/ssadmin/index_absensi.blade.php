@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    @push('style')
        <style>
            #content_kehadiran {
                font-family: 'Times New Roman', Times, serif;
            }

            #table_bulanan {
                font-family: 'Times New Roman', Times, serif;
            }
        </style>
    @endpush
    <div class="content">
        <div class="row g-3">
            <div class="col-lg-9 col-12 order-lg-1 order-2">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h4 class="block-title">Rekap Kehadiran</h4>
                        <div class="block-options">
                            <button type="button" class="btn-block-option me-1" data-toggle="block-option"
                                data-action="fullscreen_toggle"></button>
                            <button type="button" id="cetak_rekap" class="btn btn-sm btn-primary">
                                Cetak
                            </button>
                        </div>
                    </div>
                    <div id="content_kehadiran" class="block-content block-content-full">
                        <div class="table-responsive d-none">
                            <table id="daftarKehadiran"
                                class="table w-100 table-sm table-bordered border-dark align-middle">
                                <thead class="align-middle text-center border-dark">
                                    <tr>
                                        <h4 class="text-center fw-normal mb-4">
                                            <span>REKAP KEHADIRAN PESERTA DIDIK</span><br>
                                            <strong>SD NEGERI LEMAHBANG</strong><br>
                                            <span class="tahun-plj"><!-- tahun pelajaran --></span>
                                        </h4>
                                        <strong class="text-start mb-2 kelas-nama"></strong>
                                        <strong class="float-end mb-2 text-uppercase semester"></strong>
                                    </tr>
                                    <tr>
                                        <th rowspan="3">No</th>
                                        <th rowspan="3">NIS</th>
                                        <th rowspan="3" style="min-width: 250px;">Nama</th>
                                        <th rowspan="3">L/P</th>
                                        <th colspan="24">Bulan</th>
                                        <th rowspan="2" colspan="4">Total</th>
                                    </tr>
                                    <tr id="namaBulan">
                                        {{-- daftar bulan --}}
                                    </tr>
                                    <tr id="ketPresensi">
                                        {{-- keterangan presensi siswa --}}
                                        <th class="total" style="min-width: 30px;">H</th>
                                        <th class="total" style="min-width: 30px;">S</th>
                                        <th class="total" style="min-width: 30px;">I</th>
                                        <th class="total" style="min-width: 30px;">A</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- content data kehadiran --}}
                                </tbody>
                            </table>
                            <div id="ttd_presensi" hidden class="row m-0 mt-4 text-center">
                                <div class="col-6 align-middle">
                                    <span>Mengetahui <br>Kepala Sekolah</span><br><br><br><br><br>
                                    <strong class="text-uppercase"><u>{{ $kepsek->namaPegawai }}</u></strong><br>
                                    <span class="text-uppercase">NIP.{{ $kepsek->nip }}</span>
                                </div>
                                <div class="col-6">
                                    <span>
                                        Magetan,
                                        <span id="tgl_ttd">{{ Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                                        <a href="javascript:void(0)" class="link-info ms-1" id="change_tgl"
                                            data-bs-toggle="tooltip" data-bs-title="Ubah Tanggal"><i
                                                class="fs-sm fa-solid fa-calendar-days"></i></a>
                                        <br>
                                        Wali Kelas
                                    </span>
                                    <br><br><br><br><br>
                                    <strong class="text-uppercase wali-kelas"></strong><br>
                                    <span class="text-uppercase nip-wakel"></span>
                                </div>
                            </div>
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
                                        <option {{ $item->status == 'Aktif' ? 'selected' : '' }}
                                            value="{{ $item->idPeriode }}">{{ $item->semester }} {{ $item->tahun }}
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
                            {{-- <div class="col-lg-12 col-3">
                                <label for="" class="form-label">Tanggal</label>
                                <input type="text" readonly class="form-control" name="" id="tgl_aktif"
                                    aria-describedby="helpId" placeholder="Pilih Tanggal" />
                            </div> --}}
                            <div class="col-lg-12 col-3">
                                <label for="" class="form-label">Setting</label>
                                <div class="form-check form-switch" id="bt-swc">
                                    <input class="form-check-input" type="checkbox" id="btn_ttd_switch">
                                    <label class="form-check-label fs-sm" for="btn_ttd_switch">Tampilkan Baris TTD</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal absen bulanan --}}
    <div class="modal fade" id="modal_presebsi_bulan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal_presebsi_bulan" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"></h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option"
                                data-action="fullscreen_toggle"></button>
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <div class="mb-3 text-end">
                            <div class="row justify-content-end">
                                <div class="col">
                                    <button class="btn btn-primary" id="cetak_bulanan" type="button">Cetak</button>
                                    <div class="mt-2">
                                        <div class="form-check form-switch form-check-reverse">
                                            <input class="form-check-input" type="checkbox" id="btn_ttd_switch_2">
                                            <label class="form-check-label fs-sm" for="btn_ttd_switch">Tampilkan Baris
                                                TTD</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 table-responsive" id="table_bulanan">
                            {{-- conten tabel kehadiran bulanan --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal change tanggal --}}
    <div class="modal fade" id="modal_change_tanggal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal_change_tanggal" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Ubah Tanggal TTD</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <div class="mb-4">
                            <input type="text" readonly class="form-control" id="thl_check"
                                placeholder="Pilih Tanggal" />
                        </div>
                        <div class="mb-3 text-end ">
                            <button type="button" id="sv_tgl" class="btn btn-primary">
                                Ubah Tanggal
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
                $.ajax({
                    type: "GET",
                    url: `{{ route('form.kelas') }}`,
                    data: {
                        periode: $('#periode').val()
                    },
                    success: function(data) {
                        $('#kelas').empty();
                        $.each(data.kelas, function(i, item) {
                            $('#kelas').append(
                                `<option value="${item.namaKelas}" data-nip="${item.guru.nip}" data-wakel="${item.guru.namaPegawai}">Kelas ${item.namaKelas}</option>`
                            );
                            if (i === 0) {
                                $('#kelas').find('option').attr('selected', 'selected');
                                let selectedWakel = $('#kelas').find('option:selected').data('wakel');
                                let nip = $('#kelas').find('option:selected').data('nip');
                                $('#wali_kelas').val(selectedWakel);
                                $('.wali-kelas').html(`<u>${selectedWakel}</u>`);
                                $('.nip-wakel').text('NIP.' + nip);
                                getRekap();
                            }
                        });
                    },
                });
            }

            function getRekap() {
                let periode = $('#periode').find('option:selected').val();
                let kelas = $('#kelas').find('option:selected').val();
                // let tgl = $('#tgl_aktif').val();
                $.ajax({
                    type: 'GET',
                    url: `{{ url('akademik/presensi/rekap/${periode}/${kelas}') }}`,
                    success: function(data) {
                        $('#content_kehadiran div').removeClass('d-none');
                        // ambil periode
                        if (data.periode && data.periode.tahun && data.periode.semester) {
                            let per = data.periode.tahun;
                            let smt = data.periode.semester;
                            $('.tahun-plj').text('TAHUN PELAJARAN ' + per);
                            $('.semester').text('SEMESTER : ' + smt);
                        }
                        // ambil kelas
                        let kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                        if ($('#kelas').val()) {
                            let kls = $('#kelas').val();
                            $('.kelas-nama').text('KELAS : ' + kls + ' (' + kls_name[kls - 1 ?? ''] + ')');
                        }
                        $('#namaBulan').empty();
                        $('#daftarKehadiran tbody').empty();
                        $('#ketPresensi').find('th').not('.total').remove();


                        $.each(data.bulan, function(key, value) {
                            // perulangan nama bulan
                            $('#namaBulan').append(
                                `<th colspan="4">
                                    <a href="javascript:void(0)" class="nav-link" data-bulan="${value}" id="cek_rekapBulan" data-bs-toggle="tooltip" data-bs-title="Rekap Kehadiran Bulan ${value}">${value}</a>
                                </th>`
                            );

                            // perilangan keterangan presensi
                            $('#ketPresensi').append(`
                                <th style="min-width: 30px;">H</th>
                                <th style="min-width: 30px;">S</th>
                                <th style="min-width: 30px;">I</th>
                                <th style="min-width: 30px;">A</th>
                            `);
                        });

                        $.each(data.siswa, function(key, value) {
                            let barisPresensi = `<tr>
                                <td class="text-center fs-sm ">${key + 1}</td>
                                <td class="fs-sm text-center">${value.nis}</td>
                                <td class="fs-sm text-nowrap">${value.namaSiswa}</td>
                                <td class="fs-sm text-center">${value.jenisKelamin === 'Laki-Laki' ? 'L' : 'P'}</td>
                            `;

                            let dfBulan = data.bulan.length;
                            let absen = data.absensi;
                            $.each(data.bulan, function(key, bulan) {
                                let kehadiran = data.absensi;
                                let jmlHadir = kehadiran.filter(function(presensi) {
                                    return presensi.idSiswa === value.idSiswa &&
                                        presensi.bulan === bulan &&
                                        presensi.presensi === 'H';
                                }).length;

                                // Pastikan setiap nilai presensi ditampilkan dalam tabel
                                let jmlSakit = kehadiran.filter(function(presensi) {
                                    return presensi.idSiswa === value.idSiswa && presensi
                                        .bulan === bulan && presensi.presensi === 'S';
                                }).length;

                                let jmlIzin = kehadiran.filter(function(presensi) {
                                    return presensi.idSiswa === value.idSiswa && presensi
                                        .bulan === bulan && presensi.presensi === 'I';
                                }).length;

                                let jmlAlpa = kehadiran.filter(function(presensi) {
                                    return presensi.idSiswa === value.idSiswa && presensi
                                        .bulan === bulan && presensi.presensi === 'A';
                                }).length;

                                // Mengisi baris tabel dengan nilai yang sesuai
                                barisPresensi += `
                                    <td class="text-center">${jmlHadir == 0 ? '' : jmlHadir}</td>
                                    <td class="text-center">${jmlSakit == 0 ? '' : jmlSakit}</td>
                                    <td class="text-center">${jmlIzin == 0 ? '' : jmlIzin}</td>
                                    <td class="text-center">${jmlAlpa == 0 ? '' : jmlAlpa}</td>
                                `;
                            });

                            let totHadir = absen.filter(function(presensi) {
                                return presensi.idSiswa === value.idSiswa &&
                                    presensi.noBulan >= 1 &&
                                    presensi.noBulan <= dfBulan &&
                                    presensi.presensi === 'H';
                            }).length;
                            let totSakit = absen.filter(function(presensi) {
                                return presensi.idSiswa === value.idSiswa &&
                                    presensi.noBulan >= 1 &&
                                    presensi.noBulan <= dfBulan &&
                                    presensi.presensi === 'S';
                            }).length;
                            let totIzin = absen.filter(function(presensi) {
                                return presensi.idSiswa === value.idSiswa &&
                                    presensi.noBulan >= 1 &&
                                    presensi.noBulan <= dfBulan &&
                                    presensi.presensi === 'I';
                            }).length;
                            let totAlfa = absen.filter(function(presensi) {
                                return presensi.idSiswa === value.idSiswa &&
                                    presensi.noBulan >= 1 &&
                                    presensi.noBulan <= dfBulan &&
                                    presensi.presensi === 'A';
                            }).length;
                            let total = `
                                    <td class="text-center">${totHadir}</td>
                                    <td class="text-center">${totSakit}</td>
                                    <td class="text-center">${totIzin}</td>
                                    <td class="text-center">${totAlfa}</td>
                                    </tr>
                                    `;

                            $('#daftarKehadiran tbody').append(barisPresensi + total);
                        });
                    }
                });
            }

            function getRekapBulanan(bulan) {
                let periode = $('#periode').find('option:selected').val();
                let kelas = $('#kelas').find('option:selected').val();
                // let tgl = $('#tgl_aktif').val();
                $('#table_bulanan').empty();
                $.ajax({
                    type: 'GET',
                    url: `{{ url('akademik/presensi/rekap/${periode}/${kelas}') }}`,
                    success: function(data) {
                        let tp = data.periode.tahun;
                        let bln = bulan;
                        let kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                        let kls;
                        if ($('#kelas').val()) {
                            kls = $('#kelas').val();
                        }
                        let tableHTML = `<table class="table table-sm table-bordered border-dark w-100 align-middle">
                            <thead class="align-middle text-center border-dark">
                                <tr>
                                    <h4 class="text-center fw-normal mb-4">
                                        <span>DAFTAR HADIR PESERTA DIDIK</span><br>
                                        <strong>SD NEGERI LEMAHBANG</strong><br>
                                        <span class="tahun-plj">TAHUN PELAJARAN ${tp}</span>
                                    </h4>
                                    <strong class="text-start mb-2 kelas-nama">KELAS : ${kls} (${kls_name[kls - 1 ?? '']})</strong>
                                    <strong class="float-end mb-2 text-uppercase bulanan">BULAN : ${bln}</strong>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="width: 30px;">NO</th>
                                    <th rowspan="2" style="width: 40px;">NIS</th>
                                    <th rowspan="2">NAMA</th>
                                    <th rowspan="2" style="width: 35px;">L/P</th>
                                    <th colspan="31">Tanggal</th>
                                    <th colspan="4">Jumlah</th>
                                </tr>
                                <tr>`;
                        // Tambahkan tanggal pada baris kedua
                        for (let i = 1; i <= 31; i++) {
                            tableHTML += `<th style="min-width: 30px;">${i}</th>`;
                        }

                        // Tutup tag <tr> dan <thead>
                        tableHTML += `<th style="min-width: 30px;">H</th>
                                    <th style="min-width: 30px;">S</th>
                                    <th style="min-width: 30px;">I</th>
                                    <th style="min-width: 30px;">A</th>
                                </tr>
                            </thead>
                            <tbody>`;

                        $.each(data.siswa, function(key, value) {
                            let kehadiran = data.absensi;
                            tableHTML += `<tr>
                                <td class="text-center fs-sm ">${key + 1}</td>
                                <td class="fs-sm text-center">${value.nis}</td>
                                <td class="fs-sm text-nowrap">${value.namaSiswa}</td>
                                <td class="fs-sm text-center">${value.jenisKelamin === 'Laki-Laki' ? 'L' : 'P'}</td>`;

                            for (let i = 1; i <= 31; i++) {
                                let presensi = kehadiran.find(function(item) {
                                    return item.idSiswa === value.idSiswa && item.bulan === bln &&
                                        item.tanggal === i;
                                });
                                if (presensi) {
                                    tableHTML += `<td class="fs-sm text-center">${presensi.presensi}</td>`;
                                } else {
                                    tableHTML += `<td></td>`;
                                }
                            }

                            let jmlHadir = kehadiran.filter(function(item) {
                                return item.idSiswa === value.idSiswa &&
                                    item.bulan === bln &&
                                    item.presensi === 'H';
                            }).length;
                            let jmlSakit = kehadiran.filter(function(item) {
                                return item.idSiswa === value.idSiswa &&
                                    item.bulan === bln &&
                                    item.presensi === 'S';
                            }).length;
                            let jmlIzin = kehadiran.filter(function(item) {
                                return item.idSiswa === value.idSiswa &&
                                    item.bulan === bln &&
                                    item.presensi === 'I';
                            }).length;
                            let jmlAlfa = kehadiran.filter(function(item) {
                                return item.idSiswa === value.idSiswa &&
                                    item.bulan === bln &&
                                    item.presensi === 'A';
                            }).length;

                            tableHTML += `<td class="fs-sm text-center">${jmlHadir}</td>
                                <td class="fs-sm text-center">${jmlSakit}</td>
                                <td class="fs-sm text-center">${jmlIzin}</td>
                                <td class="fs-sm text-center">${jmlAlfa}</td>`;

                            tableHTML += '</tr>';

                        });

                        tableHTML += `</tbody></table>`;

                        let kepsek = {!! json_encode($kepsek) !!};
                        let tgl = {!! json_encode(Carbon\Carbon::now()->translatedFormat('d F Y')) !!};
                        let selectedWakel = $('#kelas').find('option:selected').data('wakel');
                        let nip = $('#kelas').find('option:selected').data('nip');
                        let ttd = `<div id="ttd_presensi_2" hidden class="row m-0 mt-4 text-center">
                                <div class="col-6 align-middle">
                                    <span>Mengetahui <br>Kepala Sekolah</span><br><br><br><br><br>
                                    <strong class="text-uppercase"><u>${kepsek.namaPegawai}</u></strong><br>
                                    <span class="text-uppercase">NIP.${kepsek.nip}</span>
                                </div>
                                <div class="col-6">
                                    <span>
                                        Magetan,
                                        <span id="tgl_ttd_2">${tgl}</span>
                                        <a href="javascript:void(0)" class="link-info ms-1" id="change_tgl_2"
                                            data-bs-toggle="tooltip" data-bs-title="Ubah Tanggal"><i
                                                class="fs-sm fa-solid fa-calendar-days"></i></a>
                                        <br>
                                        Wali Kelas
                                    </span>
                                    <br><br><br><br><br>
                                    <strong class="text-uppercase"><u>${selectedWakel}</u></strong><br>
                                    <span class="text-uppercase">NIP : ${nip}</span>
                                </div>
                            </div>`;

                        $('#table_bulanan').prepend(tableHTML + ttd);

                    }
                });
            }

            $('#btn_ttd_switch').on('change', function() {
                if ($('#ttd_presensi').is(':hidden')) {
                    $('#ttd_presensi').prop('hidden', false);
                    $('#bt-swc .form-check-label').text('Sembunyikan Baris TTD');
                } else {
                    $('#ttd_presensi').prop('hidden', true);
                    $('#bt-swc .form-check-label').text('Tampilkan Baris TTD');
                }
            });
            $('#btn_ttd_switch_2').on('change', function() {
                if ($('#ttd_presensi_2').is(':hidden')) {
                    $('#ttd_presensi_2').prop('hidden', false);
                    $('#modal_presebsi_bulan .form-check-label').text('Sembunyikan Baris TTD');
                } else {
                    $('#ttd_presensi_2').prop('hidden', true);
                    $('#modal_presebsi_bulan .form-check-label').text('Tampilkan Baris TTD');
                }
            });


            $('#change_tgl').click(function() {
                $('#modal_change_tanggal').modal('show');
                $('#sv_tgl').click(function() {
                    $('#modal_change_tanggal').modal('hide');
                    let tgl = $('#thl_check').val();
                    $('#tgl_ttd').text(tgl);
                });
            });

            $(document).on('click', '#change_tgl_2', function() {
                $('#modal_change_tanggal').modal('show');
                $('#modal_change_tanggal').addClass('mt-6');
                $('#modal_change_tanggal .modal-dialog').addClass('rounded-2 shadow');
                // $('#modal_presebsi_bulan').addClass('z-0');
                $('#sv_tgl').click(function() {
                    $('#modal_change_tanggal').modal('hide');
                    let tgl = $('#thl_check').val();
                    $('#tgl_ttd_2').text(tgl);
                });
            });

            $('#modal_change_tanggal').on('hidden.bs.modal', function() {
                $('#thl_check').val('');
                $('#modal_change_tanggal').removeClass('mt-6');
                $('#modal_change_tanggal .modal-dialog').removeClass('rounded-2 shadow');
            });


            $(document).on('click', '#cek_rekapBulan', function() {
                let bln = $(this).data('bulan');
                $('#modal_presebsi_bulan').modal('show');
                getRekapBulanan(bln);
                $('#modal_presebsi_bulan .block-header .block-title').text('Rekap Kehadiran Bulan ' + bln);
            });
            
            $('#modal_presebsi_bulan').on('hidden.bs.modal', function() {
                if ($('#btn_ttd_switch_2').is(':checked')) {
                    $('#btn_ttd_switch_2').prop('checked', false);
                }
            });

            $(document).ready(function() {
                new AirDatepicker('#thl_check', {
                    // selectedDates: [new Date()],
                    container: "#modal_change_tanggal",
                    dateFormat: "dd MMMM yyyy",
                });
                // new AirDatepicker('#tgl_aktif', {
                //     selectedDates: [new Date()],
                //     dateFormat: "dd MMMM yyyy",
                //     onSelect: function(formattedDate, date, inst) {
                //         // Trigger your jQuery function here
                //         yourjQueryFunction(formattedDate);
                //     },
                // });
                // getRekap();
                $('#kelas').change(function() {
                    getRekap();
                    $('#wali_kelas').val('');
                    let selectedWakel = $(this).find('option:selected').data('wakel');
                    let nip = $(this).find('option:selected').data('nip');
                    $('#wali_kelas').val(selectedWakel);
                    $('.wali-kelas').html(`<u>${selectedWakel}</u>`);
                    $('.nip-wakel').text('NIP.' + nip);
                    $('#na_wali').html(`<u>${selectedWakel}</u>`);
                    $('#nip_wali').text('NIP.' + nip);
                });
                getSelectKelas();
                $("#periode").change(function() {
                    getRekap();
                    getSelectKelas();
                });

                // function yourjQueryFunction(formattedDate) {
                //     getRekap();

                //     // Replace this with your actual jQuery function code
                //     console.log("Selected date:", formattedDate);
                // }               
                $(document).on('mouseenter', '#cek_rekapBulan', function() {
                    $(this).tooltip();
                });

                $('#cetak_rekap').click(function() {
                    var printContents = $('#content_kehadiran').html();
                    var originalContents = $('body').html();
                    $('body').empty().css({
                        'font-family': '\'Times New Roman\', Times, serif',
                        'font-size': '12pt',
                    }).html(printContents);
                    $('#change_tgl').addClass(
                        'd-none'); // Menambahkan kelas d-none pada elemen dengan id change_tgl
                    window.print();
                    location.reload();
                });
                $('#cetak_bulanan').click(function() {
                    var printContents = $('#table_bulanan').html();
                    var originalContents = $('body').html();
                    $('body').empty().css({
                        'font-family': '\'Times New Roman\', Times, serif',
                        'font-size': '12pt',
                    }).html(printContents);
                    $('#change_tgl_2').addClass(
                        'd-none'); // Menambahkan kelas d-none pada elemen dengan id change_tgl
                    window.print();
                    location.reload();
                });

                // $('[data-bs-toggle="tooltip"]').tooltip();
            });
        </script>
    @endpush
@endsection
