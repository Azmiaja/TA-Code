@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        @can('super.admin')
            <div class="row g-4">
                <div class="col-lg-9 col-12 ">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xxl-4">
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold">{{ $pegawai }}</dt>
                                        <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Jumlah Pegawai Aktif</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-user-tie fs-3 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="{{ route('pegawai.index') }}">
                                        <span>View all pegawai</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xxl-4">
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold">{{ $siswa }}</dt>
                                        <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Jumlah Siswa Aktif</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-graduation-cap fs-3 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="{{ route('siswa.index') }}">
                                        <span>View all siswa</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xxl-4">
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold">{{ $jumlahUser }}</dt>
                                        <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Jumlah Pengguna Aktif</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="far fa-user-circle fs-3 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="{{ route('user.index') }}">
                                        <span>View all user</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Grafik Siswa</h3>
                                    <div class="block-options">
                                        <select name="pilih_periode" id="pilih_periode" class="form-select form-select-sm">
                                            {{-- <option value="" disabled selected>Pilih Periode</option> --}}
                                            @foreach ($periode as $item)
                                                <option value="{{ $item->idPeriode }}"
                                                    {{ $item->status === 'Aktif' ? 'selected' : '' }}>
                                                    Semester
                                                    {{ $item->semester }} {{ $item->tahun }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="block-content block-content-full">
                                    <div id="grafik_siswa"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full">
                            <div id="chart_pengguna"></div>
                        </div>
                        <div class="bg-body-light rounded-bottom">
                            <span class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex">
                                <span>Grafik Pengguna</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        {{-- Admin --}}
        @can('admin')
            <div class="row g-4">
                <div class="col-lg-9 col-12">
                    <div class="row items-push">
                        <div class="col-sm-12 col-xxl-6">
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold">{{ $pegawai }}</dt>
                                        <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Jumlah Pegawai Aktif</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-user-tie fs-3 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="{{ route('pegawai.index') }}">
                                        <span>View all pegawai</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xxl-6">
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold">{{ $siswa }}</dt>
                                        <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">Jumlah Siswa Aktif</dd>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-graduation-cap fs-3 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="{{ route('siswa.index') }}">
                                        <span>View all siswa</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-12">
                                <div class="block block-rounded">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title">Grafik Siswa</h3>
                                        <div class="block-options">
                                            <select name="pilih_periode" id="pilih_periode" class="form-select form-select-sm">
                                                {{-- <option value="" disabled selected>Pilih Periode</option> --}}
                                                @foreach ($periode as $item)
                                                    <option value="{{ $item->idPeriode }}"
                                                        {{ $item->status === 'Aktif' ? 'selected' : '' }}>
                                                        Semester
                                                        {{ $item->semester }} {{ $item->tahun }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="block-content block-content-full">
                                        <div id="grafik_siswa"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full">
                            <div id="grafik_jumlah_siswa"></div>
                        </div>
                        <div class="bg-body-light rounded-bottom">
                            <span class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex">
                                <span>Grafik Jumlah Siswa</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        @push('scripts')
            @can('super.admin')
                <script>
                    function getChart() {
                        var chart;
                        $.ajax({
                            url: "{{ url('chart/donat/user') }}",
                            method: 'GET',
                            success: function(data) {
                                let Admin = data.guru.find(item => item.hakAkses === 'Admin') ?? '';
                                let Guru = data.guru.find(item => item.hakAkses === 'Guru') ?? '';
                                let Siswa = data.siswa.find(item => item.hakAkses === 'Siswa') ?? '';
                                
                                var admin = Admin.total ?? 0;
                                var guru = Guru.total ?? 0;
                                var siswa = Siswa.total ?? 0;

                                var options = {
                                    dataLabels: {
                                        enabled: false,
                                    },
                                    chart: {
                                        width: '100%',
                                        height: '290px',
                                        type: 'donut',
                                        offsetY: 0,
                                        redrawOnParentResize: true,
                                        redrawOnWindowResize: true
                                    },
                                    theme: {
                                        palette: 'palette4' // upto palette10
                                    },
                                    series: [admin, guru, siswa],
                                    labels: ['Admin', 'Guru', 'Siswa'],
                                    legend: {
                                        show: true,
                                        position: 'bottom',
                                    },
                                    plotOptions: {
                                        pie: {
                                            donut: {
                                                labels: {
                                                    show: true,
                                                    total: {
                                                        show: true,
                                                    }
                                                }
                                            }
                                        }
                                    },
                                };

                                chart = new ApexCharts(document.querySelector("#chart_pengguna"), options);

                            },
                            complete: function() {
                                chart.render();

                            }
                        });
                    }

                    function getSiswa() {
                        var chart;
                        $.ajax({
                            url: `{{ url('chart/jumlah-siswa') }}`,
                            type: 'GET',
                            data: {
                                periode: $('#pilih_periode option:selected').val(),

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

                                chart = new ApexCharts(document.querySelector("#grafik_siswa"), options);

                            },
                            complete: function() {
                                chart.render();

                            }
                        });
                    }

                    $(document).ready(function() {
                        getChart();
                        getSiswa();
                        // getSiswaAktif();
                    });
                    $('#pilih_periode').change(getSiswa);
                </script>
            @endcan
            @can('admin')
                <script>
                    function getSiswa() {
                        var chart;
                        $.ajax({
                            url: `{{ url('chart/jumlah-siswa') }}`,
                            type: 'GET',
                            data: {
                                periode: $('#pilih_periode option:selected').val(),

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

                                chart = new ApexCharts(document.querySelector("#grafik_siswa"), options);

                            },
                            complete: function() {
                                chart.render();

                            }
                        });
                    }

                    function getSiswaAktif() {
                        var chart;
                        $.ajax({
                            url: `{{ url('chart/jumlah-siswa-aktif') }}`,
                            type: "GET",
                            success: function(data) {
                                let laki = data.L;
                                let perm = data.P;

                                var options = {
                                    dataLabels: {
                                        enabled: false,
                                    },
                                    chart: {
                                        width: '100%',
                                        height: '300px',
                                        type: 'donut',
                                        offsetY: 0,
                                        redrawOnParentResize: true,
                                        redrawOnWindowResize: true
                                    },
                                    theme: {
                                        palette: 'palette4' // upto palette10
                                    },
                                    series: [laki, perm],
                                    labels: ['Laki-Laki', 'Perempuan'],
                                    legend: {
                                        show: true,
                                        position: 'bottom',
                                    },
                                    plotOptions: {
                                        pie: {
                                            donut: {
                                                labels: {
                                                    show: true,
                                                    total: {
                                                        show: true,
                                                    }
                                                }
                                            }
                                        }
                                    },
                                };

                                chart = new ApexCharts(document.querySelector("#grafik_jumlah_siswa"), options);

                            },
                            complete: function() {
                                chart.render();

                            }
                        });
                    }
                    $(document).ready(function() {
                        getSiswaAktif();
                        getSiswa();
                    });
                    $('#pilih_periode').change(getSiswa);
                </script>
            @endcan
        @endpush
    @endsection
