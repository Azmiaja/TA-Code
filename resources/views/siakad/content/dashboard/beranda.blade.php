@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="row item-push">
            <div class="col-xl-9 col-md-8 col-12 order-sm-1 order-2">
                @can('siswa')
                    <div class="block block-rounded">
                        {{-- <div class="block-header block-header-default">
                        <h3 class="block-title">Grafik Kehadiran Siswa</h3>
                    </div>
                    <div class="block-content">
                        <div id="chart_kehadiran"></div>
                    </div> --}}
                    </div>
                @endcan
                @can('guru')
                    {{-- <div class="row">
                        <div class="col-md-6">
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Wali Kelas</h3>
                                </div>
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold"></dt>
                                        <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Jumlah Pegawai Aktif</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-user-tie fs-3 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                @endcan
            </div>
            <div class="col-xl-3 col-md-4 col-12 order-sm-2 order-1">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title text-nowrap">Jadwal Mengajar</h3>
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
                                    type: 'bar',
                                    height: 400,
                                    stacked: true,
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
                                    colors: ['transparent']
                                },
                                xaxis: {
                                    categories: bulan,
                                },
                                yaxis: {
                                    min: 0,
                                    max: 31,
                                    tickAmount: 31,
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
                                }
                            };

                            var chart = new ApexCharts(document.querySelector("#chart_kehadiran"), options);
                            chart.render();
                        }
                    });
                }


                $(document).ready(function() {
                    jadwalPeajaran();
                    // showDataPresensi();
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
                $(document).ready(function() {
                    jadwalPeajaran();
                });
            </script>
        @endcan
    @endpush
@endsection
