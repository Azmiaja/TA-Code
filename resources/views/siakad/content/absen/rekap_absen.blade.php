{{-- @extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero') --}}
<link rel="stylesheet" media="all" href="{{ asset('assets/css/oneui.css') }}">
<script src="{{ asset('assets/js/lib/jquery.min.js') }}"></script>
<div class="content">
    <div class="block block-rounded">
        <div class="block-content block-content-full">
            <div class="block-header p-0 mb-4">
                <button class="btn btn-primary ms-auto" id="printRekab">
                    <i class="fa-solid fa-print me-2"></i>Cetak</button>
            </div>
            <div id="contentTabel">
                <table class="table table-sm table-bordered border-dark w-100">
                    <thead class="align-middle text-center">
                        <tr>
                            @php
                                $kelas = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                            @endphp
                            <h4 class="text-center fw-normal mb-4">
                                <span>DAFTAR HADIR PESERTA DIDIK</span><br>
                                <strong>SD NEGERI LEMAHBANG</strong><br>
                                <span>TAHUN PELAJARAN {{ $periode->first()->tahun }}</span>
                            </h4>
                            <strong class="text-start mb-2">KELAS : {{ $kelasName }}
                                ({{ $kelas[$kelasName - 1] ?? '' }})</strong>
                            <strong class="float-end mb-2 text-uppercase">
                                @php
                                    $namaBulan = \Carbon\Carbon::createFromDate(null, $bulan)->translatedFormat('F');
                                @endphp
                                BULAN : {{ $namaBulan ?? '' }}
                            </strong>
                        </tr>
                        <tr>
                            <th rowspan="2">NO</th>
                            <th rowspan="2">NIS</th>
                            <th rowspan="2" style="min-width: 260px;">NAMA</th>
                            <th rowspan="2">L/P</th>
                            <th colspan="31">Tanggal</th>
                            <th colspan="4">Jumlah</th>
                        </tr>
                        <tr>
                            @for ($i = 1; $i <= 31; $i++)
                                <th style="min-width: 30px;">
                                    {{ $i }}
                                </th>
                            @endfor
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
                                <td class="text-center fs-sm">{{ $siswa->nis }}</td>
                                <td class="fs-sm">{{ $siswa->namaSiswa }}</td>
                                <td class="text-center fs-sm fw-medium">
                                    {{ $siswa->jenisKelamin ? ($siswa->jenisKelamin == 'Laki-Laki' ? 'L' : 'P') : '-' }}
                                </td>
                                <?php
                                $jumlahHadir = '';
                                $jumlahIzin = '';
                                $jumlahSakit = '';
                                $jumlahAlpha = '';
                                ?>
                                @for ($i = 1; $i <= 31; $i++)
                                    @php
                                        $presence = $kehadiran
                                            ->where('idSiswa', $siswa->idSiswa)
                                            ->where('tanggal', $i)
                                            ->first();

                                        if ($presence) {
                                            switch ($presence->presensi) {
                                                case 'H':
                                                    $jumlahHadir++;
                                                    break;
                                                case 'I':
                                                    $jumlahIzin++;
                                                    break;
                                                case 'S':
                                                    $jumlahSakit++;
                                                    break;
                                                default:
                                                    $jumlahAlpha++;
                                            }
                                        }
                                    @endphp
                                    @if ($presence)
                                        <td class="fs-sm fw-medium text-center">{{ $presence->presensi }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @endfor
                                <td class="fs-sm fw-medium text-center">
                                    {{ $jumlahHadir }}</td>
                                <td class="fs-sm fw-medium text-center">
                                    {{ $jumlahSakit }}</td>
                                <td class="fs-sm fw-medium text-center">
                                    {{ $jumlahIzin }}</td>
                                <td class="fs-sm fw-medium text-center">
                                    {{ $jumlahAlpha }}</td>
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
                        <span>Magetan, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} <br>Wali
                            Kelas</span><br><br><br><br><br>
                        <strong class="text-uppercase"><u>{{ $wakel->namaPegawai }}</u></strong><br>
                        <span class="text-uppercase">NIP.{{ $wakel->nip }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #contentTabel {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12pt;
    }
</style>

<script>
    $(document).ready(function() {
        $('#printRekab').on('click', function() {
            var printContents = $('#contentTabel').html();
            var originalContents = $('body').html();
            $('body').empty().css({
                'font-family': '\'Times New Roman\', Times, serif',
            }).html(printContents);
            window.print();
            $('body').empty().html(originalContents);
        });
    });
</script>

{{-- @endsection --}}
