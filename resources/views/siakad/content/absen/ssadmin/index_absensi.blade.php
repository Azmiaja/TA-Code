@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    @push('style')
        <style>
            #content_kehadiran,
            #table_bulanan {
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
                    color: #000;
                }

                body {
                    background-color: #fff;
                    font-family: 'Times New Roman', Times, serif;
                    font-size: 12pt;
                    width: 100%;
                }

                .bt-show-modal,
                #change_tgl,
                #change_tgl_2 {
                    display: none;
                }


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
                        <div id="loading_spinner_2" class="text-center" style="display: none;">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                        <div class="table-responsive d-none" id="tabel_kehadiran_bulanan">
                            <table id="daftarKehadiran"
                                class="table w-100 table-sm table-bordered border-dark align-middle">
                                <thead class="align-middle text-center border-dark">
                                    <tr class="border-0">
                                        <th class="border-0 p-0" colspan="32">
                                            <h4 class="text-center fw-normal mb-4" style="font-size: 14pt;">
                                                <span>REKAP KEHADIRAN PESERTA DIDIK</span><br>
                                                <strong>SD NEGERI LEMAHBANG</strong><br>
                                                <span class="tahun-plj"><!-- tahun pelajaran --></span>
                                            </h4>
                                            <div class="d-flex justify-content-between">
                                                <strong class="text-start mb-2 kelas-nama"></strong>
                                                <strong class="float-end mb-2 text-uppercase semester"></strong>
                                            </div>
                                        </th>
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
                                <tfoot id="ttd_presensi" hidden>
                                    <tr class="border-0">
                                        <th colspan="32" class="text-center border-0 p-0">
                                            <div class="d-flex justify-content-around mt-4">
                                                <div class="fw-normal">
                                                    <span>Mengetahui <br>Kepala Sekolah</span><br><br><br><br><br>
                                                    <strong><u>{{ $kepsek->namaPegawai }}</u></strong><br>
                                                    <span>NIP.{{ $kepsek->nip }}</span>
                                                </div>
                                                <div class="fw-normal">
                                                    <span>
                                                        Magetan,
                                                        <span
                                                            id="tgl_ttd">{{ Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                                                        <a href="javascript:void(0)" class="link-info ms-1" id="change_tgl"
                                                            data-bs-toggle="tooltip" data-bs-title="Ubah Tanggal"><i
                                                                class="fs-sm fa-solid fa-calendar-days"></i></a>
                                                        <br>
                                                        Wali Kelas
                                                    </span>
                                                    <br><br><br><br><br>
                                                    <strong class="wali-kelas"></strong><br>
                                                    <span class="nip-wakel"></span>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
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
                                            value="{{ $item->idPeriode }}" data-tgmulai="{{ $item->tanggalMulai }}">
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
                        <div id="loading_spinner_3" class="text-center" style="display: none;">
                            <div class="spinner-border text-primary" role="status"></div>
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

    {{-- MODAL INSERT --}}
    <div class="modal fade" id="modal_absen_siswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalAbsen" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content border shadow-lg">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"></h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <form action="" method="POST" enctype="multipart/form-data" id="form_absensi">
                            @csrf
                            <input type="hidden" name="_method" id="method" value="POST">
                            <input type="hidden" name="idPeriode" class="form-control" value="">
                            <input type="hidden" name="idKelas" class="form-control" value="">
                            <input type="hidden" name="idPegawai" class="form-control" value="">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="tanggal_absen" class="col-sm-2 col-form-label">Tanggal</label>
                                        <div class="col-7">
                                            <input type="text" placeholder="PIlih Tanggal" id="tanggal_absen"
                                                name="tanggal" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end ">
                                    <div id="btn_switch" hidden class="form-check form-switch form-check-reverse mt-auto">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Aktifkan
                                            pengubahan
                                            data</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive mb-3">
                                    <table class="table align-middle table-borderless caption-top table-hover w-100">
                                        <caption class="fs-6 fw-medium mb-1 text-dark"></caption>
                                        <thead class="table-transparent">
                                            <tr>
                                                <th class="text-center" style="width: 5%;"></th>
                                                {{-- <th style="width: 10%;">NIS</th> --}}
                                                <th></th>
                                                <th style="width: 8%;" class="text-center">
                                                    <input type="checkbox" class="form-check-input border-dark"
                                                        title="Hadir Semua" id="pilih_semua"
                                                        style="width: 1.4rem; height: 1.4rem;">
                                                </th>
                                                <th style="width: 8%;" class="text-center">Izin</th>
                                                <th style="width: 8%;" class="text-center">Sakit</th>
                                                <th style="width: 8%;" class="text-center">Alpha</th>
                                            </tr>
                                        </thead>
                                        <tbody id="daftar_siswa">
                                            <div id="loading_spinner" class="text-center" style="display: none;">
                                                <div class="spinner-border text-primary" role="status"></div>
                                            </div>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col text-end btn-form mb-4">
                                    <button type="submit" id="btn_absen" class="btn btn-alt-success">Simpan
                                        Presensi</button>
                                </div>
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
            const modalAbsen = $('#modal_absen_siswa');
            const formAbsen = $('#form_absensi');
            const method = $('#method');

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
                                `<option value="${item.namaKelas}" data-id="${item.idKelas}" data-nip="${item.guru.nip}" data-wakel="${item.guru.namaPegawai}" data-idguru="${item.guru.idPegawai}">Kelas ${item.namaKelas}</option>`
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
                $('#loading_spinner_2').show();
                $('#tabel_kehadiran_bulanan').addClass('d-none');
                $.ajax({
                    type: 'GET',
                    url: `{{ url('akademik/presensi/rekap/${periode}/${kelas}') }}`,
                    success: function(data) {
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
                                `<th colspan="4">${value}
                                    <button id="cek_rekapBulan" type="button"
                                    class="ms-1 btn btn-sm btn-success p-0 bt-show-modal" data-bs-toggle="tooltip"
                                    data-bs-title="Lihat Rekap Kehadiran Siswa Bulan ${value}"
                                    data-bulan="${value}" style="font-size: .7rem;">
                                    <i class="fa-solid fa-right-to-bracket m-1"></i></button>
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
                                    <td class="text-center">${jmlHadir === 0 ? '' : jmlHadir}</td>
                                    <td class="text-center">${jmlSakit === 0 ? '' : jmlSakit}</td>
                                    <td class="text-center">${jmlIzin === 0 ? '' : jmlIzin}</td>
                                    <td class="text-center">${jmlAlpa === 0 ? '' : jmlAlpa}</td>
                                `;
                            });

                            let totHadir = absen.filter(function(presensi) {
                                return presensi.idSiswa === value.idSiswa &&
                                    presensi.presensi === 'H';
                            }).length;
                            let totSakit = absen.filter(function(presensi) {
                                return presensi.idSiswa === value.idSiswa &&
                                    presensi.presensi === 'S';
                            }).length;
                            let totIzin = absen.filter(function(presensi) {
                                return presensi.idSiswa === value.idSiswa &&
                                    presensi.presensi === 'I';
                            }).length;
                            let totAlfa = absen.filter(function(presensi) {
                                return presensi.idSiswa === value.idSiswa &&
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
                    },
                    complete: function() {
                        $('#tabel_kehadiran_bulanan').removeClass('d-none');
                        $('#loading_spinner_2').hide();
                    }
                });
            }

            function getRekapBulanan(bulan) {
                let periode = $('#periode').find('option:selected').val();
                let kelas = $('#kelas').find('option:selected').val();
                // let tgl = $('#tgl_aktif').val();
                $('#loading_spinner_3').show();
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
                            kls = $('#kelas').find('option:selected').val();
                        }
                        let tableHTML = `<table id="tabel_bulan" class="table table-sm table-bordered border-dark w-100 align-middle">
                            <thead class="align-middle text-center border-dark">
                                <tr class="border-0">
                                    <th class="border-0 p-0" colspan="39">
                                        <h4 class="text-center fw-normal mb-4" style="font-size:14pt;">
                                            <span>DAFTAR HADIR PESERTA DIDIK</span><br>
                                            <strong>SD NEGERI LEMAHBANG</strong><br>
                                            <span class="tahun-plj">TAHUN PELAJARAN ${tp}</span>
                                        </h4>
                                        <div class="d-flex justify-content-between">
                                            <strong class="text-start mb-2 kelas-nama">KELAS : ${kls} (${kls_name[kls - 1 ?? '']})</strong>
                                            <strong class="float-end mb-2 text-uppercase bulanan">BULAN : ${bln}</strong>
                                        </div>
                                    </th>
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
                            tableHTML +=
                                `<th style="min-width: 30px;">
                                    <a href="javascript:void(0)" id="ubah_absen" 
                                                    data-tgl="${i}"
                                                    data-bln="${bln}" 
                                                    class="nav-link" data-bs-toggle="tooltip"
                                                    data-bs-title="Ubah kehadiran siswa tanggal ${i} ${bln}.">${i}</a></th>`;
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

                        let kepsek = {!! json_encode($kepsek) !!};
                        let tgl = {!! json_encode(Carbon\Carbon::now()->translatedFormat('d F Y')) !!};
                        let selectedWakel = $('#kelas').find('option:selected').data('wakel');
                        let nip = $('#kelas').find('option:selected').data('nip');

                        tableHTML += `</tbody>
                                <tfoot id="ttd_presensi_2" hidden>
                                    <tr class="border-0">
                                        <th class="border-0 p-0" colspan="39">
                                            <div class="d-flex justify-content-around text-center mt-4">
                                                <div class="fw-normal">
                                                    <span>Mengetahui <br>Kepala Sekolah</span><br><br><br><br><br>
                                                    <strong><u>${kepsek.namaPegawai}</u></strong><br>
                                                    <span>NIP.${kepsek.nip}</span>
                                                </div>
                                                <div class="fw-normal">
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
                                                    <strong><u>${selectedWakel}</u></strong><br>
                                                    <span>NIP : ${nip}</span>
                                                </div>
                                            </div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>`;

                        $('#table_bulanan').prepend(tableHTML);

                    },
                    complete: function() {
                        $('#loading_spinner_3').hide();
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

                $(document).on('mouseenter', '#show_modal', function() {
                    $(this).tooltip();
                });
                $(document).on('mouseenter', '#ubah_absen', function() {
                    $(this).tooltip();
                });
                new AirDatepicker('#thl_check', {
                    // selectedDates: [new Date()],
                    container: "#modal_change_tanggal",
                    dateFormat: "dd MMMM yyyy",
                });

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

                $(document).on('mouseenter', '#cek_rekapBulan', function() {
                    $(this).tooltip();
                });

                $('#cetak_rekap').click(function() {
                    $('#daftarKehadiran').printThis({
                        debug: false, // show the iframe for debugging
                        importCSS: true,
                        importStyle: true,
                    });
                });
                $('#cetak_bulanan').click(function() {
                    $('#tabel_bulan').printThis({
                        debug: false, // show the iframe for debugging
                        importCSS: true,
                        importStyle: true,
                    });
                });

                modalAbsen.on('hidden.bs.modal', function() {
                    $('#tanggal_absen').prop('disabled', false);
                    $('#tanggal_absen').val(null);
                    $('#btn_switch input[type="checkbox"]').prop('checked', false);
                    $(this).find('#rm_presensi').remove();
                    if ($('#pilih_semua').is(':checked')) {
                        document.getElementById("pilih_semua").checked = false;
                    }
                });

                modalAbsen.on('show.bs.modal', function() {
                    $('#pilih_semua').change(function() {
                        if ($(this).is(':checked')) {
                            modalAbsen.find('.hadir').prop('checked', true);
                        } else {
                            modalAbsen.find('.hadir').prop('checked', false);
                        }
                    });
                });

                $(document).on('click', '#ubah_absen', function(e) {
                    e.preventDefault();
                    modalAbsen.modal('show');

                    var periode = $('#periode').find('option:selected').val();
                    var kelas = $('#kelas').find('option:selected').val();
                    var idKelas = $('#kelas').find('option:selected').data('id');
                    var idPegawai = $('#kelas').find('option:selected').data('idguru');

                    $('#loading_spinner').show();
                    $('#tanggal_absen').prop('disabled', true);

                    moment.locale('id');
                    var bulan = $(this).data('bln');
                    var month = moment().month(bulan).format("M");
                    var tanggalSelect = $(this).data('tgl');

                    $.ajax({
                        type: "GET",
                        url: `{{ url('get/siswa/absen/${kelas}/${periode}') }}`,
                        data: {
                            tanggal: tanggalSelect,
                            bulan: month
                        },
                        success: function(data) {
                            let bulanIN = moment().month(bulan).format('MMMM');
                            let tahun = moment($('#periode').find('option:selected').data(
                                    'tgmulai'))
                                .format('YYYY');
                            // tangggal selected default
                            let tgAvtive = tanggalSelect + ' ' + bulanIN + ' ' + tahun;
                            // set-up tanggal on absen 
                            moment.locale('id');
                            var tanggal_absen_update = '';
                            if (data.absen.length !== 0) {
                                tanggal_absen_update = moment(data.absen[0].tgl).format(
                                    'DD MMMM YYYY');
                                method.val('PUT');
                            } else {
                                tanggal_absen_update = tgAvtive;
                                method.val('POST');
                            }

                            $('#tanggal_absen').val(tanggal_absen_update);

                            $('#modal_absen_siswa .block-title').text('Presensi Siswa Kelas ' +
                                kelas);
                            $('#form_absensi [name="idPeriode"]').val(periode);
                            $('#form_absensi [name="idKelas"]').val(idKelas);
                            $('#form_absensi [name="idPegawai"]').val(idPegawai);

                            if (data.absen.length === 0) {
                                formAbsen.attr('action', `{{ route('absen.siswa.store') }}`);
                                $('#pilih_semua').prop('disabled', false);
                            } else {
                                formAbsen.attr('action', `{{ route('absen.siswa.update') }}`);
                                $('#pilih_semua').prop('disabled', true);
                            }


                            $('#daftar_siswa').empty();
                            var tot_sis = data.siswa.length;
                            $('caption').text(`Jumlah Siswa : ${tot_sis}`);
                            var presensi = [];

                            $.each(data.siswa, function(key, item) {
                                // console.log(data.absen.find(abs => abs.idSiswa === item.idSiswa && abs.presensi === 'H'));
                                $('#daftar_siswa').append(`
                                    <tr>
                                        <td class="text-center fw-medium">${key + 1}</td>
                                                <td><span class="fs-6 fw-medium">${item.namaSiswa}</span></br><span class="text-muted">${item.nis}</span><input type="hidden" value="${item.idSiswa}" name="idSiswa[]"></td>
                                    <td class="text-center px-md-0 px-2">
                                        <input type="radio" class="btn-check hadir" name="presensi_${item.idSiswa}" id="hadir_${item.idSiswa}"
                                            autocomplete="off" value="hadir" ${data.absen.find(abs => abs.idSiswa === item.idSiswa && abs
                                    .presensi === 'H') ? 'checked' : ''} required>
                                        <label class="btn btn-outline-success rounded-circle"
                                            style="width: 38px; height: 38px;" for="hadir_${item.idSiswa}">H</label>
                                    </td>
                                    <td class="text-center px-md-0 px-2">
                                        <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="izin_${item.idSiswa}"
                                            autocomplete="off" value="izin" ${data.absen.find(abs => abs.idSiswa === item.idSiswa && abs
                                    .presensi === 'I') ? 'checked ' : ''} required>
                                        <label class="btn btn-outline-warning rounded-circle"
                                            style="width: 38px; height: 38px;" for="izin_${item.idSiswa}">I</label>
                                    </td>
                                    <td class="text-center px-md-0 px-2">
                                        <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="sakit_${item.idSiswa}"
                                            autocomplete="off" value="sakit" ${data.absen.find(abs => abs.idSiswa === item.idSiswa && abs
                                    .presensi === 'S') ? 'checked ' : ''} required>
                                        <label class="btn btn-outline-info rounded-circle"
                                            style="width: 38px; height: 38px;" for="sakit_${item.idSiswa}">S</label>
                                    </td>
                                    <td class="text-center px-md-0 px-2">
                                        <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="alfa_${item.idSiswa}"
                                            autocomplete="off" value="alfa" ${data.absen.find(abs => abs.idSiswa === item.idSiswa && abs
                                    .presensi === 'A') ? 'checked ' : ''} required>
                                        <label class="btn btn-outline-danger rounded-circle"
                                            style="width: 38px; height: 38px;" for="alfa_${item.idSiswa}">A</label>
                                    </td>
                                    </tr>
                                    `);

                                if (data.pres.length !== 0) {
                                    presensi.push(data.pres.find(i => i.idSiswa === item
                                        .idSiswa).idAbsen);
                                }

                            });

                            if (data.pres.length !== 0) {
                                $('.btn-form').prepend(
                                    `<button type="button" class="btn btn-alt-danger" id="rm_presensi" 
                                data-tanggal="${$('#tanggal_absen').val()}"
                                data-presensi="${presensi}" data-bulan="${bulanIN}">Batalkan Presensi</button>`
                                );
                            }
                        },
                        complete: function() {
                            $('#loading_spinner').hide();
                        }
                    });
                });

                $('#form_absensi').submit(function(e) {
                    e.preventDefault();

                    var data = new FormData(this);
                    moment.locale('id');
                    var tanggalText = $('#tanggal_absen').val();
                    var tanggalMoment = moment(tanggalText, 'DD MMMM YYYY');
                    var tanggalFormatted = tanggalMoment.format('YYYY-MM-DD');
                    var tanggal = tanggalFormatted === 'Invalid date' ? '' : tanggalFormatted;
                    data.append('tanggal', tanggal);

                    var bulan = moment(tanggal).format('MMMM');

                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: data,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                modalAbsen.modal('hide');
                                getRekapBulanan(bulan);
                                getRekap();
                            } else {
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        },
                    });
                });

                modalAbsen.on('click', '#rm_presensi', function(e) {
                    e.preventDefault();

                    var id = $(this).data('presensi');
                    var tgl = $(this).data('tanggal');
                    var bulannnn = $(this).data('bulan');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Membatalkan/menghapus presensi pada <b>${tgl} ?</b>`,
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        reverseButtons: true,

                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'DELETE',
                                url: `{{ url('siswa/absen/delete/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    modalAbsen.modal('hide');
                                    getRekapBulanan(bulannnn);
                                    getRekap();
                                },
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
