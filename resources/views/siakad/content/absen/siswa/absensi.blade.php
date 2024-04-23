@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="alert alert-info pb-0" role="alert">
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
                <h4 class="block-title">Catatan Kehadiran Siswa</h4>
                <div class="block-options">
                    <select class="form-select form-select-sm" name="" id="periode_siswa">
                        @foreach ($siswaKelas as $item)
                            <option {{ $item->periode->idPeriode === $periode->idPeriode ? 'selected' : '' }}
                                value="{{ $item->periode->idPeriode }}">Kelas {{ $item->namaKelas }}
                                {{ $item->periode->semester }} {{ $item->periode->tahun }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table w-100 table-sm table-striped table-bordered border-dark align-middle">
                        <thead class="table-light align-middle text-center border-dark">
                            <tr>
                                <th rowspan="3">No</th>
                                <th rowspan="3">Kelas</th>
                                <th rowspan="3">Semester</th>
                                <th rowspan="3">Tahun Pelajaran</th>
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
                            <tr id="dataKehadiran">
                                {{-- data kehadira siswa --}}
                                <td class="total text-center" id="jml_hadir"></td>
                                <td class="total text-center" id="jml_sakit"></td>
                                <td class="total text-center" id="jml_izin"></td>
                                <td class="total text-center" id="jml_alfa"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <script>
                    function getCatatan() {
                        $.ajax({
                            type: 'GET',
                            url: "{{ route('get-kehadiran-siswa') }}",
                            data: {
                                periode: $('#periode_siswa').val(),
                            },
                            success: function(data) {

                                $('#namaBulan').empty();
                                $('#dataKehadiran').empty();
                                $('#ketPresensi').find('th').not('.total').remove();

                                $.each(data.bulan, function(key, value) {
                                    // perulangan nama bulan
                                    $('#namaBulan').append(`<th colspan="4">${value}</th>`);
                                    // perilangan keterangan presensi
                                    $('#ketPresensi').append(`
                                        <th style="min-width: 30px;">H</th>
                                        <th style="min-width: 30px;">S</th>
                                        <th style="min-width: 30px;">I</th>
                                        <th style="min-width: 30px;">A</th>
                                    `);
                                });

                                $.each(data.siswa, function(key, value) {
                                    let periode = data.periode;
                                    let kelas = data.kelas;
                                    let barisPresensi = `
                                        <td class="text-center fs-sm fw-semibold">1</td>
                                        <td class="fs-sm fw-semibold text-center">Kelas ${kelas.namaKelas}</td>
                                        <td class="fs-sm fw-semibold text-center">${periode.semester}</td>
                                        <td class="fs-sm fw-semibold text-center">${periode.tahun}</td>
                                    `;

                                    let dfBulan = data.bulan.length;
                                    let absen = data.presensi;
                                    $.each(data.bulan, function(key, bulan) {
                                        let kehadiran = data.presensi;
                                        let jmlHadir = kehadiran.filter(function(presensi) {
                                            return presensi.idSiswa === value.idSiswa && presensi
                                                .bulan === bulan && presensi.presensi === 'H';
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
                                            <td class="text-center">${jmlHadir == 0 ? '-' : jmlHadir}</td>
                                            <td class="text-center">${jmlSakit == 0 ? '-' : jmlSakit}</td>
                                            <td class="text-center">${jmlIzin == 0 ? '-' : jmlIzin}</td>
                                            <td class="text-center">${jmlAlpa == 0 ? '-' : jmlAlpa}</td>
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
                                    `;
                                    $('#dataKehadiran').append(barisPresensi + total);
                                });
                            }
                        });
                    }
                    $(document).ready(function() {
                        getCatatan();
                        $('#periode_siswa').change(function() {
                            getCatatan();
                        });
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
