@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title berita --}}
                    <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <a class="link-fx" href="javascript:void(0)">{{ $title }}</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                {{ $title2 }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-6 text-end">
                    <button class="btn btn-sm btn-alt-success" id="tambah-periode"><i class="fa fa-plus mx-2"></i>Tambah
                        Data</button>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Periode</h3>
            </div>
            <div class="block-content block-content-full">
                <table id="tabelPeriode" style="width: 100%;" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="fw-medium text-center">No</th>
                            <th class="fw-medium text-center">Semester</th>
                            <th class="fw-medium text-center">Tanggal Mulai</th>
                            <th class="fw-medium text-center">Tanggal Selesai</th>
                            <th class="fw-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Content --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL INSERT --}}
        <div class="modal fade" id="modal-tambahPeriode" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="modalInsertLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-transparent mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title" id="modal-title">Tambah Data</h3>
                            <div class="block-options">
                                <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                    aria-label="Close" onclick="clearForm()">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm">
                            <div id="panduan-input-periode"></div>
                            {{-- FORM --}}
                            <form action="POST" enctype="multipart/form-data" id="form-periode">
                                <input type="text" name="idPeriode" id="idPeriode" class="id-periode" hidden>
                                <div class="mb-4">
                                    <label class="form-label" for="semester">Semester</label>
                                    <select type="text" class="form-select add-semester" id="semester" name="semester">
                                        <option value="" disabled selected>-- Pilih Semester --</option>
                                        <option value="Ganjil">Ganjil</option>
                                        <option value="Genap">Genap</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="tanggalMulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control  add-tanggal-mulai" id="tanggalMulai"
                                        name="tanggalMulai">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label" for="tanggalSelesai">Tanggal Selesai</label>
                                    <input type="date" class="form-control  add-tanggal-selesai" id="tanggalSelesai"
                                        name="tanggalSelesai">
                                </div>
                                <div class="mb-4 text-end" id="btn-form">
                                </div>
                            </form>
                        </div>
                        <div class="block-content block-content-full bg-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function clearForm() {
                $('#form-periode input').val('');
            }
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#tabelPeriode').DataTable({
                    ajax: "{{ url('get-data/periode') }}",
                    columns: [{
                        data: 'nomor',
                        name: 'nomor',
                        className: 'text-center fw-sm'
                    }, {
                        data: 'semester',
                        name: 'semester',
                        className: 'text-center fw-sm'
                    }, {
                        data: 'tanggalMulai',
                        name: 'tanggalMulai',
                        className: 'text-center fw-sm'
                    }, {
                        data: 'tanggalSelesai',
                        nema: 'tanggalSelesai',
                        className: 'text-center fw-sm'
                    }, {
                        data: null,
                        className: 'text-center',
                        searchable: false,
                        render: function(data, type, row) {
                            return '<div class="btn-group">' +
                                '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editPeriode" value="' +
                                data.idPeriode + '">' +
                                '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusPeriode" title="Delete" value="' +
                                data.idPeriode + '" data-semester="' + data.semester + ' ' + data
                                .tanggalMulai + ' ' + data.tanggalSelesai + '">' +
                                '<i class="fa fa-fw fa-times"></i></button>' +
                                '</div>';
                        }
                    }],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25],
                });

                $('#tambah-periode').click(function() {
                    $('#modal-tambahPeriode').modal('show');
                    $('#modal-title').text('Tambah Periode Baru');
                    $('#btn-form').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-tambah"
                                    id="btn-tambahPeriode">Simpan</button>`);

                    $('#panduan-input-periode').html(`<div class="alert alert-success p-2">
                                <p class="lh-1 fw-bold">Panduan Insert Periode!</p>
                                <ul>
                                    <li class="nav"><span>1. Pilih semester <b>Ganjil/Genap.</b></span></li>
                                    <li class="nav"><span>2. Atur tangal mulai semester.</span></li>
                                    <li class="nav"><span>3. Atur tangal selesai semester.</span></li>
                                    <li class="nav"><span>3. Tekan tombol <b>Simpan</b>.</span></li>
                                </ul>
                            </div>`);

                });

                // STORE DATA
                $(document).on('click', '#btn-tambahPeriode', function(e) {
                    e.preventDefault();
                    var data = new FormData($('#form-periode')[0]);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('periode.store') }}",
                        data: data,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(response) {
                            $("#btn-close").click();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            $('#tabelPeriode').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });

                // EDIT MODAL SHOW
                $(document).on('click', '#action-editPeriode', function(e) {
                    e.preventDefault();
                    var idPeriode = $(this).val();
                    $("#modal-tambahPeriode").modal('show');
                    $('#modal-title').text('Edit Periode')
                    $('#btn-form').html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-tambah"
                                    id="btn-editPeriode">Simpan</button>`);
                    $('#panduan-input-periode').html('');
                    $.ajax({
                        type: "GET",
                        url: "{{ url('periode/edit') }}/" + idPeriode,
                        success: function(response) {
                            $('.add-semester').val(response.periode.semester);
                            $('.add-tanggal-mulai').val(response.periode.tanggalMulai);
                            $('.add-tanggal-selesai').val(response.periode.tanggalSelesai);
                            $('.id-periode').val(response.periode.idPeriode);
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });

                // UPDATE
                $(document).on('click', '#btn-editPeriode', function(e) {
                    e.preventDefault();
                    var idPeriode = $('.id-periode').val();
                    var data = {
                        'semester': $('.add-semester').val(),
                        'tanggalMulai': $('.add-tanggal-mulai').val(),
                        'tanggalSelesai': $('.add-tanggal-selesai').val(),
                    }
                    $.ajax({
                        type: "PUT",
                        url: "{{ url('periode/update') }}/" + idPeriode,
                        dataType: "json",
                        data: data,
                        success: function(response) {
                            $("#btn-close").click();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            $('#tabelPeriode').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });

                //DELETE
                //AJAX UNTUK DELETE DATA
                $(document).on('click', '#action-hapusPeriode', function(e) {
                    e.preventDefault();
                    var idPeriode = $(this).val();
                    var tag = $(this).data('semester');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Menghapus periode ' + tag + '',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'DELETE',
                                url: "{{ url('periode/destroy') }}/" + idPeriode,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });

                                    // Optionally, you can reload the DataTable or update the UI as needed
                                    $('#tabelPeriode').DataTable().ajax.reload();
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: xhr.responseJSON.message,
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
