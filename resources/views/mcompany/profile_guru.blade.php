@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title profil --}}
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
                    <button class="btn btn-sm btn-alt-success" id="insertPPGuru"><i class="fa fa-plus mx-2"></i>Tambah
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        {{-- Alert --}}
        @if (session('success') || $errors->any())
            <div class="alert alert-{{ session('success') ? 'success' : 'warning' }} alert-dismissible fade show"
                role="alert">
                @if (session('success'))
                    {{ session('success') }}
                @else
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Data Profil Guru</h3>
            </div>
            <div class="block-content block-content-full">
                <table id="tabelPPGuru" class="table table-bordered table-striped table-vcenter js-dataTable-responsive"
                    style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 5%" class="text-center">No</th>
                            <th>Nama Guru</th>
                            <th>Jabatan</th>
                            <th style="width: 25%">Gambar Profil</th>
                            <th style="width: 6%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-ppguru" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalInsertLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="modal-title">Tambah Data</h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <div id="panduan-input-periode"></div>
                        {{-- FORM --}}
                        <form method="POST" enctype="multipart/form-data" id="form-ppguru">
                            @csrf
                            @method('put')
                            <input type="hidden" name="idppGuru" id="idppGuru">
                            <div class="mb-4">
                                <label class="form-label" for="idPegawai">Nama Guru</label>
                                <select type="text" class="form-select add-idPegawai" id="idPegawai" name="idPegawai">
                                    <option value="" disabled selected>-- Pilih Guru --</option>
                                    @foreach ($guru as $g)
                                        <option value="{{ $g->idPegawai }}">{{ $g->namaPegawai }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="jabatan">Jabatan</label>
                                <input type="text" name="jabatan" id="jabatan" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="gambarPP">Gambar</label>
                                <div class="row m-0 mb-2">
                                    <div class="col-md-4 p-2 text-center form-control">
                                        <img id="preview-img" alt="preview_img" style="max-height: 200px;">
                                    </div>
                                </div>
                                {{-- <div class="form-group"> --}}
                                <input class="form-control" type="file" name="gambarPP" id="gambarPP"
                                    accept=".jpg, .png, .jpeg, .svg">
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



    @push('scripts')
        <script>
            $(document).ready(function() { // Setup CSRF Token
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#gambarPP').change(function() {
                    var reader = new FileReader();

                    reader.onload = (e) => {
                        $('#preview-img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                });

                $('#tabelPPGuru').DataTable({
                    ajax: '{!! route('profil-guru.show') !!}',
                    columns: [{
                            data: null,
                            name: 'nomor',
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row +
                                    1;
                            }
                        }, {
                            data: 'namaPegawai',
                            name: 'namaPegawai',
                        },
                        {
                            data: 'jabatan',
                            name: 'jabatan',
                        },
                        {
                            data: 'gambarPP',
                            render: function(data, type, row) {
                                var imageUrl = row.gambarPP ? "{{ asset(Storage::url('')) }}/" + row
                                    .gambarPP : '';

                                return '<img src="' + imageUrl + '" alt="Gambar" width="80px"/>';
                            },
                            searchable: false,
                            className: 'fs-sm text-center'
                        },

                        {
                            data: null,
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                                                        '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusPPGuru" title="Delete" value="' +
                                    data.idppGuru + '" data-nama-judul="' + data.namaPegawai +
                                    '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25],
                });

                $('#insertPPGuru').click(function() {
                    $('#modal-ppguru').modal('show');
                    $('#form-ppguru :input').val('');
                    $('#preview-img').attr('src', '');
                    $("#btn-form").html(
                        `<button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-storePP">Simpan</button>`
                    );
                });

                // $(document).on('click', '#action-editPPGuru', function(e) {
                //     e.preventDefault();
                //     $('#modal-ppguru_update').modal('show');
                //     $('#form-ppguru_update :input').val('');
                //     $("#btn-form_update").html(
                //         `<button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                //         <button type="button" class="btn btn-primary" onclick="document.getElementById('form-ppguru_update').submit()">Simpan</button>`
                //     );

                //     var idPP = $(this).val();

                //     $('#form-ppguru_update').attr('action', '{!! url('profil/guru/update') !!}/' + idPP);

                //     $.ajaxSetup({
                //         headers: {
                //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //         }
                //     });

                //     $.ajax({
                //         type: "GET",
                //         url: "{{ url('profil-guru/edit') }}/" + idPP,
                //         headers: {
                //             "Cache-Control": "no-cache, no-store, must-revalidate",
                //             "Pragma": "no-cache"
                //         },
                //         success: function(response) {
                //             $('#idppGuru_update').val(response.idppGuru);
                //             $('#idPegawai_update').val(response.idPegawai);
                //             $('#jabatan_update').val(response.jabatan);

                //             var gambar = response.gambarPP;
                //             if (gambar != null) {
                //                 $('#preview-img_update').attr('src',
                //                     `{{ asset(storage::url('${gambar}')) }}`);
                //             }
                //         },
                //     });
                // });




                // $(document).on('click', '#btn-updatePP', function(e) {
                //     e.preventDefault();
                //     var id = $('#idppGuru').val();
                //     var data = new FormData($('#form-ppguru')[0]);


                //     $.ajax({
                //         type: "PUT",
                //         url: '{{ url('company-profil/profil-guru/update') }}/' + id,
                //         data: data,
                //         contentType: false,
                //         processData: false,
                //         dataType: "json",
                //         success: function(response) {
                //             Swal.fire({
                //                 icon: 'success',
                //                 title: 'Success',
                //                 text: response.message,
                //             });
                //             $('#modal-ppguru').modal('hide');
                //             $('#tabelPPGuru').DataTable().ajax.reload();
                //         },
                //         error: function(xhr, status, error) {
                //             Swal.fire({
                //                 icon: 'error',
                //                 title: 'Error',
                //                 text: xhr.responseJSON.message,
                //             });
                //         }
                //     });
                // });

                $(document).on('click', '#btn-storePP', function(e) {
                    e.preventDefault();

                    var data = new FormData($('#form-ppguru')[0]);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('profil-guru.store') }}",
                        data: data,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            $('#modal-ppguru').modal('hide');
                            $('#tabelPPGuru').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                            // Menampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON.message,
                            });
                        }
                    });
                });

                $(document).on('click', '#action-hapusPPGuru', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-judul');

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
                                url: "{{ url('profil-guru/destroy') }}/" + id,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });
                                    $('#tabelPPGuru').DataTable().ajax.reload();
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Data gagal dihapus.',
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
