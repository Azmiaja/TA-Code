@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        @can('super.admin')
            <div class="row g-4">
                <div class="col-lg-9 col-12">
                    <div class="row items-push">
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
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full ratio ratio-1x1">

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
                        
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full ratio ratio-1x1">

                        </div>
                        <div class="bg-body-light rounded-bottom">
                            <span class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex">
                                <span>Grafik Siswa</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        {{-- <div class="row d-flex nowrap">
            <div
                class="col-xxl-9 col-xl-9 col-lg-8 col-md-7 pe-md-3 mb-sm-3 mb-3 pe-0 col-sm-12 col-12 order-md-first order-last"> --}}
        {{-- @canany(['super.admin', 'admin'])
                    <div class="row item-push mb-md-3 mb-0">
                        <div class=" mb-lg-0 mb-sm-3 mb-3 col-6 col-xl-4 col-sm-4 col-md-6 col-lg-6">
                            <!-- Pending Orders -->
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-2 fw-bold">{{ $pegawai }}</dt>
                                        <dt class="fs-5 fw-medium lh-2">Aktif: <strong
                                                class="text-success">{{ $jumlahPegawaiAktif }}</strong></dt>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-user-tie fs-2 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span>Total Pegawai</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Pending Orders -->
                        </div>
                        <div class="mb-lg-0 mb-sm-3 mb-3 col-xl-4 col-6 col-sm-4 col-md-6 col-lg-6">
                            <!-- Pending Orders -->
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-2 fw-bold">{{ $siswa }}</dt>
                                        <dt class="fs-5 fw-medium lh-2">Aktif: <strong
                                                class="text-success">{{ $jumlahSiswaAktif }}</strong></dt>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-graduation-cap fs-2 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span>Total Siswa</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Pending Orders -->
                        </div>
                        <div class="mt-lg-3 mb-lg-0 mt-xl-0 mb-sm-3 mb-3 col-xl-4 col-sm-4 col-md-12 col-lg-12">
                            <!-- Pending Orders -->
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-1 fw-bold">{{ $jumlahUser }}</dt>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-users fs-2 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span>Total User</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Pending Orders -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Jumlah Pengajar Per Kelas</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <div class="py-1">
                                        <!-- Bars Chart Container -->
                                        <canvas style="max-height: 350px" id="chart_jumlah_pengajar"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Jumlah Siswa Per Kelas</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <div class="py-1">
                                        <!-- Bars Chart Container -->
                                        <canvas style="max-height: 350px" id="chart_jumlah_siswa"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Jenis Kelamin</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <div class="py-1">
                                        <!-- Donut Chart Container -->
                                        <canvas style="width: 100%; max-height: 170px;" id="chrat_bar_jK"></canvas>
                                    </div>
                                    <div class="py-1">
                                        <!-- Donut Chart Container -->
                                        <canvas style="width: 100%; max-height: 170px;" id="chrat_bar_jK_siswa"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcanany --}}
        {{-- @can('siswa')
                    <div class="row item-push mb-md-3 mb-0">
                        <div class=" mb-lg-0 mb-sm-3 mb-3 col-12 col-lg-6">
                            <!-- Pending Orders -->
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-1 fw-bold" id="jumlah_mapel"></dt>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-book fs-2 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span>Total Mapel</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Pending Orders -->
                        </div>
                        <div class="mb-lg-0 mb-sm-3 mb-3 col-12 col-lg-6">
                            <!-- Pending Orders -->
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-4 fw-bold lh-2" id="wali_kelas"></dt>
                                        <dt class="fw-medium lh-1"><small>NIP : <span id="nip_wakel"></span></small></dt>
                                        <dt class="fw-medium lh-1"><small>Hp : <span id="nohp_wakel"></span></small></dt>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-graduation-cap fs-2 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span>Wali Kelas</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Pending Orders -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Nilai Mapel Siswa</h3>
                                    <div class="block-options">
                                        <div class="row pt-1 m-0 float-end">
                                            <label class="col-auto col-form-label" for="semester">Nilai</label>
                                            <div class="col-md col-auto p-0 align-self-center">
                                                <!--ATUR PERIODE-->
                                                <select class="form-select form-select-sm" id="an_nilai">
                                                    <option selected value="nilaiUH">Nilai UH</option>
                                                    <option value="nilaiUTS">Nilai UTS</option>
                                                    <option value="nilaiUAS">Nilai UAS</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="block-content block-content-full">
                                    <div class="py-1">
                                        <!-- Bars Chart Container -->
                                        <canvas style="max-height: 350px" id="chart_nilai_siswa"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan --}}
        {{-- @can('guru')
                    <div class="row item-push mb-md-3 mb-0">
                        <div class=" mb-lg-0 mb-sm-3 mb-3 col-6 col-xl-4 col-sm-4 col-md-6 col-lg-6">
                            <!-- Pending Orders -->
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold" id="jumlah_kelas"></dt>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-book fs-2 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span>Jumlah Kelas Diajar</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Pending Orders -->
                        </div>
                        <div class="mb-lg-0 mb-sm-3 mb-3 col-6 col-xl-4 col-sm-4 col-md-6 col-lg-6">
                            <!-- Pending Orders -->
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold lh-2" id="wali_kelas">Kelas
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-graduation-cap fs-2 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span>Wali Kelas</span>
                                        <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Pending Orders -->
                        </div>
                        <div class="mt-lg-3 mb-lg-0 mt-xl-0 mb-sm-3 mb-3 col-xl-4 col-sm-4 col-md-12 col-lg-12">
                            <!-- Pending Orders -->
                            <div class="block block-rounded d-flex flex-column h-100 mb-0">
                                <div
                                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="fs-3 fw-bold lh-2" id="jml_siswa"></dt>
                                    </dl>
                                    <div class="item item-rounded-lg bg-body-light">
                                        <i class="fa-solid fa-graduation-cap fs-2 text-primary"></i>
                                    </div>
                                </div>
                                <div class="bg-body-light rounded-bottom">
                                    <a class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span>Jumlah Siswa Kelas
                                            <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Pending Orders -->
                        </div>
                    </div>
                @endcan --}}
        {{-- </div> --}}

        {{-- <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-5 ps-md-3 ps-2 p-0 col-sm-12 col-12 order-md-last order-first">
                <div class="row">
                    <div class="col-md-12 col-sm-6">
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title data-kelas">Kalender Jadwal</h3>
                                @canany(['super.admin', 'admin'])
                                    <div class="block-options">
                                        <select id="kelas-nama" class="form-select form-select-sm">
                                            <option selected value="1">Kelas 1</option>
                                            <option value="2">Kelas 2</option>
                                            <option value="3">Kelas 3</option>
                                            <option value="4">Kelas 4</option>
                                            <option value="5">Kelas 5</option>
                                            <option value="6">Kelas 6</option>
                                        </select>
                                    </div>
                                @endcanany
                            </div>
                            <div class="block-content p-0 datepicker-container">
                                <div class="row m-0 justify-content-center">
                                    <div class="col-11">
                                        <div class="" style="width: 70px;" id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light fs-sm">
                                <div class="px-3 py-2" id="dateDetails"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-6">
                        @canany(['super.admin', 'admin'])
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Jumlah User</h3>
                                </div>
                                <div class="block-content block-content-full text-center">
                                    <div class="py-1">
                                        <!-- Donut Chart Container -->
                                        <canvas style="width: 100%" id="chart_donut_jumlah_user"></canvas>
                                    </div>
                                </div>
                            </div>
                        @endcanany
                    </div>
                </div>

            </div> --}}
        {{-- </div> --}}
        {{-- </div> --}}


        @push('scripts')
            @cannot('guru')
                <script>
                    $(document).ready(function() {
                        $('#calendar').datepicker({
                            format: 'yyyy-mm-dd',
                            todayHighlight: true,
                            autoclose: true,
                            orientation: 'bottom auto'
                        });

                        $('#calendar').on('changeDate', function(e) {

                            var selectedDate = e.format('yyyy-mm-dd');

                            var hari = moment(selectedDate).format('dddd');

                            var hariIndonesia = {
                                'Sunday': 'Minggu',
                                'Monday': 'Senin',
                                'Tuesday': 'Selasa',
                                'Wednesday': 'Rabu',
                                'Thursday': 'Kamis',
                                'Friday': 'Jumat',
                                'Saturday': 'Sabtu',
                            };

                            // console.log(hariIndonesia[hari]);

                            $.ajax({
                                url: "{{ url('get-kalender-jadwal') }}",
                                type: 'GET',
                                data: {
                                    hari: hariIndonesia[hari],
                                    kelas: $("#kelas-nama").val(),
                                    periode: $('#periode').val(),
                                },
                                success: function(data) {
                                    if (data && data.data.length > 0) {
                                        // Jika data berhasil diterima

                                        // Tampilkan daftar jadwal pelajaran
                                        var detailsHTML = '<ul class="list-group">';

                                        for (let i = 0; i < data.data.length; i++) {
                                            // Tambahkan detail jadwal pelajaran
                                            detailsHTML += '<li class="list-group-item lh-1">' +
                                                '<strong>' + data.data[i].hari + '</strong> - <strong>' +
                                                data.data[i].namaMapel +
                                                '</strong>' +
                                                '<p>Jam: ' + data.data[i].jamMulai + ' - ' + data.data[i]
                                                .jamSelesai + '</p>' +
                                                '<p class="lh-0">Pengajar: ' + data.data[i].namaPegawai +
                                                '</p></li>';
                                        }

                                        detailsHTML += '</ul>';

                                        // Tampilkan hasil di #dateDetails
                                        $('#dateDetails').html(detailsHTML);
                                    } else {
                                        // Jika data tidak berhasil diterima atau tidak ada jadwal pelajaran

                                        // Tampilkan pesan yang sesuai
                                        var messageHTML = data && data.data.length === 0 ?
                                            '<p>Jadwal pelajaran untuk tanggal ini belum diset.</p>' :
                                            '<p>Gagal mendapatkan jadwal pelajaran.</p>';

                                        $('#dateDetails').html(messageHTML);
                                    }
                                },

                                error: function(error) {
                                    console.error('Error fetching data:', error);
                                }
                            });
                        });
                    });
                </script>
            @endcannot
            @canany(['super.admin', 'admin'])
                <script>
                    $(document).ready(function() {
                        getChart();

                        getChartBarJK();
                        getChartBarJKsiswa();
                        // getChartBar($('#periode').val());
                        getChartBar($('#periode').val());

                        getSiswa($('#periode').val())

                        // Tambahkan event listener untuk perubahan nilai pada elemen select
                        $('#periode').change(function() {
                            getSiswa($(this).val());
                            getChartBar($(this).val());
                        });



                    });

                    function getChart() {
                        $.ajax({
                            url: "{{ url('chart/donat/user') }}",
                            method: 'GET',
                            success: function(data) {
                                console.log(data);

                                var ctx = document.getElementById('chart_donut_jumlah_user').getContext('2d');
                                var chart = new Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: data.data.map(function(item) {
                                            return item.hakAkses;
                                        }),
                                        datasets: [{
                                            label: 'Jumlah User',
                                            data: data.data.map(function(item) {
                                                return item.jumlah;
                                            }),
                                            backgroundColor: [
                                                '#81c2ff',
                                                '#abe37d',
                                                '#fff18a',
                                                '#ffbe8a',
                                                '#f8d4d4',
                                                '#c1e7ee'
                                            ],
                                            borderColor: [
                                                '#81c2ff',
                                                '#abe37d',
                                                '#fff18a',
                                                '#ffbe8a',
                                                '#f8d4d4',
                                                '#c1e7ee'
                                            ],
                                            borderWidth: 1,
                                        }],
                                    },
                                    options: {
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: 'bottom',
                                                labels: {
                                                    fontSize: 16,
                                                },
                                            },
                                        },
                                        responsive: true,
                                    },
                                });
                            },
                        });
                    }

                    function getChartBar(periodeId) {
                        $.ajax({
                            url: `{{ url('/jumlah-pengajar-per-kelas') }}/${periodeId}`,
                            method: 'GET',
                            success: function(data) {
                                console.log(data);

                                const ctx = document.getElementById('chart_jumlah_pengajar').getContext('2d');
                                if (window.myBarChart) {
                                    // Hancurkan chart lama jika sudah ada
                                    window.myBarChart.destroy();
                                }
                                window.myBarChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: data.map((item) => `Kelas ${item.namaKelas}`),
                                        datasets: [{
                                            label: 'Jumlah Pengajar',
                                            data: data.map((item) => item.jumlah),
                                            backgroundColor: [
                                                '#81c2ff',
                                                '#abe37d',
                                                '#fff18a',
                                                '#ffbe8a',
                                                '#f8d4d4',
                                                '#c1e7ee'
                                            ],
                                            borderColor: [
                                                '#81c2ff',
                                                '#abe37d',
                                                '#fff18a',
                                                '#ffbe8a',
                                                '#f8d4d4',
                                                '#c1e7ee'
                                            ],
                                            borderWidth: 1,
                                            borderRadius: 10,
                                        }],
                                    },
                                    options: {
                                        bezierCurve: false,
                                        plugins: {
                                            legend: {
                                                display: false,
                                            },
                                            tooltip: {
                                                radius: '3',
                                                enabled: true,
                                            }
                                        },
                                        responsive: true,
                                        scales: {
                                            x: {
                                                grid: {
                                                    display: false
                                                },
                                            },
                                            y: {
                                                grid: {
                                                    display: false
                                                },
                                            },
                                            // beginAtZero = !0,
                                        },
                                        elements: {
                                            line: {
                                                tension: 0.4, // Set the tension for a smoother line
                                            },
                                        },
                                    },
                                });
                            },
                        });
                    }

                    function getSiswa(periodeId) {
                        $.ajax({
                            url: `{{ url('/jumlah-siswa') }}/${periodeId}`,
                            method: 'GET',
                            success: function(data) {
                                console.log(data);

                                const ctx = document.getElementById('chart_jumlah_siswa').getContext('2d');
                                if (window.siswaChart) {
                                    // Hancurkan chart lama jika sudah ada
                                    window.siswaChart.destroy();
                                }
                                window.siswaChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: data.map((item) => `Kelas ${item.namaKelas}`),
                                        datasets: [{
                                            label: 'Jumlah Siswa',
                                            data: data.map((item) => item.jumlah),
                                            backgroundColor: [
                                                '#81c2ff',
                                                '#abe37d',
                                                '#fff18a',
                                                '#ffbe8a',
                                                '#f8d4d4',
                                                '#c1e7ee'
                                            ],
                                            borderColor: [
                                                '#81c2ff',
                                                '#abe37d',
                                                '#fff18a',
                                                '#ffbe8a',
                                                '#f8d4d4',
                                                '#c1e7ee'
                                            ],
                                            borderWidth: 1,
                                            borderRadius: 10,
                                        }],
                                    },
                                    options: {
                                        bezierCurve: false,
                                        plugins: {
                                            legend: {
                                                display: false,
                                            },
                                            tooltip: {
                                                radius: '3',
                                                enabled: true,
                                            }
                                        },
                                        responsive: true,
                                        scales: {
                                            x: {
                                                grid: {
                                                    display: false
                                                },
                                            },
                                            y: {
                                                grid: {
                                                    display: false
                                                },
                                            },
                                            // beginAtZero = !0,
                                        },
                                        elements: {
                                            line: {
                                                tension: 0.4, // Set the tension for a smoother line
                                            },
                                        },
                                    },
                                });
                            },
                        });
                    }

                    function getChartBarJK() {
                        $.ajax({
                            url: `{{ url('chart/jenis-kelamin') }}`,
                            method: 'GET',
                            success: function(data) {
                                console.log(data);

                                const ctx = document.getElementById('chrat_bar_jK').getContext('2d');
                                const chart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: ['L', 'P'],
                                        datasets: [{
                                            label: 'Jumlah',
                                            data: data.pegawai.map(function(item) {
                                                return item.Jumlah
                                            }),
                                            backgroundColor: [
                                                '#81c2ff',
                                                '#abe37d',
                                            ],
                                            borderColor: [
                                                '#81c2ff',
                                                '#abe37d',
                                            ],
                                            borderWidth: 1,
                                            borderRadius: 10,
                                        }],
                                    },
                                    options: {
                                        indexAxis: 'y',
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                display: false,
                                                position: 'bottom',
                                                labels: {
                                                    fontSize: 16,
                                                },
                                            },
                                            title: {
                                                display: true,
                                                text: 'Pegawai',
                                                fontSize: 50,
                                                align: 'start'
                                            },
                                        },
                                        scales: {
                                            x: {
                                                grid: {
                                                    display: false
                                                }, // Sembunyikan grid untuk sumbu x
                                            },
                                            y: {
                                                grid: {
                                                    display: false
                                                }, // Sembunyikan grid untuk sumbu y
                                            },
                                        },

                                    },
                                });
                            },
                        });
                    }

                    function getChartBarJKsiswa() {
                        $.ajax({
                            url: `{{ url('chart/jenis-kelamin') }}`,
                            method: 'GET',
                            success: function(data) {
                                console.log(data);

                                const ctx = document.getElementById('chrat_bar_jK_siswa').getContext('2d');
                                const chart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: ['L', 'P'],
                                        datasets: [{
                                            label: 'Jumlah',
                                            data: data.siswa.map(function(item) {
                                                return item.Jumlah
                                            }),
                                            backgroundColor: [
                                                '#ffbe8a',
                                                '#f8d4d4',
                                                '#c1e7ee'
                                            ],
                                            borderColor: [
                                                '#ffbe8a',
                                                '#f8d4d4',
                                                '#c1e7ee'
                                            ],
                                            borderWidth: 1,
                                            borderRadius: 10,
                                        }],
                                    },
                                    options: {
                                        indexAxis: 'y',
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                display: false,
                                                position: 'bottom',
                                                labels: {
                                                    fontSize: 16,
                                                },
                                            },
                                            title: {
                                                display: true,
                                                text: 'Siswa',
                                                fontSize: 50,
                                                align: 'start'
                                            },
                                        },
                                        scales: {
                                            x: {
                                                grid: {
                                                    display: false
                                                }, // Sembunyikan grid untuk sumbu x
                                            },
                                            y: {
                                                grid: {
                                                    display: false
                                                }, // Sembunyikan grid untuk sumbu y
                                            },
                                        },

                                    },
                                });
                            },
                        });
                    }
                </script>
            @endcanany
            @can('siswa')
                <script>
                    $(document).ready(function() {


                        $.ajax({
                            url: '{{ route('count-mapel.siswa') }}',
                            type: 'GET',
                            data: {
                                kelas: $("#kelas-nama").val(),
                                periode: $('#periode').val(),
                            },
                            success: function(response) {
                                var wakel = response.wakel;
                                if (wakel && wakel.length > 0) {
                                    var pegawaiPertama = wakel[0];
                                    $('#wali_kelas').text(pegawaiPertama.namaPegawai);
                                    $('#nip_wakel').text(pegawaiPertama.nip);
                                    $('#nohp_wakel').text(pegawaiPertama.noHp);
                                } else {
                                    console.log('Data Wakel Tidak Ditemukan');
                                }
                                // Tampilkan jumlah mata pelajaran di elemen HTML dengan id #jumlah_mapel
                                $('#jumlah_mapel').text(response.jumlah_mapel);

                            },
                            error: function(xhr, status, error) {
                                console.error(error); // Tampilkan pesan kesalahan di konsol
                            }
                        });

                        $('#periode').change(function() {
                            getChartNilai();
                        });

                        getChartNilai();

                        $('#an_nilai').val('nilaiUH');

                        $('#an_nilai').change(function() {
                            getChartNilai();
                        });



                    });

                    function getChartNilai() {
                        $.ajax({
                            url: '{{ route('get-nilai.siswa') }}',
                            type: 'GET',
                            data: {
                                kelas: $("#kelas-nama").val(),
                                periode: $('#periode').val(),
                                idSiswa: $('#HD_idSiswa').data('id-siswa'),
                                nilai: $('#an_nilai').val(),
                            },
                            success: function(data) {
                                console.log(data);

                                const ctx = document.getElementById('chart_nilai_siswa').getContext('2d');
                                if (window.nilaiChart) {
                                    window.nilaiChart.destroy();
                                }

                                // Mengambil label dan warna dari dropdown nilai
                                const selectedNilai = $('#an_nilai').val();
                                const label = selectedNilai === 'nilaiUH' ? 'Nilai UH' :
                                    selectedNilai === 'nilaiUTS' ? 'Nilai UTS' : 'Nilai UAS';


                                window.nilaiChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: data.map(function(item) {
                                            return item.namaMapel;
                                        }),
                                        datasets: [{
                                            label: label,
                                            data: data.map(function(item) {
                                                return item[selectedNilai];
                                            }),
                                            backgroundColor: [
                                                '#81c2ff',
                                                '#abe37d',
                                                '#fff18a',
                                                '#ffbe8a',
                                                '#f8d4d4',
                                                '#c1e7ee'
                                            ],
                                            borderColor: [
                                                '#81c2ff',
                                                '#abe37d',
                                                '#fff18a',
                                                '#ffbe8a',
                                                '#f8d4d4',
                                                '#c1e7ee'
                                            ],
                                            borderWidth: 1,
                                            borderRadius: 10,
                                        }],
                                    },
                                    options: {

                                        responsive: true,
                                        plugins: {
                                            title: {
                                                display: true,
                                                text: label,
                                            },
                                            legend: {
                                                display: false
                                            }
                                        },
                                        scales: {
                                            y: {
                                                grid: {
                                                    display: false
                                                },
                                                max: 100,
                                                callback: function(value) {
                                                    // Batasi nilai sumbu x antara 0 dan 100
                                                    return Math.max(0, Math.min(100, value));
                                                }
                                            },
                                            x: {
                                                grid: {
                                                    display: false
                                                }
                                            }
                                        },
                                    }

                                });
                            }
                        });
                    }
                </script>
            @endcan
            @can('guru')
                <script>
                    $(document).ready(function() {
                        $('#calendar').datepicker({
                            format: 'yyyy-mm-dd',
                            todayHighlight: true,
                            autoclose: true,
                            orientation: 'bottom auto'
                        });

                        $('#calendar').on('changeDate', function(e) {

                            var selectedDate = e.format('yyyy-mm-dd');

                            var hari = moment(selectedDate).format('dddd');

                            var hariIndonesia = {
                                'Sunday': 'Minggu',
                                'Monday': 'Senin',
                                'Tuesday': 'Selasa',
                                'Wednesday': 'Rabu',
                                'Thursday': 'Kamis',
                                'Friday': 'Jumat',
                                'Saturday': 'Sabtu',
                            };

                            // console.log(hariIndonesia[hari]);

                            $.ajax({
                                url: "{{ route('get-jadwal.guru') }}",
                                type: 'GET',
                                data: {
                                    hari: hariIndonesia[hari],
                                    periode: $('#periode').val(),
                                    nama: ' {{ Auth::user()->pegawai->namaPegawai }}',
                                },
                                success: function(data) {
                                    // console.log(data);
                                    if (data && data.length > 0) {
                                        // Jika data berhasil diterima

                                        // Tampilkan daftar jadwal pelajaran
                                        var detailsHTML = '<ul class="list-group">';

                                        for (let i = 0; i < data.length; i++) {
                                            // Tambahkan detail jadwal pelajaran
                                            detailsHTML += '<li class="list-group-item lh-1">' +
                                                '<strong>' + data[i].hari + '</strong> - <strong>' +
                                                data[i].namaMapel +
                                                '</strong>' +
                                                '<p>Jam: ' + data[i].jamMulai + ' - ' + data[i].jamSelesai +
                                                '</p>' +
                                                '<p class="lh-0">Kelas: ' + data[i].namaKelas + '</p></li>';
                                        }

                                        detailsHTML += '</ul>';

                                        // Tampilkan hasil di #dateDetails
                                        $('#dateDetails').html(detailsHTML);
                                    } else {
                                        // Jika data tidak berhasil diterima atau tidak ada jadwal pelajaran

                                        // Tampilkan pesan yang sesuai
                                        var messageHTML = data && data.length === 0 ?
                                            '<p>Jadwal pelajaran untuk tanggal ini belum diset.</p>' :
                                            '<p>Gagal mendapatkan jadwal pelajaran.</p>';

                                        $('#dateDetails').html(messageHTML);
                                    }
                                },

                                error: function(error) {
                                    console.error('Error fetching data:', error);
                                }
                            });



                        });

                        $.ajax({
                            url: '{{ route('get-jml.kelas') }}',
                            type: 'GET',
                            data: {
                                periode: $('#periode').val(),
                                nama: '{{ Auth::user()->pegawai->namaPegawai }}',
                                kelas: '1'
                            },
                            success: function(response) {
                                console.log(response);

                                $('#jumlah_kelas').text(response.jumlah_kelas + ' Kelas');
                                $('#jml_siswa').text(response.jumlahSiswa + ' Siswa');

                            },
                            error: function(xhr, status, error) {
                                console.error(error); // Tampilkan pesan kesalahan di konsol
                            }
                        });
                    });
                </script>
            @endcan
        @endpush
    @endsection
    {{-- kelas: '{{ ucwords(Auth::user()->pegawai->kelas->first()->namaKelas) }}' --}}
