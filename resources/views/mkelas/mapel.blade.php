@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title --}}
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
                    <button class="btn btn-sm btn-alt-success" id="tambah-mapel"><i class="fa fa-plus mx-2"></i>Tambah
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Mata pelajaran</h3>
            </div>
            <div class="block-content block-content-full">
                <table id="tabelMapel" style="width: 100%" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Nama Pelajaran</th>
                            <th style="width: 50%;">Deskripsi</th>
                            <th class="text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Content --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL INSERT --}}
        <div class="modal fade" id="modal-Mapel" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="modalMapeltLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-transparent mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title" id="title-modal">Tambah Data</h3>
                            <div class="block-options">
                                <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm">
                            {{-- FORM --}}
                            <input type="text" name="idMapel" id="idMapel" class="id-mapel" hidden>
                            <div class="mb-4">
                                <label class="form-label" for="namaMapel">Nama Pelajaran</label>
                                <input type="text" class="form-control  nama-mapel" id="namaMapel" name="namaMapel"
                                    placeholder="Isi nama pelajaran">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="deskripsiMapel">Deskripsi</label>
                                <textarea class="form-control  deskripsi" id="deskripsiMapel"
                                    name="deskripsiMapel"></textarea>
                            </div>
                            <div class="mb-4 text-end" id="cn-btn">
                                {{-- conten button --}}
                            </div>
                        </div>
                        <div class="block-content block-content-full bg-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tabelMapel').DataTable({
                ajax: "{{ url('mapel/get-data') }}",
                columns: [{
                    data: null,
                    name: 'nomor',
                    className: 'fw-sm text-center',
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row +
                            1;
                    }
                }, {
                    data: 'namaMapel',
                    name: 'namaMapel'
                }, {
                    data: 'deskripsiMapel',
                    name: 'deskripsiMapel',
                }, {
                    data: null,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<div class="btn-group">' +
                            '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editMapel" value="' +
                            data.idMapel + '">' +
                            '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusMapel" title="Delete" value="' +
                            data.idMapel + '" data-nama-mapel="' + data.namaMapel + '">' +
                            '<i class="fa fa-fw fa-times"></i></button>' +
                            '</div>';
                    }
                }],
                dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                    "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                    "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                lengthMenu: [10, 25],
            });

            $(document).on('click', '#tambah-mapel', function(e) {
                e.preventDefault();
                $("#modal-Mapel").modal('show');
                $("#cn-btn").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-tambah" id="submit-tambahMapel">Simpan</button>`);
                $('.nama-mapel').val('');
                $('.deskripsi').val('');
            });

            $(document).on('click', '#submit-tambahMapel', function(e) {
                e.preventDefault();
                var data = {
                    'namaMapel': $('.nama-mapel').val(),
                    'deskripsiMapel': $('.deskripsi').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ url('mapel/store') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $(".btn-block-option").click();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#tabelMapel').DataTable().ajax.reload();
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

            $(document).on('click', '#action-editMapel', function(e) {
                e.preventDefault();
                var id = $(this).val();
                $("#modal-Mapel").modal('show');
                $("#title-modal").text('Edut Mapel');
                $("#cn-btn").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-edtMapel">Simpan</button>`);

                $.ajax({
                    type: "GET",
                    url: "{{ url('mapel/edit') }}/" + id,
                    success: function(response) {
                        console.log(response);
                        $('.nama-mapel').val(response.data.namaMapel);
                        $('.deskripsi').val(response.data.deskripsiMapel);
                        $('.id-mapel').val(response.data.idMapel);
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

            $(document).on('click', '#btn-edtMapel', function(e) {
                e.preventDefault();
                var id = $('.id-mapel').val();
                var data = {
                    'namaMapel': $('.nama-mapel').val(),
                    'deskripsiMapel': $('.deskripsi').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PUT",
                    url: "{{ url('mapel/update') }}/" + id,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        $(".btn-block-option").click();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#tabelMapel').DataTable().ajax.reload();
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

            $(document).on('click', '#action-hapusMapel', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var nama = $(this).data('nama-mapel');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Menghapus data ' + nama + '',
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
                            type: "DELETE",
                            url: "{{ url('/mapel/destroy') }}/" + id,
                            dataType: 'json',
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: response.message,
                                });
                                $('#tabelMapel').DataTable().ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Data mapel gagal dihapus.',
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
