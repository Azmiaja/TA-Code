@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    @push('style')
        <style>
            #tb_container_rekap {
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

                @page {
                    margin: 0.4in;
                    /* Anda bisa menyesuaikan margin sesuai kebutuhan */
                }
            }
        </style>
    @endpush
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
                <input type="text" readonly data-nama="{{ $kelas->namaKelas }}" data-id="{{ $kelas->idKelas }}"
                    value="Kelas {{ $kelas->namaKelas }} ({{ $kelas_nama[$kelas->namaKelas - 1] ?? '' }})"
                    class="form-control form-control-alt fw-semibold border-secondary" id="kelas_diampu">
            </div>
            <div class="col-md-auto mb-md-0 mb-3 align-self-end text-end">
                <button class="btn btn-primary" id="cetak_rekap_nilai">
                    <i class="fa-solid fa-print me-2"></i>
                    Cetak
                </button>
            </div>
        </div>
        {{-- <div class="row g-3 mb-4 justify-content-end">
            <div class="col-md-3 mb-md-0 mb-2">
                <label for="periode_id" class="form-label text-uppercase fw-bold fs-sm">Periode</label>
                <select class="form-select fw-medium" name="" id="periode_id">
                    @if ($periodeAktif && $periodeLewat)
                        <option value="{{ $periodeAktif->idPeriode }}" data-smt="{{ $periodeAktif->semester }}"
                            data-tahun="{{ $periodeAktif->tahun }}">
                            {{ $periodeAktif->semester }} {{ $periodeAktif->tahun }}
                        </option>
                        <option value="{{ $periodeLewat->idPeriode }}" data-smt="{{ $periodeLewat->semester }}"
                            data-tahun="{{ $periodeLewat->tahun }}">
                            {{ $periodeLewat->semester }} {{ $periodeLewat->tahun }}
                        </option>
                    @endif
                </select>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Rekapitulasi Nilai Siswa</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option me-1" data-toggle="block-option"
                                data-action="fullscreen_toggle"></button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="row">
                            <div class="col text-end">

                            </div>
                        </div>
                        <div class="table-responsive" id="tb_container_rekap">
                            <div id="loading_spinner" class="text-center" style="display: none">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <table id="tb_rekap_nilai"
                                class="table table-sm fs-sm table-bordered align-middle border-dark w-100 caption-top">
                            </table>
                        </div>
                        <div class="mt-4" id="chart_nilai"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            var chart;

            function getTb_rekap_nilai() {
                $('#loading_spinner').show();
                $('#tb_rekap_nilai').empty();
                $.ajax({
                    url: `{{ route('get.rekap.nilai') }}`,
                    type: 'GET',
                    data: {
                        periode: $('#periode_id').data('id'),
                    },
                    success: function(data) {
                        $('#chart_nilai').empty();
                        // console.log(data);
                        var kelas = data.kelas.namaKelas;
                        var kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                        var per_smt = $('#periode_id').data('smt');
                        var per_tahun = $('#periode_id').data('tahun');

                        var tb_rekap = `
                        <thead class="text-center align-middle">
                            <tr class="border-0" style="color: #000;">
                                <th colspan="${data.pengajar.length + 4}" class="text-center border-0 p-0 pb-2">
                                    <h4 class="text-center fw-normal mb-4" style="font-size: 14pt;">
                                        <span>REKAP NILAI SISWA</span><br>
                                        <strong>SD NEGERI LEMAHBANG</strong><br>
                                        <span>TAHUN PELAJARAN ${per_tahun}</span>
                                    </h4>
                                    <div class="d-flex justify-content-between">
                                        <strong class="text-start mb-0">
                                            KELAS : ${kelas} (${kls_name[kelas - 1] ?? ''})
                                        </strong>
                                        <strong class="float-end mb-0 text-uppercase">
                                            SEMESTER : ${per_smt}
                                        </strong>
                                    </div>
                                </th>
                            </tr>
                            <tr class="table-light border-dark">
                                <th rowspan="2" style="width: 20px; min-width:20px;">No</th>
                                <th rowspan="2" style="width: 42px; min-width:42px;">NIS</th>
                                <th rowspan="2" style="width: 230px; min-width:230px;">Nama Siswa</th>
                                <th colspan="${data.pengajar.length}">Capaian Mata Pelajaran</th>
                                <th rowspan="2" width="70px">Jumlah</th>
                                <th rowspan="2" width="70px">Rata-Rata</th>
                            </tr>
                            <tr class="table-light border-dark">`;

                        var totalNilaiMapel = {};
                        var jumlahSiswaPerMapel = {};
                        var nilaiTertinggi = {};
                        var nilaiTerendah = {};

                        var chr_mapel = [];

                        $.each(data.pengajar, function(key, value) {
                            var mapel = value.mapel.singkatan ?? value.mapel.namaMapel;
                            chr_mapel.push(mapel);
                            tb_rekap +=
                                `<th class="text-wrap" style="${value.mapel.singkatan === null ? 'font-size:.5rem;' : ''}">${mapel}</th>`;

                            totalNilaiMapel[value.idPengajaran] = 0;
                            jumlahSiswaPerMapel[value.idPengajaran] = 0;
                            nilaiTertinggi[value.idPengajaran] = null;
                            nilaiTerendah[value.idPengajaran] = null;
                        });

                        tb_rekap += `</tr></thead><tbody>`;

                        $.each(data.siswa, function(i, siswa) {
                            // Inisialisasi variabel raport untuk menyimpan total nilai raport per siswa
                            var raport = 0;
                            var jumPengajaran = 0;


                            tb_rekap += `<tr>
                                <td class="text-center">${i + 1}</td>
                                <td class="text-nowrap text-center">${siswa.nis}</td>
                                <td class="text-nowrap">${siswa.namaSiswa}</td>`;

                            $.each(data.pengajar, function(key, tpe) {
                                var nilai = data.nilai.find(function(nilai) {
                                    return nilai.idSiswa === siswa.idSiswa &&
                                        nilai.idPengajaran === tpe.idPengajaran;
                                });

                                // Periksa apakah nilai ditemukan
                                if (nilai !== undefined && nilai.raport !== null && nilai.raport !==
                                    0) {
                                    tb_rekap +=
                                        `<td class="text-center" style="min-width:80px;">${nilai.raport}</td>`;

                                    // Tambahkan nilai raport siswa ke total raport siswa
                                    raport += nilai.raport;
                                    jumPengajaran++;
                                    totalNilaiMapel[tpe.idPengajaran] += nilai.raport;
                                    jumlahSiswaPerMapel[tpe.idPengajaran]++;
                                    if (nilaiTertinggi[tpe.idPengajaran] === null || nilai.raport >
                                        nilaiTertinggi[tpe.idPengajaran]) {
                                        nilaiTertinggi[tpe.idPengajaran] = nilai.raport;
                                    }
                                    if (nilaiTerendah[tpe.idPengajaran] === null || nilai.raport <
                                        nilaiTerendah[tpe.idPengajaran]) {
                                        nilaiTerendah[tpe.idPengajaran] = nilai.raport;
                                    }
                                } else {
                                    // Jika nilai tidak ditemukan, tambahkan sel kosong
                                    tb_rekap +=
                                        `<td class="bg-city-lighter" style="min-width:80px"></td>`;
                                }
                            });

                            var rataRataRaport = jumPengajaran === 0 ? '' : (raport / jumPengajaran)
                                .toFixed(2);

                            // Setelah selesai memproses semua pengajar, tambahkan total raport siswa ke dalam tabel
                            tb_rekap +=
                                `<td class="text-center ${raport === null || raport === 0 ? 'bg-city-lighter' : ''}" style="min-width:55px">${raport === null || raport === 0 ? '' : raport}</td>
                                <td class="text-center ${jumPengajaran === 0 ? 'bg-city-lighter' : ''}" style="min-width:55px">${jumPengajaran === 0 ? '' : (raport / jumPengajaran).toFixed(2)}</td>
                                </tr>`;
                        });

                        // RINGKASAN KELAS
                        var chr_data_dyserap = [];

                        tb_rekap += `<tr class="border-top border-2 border-dark">
                            <td colspan="3" class="fw-bold">Jumlah</td>`;
                        $.each(data.pengajar, function(key, tpe) {
                            tb_rekap +=
                                `<td class="text-center fw-bold ${totalNilaiMapel[tpe.idPengajaran] == 0 ? 'bg-city-lighter' : ''}">${totalNilaiMapel[tpe.idPengajaran] == 0 ? '' : totalNilaiMapel[tpe.idPengajaran]}</td>`;
                        });
                        tb_rekap += `<td colspan="3"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="fw-bold">Rata-Rata Kelas</td>`;
                        $.each(data.pengajar, function(key, tpe) {
                            var rt_kelas = jumlahSiswaPerMapel[tpe.idPengajaran] === 0 ? '' : (
                                    totalNilaiMapel[tpe.idPengajaran] / jumlahSiswaPerMapel[tpe
                                        .idPengajaran])
                                .toFixed(2);
                            tb_rekap +=
                                `<td class="text-center fw-bold ${jumlahSiswaPerMapel[tpe.idPengajaran] === 0 ? 'bg-city-lighter' : ''}">${rt_kelas}</td>`;
                            // console.log(jm);
                        });
                        tb_rekap += `<td colspan="3"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="fw-bold">Nilai Terbesar</td>`;
                        $.each(data.pengajar, function(key, tpe) {
                            tb_rekap +=
                                `<td class="text-center fw-bold ${nilaiTertinggi[tpe.idPengajaran] !== null ? '' : 'bg-city-lighter'}">${nilaiTertinggi[tpe.idPengajaran] !== null ? nilaiTertinggi[tpe.idPengajaran] : ''}</td>`;
                        });
                        tb_rekap += `<td colspan="3"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="fw-bold">Nilai Terkecil</td>`;
                        $.each(data.pengajar, function(key, tpe) {
                            tb_rekap +=
                                `<td class="text-center fw-bold ${nilaiTerendah[tpe.idPengajaran] !== null ? '' : 'bg-city-lighter'}">${nilaiTerendah[tpe.idPengajaran] !== null ? nilaiTerendah[tpe.idPengajaran] : ''}</td>`;
                        });
                        tb_rekap += `<td colspan="3"></td>
                                </tr>
                                <tr class="border-bottom border-2 border-dark">
                                    <td colspan="3" class="fw-bold">Daya Serap</td>`;
                        $.each(data.pengajar, function(key, tpe) {
                            var dayaSerap = jumlahSiswaPerMapel[tpe.idPengajaran] === 0 ? '' : Math.round((
                                totalNilaiMapel[tpe.idPengajaran] / jumlahSiswaPerMapel[tpe
                                    .idPengajaran])) + '%';
                            chr_data_dyserap.push(jumlahSiswaPerMapel[tpe.idPengajaran] === 0 ? 0 : Math
                                .round((
                                    totalNilaiMapel[tpe.idPengajaran] / jumlahSiswaPerMapel[tpe
                                        .idPengajaran])));
                            tb_rekap +=
                                `<td class="text-center fw-bold ${jumlahSiswaPerMapel[tpe.idPengajaran] === 0 ? 'bg-city-lighter' : ''}">${dayaSerap}</td>`;
                            // console.log(jm);
                        });

                        tb_rekap += `<td colspan="3"></td>
                                </tr>`;

                        tb_rekap += `</tbody>`;

                        $('#tb_rekap_nilai').append(tb_rekap);

                        // GRAFIK DAYA SERAP

                        var options = {
                            series: [{
                                name: 'Daya Serap',
                                data: chr_data_dyserap
                            }],
                            chart: {
                                height: 300,
                                type: 'bar',
                            },
                            plotOptions: {
                                bar: {
                                    borderRadius: 5,
                                    columnWidth: '40%',
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: function(val) {
                                    return val + "%";
                                },
                                style: {
                                    colors: ['#1e1e1e']
                                }

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
                                categories: chr_mapel,
                                // tickPlacement: 'on'
                            },
                            yaxis: {
                                title: {
                                    text: 'Daya Serap %',
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
                            tooltip: {
                                enabled: true,
                                y: {
                                    formatter: function(val) {
                                        return val + "%"; // Convert value to percentage
                                    }
                                }
                            },
                            title: {
                                text: 'Grafik Daya Serap',
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


                        chart = new ApexCharts(document.querySelector("#chart_nilai"), options);
                        $('#chart_nilai').addClass('border border-dark border-2');

                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Data tidak dapat dimuat!.',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                    complete: function() {
                        $('#loading_spinner').hide();
                        chart.render();

                    }
                });
            }

            $(document).ready(function() {
                getTb_rekap_nilai();

                $('#periode_id').change(function() {
                    getTb_rekap_nilai();
                    chart.render();
                });

                $('#cetak_rekap_nilai').on('click', function() {
                    $('#tb_container_rekap').printThis({
                        debug: false, // show the iframe for debugging
                        importCSS: true,
                        importStyle: true,
                    });
                    // var printContents = $('#tb_container_rekap').html();
                    // var originalContents = $('body').html();
                    // $('body').empty().css({
                    //     'font-family': '\'Times New Roman\', Times, serif',
                    //     'font-size': '12pt',
                    // }).html(printContents);
                    // window.print();
                    // location.reload();
                });
            });
        </script>
    @endpush
@endsection
