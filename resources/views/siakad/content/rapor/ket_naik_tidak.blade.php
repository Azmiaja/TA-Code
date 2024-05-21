@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="row justify-content-end mb-4 g-4">
            <div class="col-md-3 mb-md-0 mb-3">
                <label for="periode_id" class="form-label fw-bold">Periode Aktif</label>
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
        </div>
        <div class="row">
            <div class="col-12">
                @if ($periode ? $periode->semester == 'Genap' : '')
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Keterangan Naik/Tidak Naik</h3>
                            <div class="block-options">
                                <button type="button" id="kel_ket" class="btn btn-sm btn-alt-success">Kelola Ket.
                                    Naik/Tidak</button>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <div id="loading_spinner" class="text-center" style="display: none">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <div class="table-responsive" id="tbl_ket"></div>
                        </div>
                    </div>
                @else
                    <div class="block block-rounded">
                        <div class="block-content block-content-full text-center">
                            <div class="m-4 p-3 py-6 rounded-4 border border-2 border-danger">
                                <i class="display-3 text-danger fa-solid fa-triangle-exclamation"></i>
                                <p class="fs-4 text-center">Keterangan Naik dan Tidak Hanya Untuk Semester Genap</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal insert --}}
    <div class="modal fade" id="modal_ket" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalMapeltLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Kelola Ket. Naik/Tidak</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm form-container">
                        <div id="loading_spinner_2" class="text-center" style="display: none">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                        <form id="fr_ket" action="" method="POST">

                        </form>
                    </div>
                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function getKet() {
                var periode = $('#periode_id').data('id');
                var kelas = $('#kelas_diampu').data('nama');
                var kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                var per_smt = $('#periode_id').data('smt');
                $('#tbl_ket').empty();
                $('#loading_spinner').show();
                var tabel;
                $.ajax({
                    url: `{{ route('get-data.ket.naik-tidak') }}`,
                    type: 'GET',
                    data: {
                        periode: periode,
                        kelas: kelas
                    },
                    success: function(data) {
                        tabel = `<table class="table table-bordered w-100 border-dark caption-top">
                            <caption class="text-dark">
                                <strong class="text-start">KELAS : ${kelas} (${kls_name[kelas - 1] ?? ''})</strong>
                                <strong class="float-end text-uppercase">SEMESTER : ${per_smt}</strong>
                            </caption>
                            <thead class="table-light text-center align-middle border-dark">
                                <tr>
                                    <th>NO</th>    
                                    <th>Nama Siswa</th>    
                                    <th>Keterangan</th>    
                                    <th>Deskripsi</th>    
                                </tr>
                            </thead>
                            <tbody>`;

                        var siswa = data.siswa;
                        $.each(siswa, function(i, siswa) {

                            tabel += `<tr>
                                    <td class="text-center" style="width:20px; min-width:20px;">${i+1}</td>
                                    <td style="width:300px; min-width:300px;">${siswa.namaSiswa}</td>`;

                            var ket = data.keterangan.find(function(item) {
                                return item.idSiswa == siswa.idSiswa;
                            });
                            if (ket !== undefined) {
                                tabel += `<td class="text-center" style="width:130px; min-width:130px;">${ket.keterangan}</td>
                                <td style="min-width:200px;">${ket.deskripsi}</td>`;
                            } else {
                                tabel += `<td style="width:130px; min-width:130px;"></td>
                                <td style="min-width:200px;"></td>`;
                            }
                            tabel += `</tr>`

                        });
                        tabel += '</tbody>';
                    },
                    complete: function() {
                        $('#loading_spinner').hide();

                        $('#tbl_ket').append(tabel);

                    }
                });
            }

            function getForm() {
                var periode = $('#periode_id').data('id');
                var kelas = $('#kelas_diampu').data('nama');
                var kelas_id = $('#kelas_diampu').data('id');
                $('#modal_ket').modal('show');
                $('#loading_spinner_2').show();
                $('#fr_ket').empty();
                var form;
                $.ajax({
                    url: `{{ route('get-data.ket.naik-tidak') }}`,
                    type: 'GET',
                    data: {
                        periode: periode,
                        kelas: kelas
                    },
                    success: function(data) {
                        form = `<div class="d-flex justify-content-end mb-2">
                                    <label for="naik_semua" class="form-label me-3 mt-1">Naik Semua</label>
                                    <input type="checkbox" class="form-check-input border-dark me-2"
                                                        title="Naik Semua" value="ya" id="naik_semua"
                                                        style="width: 1.4rem; height: 1.4rem;">
                            </div>
                        <table class="table align-middle">`;
                        var siswa = data.siswa;
                        $.each(siswa, function(i, siswa) {
                            form +=
                                `<tr>
                                    <td class="text-center fw-semibold" style="width:15px; min-width:15px;">${i+1}</td>
                                    <td><span class="fw-semibold">${siswa.namaSiswa}</span><br><span class="text-muted">${siswa.nis}</span><input type="hidden" value="${siswa.idSiswa}" name="idSiswa[]"></td>`;
                            var ket = data.keterangan.find(function(item) {
                                return item.idSiswa == siswa.idSiswa;
                            });
                            if (ket !== undefined) {
                                if (ket.keterangan == 'Ya') {
                                    form += `<td>
                                        <select class="form-select ket_naik_tidak" name="keterangan_${siswa.idSiswa}" id="ket_naik_tidak">
                                            <option value="">-</option>
                                            <option selected value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </td>`;
                                } else {
                                    form += `<td>
                                        <select class="form-select ket_naik_tidak" name="keterangan_${siswa.idSiswa}" id="ket_naik_tidak">
                                            <option value="">-</option>
                                            <option value="Ya">Ya</option>
                                            <option selected value="Tidak">Tidak</option>
                                        </select>
                                    </td>`;
                                }
                            } else {
                                form += `<td>
                                    <select class="form-select ket_naik_tidak" name="keterangan_${siswa.idSiswa}" id="ket_naik_tidak">
                                        <option selected value="">-</option>
                                        <option value="Ya">Ya</option>
                                        <option value="Tidak">Tidak</option>
                                    </select>
                                </td>`;

                            }
                            form += `</tr>`;
                        });

                        form += `</table>
                        <input type="hidden" value="${periode}" name="idPeriode"/>
                        <input type="hidden" value="${kelas_id}" name="idKelas"/>
                        <div class="mb-3 text-end">
                            <button class="btn btn-danger" type="button" id="del_all">Batalkan</button>    
                            <button class="btn btn-primary" type="submit">Simpan</button>    
                        </div>`;
                    },
                    complete: function() {
                        $('#loading_spinner_2').hide();
                        $('#fr_ket').append(form);
                        $('#fr_ket').attr('action', `{{ route('store-data.ket.naik-tidak') }}`);

                    }
                });
            }
            $(document).ready(function() {
                var periode = $('#periode_id').data('smt');
                if (periode == 'Genap') {
                    getKet();
                }
                $('#kel_ket').click(function() {
                    getForm();
                });
                $(document).on('change', '#naik_semua', function() {
                    if ($(this).is(':checked')) {
                        $(document).find('.ket_naik_tidak').val('Ya');
                    } else {
                        $(document).find('.ket_naik_tidak').val('');
                    }
                });

                $('#modal_ket').on('hidden.bs.modal', function() {
                    $('#fr_ket').trigger('reset');
                });

                insertOrUpdateData($('#fr_ket'), function() {
                    $('#modal_ket').modal('hide');
                    getKet();
                })

            });
        </script>
    @endpush
@endsection
