@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
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
    <div class="content">
        <div class="row g-3">
            <div class="col-lg-9 col-12 order-lg-1 order-2">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Rekap Penilaian</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option me-1" data-toggle="block-option"
                                data-action="fullscreen_toggle"></button>
                            <button type="button" id="cetak_rekap_nilai" class="btn btn-sm btn-primary">
                                Cetak
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
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

    @push('scripts')
        <script>
            var chart;

            function getSelectKelas() {
                $.ajax({
                    type: "GET",
                    url: `{{ route('form.kelas') }}`,
                    data: {
                        periode: $('#periode option:selected').val()
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
                                // getRekap();
                                getTb_rekap_nilai();
                                // chart.render();

                            }
                        });
                    },
                });
            }


            function getTb_rekap_nilai() {
                let periode = $('#periode').find('option:selected').val();
                let kelas = $('#kelas').find('option:selected').val();
                $('#loading_spinner').show();
                $('#tb_rekap_nilai').empty();
                $.ajax({
                    url: `{{ url('akademik/niali-siswa/rekap/${periode}/${kelas}') }}`,
                    type: 'GET',
                    success: function(data) {
                        $('#chart_nilai').empty();
                        // console.log(data);
                        var kelas = data.kelas.namaKelas;
                        var kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                        var per_smt = $('#periode option:selected').data('smt');
                        var per_tahun = $('#periode option:selected').data('tahun');

                        var tb_rekap = `<thead class="text-center align-middle">
                            <tr class="border-0">
                                <th colspan="${data.pengajar.length + 4}" class="text-center border-0 p-0">
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
                                <th rowspan="2" width="4%">No</th>
                                <th rowspan="2">Nama Siswa</th>
                                <th colspan="${data.pengajar.length}">Capaian Mata Pelajaran</th>
                                <th rowspan="2" width="70px">Jumlah</th>
                                <th rowspan="2" width="70px">Rata-Rata</th>
                                </tr>
                                <tr>`;

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
                                <td class="text-nowrap" style="min-width:250px;">${siswa.namaSiswa}</td>`;

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
                            <td colspan="2" class="fw-bold">Jumlah</td>`;
                        $.each(data.pengajar, function(key, tpe) {
                            tb_rekap +=
                                `<td class="text-center fw-bold ${totalNilaiMapel[tpe.idPengajaran] == 0 ? 'bg-city-lighter' : ''}">${totalNilaiMapel[tpe.idPengajaran] == 0 ? '' : totalNilaiMapel[tpe.idPengajaran]}</td>`;
                        });
                        tb_rekap += `<td colspan="3"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="fw-bold">Rata-Rata Kelas</td>`;
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
                                    <td colspan="2" class="fw-bold">Nilai Terbesar</td>`;
                        $.each(data.pengajar, function(key, tpe) {
                            tb_rekap +=
                                `<td class="text-center fw-bold ${nilaiTertinggi[tpe.idPengajaran] !== null ? '' : 'bg-city-lighter'}">${nilaiTertinggi[tpe.idPengajaran] !== null ? nilaiTertinggi[tpe.idPengajaran] : ''}</td>`;
                        });
                        tb_rekap += `<td colspan="3"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="fw-bold">Nilai Terkecil</td>`;
                        $.each(data.pengajar, function(key, tpe) {
                            tb_rekap +=
                                `<td class="text-center fw-bold ${nilaiTerendah[tpe.idPengajaran] !== null ? '' : 'bg-city-lighter'}">${nilaiTerendah[tpe.idPengajaran] !== null ? nilaiTerendah[tpe.idPengajaran] : ''}</td>`;
                        });
                        tb_rekap += `<td colspan="3"></td>
                                </tr>
                                <tr class="border-bottom border-2 border-dark">
                                    <td colspan="2" class="fw-bold">Daya Serap</td>`;
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

                        $('#tb_rekap_nilai').html(tb_rekap);

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

                        // chart.render();
                    },
                    complete: function() {
                        $('#loading_spinner').hide();
                        $('#chart_nilai').addClass('border border-dark border-2');
                        chart.render();
                    }
                });
            }

            $(document).ready(function() {
                getSelectKelas();
                $("#periode").change(function() {
                    // getRekap();
                    // getTb_rekap_nilai();
                    getSelectKelas();
                    // chart.resetSeries()
                    // chart.render();
                });
                $('#kelas, #periode').change(function() {
                    // getRekap();
                    getTb_rekap_nilai();
                    chart.resetSeries();
                    $('#wali_kelas').val('');
                    let selectedWakel = $('#kelas').find('option:selected').data('wakel');
                    let nip = $('#kelas').find('option:selected').data('nip');
                    $('#wali_kelas').val(selectedWakel);
                });

                $('#cetak_rekap_nilai').on('click', function() {
                    $('#tb_rekap_nilai').printThis({
                        debug: false, // show the iframe for debugging
                        importCSS: true,
                        importStyle: true,
                    });
                });
            });
        </script>
    @endpush
@endsection
