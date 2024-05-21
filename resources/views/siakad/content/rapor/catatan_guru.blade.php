@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
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
        </div>
        {{-- <div class="row g-3 mb-4 justify-content-end">
            <div class="col-md-3 mb-md-0 mb-2">
                <label for="periode_id" class="form-label text-uppercase fw-bold fs-sm">Periode</label>
                <select class="form-select fw-medium" name="" id="periode_id">
                    <option value="{{ $periodeAktif->idPeriode }}" data-smt="{{ $periodeAktif->semester }}"
                        data-tahun="{{ $periodeAktif->tahun }}">
                        {{ $periodeAktif->semester }} {{ $periodeAktif->tahun }}
                    </option>
                    <option value="{{ $periodeLewat->idPeriode }}" data-smt="{{ $periodeLewat->semester }}"
                        data-tahun="{{ $periodeLewat->tahun }}">
                        {{ $periodeLewat->semester }} {{ $periodeLewat->tahun }}
                    </option>
                </select>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Catatan Guru</h3>
                        <div class="block-options">
                            <button class="btn btn-sm btn-alt-success" id="kl_catatan">Kelola Catatan</button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="table-responsive">
                            <div id="loading_spinner" class="text-center" style="display: none">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <table id="table_catatan"
                                class="table table-bordered align-middle caption-top border-dark w-100">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal insert Catatan --}}
    <div class="modal fade" id="modal_catatan" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalMapeltLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Kelola Catatan Guru</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm form-container">
                        <form id="fr_catatan" action="{{ route('store.catatan-guru') }}" method="POST">
                            @csrf
                            @method('post')
                            <div id="loading_spinner_2" class="text-center" style="display: none">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <table class="table w-100 align-middle" id="tb_form_catatan">

                            </table>
                            <input type="hidden" name="idPeriode" id="idPeriode_fr">
                            <input type="hidden" name="idKelas" id="idKelas_fr">
                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-primary me-2">Simpan Catatan</button>
                            </div>
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
            function getCatatan() {
                $('#loading_spinner').show();
                $('#table_catatan').empty();
                $.ajax({
                    url: `{{ route('get.catatan-guru') }}`,
                    type: 'GET',
                    data: {
                        periode: $('#periode_id').data('id'),
                    },
                    success: function(data) {
                        // console.log(data);
                        var kelas = data.kelas.namaKelas;
                        var per_smt = $('#periode_id').data('smt');
                        var kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                        var table = `<caption class="text-dark">
                                    <strong class="text-start">KELAS : ${kelas} (${kls_name[kelas - 1] ?? ''})</strong>
                                    <strong class="float-end text-uppercase">SEMESTER : ${per_smt}</strong>
                                </caption>
                                <thead class="table-light text-center border-dark">
                                    <tr>
                                        <th width="20px">No</th>
                                        <th width="300px">Nama Siswa</th>
                                        <th>Catatan Guru</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                        $.each(data.siswa, function(i, siswa) {
                            table += `<tr>
                            <td class="text-center">${i + 1}</td>
                            <td>${siswa.namaSiswa}</td>`;

                            var catatan = data.catatan.find(function(d) {
                                return d.idSiswa === siswa.idSiswa;
                            });
                            if (catatan !== null && catatan !== undefined) {
                                table += `<td>${catatan.catatan_guru}</td>`;
                            } else {
                                table += `<td></td></tr>`;
                            }
                        });

                        table += `</tbody>`;

                        $('#table_catatan').append(table);
                    },
                    complete: function() {
                        $('#loading_spinner').hide();
                    }
                });
            }

            function getFormCatatan() {
                var periode = $('#periode_id').data('id');
                $('#tb_form_catatan').empty();
                $('#loading_spinner_2').show();
                $.ajax({
                    url: `{{ route('get.catatan-guru') }}`,
                    type: 'GET',
                    data: {
                        periode: $('#periode_id').data('id'),
                    },
                    success: function(data) {
                        $('#idPeriode_fr').val($('#periode_id').data('id'));
                        $('#idKelas_fr').val(data.kelas.idKelas);
                        var tab_form = '<tbody>';
                        $.each(data.siswa, function(i, siswa) {
                            tab_form +=
                                `<tr>
                                <td width="5%">${i + 1}</td>
                                <td width="35%"><span class="fw-medium">${siswa.namaSiswa}</span></br><span class="text-muted">${siswa.nis}</span><input type="hidden" name="idSiswa[]" value="${siswa.idSiswa}" /></td>`;

                            var catatan = data.catatan.find(function(d) {
                                return d.idSiswa === siswa.idSiswa;
                            });
                            if (catatan !== null && catatan !== undefined) {
                                tab_form +=
                                    `<td width="55%"><textarea class="form-control" rows="3" style="resize:none" placeholder="Catatan:" name="catatan_guru_${siswa.idSiswa}">${catatan.catatan_guru}</textarea></td>
                                <td width="5%"><button type="button" id="hps_catatan_siswa" data-siswa="${siswa.namaSiswa}" data-id="${catatan.idCtGuru}" class="btn btn-alt-danger">X</button></td>`;
                            } else {
                                tab_form +=
                                    `<td width="60%"><textarea class="form-control" rows="3" style="resize:none" placeholder="Catatan:" name="catatan_guru_${siswa.idSiswa}"></textarea></td>`;
                            }

                        });

                        tab_form += '</tbody>';

                        $('#tb_form_catatan').append(tab_form);

                    },
                    complete: function() {
                        $('#loading_spinner_2').hide();
                    }
                });
            }

            $(document).ready(function() {
                getCatatan();

                $('#periode_id').change(function() {
                    getCatatan();
                });

                $('#kl_catatan').click(function() {
                    $('#modal_catatan').modal('show');
                    getFormCatatan();
                });

                $(document).on('submit', '#fr_catatan', function(e) {
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
                                $('#modal_catatan').modal('hide');
                                getCatatan();
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

                $(document).on('click', '#hps_catatan_siswa', function(e) {
                    e.preventDefault();

                    var id = $(this).data('id');
                    var siswa = $(this).data('siswa');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus catatan guru dari siswa <b>${siswa} ?</b>`,
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
                                url: `{{ url('guru/rapor-siswa/destroy/catatan-guru/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    getFormCatatan();
                                    getCatatan();
                                },
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
