@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        @if ($periode)
            @php
                $kelas = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];
            @endphp
            <div class="row mb-4 justify-content-end align-items-end">
                <div class="col-md-3 mb-md-0 mb-3">
                    <label for="periode_aktif" class="form-label fw-bold">Periode Aktif</label>
                    <input type="text" readonly data-id="{{ $periode->idPeriode }}"
                        value="{{ $periode->semester }} {{ $periode->tahun }}"
                        class="form-control form-control-alt fw-semibold border-secondary" id="periode_aktif">
                </div>
                <div class="col-md-3 mb-md-0 mb-3">
                    <label for="kelas_name" class="form-label fw-bold">Kelas</label>
                    <select class="form-select form-select-lg fw-semibold" name="" id="kelas_name">
                        @foreach ($klsPengajaran as $item)
                            <option value="{{ $item->kelas->namaKelas }}" data-pegawai="{{ $item->idPegawai }}"
                                data-periode="{{ $item->kelas->periode->idPeriode }}"
                                data-kls_id="{{ $item->kelas->idKelas }}">
                                Kelas {{ $item->kelas->namaKelas }}
                                ({{ $kelas[$item->kelas->namaKelas - 1] ?? '' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-auto text-end">
                    <button class="btn btn-lg btn-primary" id="aksi_absen_siswa"><i
                            class="fa-solid fa-list-check me-2"></i>Mulai
                        Presensi</button>
                </div>
            </div>
            <div id="kelas_list">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Daftar Hadir Siswa
                        </h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option me-1" data-toggle="block-option"
                                data-action="fullscreen_toggle"></button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div id="loading_spinner_2" class="text-center" style="display: none">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                        <div class="table-responsive" id="tabel_absenSiswa">
                            {{-- content  --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- MODAL INSERT --}}
    <div class="modal fade" id="modal_absen_siswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalAbsen" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"></h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <form action="" method="POST" enctype="multipart/form-data" id="form_absensi">
                            @csrf
                            <input type="hidden" name="_method" id="method" value="POST">
                            <input type="hidden" name="idPeriode" class="form-control" value="">
                            <input type="hidden" name="idKelas" class="form-control" value="">
                            <input type="hidden" name="idPegawai" class="form-control" value="">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="tanggal_absen" class="col-sm-2 col-form-label">Tanggal</label>
                                        <div class="col-7">
                                            <input type="text" placeholder="PIlih Tanggal" id="tanggal_absen"
                                                name="tanggal" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end ">
                                    <div id="btn_switch" hidden class="form-check form-switch form-check-reverse mt-auto">
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Aktifkan
                                            pengubahan
                                            data</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive mb-3">
                                    <table class="table align-middle table-borderless caption-top table-hover w-100">
                                        <caption class="fs-6 fw-medium mb-1 text-dark"></caption>
                                        <thead class="table-transparent">
                                            <tr>
                                                <th class="text-center" style="width: 5%;"></th>
                                                {{-- <th style="width: 10%;">NIS</th> --}}
                                                <th></th>
                                                <th style="width: 8%;" class="text-center">
                                                    <input type="checkbox" class="form-check-input border-dark"
                                                        title="Hadir Semua" id="pilih_semua"
                                                        style="width: 1.4rem; height: 1.4rem;">
                                                </th>
                                                <th style="width: 8%;" class="text-center">Izin</th>
                                                <th style="width: 8%;" class="text-center">Sakit</th>
                                                <th style="width: 8%;" class="text-center">Alpha</th>
                                            </tr>
                                        </thead>
                                        <tbody id="daftar_siswa">
                                            <div id="loading_spinner" class="text-center" style="display: none;">
                                                <div class="spinner-border text-primary" role="status"></div>
                                            </div>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col text-end btn-form mb-4">
                                    <button type="submit" id="btn_absen" class="btn btn-alt-success">Simpan
                                        Presensi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('style')
        <style>
            #kelas_list .block-content {
                font-family: 'Times New Roman', Times, serif
            }
        </style>
    @endpush --}}

    @push('scripts')
        <script>
            const btnAbsen = $('#aksi_absen_siswa');
            const btnUbahAbsen = $('#ubah_absen');
            const modalAbsen = $('#modal_absen_siswa');
            const formAbsen = $('#form_absensi');
            const method = $('#method');

            $('#btn_switch').on('change', function() {
                if ($('#form_absensi input[type="radio"]').is(':disabled')) {
                    $('#form_absensi input[type="radio"]').prop('disabled', false);
                    $('#btn_absen').prop('disabled', false);
                    $('.form-check-label').text('Nonaktifkan pengubahan data');
                } else {
                    $('#form_absensi input[type="radio"]').prop('disabled', true);
                    $('#btn_absen').prop('disabled', true);
                    $('.form-check-label').text('Aktifkan pengubahan data');
                }
            });

            var daftarTanggal = [];

            function getDataAbsen() {
                $('#tabel_absenSiswa').empty();
                $('#loading_spinner_2').show();
                let name = $('#kelas_name option:selected').val();
                $.ajax({
                    url: `{{ url('guru/presensi/get-data') }}`,
                    type: 'GET',
                    data: {
                        kelas_nama: name,
                    },
                    success: function(data) {
                        let periode = data.periode;
                        let kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                        let kelas = name;
                        moment.locale('id');
                        var today = new Date();
                        var bulanMoment = moment(today.getMonth() + 1, 'MM');
                        var bulanFormatted = bulanMoment.format('MMMM');
                        let bulan = bulanFormatted;

                        daftarTanggal = [...new Set(data.kehadiran.map(item => item.tanggal))].sort((a, b) =>
                            new Date(a) - new Date(b));

                        let kehadiran = data.kehadiran;

                        let table = `<table class="table table-sm table-bordered w-100 border-dark">
                            <thead class="align-middle">
                                <tr class="border-0 p-0">
                                    <th class="border-0 p-0" colspan="${(daftarTanggal.length !== 0 ? daftarTanggal.length : '1')+ 8}">
                                        <strong class="text-start mb-2">
                                        KELAS : ${kelas} (${kls_name[kelas - 1] ?? ''})
                                        </strong>
                                        <strong class="float-end mb-2 text-uppercase">
                                        BULAN : ${bulan}</strong>
                                    </th>
                                </tr>
                                <tr class="table-light border-dark text-center">
                                    <th rowspan="2" style="width: 35px; min-width: 35px;">NO</th>
                                    <th rowspan="2" style="width: 42px; min-width: 42px;">NIS</th>
                                    <th rowspan="2">NAMA SISWA</th>
                                    <th rowspan="2" style="width: 42px; min-width: 42px;">L/P</th>
                                    <th colspan="${daftarTanggal.length !== 0 ? daftarTanggal.length : '1'}">Tanggal</th>
                                    <th colspan="4">Jumlah</th>
                                </tr>
                                <tr class="table-light border-dark">`;

                        if (daftarTanggal.length !== 0) {
                            $.each(daftarTanggal, function(i, tanggal) {
                                let tgl = kehadiran.find(absen => absen.tanggal == tanggal);
                                let bln = moment().format('M');
                                if (tgl !== null) {
                                    table +=
                                        `<th style="width: 35px; min-width: 35px; text-align: center;">
                                                    <a href="javascript:void(0)" id="ubah_absen" 
                                                    data-tgl="${tanggal}"
                                                    data-bln="${bln}" 
                                                    class="nav-link" data-bs-toggle="tooltip"
                                                    data-bs-title="Ubah kehadiran siswa tanggal ${tanggal} ${bulan}.">${tanggal}</a>
                                                </th>`;
                                }
                            });
                        } else {
                            table += `<th style="width:35px; min-width: 35px; text-align:center;">0</th>`;
                        }

                        table += `<th style="width: 35px; min-width: 35px; text-align: center;" title="Hadir">H</th>
                                    <th style="width: 35px; min-width: 35px; text-align: center;" title="Sakit">S</th>
                                    <th style="width: 35px; min-width: 35px; text-align: center;" title="Izin">I</th>
                                    <th style="width: 35px; min-width: 35px; text-align: center;" title="Alpha">A</th>
                                            </tr>
                                        </thead>
                                    <tbody>`;

                        $.each(data.siswa, function(i, siswa) {
                            table += `<tr>
                                <td class="text-center fs-sm ">${i + 1}</td>
                                <td class="fs-sm text-center">${siswa.nis}</td>
                                <td class="fs-sm text-nowrap">${siswa.namaSiswa}</td>
                                <td class="fs-sm text-center">${siswa.jenisKelamin === 'Laki-Laki' ? 'L' : 'P'}</td>`;

                            let pH = '';
                            let pI = '';
                            let pS = '';
                            let pA = '';

                            if (daftarTanggal.length !== 0) {

                                $.each(daftarTanggal, function(i, tanggal) {
                                    let presensi = kehadiran.find(function(item) {
                                        return item.idSiswa === siswa.idSiswa && item
                                            .bulan ===
                                            bulan && item.tanggal === tanggal;
                                    });
                                    let bg;
                                    if (presensi) {
                                        switch (presensi.presensi) {
                                            case 'H':
                                                pH++;
                                                bg = '#B7E5B4';
                                                break;
                                            case 'I':
                                                pI++;
                                                bg = '#EBC49F';
                                                break;
                                            case 'S':
                                                pS++;
                                                bg = '#F1EF99';
                                                break;
                                            default:
                                                pA++;
                                                bg = '#FF8080';
                                                break;
                                        }
                                        table +=
                                            `<td class="fs-sm text-center fw-medium" style="background-color: ${bg};">${presensi.presensi}</td>`;
                                    } else {
                                        table += `<td></td>`;
                                    }
                                });
                            } else {
                                table += `<td class="bg-danger-light"></td>`;
                            }

                            table += `<td class="fs-sm text-center ${pH == 0 ? 'bg-danger-light' : ''}">${pH}</td>
                                <td class="fs-sm text-center ${pS == 0 ? 'bg-danger-light' : ''}">${pS}</td>
                                <td class="fs-sm text-center ${pI == 0 ? 'bg-danger-light' : ''}">${pI}</td>
                                <td class="fs-sm text-center ${pA == 0 ? 'bg-danger-light' : ''}">${pA}</td></tr>`;

                        });

                        table += `</tbody></table>`;

                        $('#tabel_absenSiswa').append(table);
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
                        // Menyembunyikan spinner setelah permintaan selesai, baik berhasil atau tidak
                        $('#loading_spinner_2').hide();
                    },
                });
            }

            function datePicker() {
                new AirDatepicker('#tanggal_absen', {
                    // selectedDates: [new Date()],
                    container: "#modal_absen_siswa",
                    dateFormat: "dd MMMM yyyy",
                    toggleSelected: false,
                    minDate: new Date(new Date().getFullYear(), new Date().getMonth(),
                        1),
                    maxDate: new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0),
                    onRenderCell({
                        date,
                        cellType
                    }) {
                        // Disable all 12th dates in month
                        var disabledDates = daftarTanggal; // Misalnya, tanggal 7, 14, 21, 28
                        // Cek jika cell adalah bagian dari tanggal
                        if (cellType === 'day') {
                            // Cek apakah tanggal saat ini ada dalam daftar tanggal yang ingin dinonaktifkan
                            if (disabledDates.indexOf(date.getDate()) !== -1) {
                                // Mengembalikan objek yang menonaktifkan sel dan menambahkan kelas CSS untuk styling
                                return {
                                    disabled: true,
                                    classes: 'disabled-class',
                                    attrs: {
                                        title: 'Presensi tanggal ini sudah ada!'
                                    }
                                };
                            }
                            if (date.getDay() === 0) { // Minggu
                                return {
                                    disabled: true,
                                    classes: 'disabled-class'
                                };
                            }
                        }
                    }
                });
            }

            $(document).ready(function() {
                getDataAbsen();
                datePicker();

                $('#kelas_name').change(function() {
                    getDataAbsen();
                });

                $('#pilih_semua').change(function() {
                    if ($(this).is(':checked')) {
                        $(document).find('.hadir').prop('checked', true);
                    } else {
                        $(document).find('.hadir').prop('checked', false);
                    }
                });

                function fetchSiswa() {
                    var kelas = $('#kelas_name option:selected').val();
                    var periode = $('#periode_aktif').data('id');
                    var idKelas = $('#kelas_name option:selected').data('kls_id');
                    var idPegawai = $('#kelas_name option:selected').data('pegawai');
                    $('#loading_spinner').show();
                    $.ajax({
                        type: "GET",
                        url: `{{ url('get/tanggal/absen/${kelas}/${periode}') }}`,
                        data: {
                            kelas: idKelas,
                        },
                        success: function(data) {
                            $('#modal_absen_siswa .block-title').text('Presensi Siswa Kelas ' + kelas);
                            $('#form_absensi [name="idPeriode"]').val(periode);
                            $('#form_absensi [name="idKelas"]').val(idKelas);
                            $('#form_absensi [name="idPegawai"]').val(idPegawai);

                            $('#loading_spinner').hide();
                            $('#daftar_siswa').empty();
                            var tot_sis = data.siswa.length;
                            $('caption').text(`Jumlah Siswa : ${tot_sis}`);
                            var absen = '';

                            $.each(data.siswa, function(key, item) {
                                // console.log(item);
                                absen += `<tr>
                                            <td class="text-center fw-medium">${key + 1}</td>
                                            <td><span class="fs-6 fw-medium">${item.namaSiswa}</span></br><span class="text-muted">${item.nis}</span><input type="hidden" value="${item.idSiswa}" name="idSiswa[]"></td>
                                            <td class="text-center px-md-0 px-2">
                                                <input type="radio" class="btn-check hadir" name="presensi_${item.idSiswa}" id="hadir_${item.idSiswa}"
                                                    autocomplete="off" value="hadir" required>
                                                <label class="btn btn-outline-success rounded-circle"
                                                    style="width: 38px; height: 38px;" for="hadir_${item.idSiswa}">H</label>
                                            </td>
                                            <td class="text-center px-md-0 px-2">
                                                <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="izin_${item.idSiswa}"
                                                    autocomplete="off" value="izin" required>
                                                <label class="btn btn-outline-warning rounded-circle"
                                                    style="width: 38px; height: 38px;" for="izin_${item.idSiswa}">I</label>
                                            </td>
                                            <td class="text-center px-md-0 px-2">
                                                <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="sakit_${item.idSiswa}"
                                                    autocomplete="off" value="sakit" required>
                                                <label class="btn btn-outline-info rounded-circle"
                                                    style="width: 38px; height: 38px;" for="sakit_${item.idSiswa}">S</label>
                                            </td>
                                            <td class="text-center px-md-0 px-2">
                                                <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="alfa_${item.idSiswa}"
                                                    autocomplete="off" value="alfa" required>
                                                <label class="btn btn-outline-danger rounded-circle"
                                                    style="width: 38px; height: 38px;" for="alfa_${item.idSiswa}">A</label>
                                            </td>
                                        </tr>`;
                            });
                            $('#daftar_siswa').append(absen);
                        }
                    });
                }

                btnAbsen.click(function(e) {
                    e.preventDefault();
                    modalAbsen.modal('show');
                    // $('#pilih_semua').attr('checked', false);
                    fetchSiswa();
                    // datePicker();
                    method.val('POST');
                    formAbsen.attr('action', `{{ route('absen.siswa.store') }}`);
                    $('#btn_switch').prop('hidden', true);
                });


                modalAbsen.on('hidden.bs.modal', function() {
                    $('#tanggal_absen').prop('disabled', false);
                    $('#btn_absen').prop('disabled', false);
                    $('#tanggal_absen').val(null);
                    $('#btn_switch input[type="checkbox"]').prop('checked', false);
                    $(this).find('#rm_presensi').remove();
                    $('#pilih_semua').attr('checked', false);
                    document.getElementById("pilih_semua").checked = false;
                });

                $(document).on('click', '#ubah_absen', function(e) {
                    e.preventDefault();
                    modalAbsen.modal('show');
                    // fetchSiswa();
                    method.val('PUT');
                    formAbsen.attr('action', `{{ route('absen.siswa.update') }}`);

                    var kelas = $('#kelas_name option:selected').val();
                    var periode = $('#periode_aktif').data('id');
                    var idKelas = $('#kelas_name option:selected').data('kls_id');
                    var idPegawai = $('#kelas_name option:selected').data('pegawai');

                    $('#loading_spinner').show();
                    $('#tanggal_absen').prop('disabled', true);
                    $('#btn_switch').prop('hidden', false);
                    $('#btn_absen').prop('disabled', true);

                    $('#pilih_semua').prop('disabled', true);


                    $.ajax({
                        type: "GET",
                        url: `{{ url('get/siswa/absen/${kelas}/${periode}') }}`,
                        data: {
                            tanggal: $(this).data('tgl'),
                            bulan: $(this).data('bln')
                        },
                        success: function(data) {
                            moment.locale('id');
                            var tanggal_absen_update = moment(data.absen[0].tgl);
                            $('#tanggal_absen').val(tanggal_absen_update.format(
                                'DD MMMM YYYY'));

                            $('#modal_absen_siswa .block-title').text('Presensi Siswa Kelas ' +
                                kelas);
                            $('#form_absensi [name="idPeriode"]').val(periode);
                            $('#form_absensi [name="idKelas"]').val(idKelas);
                            $('#form_absensi [name="idPegawai"]').val(idPegawai);

                            $('#daftar_siswa').empty();
                            var tot_sis = data.siswa.length;
                            $('caption').text(`Jumlah Siswa : ${tot_sis}`);
                            var presensi = [];
                            $.each(data.siswa, function(key, item) {
                                // console.log(data.absen.find(abs => abs.idSiswa === item.idSiswa && abs.presensi === 'H'));
                                $('#daftar_siswa').append(`
                                <tr>
                                    <td class="text-center fw-medium">${key + 1}</td>
                                            <td><span class="fs-6 fw-medium">${item.namaSiswa}</span></br><span class="text-muted">${item.nis}</span><input type="hidden" value="${item.idSiswa}" name="idSiswa[]"></td>
                                <td class="text-center px-md-0 px-2">
                                    <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="hadir_${item.idSiswa}"
                                        autocomplete="off" value="hadir" ${data.absen.find(abs => abs.idSiswa === item.idSiswa && abs.presensi === 'H') ? 'checked disabled' : 'disabled'} required>
                                    <label class="btn btn-outline-success rounded-circle"
                                        style="width: 38px; height: 38px;" for="hadir_${item.idSiswa}">H</label>
                                </td>
                                <td class="text-center px-md-0 px-2">
                                    <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="izin_${item.idSiswa}"
                                        autocomplete="off" value="izin" ${data.absen.find(abs => abs.idSiswa === item.idSiswa && abs.presensi === 'I') ? 'checked disabled' : 'disabled'} required>
                                    <label class="btn btn-outline-warning rounded-circle"
                                        style="width: 38px; height: 38px;" for="izin_${item.idSiswa}">I</label>
                                </td>
                                <td class="text-center px-md-0 px-2">
                                    <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="sakit_${item.idSiswa}"
                                        autocomplete="off" value="sakit" ${data.absen.find(abs => abs.idSiswa === item.idSiswa && abs.presensi === 'S') ? 'checked disabled' : 'disabled'} required>
                                    <label class="btn btn-outline-info rounded-circle"
                                        style="width: 38px; height: 38px;" for="sakit_${item.idSiswa}">S</label>
                                </td>
                                <td class="text-center px-md-0 px-2">
                                    <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="alfa_${item.idSiswa}"
                                        autocomplete="off" value="alfa" ${data.absen.find(abs => abs.idSiswa === item.idSiswa && abs.presensi === 'A') ? 'checked disabled' : 'disabled'} required>
                                    <label class="btn btn-outline-danger rounded-circle"
                                        style="width: 38px; height: 38px;" for="alfa_${item.idSiswa}">A</label>
                                </td>
                            </tr>
                            `);

                                presensi.push(data.pres.find(i => i.idSiswa === item
                                    .idSiswa).idAbsen);

                            });

                            $('.btn-form').prepend(
                                `<button type="button" class="btn btn-alt-danger" id="rm_presensi" 
                                data-tanggal="${$('#tanggal_absen').val()}"
                                data-presensi="${presensi}">Batalkan Presensi</button>`
                            );
                        },
                        complete: function() {
                            $('#loading_spinner').hide();
                        }
                    });
                });

                $('#form_absensi').submit(function(e) {
                    e.preventDefault();

                    var data = new FormData(this);
                    moment.locale('id');
                    var tanggalText = $('#tanggal_absen').val();
                    var tanggalMoment = moment(tanggalText, 'DD MMMM YYYY');
                    var tanggalFormatted = tanggalMoment.format('YYYY-MM-DD');
                    var tanggal = tanggalFormatted === 'Invalid date' ? '' : tanggalFormatted;
                    data.append('tanggal', tanggal);

                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: data,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                modalAbsen.modal('hide');
                                getDataAbsen();
                            } else {
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        },
                    });
                });

                modalAbsen.on('click', '#rm_presensi', function(e) {
                    e.preventDefault();

                    var id = $(this).data('presensi');
                    var tgl = $(this).data('tanggal');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Membatalkan/menghapus presensi pada <b>${tgl} ?</b>`,
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        reverseButtons: true,

                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'DELETE',
                                url: `{{ url('siswa/absen/delete/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    modalAbsen.modal('hide');
                                    getDataAbsen();
                                },
                            });
                        }
                    });
                });

            });
        </script>
    @endpush
@endsection
