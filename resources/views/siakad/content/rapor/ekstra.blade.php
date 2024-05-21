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
            <div class="col-md-3 mb-md-0 mb-3">
                <label for="ekskul" class="form-label fw-bold">Ekstrakulikuler</label>
                <select class="form-select fw-semibold" name="" id="ekskul">
                    <option value="wajib">Wajib</option>
                    <option value="pilihan">Pilihan</option>
                </select>
            </div>
        </div>
        {{-- <div class="row g-3 mb-4 justify-content-end"> --}}
        {{-- <div class="col-md-3 mb-md-0 mb-2">
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
            </div> --}}
        {{-- <div class="col-md-3 mb-md-0">
                <label for="ekskul" class="form-label">Ekstrakulikuler</label>
                <select class="form-select fw-medium" name="" id="ekskul">
                    <option value="wajib">Wajib</option>
                    <option value="pilihan">Pilihan</option>
                </select>
            </div> --}}
        {{-- </div> --}}
        <div class="row">
            <div class="col-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Ekstrakulikuler <span id="title_ekstra">Wajib</span></h3>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="table-responsive">
                            <div id="loading_spinner" class="text-center" style="display: none">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <table id="tabel_ekstra"
                                class="table table-bordered align-middle caption-top border-dark w-100">

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal insert --}}
    <div class="modal fade" id="modal_ekstra" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalMapeltLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Kelola Ekstrakulikuler</h3>
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
                        <form id="fr_ekstra" action="{{ route('store.ekstra') }}" method="POST">

                        </form>
                    </div>
                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Apply border to table cells */
        .table11 td {
            border: 1px solid black;
        }

        /* Remove outside border */
        .table11 {
            border-collapse: collapse;
        }

        .table11 tr:first-child td {
            border-top: none;
        }

        .table11 tr td:first-child {
            border-left: none;
        }

        .table11 tr:last-child td {
            border-bottom: none;
        }

        .table11 tr td:last-child {
            border-right: none;
        }
    </style>

    @push('scripts')
        <script>
            function getEkstra() {
                $('#loading_spinner').show();
                $('#tabel_ekstra').empty();
                $.ajax({
                    url: `{{ route('get.ekstra-siswa') }}`,
                    type: 'GET',
                    data: {
                        periode: $('#periode_id').data('id'),
                        ekskul: $('#ekskul option:selected').val()
                    },
                    success: function(data) {
                        // console.log(data);
                        var pedik = $('#ekskul option:selected').val();

                        var kelas = data.kelas.namaKelas;
                        var per_smt = $('#periode_id').data('smt');
                        var kls_name = ['SATU', 'DUA', 'TIGA', 'EMPAT', 'LIMA', 'ENAM'];
                        var table = `<caption class="text-dark">
                                    <strong class="text-start">KELAS : ${kelas} (${kls_name[kelas - 1] ?? ''})</strong>
                                    <strong class="float-end text-uppercase">SEMESTER : ${per_smt}</strong>
                                </caption>
                                <thead class="table-light text-center border-dark align-middle">
                                    <tr>
                                        <th rowspan="2" width="5">No</th>
                                        <th rowspan="2" width="30%">Nama Siswa</th>
                                        <th colspan="2">Ekstrakulikuler ${pedik}</th>
                                        <th rowspan="2" width="50px">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th style="width:200px">Ekskul Diikuti</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                </tbody>`;

                        // table = tabelWajib(table);

                        $.each(data.siswa, function(i, siswa) {

                            table += `<tr>
                            <td class="text-center">${i + 1}</td>
                            <td>${siswa.namaSiswa}</td>`;

                            // console.log(ekstrakulikuler);
                            var ekstrakulikuler = data.ekstra.filter(function(ekstra) {
                                return ekstra.idSiswa == siswa.idSiswa;
                            });

                            if (pedik == 'wajib') {
                                if (ekstrakulikuler.length === 1) {
                                    // console.log(ekstrakulikuler);
                                    $.each(ekstrakulikuler, function(key, val) {
                                        var ekskul = data.ekskul.find(function(ekstra) {
                                            return ekstra.idEks == val.idEks;
                                        });
                                        // console.log(val);
                                        table += `<td style="width:200px">${ekskul.ekstra}</td>
                                    <td>${val.deskripsi}</td>`;
                                    });
                                } else if (ekstrakulikuler.length > 1) {
                                    var ek1 = '';
                                    $.each(ekstrakulikuler, function(key, val) {
                                        var ekskul = data.ekskul.find(function(ekstra) {
                                            return ekstra.idEks == val.idEks;
                                        });
                                        ek1 +=
                                            `<tr class="border-dark"><td width="200" style="min-width:200px;">${ekskul.ekstra}</td><td>${val.deskripsi}</td></tr>`;
                                    });
                                    ek1 =
                                        `<table style="border-collapse: collapse;" class="table table11 w-100 m-0">${ek1}</table>`;
                                    table += `<td class="p-0" colspan="2">${ek1}</td>`;
                                } else {
                                    table += `<td></td>
                                    <td></td>`;
                                }
                            } else if (pedik == 'pilihan') {
                                // console.log(ekstrakulikuler);
                                // console.log(ekstrakulikuler);

                                if (ekstrakulikuler.length == 1) {
                                    $.each(ekstrakulikuler, function(key, val) {
                                        var ekskul = data.ekskul.find(function(ekstra) {
                                            return ekstra.idEks == val.idEks;
                                        });
                                        table += `<td style="width:200px">${ekskul.ekstra}</td>
                                    <td>${val.deskripsi}</td>`;
                                    });
                                } else if (ekstrakulikuler.length > 1) {
                                    var ek1 = '';
                                    $.each(ekstrakulikuler, function(key, val) {
                                        var ekskul = data.ekskul.find(function(ekstra) {
                                            return ekstra.idEks == val.idEks;
                                        });
                                        ek1 +=
                                            `<tr class="border-dark"><td style="width:200px;">${ekskul.ekstra}</td><td>${val.deskripsi}</td></tr>`;
                                    });
                                    ek1 =
                                        `<table style="border-collapse: collapse;" class="table table11 w-100 m-0">${ek1}</table>`;
                                    table += `<td class="p-0" colspan="2">${ek1}</td>`;
                                } else {
                                    table += `<td></td>
                                    <td></td>`;
                                }
                            }

                            table +=
                                `<td width="50px"><button type="button" id="bt_kl_ekstra" title="Edit ${siswa.namaSiswa}" data-id="${siswa.idSiswa}" class="btn btn-alt-warning"><i class="fa-regular fa-pen-to-square"></i></button></td></tr>`;
                        });

                        table += `</tbody>`;

                        $('#tabel_ekstra').append(table);
                    },
                    complete: function() {
                        $('#loading_spinner').hide();
                    }
                });
            }

            function getForm(idSiswa) {
                $('#loading_spinner_2').show();
                $('#fr_ekstra').empty();
                $.ajax({
                    url: `{{ route('get.ekstra-siswa') }}`,
                    type: 'GET',
                    data: {
                        periode: $('#periode_id').data('id'),
                        ekskul: $('#ekskul option:selected').val()
                    },
                    success: function(data) {
                        var siswa = data.siswa.find(function(sis) {
                            return sis.idSiswa == idSiswa;
                        });

                        var form =
                            `@csrf
                    @method('post')
                    <div class="mb-3">
                        <label for="siswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control form-control-alt" id="siswa" readonly value="${siswa.namaSiswa}" />
                        <input type="hidden" name="idSiswa" value="${siswa.idSiswa}" />
                    </div>
                    <div class="mb-3">
                        <label for="ekskul" class="form-label">Ekstrakulikuler ${$('#ekskul option:selected').text().trim()}</label>`;

                        if ($('#ekskul option:selected').text().trim() == 'Wajib') {
                            form += `<div class="form-text">
                            <i class="fa-solid fa-circle-info me-1"></i>Isi deskripsi dari ekstrakulikuler yang wajib diikuti oleh siswa.
                                    </div>`;
                        } else {
                            form += `<div class="form-text">
                            <i class="fa-solid fa-circle-info me-1"></i>Isi deskripsi dari ekstrakulikuler pilihan yang diikuti oleh siswa.
                                    </div>`;
                        }

                        form += `<div class="ms-3 list-group">`;
                        var ekskul = data.ekskul.filter(function(fe) {
                            return fe.status == $('#ekskul option:selected').val();
                        });
                        $.each(ekskul, function(i, ekskul) {
                            var eks = data.ekstra.find(function(fe) {
                                return fe.idSiswa === siswa.idSiswa && fe.idEks === ekskul.idEks;
                            });
                            if (eks) {
                                form += `<div class="mb-3">
                                        <label for="ekstra_${ekskul.idEks}" class="form-label">${ekskul.ekstra}</label>
                                        <div class="d-flex">
                                            <textarea class="form-control me-2" placeholder="Deskripsikan perkembangan siswa dalam ekskul ${ekskul.ekstra}" style="resize:none;" id="ekstra_${ekskul.idEks}" name="ekstra_${ekskul.idEks}" rows="2">${eks.deskripsi}</textarea>
                                            <button type="button" value="${eks.idKegiatan}" data-nama-siswa="${siswa.namaSiswa}" data-nama-ekstra="${ekskul.ekstra}" data-nama-idsis="${siswa.idSiswa}" id="bt_delete_ekstra" class="btn btn-sm btn-alt-danger" title="Hapus">X</button>
                                        </div>
                                        <input type="hidden" name="eksid[]" value="${ekskul.idEks}">
                                    </div>`;
                            } else {
                                form += `<div class="mb-3">
                                        <label for="ekstra_${ekskul.idEks}" class="form-label">${ekskul.ekstra}</label>
                                        <textarea class="form-control" placeholder="Deskripsikan perkembangan siswa dalam ekskul ${ekskul.ekstra}" style="resize:none;" id="ekstra_${ekskul.idEks}" name="ekstra_${ekskul.idEks}" rows="2"></textarea>
                                        <input type="hidden" name="eksid[]" value="${ekskul.idEks}">
                                    </div>`;
                            }
                        });
                        form += `
                        </div>
                    </div>
                    <input type="hidden" name="idPeriode" value="${$('#periode_id').data('id')}"/>
                    <input type="hidden" name="idKelas" value="${data.kelas.idKelas}"/>
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>`;

                        $('#fr_ekstra').append(form);

                        // console.log(siswa);
                    },
                    complete: function() {
                        $('#loading_spinner_2').hide();
                    }
                });
            }

            $(document).ready(function() {
                getEkstra();

                $('#ekskul, #periode_id').change(function() {
                    getEkstra();
                    var text = $('#ekskul option:selected').text().trim();
                    $('#title_ekstra').text(text);
                });

                $(document).on('click', '#bt_kl_ekstra', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $('#modal_ekstra').modal('show');
                    getForm(id);
                });

                $(document).on('submit', '#fr_ekstra', function(e) {
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
                            // console.log(response.data);
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $('#modal_ekstra').modal('hide');
                                getEkstra();
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

                $(document).on('click', '#bt_delete_ekstra', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-ekstra');
                    var siswa = $(this).data('nama-siswa');
                    var idSiswa = $(this).data('nama-idsis');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus ekstrakulikuler <b>${nama}</b> dari siswa <b>${siswa}</b>.`,
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: `{{ url('guru/rapor-siswa/delete/ekstrakulikuler/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            icon: response.status,
                                            title: response.title,
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        getForm(idSiswa);
                                        getEkstra();
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
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
