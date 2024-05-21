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
                <h4 class="block-title">Nilai Siswa</h4>
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
                <div class="table-responsive" id="tb_container_rekap">
                    <div id="loading_spinner" class="text-center" style="display: none">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <table id="table_nilai_siswa"
                        class="table table-sm table-bordered align-middle border-dark w-100 caption-top">
                    </table>
                </div>
                <div class="mt-3" id="chart_nilai"></div>
            </div>
        </div>
    </div>

    <script>
        function getNilai() {
            $('#loading_spinner').show();
            // $('#table_nilai_siswa').addClass('d-none');
            $('#table_nilai_siswa').empty();
            $('#chart_nilai').empty();
            $.ajax({
                url: `{{ route('get-nilai-siswa') }}`,
                type: 'GET',
                data: {
                    periode: $('#periode_siswa option:selected').val(),
                },
                success: function(data) {
                    console.log();
                    var kelas = data.kelas.namaKelas;
                    var kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                    var per_smt = $('#periode_siswa option:selected').data('smt');
                    var per_tahun = $('#periode_siswa option:selected').data('tahun');
                    var tb_rekap = `<caption class="text-dark mb-0">
                                        <strong class="text-start mb-0">
                                                    KELAS : ${kelas} (${kls_name[kelas - 1] ?? ''})
                                                </strong>
                                        <strong class="float-end mb-0 text-uppercase">
                                            SEMESTER : ${per_smt}</strong>
                                    </caption>
                                    <thead class="table-light text-center align-middle border-dark">
                                        <tr>
                                            <th width="4%">No</th>
                                            <th>Mata Pelajaran</th>
                                            <th width="15%">Nilai</th>
                                        </tr>
                                    </thead><tbody>`;

                    var idSiswa = data.siswa.idSiswa;
                    var raport = 0;
                    var jumPengajaran = 0;
                    var N_map = [];
                    var N_sis = [];
                    $.each(data.pengajar, function(key, value) {
                        var mapel = value.mapel.namaMapel;
                        var mapel2 = value.mapel.singkatan ?? value.mapel.namaMapel;
                        if (mapel) {
                            tb_rekap += `<tr>
                                <td class="text-center">${key + 1}</td>
                                <td>${mapel}</td>`;
                            N_map.push(mapel2);
                        }
                        var nilai = data.nilai.find(function(nilai) {
                            return nilai.idSiswa === idSiswa &&
                                nilai.idPengajaran === value.idPengajaran;
                        });
                        if (nilai !== undefined && nilai.raport !== null && nilai.raport !== 0) {
                            tb_rekap += `<td class="text-center">${nilai.raport}</td></tr>`;

                            N_sis.push(nilai.raport);

                            raport += nilai.raport;
                            jumPengajaran++;
                        } else {
                            tb_rekap += `<td class="text-center"></td></tr>`;
                        }

                    });
                    tb_rekap += `<tr class="border-top border-2 border-dark">
                                <td colspan="2" class="fw-bold">Jumlah</td>
                                <td class="text-center fw-bold">${raport === null || raport === 0 ? '' : raport}</td>
                                </tr>
                                <tr class="border-bottom border-2 border-dark">
                                <td colspan="2" class="fw-bold">Rata-Rata</td>
                                <td class="text-center fw-bold">${jumPengajaran === 0 ? '' : (raport / jumPengajaran).toFixed(2)}</td>
                                </tr>
                                </tbody>`;

                    $('#table_nilai_siswa').html(tb_rekap);

                    var options = {
                        series: [{
                            name: 'Nilai Siswa',
                            data: N_sis
                        }],
                        chart: {
                            height: 370,
                            type: 'bar',
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 5,
                                columnWidth: '50%',
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            width: 0
                        },
                        grid: {
                            row: {
                                colors: ['#fff', '#f2f2f2']
                            }
                        },
                        xaxis: {
                            labels: {
                                rotate: -45
                            },
                            categories: N_map,
                            // tickPlacement: 'on'
                        },
                        yaxis: {
                            title: {
                                text: 'Nilai Siswa',
                            },
                            min: 0,
                            max: 100,
                            tickAmount: 10,
                            labels: {
                                show: true,
                                formatter: function(val) {
                                    return Math.floor(val); // Menghilangkan desimal atau koma
                                }
                            },
                        },
                        title: {
                            text: 'Grafik Nilai Siswa',
                            align: 'left',
                            margin: 10,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize: '18px',
                                fontWeight: 'bold',
                                // fontFamily: undefined,
                                color: '#263238'
                            },
                        }
                    };


                    var chart = new ApexCharts(document.querySelector("#chart_nilai"), options);

                    chart.render();
                    $('#chart_nilai').addClass('border border-dark border-2');

                    // $('#table_nilai_siswa tfoot').html(tb_foot);
                },
                complete: function() {
                    $('#loading_spinner').hide();
                    // $('#table_nilai_siswa').removeClass('d-none');
                }
            });
        }


        $(document).ready(function() {
            // getTb_rekap_nilai();
            getNilai();

            $('#periode_siswa').change(function() {
                // getTb_rekap_nilai();
                getNilai();
            });
        });
    </script>
@endsection
