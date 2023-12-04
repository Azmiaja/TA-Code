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
                {{-- data-bs-target="#modal-tambahBerita" --}}
                {{-- data-bs-toggle="modal" --}}
            </div>
        </div>
    </div>
    <div class="content">

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
                            <th style="width: 25%">Sumber Berita</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($berita as $item)
                            <tr>
                                <td class="text-center fs-sm">{{ $loop->iteration }}</tde=>
                                <td class="fw-semibold fs-sm">
                                    {{ \Carbon\Carbon::parse($item->waktuBerita)->format('d-m-Y') }}</td>
                                <td class="fs-sm">{{ $item->judulBerita }}</td>
                                <td class="fs-sm" style="max-width: 220px;">
                                    <div class="ellipse">
                                        @if ($item->sumberBerita)
                                            {{ $item->sumberBerita }}
                                        @else
                                            <em class="opacity-50">Sumber berita tidak tercantum</em>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-alt-primary" title="Edit"
                                            onclick="showBeritaEdit({{ $item->idBerita }})"><i
                                                class="fa fa-fw fa-pencil-alt"></i></button>
                                        <button type="button" class="btn btn-sm btn-alt-danger" title="Delete"
                                            onclick="showBeritaDelete({{ $item->idBerita }})">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MOAL --}}
    @include('mcompany/modal-berita')


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
                        data: 'sumberBerita',
                        render: function(data, type, row) {
                            if (data) {
                                return '<td class="fs-sm" style="max-width: 220px;">' +
                                    '<div class="ellipse">' + data + '</div>' +
                                    '</td>';
                            } else {
                                return '<td class="fs-sm" style="max-width: 220px;">' +
                                    '<div class="ellipse">' +
                                    '<em class="opacity-50">Sumber berita tidak tercantum</em>' +
                                    '</div>' +
                                    '</td>';
                            }
                        },
                        name: 'sumberBerita',
                        className: 'fs-sm'
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

            // Fungsi untuk mendapatkan konten CKEditor
            function getEditorContent() {
                return myEditor.getData();
            }

            // Fungsi untuk mengatur konten CKEditor
            function setEditorContent(content) {
                myEditor.setData(content);
            }

            // menampilkan gambar setelah gambar di input
            $('#gambarBerita').change(function() {
                var reader = new FileReader();

                reader.onload = (e) => {
                    $('#preview-img').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $(document).on('click', '#action-editBerita', function(e) {
                e.preventDefault();
                $('#modalBerita').modal('show');
                $("#modal-title").text('Edit Berita');
                $("#btn-form").html(
                    `<button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-updateBerita">Simpan</button>`
                );

                var id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ url('berita/edit') }}/" + id,
                    headers: {
                        "Cache-Control": "no-cache, no-store, must-revalidate",
                        "Pragma": "no-cache"
                    },
                    success: function(response) {
                        $('#idBerita').val(response.berita.idBerita);
                        $('#judulBerita').val(response.berita.judulBerita);
                        $('#waktuBerita').val(response.berita.waktuBerita);
                        $('#sumberBerita').val(response.berita.sumberBerita);
                        var isiBerita = response.berita.isiBerita ? response.berita.isiBerita :
                            null;
                        if (isiBerita != null) {
                            setEditorContent(isiBerita);
                        }
                        setEditorContent(response.berita.isiBerita);
                        // myEditor.setData(isiBerita);

                        var gambarPath = response.berita.gambar ?
                            "{{ asset(Storage::url('')) }}/" + response.berita.gambar : null;

                        if (gambarPath) {
                            $('#preview-img').attr('src', gambarPath);
                        } else {
                            $('#preview-img').removeAttr('src');
                            $('#preview-img').attr('alt', 'Gambar tidak tersedia');
                        }

                    }
                });
            });

            $(document).on('click', '#btn-updateBerita', function(e) {
                e.preventDefault();

                var id = $('#idBerita').val();
                var judulBerita = $('#judulBerita').val();
                var waktuBerita = $('#waktuBerita').val();
                var sumberBerita = $('#sumberBerita').val();
                // var gambarBerita = $('#gambarBerita')[0].files[0];
                var isiBerita = myEditor.getData();
                // data.append('isiBerita', isiBerita);

                // console.log(gambarBerita);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PUT",
                    url: "{{ url('berita/update') }}/" + id,
                    data: {
                        'judulBerita': judulBerita,
                        'isiBerita': isiBerita,
                        'waktuBerita': waktuBerita,
                        'sumberBerita': sumberBerita,
                        // 'gambar': gambarBerita,

                    },
                    // contentType: false,
                    // processData: false,
                    dataType: "json",
                    success: function(response) {
                        // $(".btn-block-option").click();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        });
                        $('#modalBerita').modal('hide');
                        $('#tabelBerita').DataTable().ajax.reload();
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
@endsection
