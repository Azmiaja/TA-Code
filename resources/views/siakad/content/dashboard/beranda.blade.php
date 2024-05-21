@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="row item-push">
            <div class="col-xl-9 col-md-8 col-12 order-sm-1 order-2">
                @can('siswa')
                    {{-- <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Grafik Kehadiran Siswa</h3>
                        </div>
                        <div class="block-content">
                            <div id="chart_kehadiran"></div>
                        </div>
                    </div> --}}
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Grafik Nilai Siswa
                        </div>
                        <div class="block-content">
                            <div id="chart_nilai"></div>
                        </div>
                    </div>
                @endcan
                @can('guru')
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Grafik Jumlah Siswa</h3>
                            <div class="block-options">
                                <input type="text" readonly data-id="{{ $periode->idPeriode }}"
                                    value="Semester {{ $periode->semester }} {{ $periode->tahun }}"
                                    data-smt="{{ $periode->semester }}" data-tahun="{{ $periode->tahun }}"
                                    class="form-control form-control-sm fw-semibold" id="periode_id">
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <div id="grafik_siswa"></div>
                        </div>
                    </div>
                    @if ($kelas)
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Grafik Daya Serap</h3>
                                <div class="block-options">
                                    <input type="text" readonly data-id="{{ $periode->idPeriode }}"
                                        value="Semester {{ $periode->semester }} {{ $periode->tahun }}"
                                        data-smt="{{ $periode->semester }}" data-tahun="{{ $periode->tahun }}"
                                        class="form-control form-control-sm fw-semibold" id="periode_id2">
                                </div>
                            </div>
                            <div class="block-content block-content-full">
                                <div id="grafik_dayaSerap"></div>
                            </div>
                        </div>
                    @endif
                @endcan
            </div>
            <div class="col-xl-3 col-md-4 col-12 order-sm-2 order-1">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title text-nowrap">Jadwal
                            @can('siswa')
                                Pelajaran
                            @endcan
                            @can('guru')
                                Mengajar
                            @endcan
                        </h3>
                    </div>
                    <div class="block-content block-content-full px-3 py-1">
                        <!-- Jadwal -->
                        <div id="jadwal_siswa"></div>
                        <ul class="list-unstyled col-12" id="jadwal_hariIni"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @can('siswa')
            <script>
                function getJadwal(hari, tgl) {
                    $.ajax({
                        url: `{{ url('get-kalender-jadwal') }}`,
                        type: 'GET',
                        data: {
                            hari: hari,
                        },
                        success: function(data) {
                            $('#jadwal_hariIni').empty();
                            let jadwal =
                                `<li class="mb-0 h3 fw-bold" style="color:#45bced;">${hari}<span class="text-dark float-end fs-sm fw-medium mt-2">${tgl}</span></li><div class="border border-bottom mb-3"></div>`;
                            if (data.jadwal.length > 0) {
                                $.each(data.jadwal, function(i, item) {
                                    $.each(item, function(j, detail) {
                                        jadwal += `<li class="mb-0 fw-bold h6">${detail.mapel}</li>
                                    <li class="fs-sm text-dark"><i class="fa-regular fa-clock me-2" style="font-size: .9rem;"></i>${detail.mulai} - ${detail.selesai}</li>
                                    <div class="border border-bottom mb-3 mt-1"></div>`;
                                    });
                                });
                            } else {
                                jadwal +=
                                    `<li class="text-center text-muted my-3">Jadwal Masih Kosong</li>`;
                            }
                            $('#jadwal_hariIni').append(jadwal);
                        }
                    });
                }

                function jadwalPeajaran() {
                    var selectedDate = new Date(); // Gunakan tanggal yang dipilih
                    var startOfWeek = new Date(selectedDate);
                    startOfWeek.setDate(selectedDate.getDate() - (selectedDate.getDay() - 1));

                    var endOfWeek = new Date(selectedDate);
                    endOfWeek.setDate(selectedDate.getDate() + (7 - selectedDate.getDay()));

                    var daftarTanggal = [];
                    for (var d = new Date(startOfWeek); d <= endOfWeek; d.setDate(d.getDate() + 1)) {
                        daftarTanggal.push(new Date(d));
                    }

                    new AirDatepicker('#jadwal_siswa', {
                        inline: true,
                        classes: 'w-100 border-0 mb-3 text-dark fw-medium',
                        dateFormat: 'yyyy-MM-dd',
                        view: 'days',
                        minDate: startOfWeek,
                        maxDate: endOfWeek,
                        toggleSelected: false,
                        navTitles: {
                            days: '<strong>MMMM</strong>, yyyy',
                        },
                        daysName: {
                            classes: 'text-dark'
                        },
                        onRenderCell: function({
                            date,
                            cellType
                        }) {
                            if (cellType === 'day') {
                                var formattedDate = new Date(date).setHours(0, 0, 0, 0);
                                // Periksa apakah tanggal saat ini ada di dalam array daftarTanggal
                                if (!daftarTanggal.find(dt => new Date(dt).setHours(0, 0, 0, 0) === formattedDate)) {
                                    return {
                                        disabled: true,
                                        classes: 'd-none',
                                    };
                                }
                                if (date.getDay() === 0) { // Minggu
                                    return {
                                        disabled: true,
                                        classes: 'disabled-class'
                                    };
                                }
                            }
                        },
                        onSelect: function(formattedDate, date, inst) {
                            var hari = moment(formattedDate.formattedDate).format('dddd');
                            var hariIndonesia = {
                                'Sunday': 'Minggu',
                                'Monday': 'Senin',
                                'Tuesday': 'Selasa',
                                'Wednesday': 'Rabu',
                                'Thursday': 'Kamis',
                                'Friday': 'Jumat',
                                'Saturday': 'Sabtu',
                            };
                            var tgl = moment(formattedDate.formattedDate).format('DD-MM-yyyy');
                            // console.log(formattedDate);
                            getJadwal(hariIndonesia[hari], tgl)
                        }
                    }).selectDate(selectedDate);
                }

                function showDataPresensi() {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('get-kehadiran-siswa') }}",
                        data: {
                            periode: {!! json_encode($periode->idPeriode) !!},
                        },
                        success: function(data) {
                            console.log(data);
                            $('#chart_kehadiran').empty();
                            var bulan = [];
                            var hadir = [];
                            var sakit = [];
                            var izin = [];
                            var alfa = [];
                            $.each(data.bulan, function(i, bln) {
                                bulan.push(bln);
                                let kehadiran = data.presensi;
                                let jmlHadir = kehadiran.filter(function(presensi) {
                                    return presensi.bulan === bln && presensi.presensi === 'H';
                                }).length;
                                let jmlSakit = kehadiran.filter(function(presensi) {
                                    return presensi.bulan === bln && presensi.presensi === 'S';
                                }).length;
                                let jmlIzin = kehadiran.filter(function(presensi) {
                                    return presensi.bulan === bln && presensi.presensi === 'I';
                                }).length;
                                let jmlAlpa = kehadiran.filter(function(presensi) {
                                    return presensi.bulan === bln && presensi.presensi === 'A';
                                }).length;

                                hadir.push(jmlHadir);
                                sakit.push(jmlSakit);
                                izin.push(jmlIzin);
                                alfa.push(jmlAlpa);
                            });
                            console.log(hadir);

                            var options = {
                                series: [{
                                    name: 'Hadir',
                                    data: hadir
                                }, {
                                    name: 'Sakit',
                                    data: sakit
                                }, {
                                    name: 'Izin',
                                    data: izin
                                }, {
                                    name: 'Alfa',
                                    data: alfa
                                }],
                                chart: {
                                    type: 'area',
                                    height: 300,
                                    stacked: true,
                                    toolbar: {
                                        show: true,
                                        tools: {
                                            download: true,
                                            selection: false,
                                            zoom: false,
                                            zoomin: false,
                                            zoomout: false,
                                            pan: false,
                                            reset: false
                                        },
                                    }
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: false,
                                        columnWidth: '55%',
                                        endingShape: 'rounded'
                                    },
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    show: true,
                                    width: 2,
                                    colors: ['transparent'],
                                },
                                xaxis: {
                                    categories: bulan,
                                },
                                yaxis: {
                                    min: 0,
                                    max: 31,
                                    tickAmount: 10,
                                    labels: {
                                        show: true,
                                        formatter: function(val) {
                                            return Math.floor(val); // Menghilangkan desimal atau koma
                                        }
                                    },
                                },
                                fill: {
                                    opacity: 1
                                },
                                tooltip: {
                                    y: {
                                        formatter: function(val) {
                                            return val + ' Hari'
                                        }
                                    }
                                },
                            };

                            var chart = new ApexCharts(document.querySelector("#chart_kehadiran"), options);
                            chart.render();
                        }
                    });
                }

                function getGrafikNilai() {
                    $('#chart_nilai').empty();
                    $.ajax({
                        url: `{{ route('get-nilai-siswa') }}`,
                        type: 'GET',
                        data: {
                            periode: {!! json_encode($periode->idPeriode) !!},

                        },
                        success: function(data) {
                            var N_map = [];
                            var N_sis = [];
                            var idSiswa = data.siswa.idSiswa;
                            $.each(data.pengajar, function(key, value) {
                                var mapel = value.mapel.singkatan ?? value.mapel.namaMapel;
                                if (mapel) {
                                    N_map.push(mapel);
                                }
                                var nilai = data.nilai.find(function(nilai) {
                                    return nilai.idSiswa === idSiswa &&
                                        nilai.idPengajaran === value.idPengajaran;
                                });
                                if (nilai !== undefined && nilai.raport !== null && nilai.raport !== 0) {
                                    N_sis.push(nilai.raport);
                                }

                            });
                            var options = {
                                series: [{
                                    name: 'Nilai Siswa',
                                    data: N_sis
                                }],
                                chart: {
                                    height: 400,
                                    type: 'bar',
                                },
                                plotOptions: {
                                    bar: {
                                        borderRadius: 5,
                                        columnWidth: '45%',
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
                            };


                            var chart = new ApexCharts(document.querySelector("#chart_nilai"), options);

                            chart.render();
                        },
                    });
                }

                $(document).ready(function() {
                    jadwalPeajaran();
                    // showDataPresensi();
                    getGrafikNilai();
                });
            </script>
        @endcan

        @can('guru')
            <script>
                function getJadwalGuru(hari, tgl) {
                    $.ajax({
                        url: `{{ url('get-guru-jadwal') }}`,
                        type: 'GET',
                        data: {
                            hari: hari
                        },
                        success: function(data) {
                            // console.log(data);
                            $('#jadwal_hariIni').empty();
                            let jadwal =
                                `<li class="mb-0 h3 fw-bold" style="color:#45bced;">${hari}<span class="text-dark float-end fs-sm fw-medium mt-2">${tgl}</span></li><div class="border border-bottom mb-3"></div>`;
                            if (data.jadwal.length > 0) {
                                // console.log('data 1' + data.jadwal);
                                $.each(data.jadwal, function(i, item) {
                                    $.each(item, function(j, detail) {
                                        // console.log(detail);
                                        jadwal +=
                                            `<li class="mb-1 text-warning fw-bold h6">Kelas ${detail.kelas}</li><li class="mb-0 fw-bold h6">${detail.mapel}</li>
                                            <li class="fs-sm text-dark"><i class="fa-regular fa-clock me-2" style="font-size: .9rem;"></i>${detail.mulai} - ${detail.selesai}</li><div class="border border-bottom mb-3 mt-1"></div>`;
                                    });
                                });
                            } else {
                                // console.log('data 3' + data.jadwal);
                                jadwal +=
                                    `<li class="text-center text-muted my-3">Jadwal Masih Kosong</li>`;
                            }
                            $('#jadwal_hariIni').append(jadwal);
                        }
                    });
                }

                function jadwalPeajaran() {
                    var selectedDate = new Date(); // Gunakan tanggal yang dipilih
                    var startOfWeek = new Date(selectedDate);
                    startOfWeek.setDate(selectedDate.getDate() - (selectedDate.getDay() - 1));

                    var endOfWeek = new Date(selectedDate);
                    endOfWeek.setDate(selectedDate.getDate() + (7 - selectedDate.getDay()));

                    var daftarTanggal = [];
                    for (var d = new Date(startOfWeek); d <= endOfWeek; d.setDate(d.getDate() + 1)) {
                        daftarTanggal.push(new Date(d));
                    }

                    new AirDatepicker('#jadwal_siswa', {
                        inline: true,
                        classes: 'w-100 border-0 mb-3 text-dark fw-medium',
                        dateFormat: 'yyyy-MM-dd',
                        view: 'days',
                        minDate: startOfWeek,
                        maxDate: endOfWeek,
                        toggleSelected: false,
                        navTitles: {
                            days: '<strong>MMMM</strong>, yyyy',
                        },
                        daysName: {
                            classes: 'text-dark'
                        },
                        onRenderCell: function({
                            date,
                            cellType
                        }) {
                            if (cellType === 'day') {
                                var formattedDate = new Date(date).setHours(0, 0, 0, 0);
                                // Periksa apakah tanggal saat ini ada di dalam array daftarTanggal
                                if (!daftarTanggal.find(dt => new Date(dt).setHours(0, 0, 0, 0) === formattedDate)) {
                                    return {
                                        disabled: true,
                                        classes: 'd-none',
                                    };
                                }
                                if (date.getDay() === 0) { // Minggu
                                    return {
                                        disabled: true,
                                        classes: 'disabled-class',
                                        attrs: {
                                            title: 'Libur!'
                                        }
                                    };
                                }
                            }
                        },
                        onSelect: function(formattedDate, date, inst) {
                            var hari = moment(formattedDate.formattedDate).format('dddd');
                            var hariIndonesia = {
                                'Sunday': 'Minggu',
                                'Monday': 'Senin',
                                'Tuesday': 'Selasa',
                                'Wednesday': 'Rabu',
                                'Thursday': 'Kamis',
                                'Friday': 'Jumat',
                                'Saturday': 'Sabtu',
                            };
                            var tgl = moment(formattedDate.formattedDate).format('DD-MM-yyyy');
                            // console.log(formattedDate);
                            getJadwalGuru(hariIndonesia[hari], tgl)
                        }
                    }).selectDate(selectedDate);

                }

                function getSiswa() {
                    $.ajax({
                        url: `{{ url('chart/jumlah-siswa') }}`,
                        type: 'GET',
                        data: {
                            periode: $('#periode_id').data('id'),

                        },
                        success: function(data) {
                            $('#grafik_siswa').empty();
                            let kelas = [];
                            let siswaL = [];
                            let siswaP = [];
                            $.each(data, function(key, item) {
                                kelas.push('Kelas ' + item.namaKelas);
                                let L = item.siswa.filter(i => i.jenisKelamin === 'Laki-Laki').length;
                                let P = item.siswa.filter(i => i.jenisKelamin === 'Perempuan').length;
                                siswaL.push(L);
                                siswaP.push(P);
                            });
                            // Mengurutkan kelas bersamaan dengan siswaL dan siswaP
                            let combined = kelas.map(function(value, index) {
                                return {
                                    kelas: value,
                                    siswaL: siswaL[index],
                                    siswaP: siswaP[index]
                                };
                            });
                            combined.sort((a, b) => a.kelas.localeCompare(b.kelas));
                            kelas = combined.map(item => item.kelas);
                            siswaL = combined.map(item => item.siswaL);
                            siswaP = combined.map(item => item.siswaP);
                            var options = {
                                dataLabels: {
                                    enabled: false,
                                },
                                chart: {
                                    width: '100%',
                                    height: '290px',
                                    type: 'bar',
                                    offsetY: 0,
                                    redrawOnParentResize: true,
                                    redrawOnWindowResize: true
                                },
                                theme: {
                                    palette: 'palette1' // upto palette10
                                },
                                series: [{
                                    name: 'Laki-Laki',
                                    data: siswaL
                                }, {
                                    name: 'Perempuan',
                                    data: siswaP
                                }],
                                xaxis: {
                                    categories: kelas,
                                },
                                legend: {
                                    show: true,
                                    position: 'bottom',
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: false,
                                        columnWidth: '55%',
                                    },
                                },
                            };

                            var chart = new ApexCharts(document.querySelector("#grafik_siswa"), options);

                            chart.render();
                        },
                    });
                }

                var chart;
                function getTb_rekap_nilai() {
                    $('#grafik_dayaSerap').empty();
                    $.ajax({
                        url: `{{ route('get.rekap.nilai') }}`,
                        type: 'GET',
                        data: {
                            periode: $('#periode_id2').data('id'),
                        },
                        success: function(data) {
                            // console.log(data);
                            var kelas = data.kelas.namaKelas;
                            var kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                            var per_smt = $('#periode_id').data('smt');
                            var per_tahun = $('#periode_id').data('tahun');
                            var totalNilaiMapel = {};
                            var jumlahSiswaPerMapel = {};
                            var nilaiTertinggi = {};
                            var nilaiTerendah = {};

                            var chr_mapel = [];

                            $.each(data.pengajar, function(key, value) {
                                var mapel = value.mapel.singkatan ?? value.mapel.namaMapel;
                                chr_mapel.push(mapel);
                                totalNilaiMapel[value.idPengajaran] = 0;
                                jumlahSiswaPerMapel[value.idPengajaran] = 0;
                                nilaiTertinggi[value.idPengajaran] = null;
                                nilaiTerendah[value.idPengajaran] = null;
                            });

                            $.each(data.siswa, function(i, siswa) {
                                // Inisialisasi variabel raport untuk menyimpan total nilai raport per siswa
                                var raport = 0;
                                var jumPengajaran = 0;
                                $.each(data.pengajar, function(key, tpe) {
                                    var nilai = data.nilai.find(function(nilai) {
                                        return nilai.idSiswa === siswa.idSiswa &&
                                            nilai.idPengajaran === tpe.idPengajaran;
                                    });

                                    // Periksa apakah nilai ditemukan
                                    if (nilai !== undefined && nilai.raport !== null && nilai.raport !==
                                        0) {
                                        raport += nilai.raport;
                                        jumPengajaran++;
                                        totalNilaiMapel[tpe.idPengajaran] += nilai.raport;
                                        jumlahSiswaPerMapel[tpe.idPengajaran]++;
                                    } 
                                });
                            });

                            var chr_data_dyserap = [];
                            $.each(data.pengajar, function(key, tpe) {
                                var dayaSerap = jumlahSiswaPerMapel[tpe.idPengajaran] === 0 ? '' : Math.round((
                                    totalNilaiMapel[tpe.idPengajaran] / jumlahSiswaPerMapel[tpe
                                        .idPengajaran])) + '%';
                                chr_data_dyserap.push(jumlahSiswaPerMapel[tpe.idPengajaran] === 0 ? 0 : Math
                                    .round((
                                        totalNilaiMapel[tpe.idPengajaran] / jumlahSiswaPerMapel[tpe
                                            .idPengajaran])));
                            });

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
                            };


                            chart = new ApexCharts(document.querySelector("#grafik_dayaSerap"), options);

                        },
                        complete: function() {
                            chart.render();
                        }
                    });
                }

                $(document).ready(function() {
                    jadwalPeajaran();
                    getSiswa();
                    getTb_rekap_nilai();
                });
            </script>
        @endcan
    @endpush
@endsection
