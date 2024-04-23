@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <style>
        #rekap_absen_all {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }

        #table_bulanan {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
        }
    </style>
    @php
        use Carbon\Carbon;

    @endphp
    <div class="content">
        {{-- <div class="row mb-3">
            <div class="col text-end">
                <div class="dropdown-center">
                    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-rectangle-list me-2"></i>
                        Rekap (Bulanan)
                    </button>
                    <ul class="dropdown-menu">
                        @php

                            $displayedMonth = [];
                            $tanggalMulai = Carbon::parse($periode->tanggalMulai);
                            $tanggalSelesai = Carbon::parse($periode->tanggalSelesai);

                            $daftarBulan = [];
                            $noBulan = [];

                            while ($tanggalMulai <= $tanggalSelesai) {
                                $daftarBulan[] = $tanggalMulai->translatedFormat('F');
                                $noBulan[] = $tanggalMulai->translatedFormat('m');
                                $tanggalMulai->addMonth();
                            }

                            // Mengonversi array $noBulan menjadi string dipisahkan dengan koma
                            $noBulanString = implode(',', $noBulan);
                        @endphp

                        @if ($daftarBulan)
                            @foreach ($daftarBulan as $index => $bulan)
                                @php
                                    // Mengambil nomor bulan yang sesuai dengan indeks saat ini
                                    $nomorBulan = $noBulan[$index];
                                @endphp
                                <li>
                                    <a class="dropdown-item fw-medium"
                                        href="{{ route('rekapitulasi.index', ['name' => $kelas->namaKelas, 'bulan' => $nomorBulan]) }}">
                                        <i class="fa-solid fa-calendar-check fs-6 text-info me-2"></i>
                                        {{ $bulan }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div> --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                @php

                    $kelas_nama = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                @endphp
                <h3 class="block-title">Rekapitulasi Presensi Kelas {{ $kelas->namaKelas }}
                    ({{ $kelas_nama[$kelas->namaKelas - 1] ?? '' }})
                </h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option me-1" data-toggle="block-option"
                        data-action="fullscreen_toggle"></button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="row mb-4">
                    <div class="col text-end">
                        <button class="btn btn-primary" id="cetak_rekap_all">
                            <i class="fa-solid fa-print me-2"></i>
                            Cetak
                        </button>
                    </div>
                </div>
                <div id="rekap_absen_all">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered border-dark w-100">
                            <thead class="align-middle text-center">
                                <tr>
                                    <h4 class="text-center fw-normal mb-4">
                                        <span>REKAP KEHADIRAN PESERTA DIDIK</span><br>
                                        <strong>SD NEGERI LEMAHBANG</strong><br>
                                        <span>TAHUN PELAJARAN {{ $periode->first()->tahun }}</span>
                                    </h4>
                                    <strong class="text-start mb-2">KELAS : {{ $kelas->namaKelas }}
                                        ({{ $kelas_nama[$kelas->namaKelas - 1] ?? '' }})</strong>
                                    <strong class="float-end mb-2 text-uppercase">SEMESTER :
                                        {{ $periode->semester }}</strong>
                                </tr>
                                <tr>
                                    <th rowspan="3">No</th>
                                    <th rowspan="3">NIS</th>
                                    <th rowspan="3">Nama</th>
                                    <th rowspan="3">L/P</th>
                                    <th colspan="24">Bulan</th>
                                    <th rowspan="2" colspan="4">Total</th>
                                </tr>
                                <tr>
                                    @php
                                        $tanggalMulai = Carbon::parse($periode->tanggalMulai);
                                        $tanggalSelesai = Carbon::parse($periode->tanggalSelesai);

                                        $daftarBulan = [];

                                        while ($tanggalMulai <= $tanggalSelesai) {
                                            $daftarBulan[] = $tanggalMulai->translatedFormat('F');
                                            $tanggalMulai->addMonth();
                                        }
                                    @endphp
                                    @if ($daftarBulan)
                                        @foreach ($daftarBulan as $item)
                                            <th colspan="4"><a href="javascript:void(0)" id="show_modal"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-title="Rekap Kehadiran Siswa Bulan {{ $item }}"
                                                    data-bulan="{{ $item }}"
                                                    class="nav-link">{{ $item }}</a></th>
                                        @endforeach
                                    @endif
                                </tr>
                                <tr>
                                    @if ($daftarBulan)
                                        @foreach ($daftarBulan as $item)
                                            <th style="min-width: 30px;">H</th>
                                            <th style="min-width: 30px;">S</th>
                                            <th style="min-width: 30px;">I</th>
                                            <th style="min-width: 30px;">A</th>
                                        @endforeach
                                    @endif
                                    <th style="min-width: 30px;">H</th>
                                    <th style="min-width: 30px;">S</th>
                                    <th style="min-width: 30px;">I</th>
                                    <th style="min-width: 30px;">A</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswaWithKelas as $siswa)
                                    <tr>
                                        <td class="text-center fs-sm fw-medium">{{ $loop->iteration }}</td>
                                        <td class="fs-sm text-center">{{ $siswa->nis }}</td>
                                        <td class="fs-sm text-nowrap">{{ $siswa->namaSiswa }}</td>
                                        <td class="text-center fs-sm">
                                            {{ $siswa->jenisKelamin ? ($siswa->jenisKelamin == 'Laki-Laki' ? 'L' : 'P') : '-' }}
                                        </td>
                                        @foreach ($daftarBulan as $bulan)
                                            @php
                                                $jumlahHadir = $kehadiran
                                                    ->where('idSiswa', $siswa->idSiswa)
                                                    ->where('bulan', $bulan)
                                                    ->where('presensi', 'H')
                                                    ->count();

                                                $jumlahSakit = $kehadiran
                                                    ->where('idSiswa', $siswa->idSiswa)
                                                    ->where('bulan', $bulan)
                                                    ->where('presensi', 'S')
                                                    ->count();

                                                $jumlahIzin = $kehadiran
                                                    ->where('idSiswa', $siswa->idSiswa)
                                                    ->where('bulan', $bulan)
                                                    ->where('presensi', 'I')
                                                    ->count();

                                                $jumlahAlpa = $kehadiran
                                                    ->where('idSiswa', $siswa->idSiswa)
                                                    ->where('bulan', $bulan)
                                                    ->where('presensi', 'A')
                                                    ->count();
                                            @endphp
                                            <td class="text-center">{{ $jumlahHadir ?: '' }}</td>
                                            <td class="text-center">{{ $jumlahSakit ?: '' }}</td>
                                            <td class="text-center">{{ $jumlahIzin ?: '' }}</td>
                                            <td class="text-center">{{ $jumlahAlpa ?: '' }}</td>
                                        @endforeach
                                        {{-- Hitung total kehadiran untuk setiap siswa --}}
                                        @php
                                            $totalHadir = $kehadiran
                                                ->where('idSiswa', $siswa->idSiswa)
                                                ->where('noBulan', '>=', 1)
                                                ->where('noBulan', '<=', count($daftarBulan))
                                                ->where('presensi', 'H')
                                                ->count();

                                            $totalSakit = $kehadiran
                                                ->where('idSiswa', $siswa->idSiswa)
                                                ->where('noBulan', '>=', 1)
                                                ->where('noBulan', '<=', count($daftarBulan))
                                                ->where('presensi', 'S')
                                                ->count();

                                            $totalIzin = $kehadiran
                                                ->where('idSiswa', $siswa->idSiswa)
                                                ->where('noBulan', '>=', 1)
                                                ->where('noBulan', '<=', count($daftarBulan))
                                                ->where('presensi', 'I')
                                                ->count();

                                            $totalAlpa = $kehadiran
                                                ->where('idSiswa', $siswa->idSiswa)
                                                ->where('noBulan', '>=', 1)
                                                ->where('noBulan', '<=', count($daftarBulan))
                                                ->where('presensi', 'A')
                                                ->count();
                                        @endphp
                                        <td class="text-center">{{ $totalHadir ?: '' }}</td>
                                        <td class="text-center">{{ $totalSakit ?: '' }}</td>
                                        <td class="text-center">{{ $totalIzin ?: '' }}</td>
                                        <td class="text-center">{{ $totalAlpa ?: '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row m-0 mt-4 text-center">
                            <div class="col-6 align-middle">
                                <span>Mengetahui <br>Kepala Sekolah</span><br><br><br><br><br>
                                <strong class="text-uppercase"><u>{{ $kepsek->namaPegawai }}</u></strong><br>
                                <span class="text-uppercase">NIP.{{ $kepsek->nip }}</span>
                            </div>
                            <div class="col-6">
                                <span>Magetan, {{ Carbon::now()->translatedFormat('d F Y') }} <br>Wali
                                    Kelas</span><br><br><br><br><br>
                                <strong class="text-uppercase"><u>{{ $wakel->namaPegawai }}</u></strong><br>
                                <span class="text-uppercase">NIP.{{ $wakel->nip }}</span>
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

    @push('scripts')
        <script>
            function getRekapBulanan(bulan) {
                $('#table_bulanan').empty();
                $.ajax({
                    type: 'GET',
                    url: `{{ url('guru/presensi/rekap/kelas') }}`,
                    success: function(data) {
                        let tp = data.periode.tahun;
                        let bln = bulan;
                        let kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                        let kls = {!! json_encode($kelas) !!};
                        let tableHTML = `<table class="table table-sm table-bordered border-dark w-100 align-middle">
                            <thead class="align-middle text-center border-dark">
                                <tr>
                                    <h4 class="text-center fw-normal mb-4">
                                        <span>DAFTAR HADIR PESERTA DIDIK</span><br>
                                        <strong>SD NEGERI LEMAHBANG</strong><br>
                                        <span class="tahun-plj">TAHUN PELAJARAN ${tp}</span>
                                    </h4>
                                    <strong class="text-start mb-2 kelas-nama">KELAS : ${kls.namaKelas} (${kls_name[kls.namaKelas - 1 ?? '']})</strong>
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
                        let tgl = {!! json_encode(\Carbon\Carbon::now()->translatedFormat('d F Y')) !!};
                        let wakel = {!! json_encode($wakel) !!};
                        let ttd = `<div id="ttd_presensi_2" class="row m-0 mt-4 text-center">
                                <div class="col-6 align-middle">
                                    <span>Mengetahui <br>Kepala Sekolah</span><br><br><br><br><br>
                                    <strong class="text-uppercase"><u>${kepsek.namaPegawai}</u></strong><br>
                                    <span class="text-uppercase">NIP.${kepsek.nip}</span>
                                </div>
                                <div class="col-6">
                                    <span>
                                        Magetan,
                                        <span id="tgl_ttd">${tgl}</span>
                                        <br>
                                        Wali Kelas
                                    </span>
                                    <br><br><br><br><br>
                                    <strong class="text-uppercase"><u>${wakel.namaPegawai}</u></strong><br>
                                    <span class="text-uppercase">NIP : ${wakel.nip}</span>
                                </div>
                            </div>`;

                        $('#table_bulanan').prepend(tableHTML + ttd);

                    }
                });
            }
            
            $(document).on('click', '#show_modal', function() {
                let bln = $(this).data('bulan');
                $('#modal_presebsi_bulan').modal('show');
                getRekapBulanan(bln);
            });
            $(document).ready(function() {

                $('#cetak_rekap_all').click(function() {
                    var printContents = $('#rekap_absen_all').html();
                    var originalContents = $('body').html();
                    $('body').empty().css({
                        'font-family': '\'Times New Roman\', Times, serif',
                        'font-size': '12pt',
                    }).html(printContents);
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
                    window.print();
                    location.reload();
                });
            });
        </script>
    @endpush
@endsection
