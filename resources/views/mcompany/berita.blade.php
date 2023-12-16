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
                    <button class="btn btn-sm btn-alt-success" id="insertBerita"><i class="fa fa-plus mx-2"></i>Tambah
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
                <h3 class="block-title">Table Berita</h3>
            </div>
            <div class="block-content block-content-full">
                <table id="tabelBerita" class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
                    <thead>
                        <tr>
                            <th style="width: 5%" class="text-center">No</th>
                            <th style="width: 16%;">Tanggal Berita</th>
                            <th>Judul Berita</th>
                            <th style="width: 25%">Gambar Berita</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MOAL --}}
    @include('mcompany/modal-berita')


    @push('scripts')
        <script>
            $(document).ready(function() {

                // Setup CSRF Token
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#tabelBerita').DataTable({
                    ajax: "{{ route('berita.get-data') }}",
                    columns: [{
                            data: 'nomor',
                            name: 'nomor',
                            className: 'text-center fw-medium fs-sm'
                        },
                        {
                            data: 'waktuBerita',
                            name: 'waktuBerita',
                            className: 'text-center  fs-sm'
                        },
                        {
                            data: 'judulBerita',
                            name: 'judulBerita',
                            className: 'fs-sm'
                        },
                        {
                            data: 'gambar',
                            render: function(data, type, row) {
                                var imageUrl = row.gambar ? "{{ asset(Storage::url('')) }}/" + row
                                    .gambar : '';

                                return '<img src="' + imageUrl + '" alt="Gambar" width="80px"/>';
                            },
                            searchable: false,
                            className: 'fs-sm text-center'
                        },

                        {
                            data: null,
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editBerita" value="' +
                                    data.idBerita + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusBerita" title="Delete" value="' +
                                    data.idBerita + '" data-nama-judul="' + data.judulBerita + '">' +
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
                // show modal berita tambah
                $('#insertBerita').click(function() {
                    $('#modalBerita').modal('show');
                    $('#formBerita :input').val('');
                    $('#preview-img').attr('src', '');
                    myEditor.setData('');
                    $("#modal-title").text('Tambah Berita');
                    $("#btn-form").html(
                        `<button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-storeBerita">Simpan</button>`
                    );
                });

                $(document).on('click', '#btn-storeBerita', function(e) {
                    e.preventDefault();

                    var data = new FormData($('#formBerita')[0]);
                    var isiBerita = myEditor.getData();
                    data.append('isiBerita', isiBerita);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('berita.store') }}",
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
                            $('#modalBerita').modal('hide');
                            $('#tabelBerita').DataTable().ajax.reload();
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

                // FUNGSI CLASSIC EDITOR 1
                var myEditor;
                ClassicEditor
                    .create(document.querySelector('.clasic-editor'))
                    .then(editor => {
                        myEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });

                var myEditor_update;
                ClassicEditor
                    .create(document.querySelector('#isiBerita_update'))
                    .then(editor => {
                        myEditor_update = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });

                // Fungsi untuk mendapatkan konten CKEditor
                function getEditorContent() {
                    return myEditor.getData();
                }

                // Fungsi untuk mengatur konten CKEditor
                function setEditorContent(content) {
                    myEditor.setData(content);
                }
                // Fungsi untuk mengatur konten CKEditor
                function setEditorContent(content) {
                    myEditor_update.setData(content);
                }

                // menampilkan gambar setelah gambar di input
                $('#gambarBerita').change(function() {
                    var reader = new FileReader();

                    reader.onload = (e) => {
                        $('#preview-img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                });
                $('#gambarBerita_update').change(function() {
                    var reader = new FileReader();

                    reader.onload = (e) => {
                        $('#preview-img_update').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                });

                $(document).on('click', '#action-editBerita', function(e) {
                    e.preventDefault();

                    // Show the update modal
                    $('#modalBerita_update').modal('show');

                    // Set the buttons in the modal
                    $("#btn-form_update").html(`
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('form_update_berita').submit()" id="btn-updateBerita">Simpan</button>
                `);

                    // Get the Berita ID
                    var idBerita = $(this).val();
                    // console.log(idBerita);

                    // Set the form action dynamically
                    $('#form_update_berita').attr('action', '{!! url('berita/update') !!}/' + idBerita);

                    // Fetch Berita data using AJAX
                    $.ajax({
                        type: "GET",
                        url: "{{ url('berita/edit') }}/" + idBerita,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            // Set the form fields with the fetched data
                            $('#idBerita_update').val(response.berita.idBerita);
                            $('#judulBerita_update').val(response.berita.judulBerita);
                            $('#waktuBerita_update').val(response.berita.waktuBerita);
                            $('#sumberBerita_update').val(response.berita.sumberBerita);

                            // Set the editor content
                            setEditorContent(response.berita.isiBerita);

                            // Set the preview image
                            var gambarPath = response.berita.gambar ?
                                "{{ asset(Storage::url('')) }}/" + response.berita.gambar : null;
                            if (gambarPath) {
                                $('#preview-img_update').attr('src', gambarPath);
                            } else {
                                $('#preview-img_update').removeAttr('src').attr('alt',
                                    'Gambar tidak tersedia');
                            }
                        }
                    });
                });

                $('#btn-close-berita').on('click', function() {
                    $('#formBerita input').val('');
                });


                $(document).on('click', '#action-hapusBerita', function(e) {
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
                                url: "{{ url('berita/destroy') }}/" + id,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });
                                    $('#tabelBerita').DataTable().ajax.reload();
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
