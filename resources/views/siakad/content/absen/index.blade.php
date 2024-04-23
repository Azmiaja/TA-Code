@extends('siakad/layouts/app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="row item-push mb-4">
            <div class="col-12 text-end">
                <button class="btn btn-lg btn-primary" id="aksi_absen_siswa"><i class="fa-solid fa-list-check me-2"></i>Mulai
                    Presensi</button>
            </div>
        </div>
        <div id="kelas_list">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    @php
                        $kelas_nama = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];

                        $daftarTanggal = $kehadiran->pluck('tanggal')->unique()->sort()->toArray();

                    @endphp
                    <h3 class="block-title">Presensi Kelas {{ $kelasName }}
                        ({{ $kelas_nama[$kelasName - 1] ?? '' }})
                    </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option me-1" data-toggle="block-option"
                            data-action="fullscreen_toggle"></button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive" id="tabel_absenSiswa">
                        {{-- content  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL INSERT --}}
    <div class="modal fade" id="modal_absen_siswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalAbsen" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Presensi Kelas {{ $data[0]->kelas->namaKelas }}</h3>
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
                            <input type="hidden" name="idPeriode" class="form-control" value="{{ $periode->idPeriode }}">
                            <input type="hidden" name="idKelas" class="form-control" value="{{ $data[0]->idKelas }}">
                            <input type="hidden" name="idPengajaran" class="form-control"
                                value="{{ $data[0]->idPengajaran }}">
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="tanggal_absen" class="col-sm-2 col-form-label">Tanggal</label>
                                        <div class="col-7">
                                            <input type="text" placeholder="PIlih Tanggal" id="tanggal_absen"
                                                name="tanggal" class="form-control" value readonly>
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
                                    <table class="table align-middle table-borderless table-hover w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 5%;">No</th>
                                                <th style="width: 10%;">NIS</th>
                                                <th>Nama</th>
                                                <th style="width: 8%;" class="text-center">Hadir</th>
                                                <th style="width: 8%;" class="text-center">Izin</th>
                                                <th style="width: 8%;" class="text-center">Sakit</th>
                                                <th style="width: 8%;" class="text-center">Alfa</th>
                                            </tr>
                                        </thead>
                                        <tbody id="daftar_siswa">
                                            <div id="loading_spinner" class="text-center" style="display: none;">
                                                <div class="spinner-border text-primary" role="status"></div>
                                            </div>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col text-end">
                                    {{-- <div class="d-flex justify-content-end form-check ms-auto me-auto mb-3 pb-1">
                                        <input class="form-check-input" required type="checkbox" value=""
                                            id="reverseCheck1" style="width: 18px; height: 18px;">
                                        <label class="form-check-label fw-medium mt-auto ms-1" style="padding-top: 2px;" for="reverseCheck1">
                                            Semua presensi siswa telah terisi dengan benar.
                                        </label>
                                    </div> --}}
                                    <button type="submit" id="btn_absen" class="btn btn-alt-success mb-4">Simpan
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

    @push('style')
        <style>
            #kelas_list .block-content {
                font-family: 'Times New Roman', Times, serif
            }
        </style>
    @endpush

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
                let name = {!! json_encode($kelasName) !!};
                $.ajax({
                    url: `{{ url('guru/presensi/get-data/${name}') }}`,
                    type: 'GET',
                    success: function(data) {
                        $('#tabel_absenSiswa').empty();
                        let periode = data.periode;
                        let kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                        let kelas = {!! json_encode($kelasName) !!};
                        let bulan = data.kehadiran[0].bulan;
                        daftarTanggal = [...new Set(data.kehadiran.map(item => item.tanggal))].sort((a, b) =>
                            new Date(a) - new Date(b));
                        let kehadiran = data.kehadiran;
                        let table = `<table class="table table-sm table-bordered w-100 border-dark">
                            <thead class="align-middle text-center border-dark table-light">
                                <tr>
                                    <h4 class="text-center fw-normal mb-4">
                                        <span>DAFTAR HADIR PESERTA DIDIK</span><br>
                                        <strong>SD NEGERI LEMAHBANG</strong><br>
                                        <span>TAHUN PELAJARAN ${periode.tahun}</span>
                                    </h4>
                                    <strong class="text-start mb-2">
                                        KELAS : ${kelas} (${kls_name[kelas - 1] ?? ''})
                                    </strong>
                                    <strong class="float-end mb-2 text-uppercase">
                                        BULAN : ${bulan}</strong>
                                </tr>
                                <tr>
                                    <th rowspan="2" style="width: 30px;">NO</th>
                                    <th rowspan="2" style="width: 40px;">NIS</th>
                                    <th rowspan="2">NAMA</th>
                                    <th rowspan="2" style="width: 35px;">L/P</th>
                                    <th colspan="${daftarTanggal.length}">Tanggal</th>
                                    <th colspan="4">Jumlah</th>
                                </tr>
                                <tr>`;

                        $.each(daftarTanggal, function(i, tanggal) {
                            let tgl = kehadiran.find(absen => absen.tanggal == tanggal);
                            let bln = {!! json_encode(now()->month) !!};
                            if (tgl) {
                                table +=
                                    `<th style="width: 35px;">
                                        <a href="javascrupt:void(0)" id="ubah_absen" 
                                        data-tgl="${tanggal}"
                                        data-bln="${bln}" 
                                        class="nav-link" data-bs-toggle="tooltip"
                                        data-bs-title="Ubah kehadiran siswa tanggal ${tanggal} ${bulan}.">${tanggal}</a>
                                    </th>`;
                            }
                        });

                        table += `<th style="width: 35px;">H</th>
                                    <th style="width: 35px;">S</th>
                                    <th style="width: 35px;">I</th>
                                    <th style="width: 35px;">A</th>
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

                            $.each(daftarTanggal, function(i, tanggal) {
                                let presensi = kehadiran.find(function(item) {
                                    return item.idSiswa === siswa.idSiswa && item.bulan ===
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
                                        `<td class="fs-sm text-center" style="background-color: ${bg};">${presensi.presensi}</td>`;
                                } else {
                                    table += `<td></td>`;
                                }
                            });

                            table += `<td class="fs-sm text-center ${pH == 0 ? 'bg-danger-light' : ''}">${pH}</td>
                                <td class="fs-sm text-center ${pS == 0 ? 'bg-danger-light' : ''}">${pS}</td>
                                <td class="fs-sm text-center ${pI == 0 ? 'bg-danger-light' : ''}">${pI}</td>
                                <td class="fs-sm text-center ${pA == 0 ? 'bg-danger-light' : ''}">${pA}</td></tr>`;

                        });

                        table += `</tbody></table>`;

                        $('#tabel_absenSiswa').append(table);
                    }
                });
            }

            function datePicker() {
                new AirDatepicker('#tanggal_absen', {
                    // selectedDates: [new Date()],
                    container: "#modal_absen_siswa",
                    dateFormat: "dd MMMM yyyy",
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
                        }
                    }
                });
            }

            $(document).ready(function() {
                getDataAbsen();
                datePicker();

                function fetchSiswa() {
                    var kelas = $('#btn_side_kelas_{{ $data[0]->idKelas }}').data('kelas');
                    var periode = $('#btn_side_kelas_{{ $data[0]->idKelas }}').data('periode');
                    $('#loading_spinner').show();
                    $.ajax({
                        type: "GET",
                        url: `{{ url('get/tanggal/absen/${kelas}/${periode}') }}`,
                        data: {
                            kelas: `{{ $data[0]->idKelas }}`
                        },
                        success: function(data) {
                            $('#loading_spinner').hide();
                            $('#daftar_siswa').empty();
                            $.each(data.siswa, function(key, item) {
                                // console.log(item);
                                $('#daftar_siswa').append(`
                            <tr>
                                <td class="text-center">${key + 1}</td>
                                <td>${item.nis}</td>
                                <td>${item.namaSiswa}<input type="hidden" value="${item.idSiswa}" name="idSiswa[]"></td>
                                <td class="text-center px-md-0 px-2">
                                    <input type="radio" class="btn-check" name="presensi_${item.idSiswa}" id="hadir_${item.idSiswa}"
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
                            </tr>
                            `);
                            });
                        }
                    });
                }

                btnAbsen.click(function(e) {
                    e.preventDefault();
                    modalAbsen.modal('show');
                    fetchSiswa();
                    method.val('POST');
                    formAbsen.attr('action', `{{ route('absen.siswa.store') }}`);
                    $('#btn_switch').prop('hidden', true);
                });


                modalAbsen.on('hidden.bs.modal', function() {
                    $('#tanggal_absen').prop('disabled', false);
                    $('#btn_absen').prop('disabled', false);
                    $('#tanggal_absen').val(null);
                    $('#btn_switch input[type="checkbox"]').prop('checked', false);
                    // formAbsen.trigger('reset');
                });

                $(document).on('click', '#ubah_absen', function(e) {
                    e.preventDefault();
                    modalAbsen.modal('show');
                    // fetchSiswa();
                    method.val('PUT');
                    formAbsen.attr('action', `{{ route('absen.siswa.update') }}`);

                    var kelas = $('#btn_side_kelas_{{ $data[0]->idKelas }}').data('kelas');
                    var periode = $('#btn_side_kelas_{{ $data[0]->idKelas }}').data('periode');
                    $('#loading_spinner').show();
                    $('#tanggal_absen').prop('disabled', true);
                    $('#btn_switch').prop('hidden', false);
                    $('#btn_absen').prop('disabled', true);

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
                            $('#tanggal_absen').val(tanggal_absen_update.format('DD MMMM YYYY'));
                            console.log();
                            $('#loading_spinner').hide();
                            $('#daftar_siswa').empty();
                            $.each(data.siswa, function(key, item) {
                                // console.log(data.absen.find(abs => abs.idSiswa === item.idSiswa && abs.presensi === 'H'));
                                $('#daftar_siswa').append(`
                                <tr>
                                <td class="text-center">${key + 1}</td>
                                <td>${item.nis}</td>
                                <td>${item.namaSiswa}<input type="hidden" value="${item.idSiswa}" name="idSiswa[]"></td>
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

                            });
                        }
                    });
                });

                // insertOrUpdateData($('#form_absensi_siswa'), function() {});
                $('#form_absensi').submit(function(e) {
                    e.preventDefault();

                    var data = new FormData(this);
                    data.append('tanggal', $('#tanggal_absen').val());

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

            });
        </script>
    @endpush
@endsection
