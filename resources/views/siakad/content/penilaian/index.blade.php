@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        @if ($periode)
            <div class="row g-3 mb-4 justify-content-end">
                <div class="col-md-3 mb-md-0 mb-2">
                    <label for="periode_id" class="form-label text-uppercase fw-bold fs-sm">Periode Aktif</label>
                    <input type="text" readonly data-id="{{ $periode->idPeriode }}"
                        value="{{ $periode->semester }} {{ $periode->tahun }}"
                        class="form-control-alt fw-medium form-control border-secondary" id="periode_id">
                    {{-- <select class="form-select fw-medium" name="" id="periode_id"> --}}
                    {{-- @if ($periodeAktif && $periodeLewat)
                        <option value="{{ $periodeAktif->idPeriode }}">{{ $periodeAktif->semester }}
                            {{ $periodeAktif->tahun }}
                        </option>
                        <option value="{{ $periodeLewat->idPeriode }}">{{ $periodeLewat->semester }}
                            {{ $periodeLewat->tahun }}
                        </option>
                    @endif --}}
                    {{-- </select> --}}
                </div>
                <div class="col-md-3 mb-md-0 mb-2">
                    <label for="kelas_name" class="form-label text-uppercase fw-bold fs-sm">Kelas</label>
                    <select class="form-select fw-medium" name="" id="kelas_name">
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="mapel_id" class="form-label text-uppercase fw-bold fs-sm">Mata Pelajaran</label>
                    <select class="form-select fw-medium" name="" id="mapel_id">
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Penilaian Siswa</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option me-1" data-toggle="block-option"
                                    data-action="fullscreen_toggle"></button>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="table-responsive">
                                <div id="loading_spinner_2" class="text-center" style="display: none">
                                    <div class="spinner-border text-primary" role="status"></div>
                                </div>
                                <table id="table_penilaian"
                                    class="table table-sm fs-sm table-bordered align-middle border-dark w-100">

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    {{-- Modal insert TP --}}
    <div class="modal fade" id="modal_TP" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalMapeltLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
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
                    <div class="block-content fs-sm form-container">
                        {{-- FORM --}}
                    </div>
                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Menampilkan tabel penilaian
            function getPenilaian() {
                $('#table_penilaian').empty();
                $('#loading_spinner_2').show();
                $.ajax({
                    url: `{{ url('get-data/penilaian-siswa') }}`,
                    type: 'GET',
                    data: {
                        mapel: $('#mapel_id option:selected').val(),
                        kelas: $('#kelas_name option:selected').val(),
                        pengajaran: $('#mapel_id option:selected').data('pengajaran'),
                        periode: $('#periode_id').data('id'),
                    },
                    success: function(data) {
                        var tp_count = data.tp.length;
                        var lm_count = data.lm.length;
                        // console.log(data);

                        var table = `<thead class="text-center align-middle table-light border-dark">
                            <tr>
                                <th class="fixed-side" rowspan="2" width="20px">No</th>
                                <th rowspan="2">Nama Siswa</th>
                                <th colspan="${tp_count + 1}">Sumatif Tujuan Pembelajaran</th>
                                <th colspan="${lm_count + 1}">Sumatif Lingkup Materi</th>
                                <th colspan="3">Sumatif Akhir Semester</th>
                                <th rowspan="2" width="80px" class="text-wrap">Nilai Akhir (Rapor)</th>
                                <th colspan="2" width="100%">Deskripsi Capaian</th>
                            </tr>
                            <tr>`;

                        if (data.tp.length !== 0) {
                            $.each(data.tp, function(i, s_tp) {
                                table +=
                                    `<th width="65px"><button type="button" class="btn rounded-0 btn-success" id="beri_nilai_TP" data-kode="${s_tp.kodeTP}" data-val="${s_tp.deskripsi}" data-id="${s_tp.idTP}" data-bs-toggle="tooltip" data-bs-title="Input Nilai ${s_tp.kodeTP}">${s_tp.kodeTP}</button></th>`;
                            });

                            table += `<th width="65px" class="bg-gray">Nilai Akhir</th>`;
                        } else {
                            table +=
                                `<th width="65px" class="text-center">null</th>`;
                        }

                        if (data.lm.length !== 0) {
                            $.each(data.lm, function(j, s_lm) {
                                table +=
                                    `<th width="65px"><button type="button" class="btn rounded-0 btn-info" id="beri_nilai_LM" data-kode="${s_lm.kodeLM}" data-val="${s_lm.deskripsi}" data-id="${s_lm.idLM}" data-bs-toggle="tooltip" data-bs-title="Input Nilai ${s_lm.kodeLM}">${s_lm.kodeLM}</button></th>`;
                            });

                            table += `<th width="65px" class="bg-gray">Nilai Akhir</th>`;
                        } else {
                            table +=
                                `<th width="65px" class="text-center">null</th>`;
                        }

                        table += `<th width="65px"><button type="button" class="btn rounded-0 btn-primary text-nowrap" style="font-size: 14px;" id="beri_nilai_nontes" data-bs-toggle="tooltip" data-bs-title="Input Nilai Akhir Semester Non Tes">N-Tes</button></th>
                                <th width="65px"><button type="button" class="btn rounded-0 btn-warning" id="beri_nilai_tes" data-bs-toggle="tooltip" data-bs-title="Input Nilai Akhir Semester Tes">Tes</button></th>
                                <th width="65px" class="bg-gray">Nilai Akhir</th>
                                <th class="text-nowrap">Capaian Tertinggi</th>
                                <th class="text-nowrap">Capaian Terendah</th>
                                </tr>
                            </thead>
                            <tbody>`;

                        $.each(data.siswa, function(k, siswa) {
                            table += `<tr>
                            <td class="text-center fixed-side">${k + 1}</td>
                            <td style="min-width:250px">${siswa.namaSiswa}</td>`;

                            if (data.tp.length !== 0) {
                                $.each(data.tp, function(i, s_tp) {
                                    var nilai_tp = data.nilai_tp.find(function(item) {
                                        return item.idSiswa === siswa.idSiswa &&
                                            s_tp.kodeTP === item.kodeTP;
                                    });
                                    if (nilai_tp) {
                                        table +=
                                            `<td class="text-center input-nilai ${nilai_tp.nilaiTP === null ? 'bg-city-lighter' : ''}">${nilai_tp.nilaiTP === null ? '' : nilai_tp.nilaiTP}</td>`;
                                    } else {
                                        table +=
                                            `<td class="text-center input-nilai bg-city-lighter"></td>`;
                                    }
                                });


                                var na_tp = data.nilai.find(function(item) {
                                    return item.idSiswa === siswa.idSiswa;
                                });

                                if (na_tp) {
                                    table +=
                                        `<td class="text-center ${na_tp.nilaiAkhirTP === null ? 'bg-city-lighter' : 'bg-success-light'}">${na_tp.nilaiAkhirTP === null ? '' : na_tp.nilaiAkhirTP}</td>`
                                } else {
                                    table += `<td class="bg-city-lighter"></td>`;
                                }


                            } else {
                                table +=
                                    `<td class="text-center bg-city-lighter"></td>`;
                            }

                            if (data.lm.length !== 0) {
                                $.each(data.lm, function(j, s_lm) {
                                    var nilai_lm = data.nilai_lm.find(function(item) {
                                        return item.idSiswa === siswa.idSiswa &&
                                            item.kodeLM === s_lm.kodeLM;
                                    });
                                    // console.log(nilai_lm);
                                    if (nilai_lm) {
                                        table +=
                                            `<td class="text-center input-nilai ${nilai_lm.nilaiLM === null ? 'bg-city-lighter' : ''}">${nilai_lm.nilaiLM === null ? '' : nilai_lm.nilaiLM}</td>`;
                                    } else {
                                        table +=
                                            `<td class="text-center input-nilai bg-city-lighter"></td>`;
                                    }
                                });

                                var na_lm = data.nilai.find(function(item) {
                                    return item.idSiswa === siswa.idSiswa;
                                });

                                if (na_lm) {
                                    table +=
                                        `<td class="text-center ${na_lm.nilaiAkhirLM === null ? 'bg-city-lighter' : 'bg-success-light'}">${na_lm.nilaiAkhirLM === null ? '' : na_lm.nilaiAkhirLM}</td>`
                                } else {
                                    table += `<td class="bg-city-lighter"></td>`;
                                }

                            } else {
                                table +=
                                    `<td class="text-center bg-city-lighter"></td>`;
                            }

                            var nilai_N_tes = data.nilai.find(function(item) {
                                return item.idSiswa === siswa.idSiswa;
                            });
                            if (nilai_N_tes) {
                                table +=
                                    `<td class="text-center ${nilai_N_tes.nilaiNtes === null ? 'bg-city-lighter' : ''}">${nilai_N_tes.nilaiNtes === null ? '' : nilai_N_tes.nilaiNtes}</td>`;
                            } else {
                                table += `<td class="bg-city-lighter"></td>`;
                            }

                            var nilai_Tes = data.nilai.find(function(item) {
                                return item.idSiswa === siswa.idSiswa;
                            });
                            if (nilai_Tes) {
                                table +=
                                    `<td class="text-center ${nilai_Tes.nilaiTes === null ? 'bg-city-lighter' : ''}">${nilai_Tes.nilaiTes === null ? '' : nilai_Tes.nilaiTes}</td>`;
                            } else {
                                table += `<td class="bg-city-lighter"></td>`;
                            }

                            var nilai_RT = data.nilai.find(function(item) {
                                return item.idSiswa === siswa.idSiswa;
                            });

                            if (nilai_RT) {
                                table +=
                                    `<td class="text-center ${nilai_RT.jumSAkhir === null ? 'bg-city-lighter' : 'bg-success-light'}">${nilai_RT.jumSAkhir === null ? '' : nilai_RT.jumSAkhir}</td>`;
                            } else {
                                table += `<td class="bg-city-lighter"></td>`;
                            }

                            var nilaiRapor = data.nilai.find(function(item) {
                                return item.idSiswa === siswa.idSiswa;
                            });

                            if (nilaiRapor) {
                                table +=
                                    `<td class="text-center ${nilaiRapor.raport === null || nilaiRapor.raport === 0 ? 'bg-city-lighter' : 'bg-success-light'}">${nilaiRapor.raport === null || nilaiRapor.raport === 0 ? '' : nilaiRapor.raport}</td>
                                <td style="min-width:350px; font-size: 10pt;">${nilaiRapor.deskripsiCPtinggi === null ? '' : nilaiRapor.deskripsiCPtinggi}</td>
                                <td style="min-width:350px; font-size: 10pt;">${nilaiRapor.deskripsiCPrendah === null ? '' : nilaiRapor.deskripsiCPrendah}</td></tr>`;
                            } else {
                                table += `<td class="bg-city-lighter"></td>
                            <td></td><td></td></tr>`;
                            }

                            // table += `</tr>`;
                        });

                        table += '<tbody>';

                        $('#table_penilaian').append(table);
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

            // Menampilkan form penilaian TP
            function getTPInput(id, deskripsi, kode) {
                $.ajax({
                    url: `{{ url('get-data/penilaian-siswa') }}`,
                    type: 'GET',
                    data: {
                        mapel: $('#mapel_id option:selected').val(),
                        kelas: $('#kelas_name option:selected').val(),
                        pengajaran: $('#mapel_id option:selected').data('pengajaran'),
                        periode: $('#periode_id').data('id')

                    },
                    success: function(data) {
                        $('#modal_TP .form-container').empty();

                        $('#modal_TP .block-title').text('Input Nilai Tujuan Pembelajaran');

                        let kls_name = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];
                        let kelas = $('#kelas_name option:selected').val();

                        var dataTP = `<form method="post" id="form_TP" action="{!! route('store.nilai.tp') !!}">
                        @csrf
                        @method('post')
                        <div class="row m-0 mb-3">
                                    <table>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Kode</td>
                                            <td class="align-top pe-2">:</td>
                                            <td id="kode_TP" class="align-top">${kode}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Mata Pelajaran</td>
                                            <td class="align-top pe-2">:</td>
                                            <td id="mapel_TP" class="align-top">${$('#mapel_id option:selected').data('nama')}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">KKM</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">${$('#mapel_id option:selected').data('kkm')}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Tujuan Pembelajaran</td>
                                            <td class="align-top pe-2">:</td>
                                            <td id="deskrip_TP" style="text-align:justify;" class="align-top">${deskripsi}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Kelas</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">${kelas} (${kls_name[kelas -1 ?? '']})</td>
                                        </tr>
                                    </table>
                                </div>
                                <table class="table table-sm table-borderles align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                        var nilaiTPP = [];

                        $.each(data.siswa, function(i, item) {
                            dataTP +=
                                `<tr>
                            <td>${i + 1}</td>
                            <td class="text-nowrap">${item.namaSiswa}<input type="hidden" value="${item.idSiswa}" name="idSiswa[]"/></td>`;

                            var nilai_tp = data.nilai_tp.find(function(items) {
                                return items.idSiswa === item.idSiswa &&
                                    items.kodeTP === id;
                            });


                            if (nilai_tp) {
                                nilaiTPP.push(nilai_tp.idNilaiTP);
                                dataTP +=
                                    `<td width="25%"><input type="number" step="any" class="form-control form-control-sm text-center" name="nilai_tp_${item.idSiswa}" value="${nilai_tp.nilaiTP === null ? '' : nilai_tp.nilaiTP}"/></td>`;
                            } else {
                                dataTP +=
                                    `<td width="25%"><input type="number" step="any" class="form-control form-control-sm text-center" name="nilai_tp_${item.idSiswa}" value=""/></td>`;
                            }
                            dataTP += `</tr>`;
                        });

                        dataTP += `</tbody></table>`;
                        dataTP +=
                            `<input type="hidden" value="${id}" name="idTP"/><input type="hidden" name="idPengajaran" value="${$('#mapel_id option:selected').data('pengajaran')}"/><input value="${$('#periode_id').data('id')}" name="idPeriode" type="hidden"/>
                        </div>
                        <div class="mb-4 px-1 text-end">`;

                        if (nilaiTPP.length > 0) {
                            dataTP +=
                                `<button type="button" id="btn_hps_nilaiTP" data-kode="${kode}" data-id="${nilaiTPP}" class="btn btn-danger">Batalkan</button>`;
                        }

                        dataTP += `
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>`;

                        $('#modal_TP .form-container').html(dataTP);

                    }
                });
            }

            // Menampilkan form penilaian LM
            function getLMInput(id, deskripsi, kode) {
                $.ajax({
                    url: `{{ url('get-data/penilaian-siswa') }}`,
                    type: 'GET',
                    data: {
                        mapel: $('#mapel_id option:selected').val(),
                        kelas: $('#kelas_name option:selected').val(),
                        pengajaran: $('#mapel_id option:selected').data('pengajaran'),
                        periode: $('#periode_id').data('id')

                    },
                    success: function(data) {
                        $('#modal_TP .form-container').empty();

                        $('#modal_TP .block-title').text('Input Nilai Lingkup Materi');

                        let kls_name = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];
                        let kelas = $('#kelas_name option:selected').val();

                        var dataTP = `<form id="form_LM" method="post" action="{!! route('store.nilai.lm') !!}">
                            @csrf
                            @method('post')
                            <div class="row m-0 mb-3">
                                    <table>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Kode</td>
                                            <td class="align-top pe-2">:</td>
                                            <td id="kode_LM" class="align-top">${kode}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Mata Pelajaran</td>
                                            <td class="align-top pe-2">:</td>
                                            <td id="mapel_LM" class="align-top">${$('#mapel_id option:selected').text().trim()}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">KKM</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">${$('#mapel_id option:selected').data('kkm')}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Lingkup Materi</td>
                                            <td class="align-top pe-2">:</td>
                                            <td id="desk_LM" class="align-top">${deskripsi}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Kelas</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">${kelas} (${kls_name[kelas -1 ?? '']})</td>
                                        </tr>
                                    </table>
                                </div>
                                <table class="table table-sm table-borderles align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                        var nilaiLMM = [];

                        $.each(data.siswa, function(i, item) {
                            dataTP +=
                                `<tr>
                            <td>${i + 1}</td>
                            <td class="text-nowrap">${item.namaSiswa}<input type="hidden" value="${item.idSiswa}" name="idSiswa[]"/></td>`;

                            var nilai_lm = data.nilai_lm.find(function(items) {
                                return items.idSiswa === item.idSiswa &&
                                    items.kodeLM === id;
                            });
                            if (nilai_lm) {
                                nilaiLMM.push(nilai_lm.idNilaiLM);
                                dataTP +=
                                    `<td width="25%"><input class="form-control form-control-sm text-center" name="nilai_lm_${item.idSiswa}" value="${nilai_lm.nilaiLM === null ? '' : nilai_lm.nilaiLM}"/></td>`;
                            } else {
                                dataTP +=
                                    `<td width="25%"><input class="form-control form-control-sm text-center" name="nilai_lm_${item.idSiswa}" value=""/></td>`;
                            }
                            dataTP += `</tr>`;
                        });

                        dataTP +=
                            `</tbody>
                        </table>
                        <input type="hidden" value="${id}" name="idLM"/><input type="hidden" name="idPengajaran" value="${$('#mapel_id option:selected').data('pengajaran')}"/><input value="${$('#periode_id').data('id')}" name="idPeriode" type="hidden"/>
                        </div>
                        <div class="mb-4 px-1 text-end">`;
                        if (nilaiLMM.length > 0) {
                            dataTP +=
                                `<button type="button" id="btn_hps_nilaiLM" data-kode="${kode}" data-id="${nilaiLMM}" class="btn btn-danger">Batalkan</button>`;
                        }
                        dataTP += `
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>`;

                        $('#modal_TP .form-container').html(dataTP);


                    }
                });
            }

            // Menampilkan form penilaian akhir Non Tes
            function getSAkhirNoTes() {
                $.ajax({
                    url: `{{ url('get-data/penilaian-siswa') }}`,
                    type: 'GET',
                    data: {
                        mapel: $('#mapel_id option:selected').val(),
                        kelas: $('#kelas_name option:selected').val(),
                        pengajaran: $('#mapel_id option:selected').data('pengajaran'),
                        periode: $('#periode_id').data('id')

                    },
                    success: function(data) {
                        $('#modal_TP .form-container').empty();

                        $('#modal_TP .block-title').text('Input Nilai Akhir Semester');

                        let kls_name = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];
                        let kelas = $('#kelas_name option:selected').val();

                        var dataTP = `<form id="form_NonTes" method="post" action="{!! route('store.nilai.akhir.nontes') !!}">
                            @csrf
                            @method('post')
                            <div class="row m-0 mb-3">
                                    <table>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Penilaian</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">Non Tes</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Mata Pelajaran</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">${$('#mapel_id option:selected').text().trim()}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">KKM</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">${$('#mapel_id option:selected').data('kkm')}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Kelas</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">${kelas} (${kls_name[kelas -1 ?? '']})</td>
                                        </tr>
                                    </table>
                                </div>
                                <table class="table table-sm table-borderles align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                        var ntesNot = [];
                        $.each(data.siswa, function(i, item) {
                            dataTP +=
                                `<tr>
                            <td>${i + 1}</td>
                            <td class="text-nowrap">${item.namaSiswa}<input type="hidden" value="${item.idSiswa}" name="idSiswa[]"/></td>`;

                            var nilai_akhir_nontes = data.nilai.find(function(items) {
                                return items.idSiswa === item.idSiswa
                            });
                            if (nilai_akhir_nontes) {
                                ntesNot.push(nilai_akhir_nontes.idNilai);
                                dataTP +=
                                    `<td width="25%"><input class="form-control form-control-sm text-center" name="nilai_akhir_nontes_${item.idSiswa}" value="${nilai_akhir_nontes.nilaiNtes === null ? '' : nilai_akhir_nontes.nilaiNtes}"/></td>`;
                            } else {
                                dataTP +=
                                    `<td width="25%"><input class="form-control form-control-sm text-center" name="nilai_akhir_nontes_${item.idSiswa}" value=""/></td>`;
                            }
                            dataTP += `</tr>`;
                        });

                        dataTP +=
                            `</tbody>
                        </table>
                        <input type="hidden" name="idPengajaran" value="${$('#mapel_id option:selected').data('pengajaran')}"/><input value="${$('#periode_id').data('id')}" name="idPeriode" type="hidden"/>
                        </div>
                        <div class="mb-4 px-1 text-end">`;

                        if (ntesNot.length > 0) {
                            dataTP +=
                                `<button type="button" id="btn_hps_Ntes" class="btn btn-danger"data-kode="Non Tes" data-id="${ntesNot}">Batalkan</button>`;
                        }

                        dataTP += `
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>`;

                        $('#modal_TP .form-container').html(dataTP);


                    }
                });
            }

            // Menampilkan form penilaian akhir Tes
            function getSAkhirTes() {
                $.ajax({
                    url: `{{ url('get-data/penilaian-siswa') }}`,
                    type: 'GET',
                    data: {
                        mapel: $('#mapel_id option:selected').val(),
                        kelas: $('#kelas_name option:selected').val(),
                        pengajaran: $('#mapel_id option:selected').data('pengajaran'),
                        periode: $('#periode_id').data('id')

                    },
                    success: function(data) {
                        $('#modal_TP .form-container').empty();

                        $('#modal_TP .block-title').text('Input Nilai Akhir Semester');

                        let kls_name = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];
                        let kelas = $('#kelas_name option:selected').val();

                        var dataTP = `<form id="form_Tes" method="post" action="{!! route('store.nilai.akhir.tes') !!}">
                            @csrf
                            @method('post')
                            <div class="row m-0 mb-3">
                                    <table>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Penilaian</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">Tes</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Mata Pelajaran</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">${$('#mapel_id option:selected').text().trim()}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">KKM</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">${$('#mapel_id option:selected').data('kkm')}</td>
                                        </tr>
                                        <tr>
                                            <td width="35%" class="align-top fw-bold">Kelas</td>
                                            <td class="align-top pe-2">:</td>
                                            <td class="align-top">${kelas} (${kls_name[kelas -1 ?? '']})</td>
                                        </tr>
                                    </table>
                                </div>
                                <table class="table table-sm table-borderles align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                        var ntesNot = [];

                        $.each(data.siswa, function(i, item) {
                            dataTP +=
                                `<tr>
                            <td>${i + 1}</td>
                            <td class="text-nowrap">${item.namaSiswa}<input type="hidden" value="${item.idSiswa}" name="idSiswa[]"/></td>`;

                            var nilai_akhir_tes = data.nilai.find(function(items) {
                                return items.idSiswa === item.idSiswa
                            });
                            if (nilai_akhir_tes) {
                                ntesNot.push(nilai_akhir_tes.idNilai);
                                dataTP +=
                                    `<td width="25%"><input class="form-control form-control-sm text-center" name="nilai_akhir_tes_${item.idSiswa}" value="${nilai_akhir_tes.nilaiTes === null ? '' : nilai_akhir_tes.nilaiTes}"/></td>`;
                            } else {
                                dataTP +=
                                    `<td width="25%"><input class="form-control form-control-sm text-center" name="nilai_akhir_tes_${item.idSiswa}" value=""/></td>`;
                            }
                            dataTP += `</tr>`;
                        });

                        dataTP +=
                            `</tbody>
                        </table>
                        <input type="hidden" name="idPengajaran" value="${$('#mapel_id option:selected').data('pengajaran')}"/><input value="${$('#periode_id').data('id')}" name="idPeriode" type="hidden"/>
                        </div>
                        <div class="mb-4 px-1 text-end">`;

                        if (ntesNot.length > 0) {
                            dataTP +=
                                `<button type="button" id="btn_hps_Tes" class="btn btn-danger"data-kode="Tes" data-id="${ntesNot}">Batalkan</button>`;
                        }

                        dataTP += `
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>`;

                        $('#modal_TP .form-container').html(dataTP);


                    }
                });
            }

            function getKelas(periode) {
                $('#kelas_name').empty();
                $.ajax({
                    url: `{{ route('get.kelas.gurupengajar') }}`,
                    type: 'GET',
                    data: {
                        periode: periode,
                    },
                    success: function(data) {
                        // console.log(data);
                        var option = '';
                        var kelasN = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];
                        $.each(data, function(i, item) {
                            option +=
                                `<option value="${item.kelas.namaKelas}">Kelas ${item.kelas.namaKelas} (${kelasN[item.kelas.namaKelas - 1] ?? ''})</option>`;
                        });
                        $('#kelas_name').html(option);

                        getMapel($('#kelas_name option:selected').val(), $('#periode_id').data('id'));


                    }
                });
            }

            function getMapel(kelas, periode) {
                $('#mapel_id').empty();
                $.ajax({
                    url: `{{ route('get.mapel.gurupengajar.nilai') }}`,
                    type: 'GET',
                    data: {
                        kelas: kelas,
                        periode: periode
                    },
                    success: function(data) {
                        // console.log(data);
                        let option = '';
                        $.each(data.mapel, function(i, item) {
                            let selectedAttr = (i === 0) ? 'selected' : '';
                            option +=
                                `<option data-pengajaran="${item.idPengajaran}" data-nama="${item.mapel.namaMapel}" value="${item.mapel.idMapel}" data-kkm="${item.mapel.kkm}" ${selectedAttr}>${item.mapel.singkatan ?? item.mapel.namaMapel}</option>`;
                        });
                        $('#mapel_id').html(option);

                        getPenilaian();
                    }
                });
            }

            $(document).ready(function() {
                // getPenilaian();

                var periodeID = $('#periode_id').data('id');
                getKelas(periodeID);

                // getPenilaianTable();
                $('#periode_id').change(function() {
                    getKelas($(this).find('option:selected').val());
                });

                $('#kelas_name').change(function() {
                    getMapel($(this).find('option:selected').val(), $('#periode_id').data('id'));
                });

                $('#mapel_id').change(function() {
                    getPenilaian();
                });


                $(document).on('click', '#beri_nilai_TP', function(e) {
                    e.preventDefault();
                    var id = $(this).text().trim();
                    var data = $(this).data('val');
                    var kode = $(this).data('kode');

                    $('#modal_TP').modal('show');
                    // console.log(id);
                    getTPInput(id, data, kode);
                });
                $(document).on('click', '#beri_nilai_LM', function(e) {
                    e.preventDefault();
                    var id = $(this).text().trim();
                    var data = $(this).data('val');
                    var kode = $(this).data('kode');

                    $('#modal_TP').modal('show');
                    // console.log(id);
                    getLMInput(id, data, kode);
                });
                $(document).on('click', '#beri_nilai_nontes', function(e) {
                    e.preventDefault();
                    $('#modal_TP').modal('show');
                    // console.log(id);
                    getSAkhirNoTes();
                });

                $(document).on('click', '#beri_nilai_tes', function(e) {
                    e.preventDefault();
                    $('#modal_TP').modal('show');
                    // console.log(id);
                    getSAkhirTes();
                });

                $(document).on('mouseenter', '#beri_nilai_TP', function() {
                    $(this).tooltip();
                });
                $(document).on('mouseenter', '#beri_nilai_LM', function() {
                    $(this).tooltip();
                });
                $(document).on('mouseenter', '#beri_nilai_nontes', function() {
                    $(this).tooltip();
                });
                $(document).on('mouseenter', '#beri_nilai_tes', function() {
                    $(this).tooltip();
                });

                $(document).on('submit', '#form_TP', function(e) {
                    e.preventDefault();

                    var data = new FormData(this);
                    var kodeTP = $(this).find('#kode_TP').text().trim();
                    var mapel = $(this).find('#mapel_TP').text().trim();
                    var deks = $(this).find('#deskrip_TP').text().trim();
                    data.append('kodeTP', kodeTP);
                    data.append('mapel', mapel);
                    data.append('deskripsiTP', deks);

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
                                $('#modal_TP').modal('hide');
                                getPenilaian();
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

                $(document).on('submit', '#form_LM', function(e) {
                    e.preventDefault();

                    var data = new FormData(this);
                    var kodeLM = $(this).find('#kode_LM').text().trim();
                    var mapel = $(this).find('#mapel_LM').text().trim();
                    var deks = $(this).find('#desk_LM').text().trim();
                    data.append('kodeLM', kodeLM);
                    data.append('mapel', mapel);
                    data.append('deskripsiLM', deks);

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
                                $('#modal_TP').modal('hide');
                                getPenilaian();
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

                $(document).on('submit', '#form_NonTes', function(e) {
                    e.preventDefault();

                    var data = new FormData(this);

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
                                $('#modal_TP').modal('hide');
                                getPenilaian();
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

                $(document).on('submit', '#form_Tes', function(e) {
                    e.preventDefault();

                    var data = new FormData(this);

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
                                $('#modal_TP').modal('hide');
                                getPenilaian();
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

                $(document).on('click', '#btn_hps_nilaiTP', function(e) {
                    e.preventDefault();

                    var id = $(this).data('id');
                    var kode = $(this).data('kode');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Membatalkan/menghapus data penilaian <b>${kode} ?</b>`,
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
                                url: `{{ url('guru/penilaian-siswa/delete-nilaiTP/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    $('#modal_TP').modal('hide');
                                    getPenilaian();
                                },
                            });
                        }
                    });
                });

                $(document).on('click', '#btn_hps_nilaiLM', function(e) {
                    e.preventDefault();

                    var id = $(this).data('id');
                    var kode = $(this).data('kode');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Membatalkan/menghapus data penilaian <b>${kode} ?</b>`,
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
                                url: `{{ url('guru/penilaian-siswa/delete-nilaiLM/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    $('#modal_TP').modal('hide');
                                    getPenilaian();
                                },
                            });
                        }
                    });
                });

                $(document).on('click', '#btn_hps_Tes', function(e) {
                    e.preventDefault();

                    var id = $(this).data('id');
                    var kode = $(this).data('kode');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Membatalkan/menghapus data penilaian <b>${kode} ?</b>`,
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
                                url: `{{ url('guru/penilaian-siswa/delete-Tes/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    $('#modal_TP').modal('hide');
                                    getPenilaian();
                                },
                            });
                        }
                    });
                });

                $(document).on('click', '#btn_hps_Ntes', function(e) {
                    e.preventDefault();

                    var id = $(this).data('id');
                    var kode = $(this).data('kode');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Membatalkan/menghapus data penilaian <b>${kode} ?</b>`,
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
                                url: `{{ url('guru/penilaian-siswa/delete-Ntes/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    $('#modal_TP').modal('hide');
                                    getPenilaian();
                                },
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
