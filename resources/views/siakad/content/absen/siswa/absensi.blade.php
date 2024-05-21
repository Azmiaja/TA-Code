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
                            <option data-smt="{{ $item->periode->semester }}"
                                {{ $item->periode->idPeriode === $periode->idPeriode ? 'selected' : '' }}
                                value="{{ $item->periode->idPeriode }}">Kelas {{ $item->namaKelas }}
                                {{ $item->periode->semester }} {{ $item->periode->tahun }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <div id="loading_spinner" class="text-center" style="display: none">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <table id="tabel_absen" class="table table-sm w-100 table-bordered border-dark align-middle caption-top">

                    </table>
                </div>

                <script>
                    function getDataCatatan() {
                        $("#loading_spinner").show();
                        $('#tabel_absen').empty();
                        $.ajax({
                            url: `{{ route('get-kehadiran-siswa') }}`,
                            type: 'GET',
                            data: {
                                periode: $('#periode_siswa option:selected').val(),
                            },
                            success: function(data) {
                                var kelas = data.kelas.namaKelas;
                                var kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                                var per_smt = $('#periode_siswa option:selected').data('smt');
                                var per_tahun = $('#periode_siswa option:selected').data('tahun');
                                var tabel = `<caption class="text-dark mb-0">
                                        <strong class="text-start mb-0">
                                                    KELAS : ${kelas} (${kls_name[kelas - 1] ?? ''})
                                                </strong>
                                        <strong class="float-end mb-0 text-uppercase">
                                            SEMESTER : ${per_smt}</strong>
                                    </caption>
                                <thead class="table-light align-middle text-center border-dark">
                                    <tr>
                                        <th rowspan="2" width="5%">No</th>
                                        <th rowspan="2">Bulan</th>
                                        <th colspan="4">Keterangan</th>
                                    </tr>
                                    <tr>
                                        <th width="5%">H</th>
                                        <th width="5%">S</th>
                                        <th width="5%">I</th>
                                        <th width="5%">A</th>
                                    </tr>
                                    </thead><tbody>`;

                                var siswa = data.siswa.idSiswa;
                                let kehadiran = data.presensi;
                                $.each(data.bulan, function(key, value) {
                                    let jmlHadir = kehadiran.filter(function(presensi) {
                                        return presensi.idSiswa === siswa && presensi
                                            .bulan === value && presensi.presensi === 'H';
                                    }).length;

                                    // Pastikan setiap nilai presensi ditampilkan dalam tabel
                                    let jmlSakit = kehadiran.filter(function(presensi) {
                                        return presensi.idSiswa === siswa && presensi
                                            .bulan === value && presensi.presensi === 'S';
                                    }).length;

                                    let jmlIzin = kehadiran.filter(function(presensi) {
                                        return presensi.idSiswa === siswa && presensi
                                            .bulan === value && presensi.presensi === 'I';
                                    }).length;

                                    let jmlAlpa = kehadiran.filter(function(presensi) {
                                        return presensi.idSiswa === siswa && presensi
                                            .bulan === value && presensi.presensi === 'A';
                                    }).length;
                                    tabel += `<tr>
                                        <td class="text-center fw-semibold">${key+1}</td>
                                        <td class="text-uppercase fw-semibold">${value}</td>
                                        <td class="text-center fw-medium">${jmlHadir == 0 ? '' : jmlHadir}</td>
                                        <td class="text-center fw-medium">${jmlSakit == 0 ? '' : jmlSakit}</td>
                                        <td class="text-center fw-medium">${jmlIzin == 0 ? '' : jmlIzin}</td>
                                        <td class="text-center fw-medium">${jmlAlpa == 0 ? '' : jmlAlpa}</td>
                                        </tr>`;
                                });

                                let totHadir = kehadiran.filter(function(presensi) {
                                    return presensi.idSiswa === siswa &&
                                        presensi.presensi === 'H';
                                }).length;
                                let totSakit = kehadiran.filter(function(presensi) {
                                    return presensi.idSiswa === siswa &&
                                        presensi.presensi === 'S';
                                }).length;
                                let totIzin = kehadiran.filter(function(presensi) {
                                    return presensi.idSiswa === siswa &&
                                        presensi.presensi === 'I';
                                }).length;
                                let totAlfa = kehadiran.filter(function(presensi) {
                                    return presensi.idSiswa === siswa &&
                                        presensi.presensi === 'A';
                                }).length;

                                tabel += `<tr>
                                    <td colspan="2" class="text-uppercase border-top border-2 border-dark fw-bold">Jumlah</td>
                                    <td class="text-center border-top border-2 border-dark fw-bold">${totHadir}</td>
                                    <td class="text-center border-top border-2 border-dark fw-bold">${totSakit}</td>
                                    <td class="text-center border-top border-2 border-dark fw-bold">${totIzin}</td>
                                    <td class="text-center border-top border-2 border-dark fw-bold">${totAlfa}</td>
                                    </tr><>/tbody`;

                                $('#tabel_absen').html(tabel);
                            },
                            complete: function() {
                                $('#loading_spinner').hide();
                            }
                        });
                    }

                    $(document).ready(function() {
                        // getCatatan();
                        getDataCatatan();
                        $('#periode_siswa').change(function() {
                            // getCatatan();
                            getDataCatatan();
                        });
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
