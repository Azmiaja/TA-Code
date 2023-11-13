@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            {{-- Page title berita --}}
            <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Manajemen Company</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{ $title2 }}
                    </li>
                </ol>
            </nav>
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
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Table Berita</h3>
            </div>
            <div class="block-content block-content-full">
                <table id="tabelBerita"
                    class="d-inline table table-responsive table-bordered table-striped table-vcenter desktop tablet-p mobile-p"
                    style="width:800px">
                    <thead class="text-light" style="background-color: #537188">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Berita</th>
                            <th>Judul Berita</th>
                            <th>Isi Berita</th>
                            <th>Gambar</th>
                            <th>Sumber Berita</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($berita as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->waktuBerita)->format('d-m-Y') }}</td>
                                <td>{{ $item->judulBerita }}</td>
                                <td>
                                    <div class="ellipse">{!! $item->isiBerita !!}</div>
                                </td>
                                <td class="text-center">
                                    @if ($item->gambar)
                                        <img src="{{ Storage::url($item->gambar) }}" height="100px">
                                    @else
                                        <em class="opacity-50">Gambar tidak ditemukan</em>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->sumberBerita)
                                        {{ $item->sumberBerita }}
                                    @else
                                        <em class="opacity-50">Sumber berita tidak tercantum</em>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $item->idBerita }}"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deletModal{{ $item->idBerita }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal --}}
                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEdit{{ $item->idBerita }}" data-bs-backdrop="static"
                                data-bs-keyboard="false">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #537188"
                                            data-bs-theme="dark">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Berita</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('berita.update', $item) }}" enctype="multipart/form-data"
                                            method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <input type="text" name="idBerita" value="{{ $item->idBerita }}" hidden>
                                                <div class="mb-4">
                                                    <label class="form-label" for="judulBerita">Judul Berita</label>
                                                    <input type="text" class="form-control" id="judulBerita"
                                                        name="judulBerita" placeholder="Judul Berita Anda.."
                                                        value="{{ $item->judulBerita }}">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="gambarBerita">Gambar Berita</label>
                                                    <div class="row ms-1 mb-2 p-0">
                                                        <div class="col-auto border rounded-2">
                                                            <div class="m-3">
                                                                <img src="{{ Storage::url($item->gambar) }}"
                                                                    alt="{{ $item->gambar }}" height="150">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input class="form-control" type="file" name="gambar"
                                                        id="gambarBerita" accept="image/*">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="isiBerita">Isi Berita</label>
                                                    <textarea id="js-ckeditor5-classic-edit-{{ $item->idBerita }}" class="form-control" name="isiBerita">{{ $item->isiBerita }}</textarea>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="row g-4 m-0">
                                                        <div class="col-lg-4 col-sm-12 col-12 ps-0">
                                                            <label class="form-label" for="waktuBerita">Tanggal
                                                                Berita</label>
                                                            @php
                                                                $carbonDate = \Carbon\Carbon::parse($item->waktuBerita);
                                                            @endphp
                                                            <input type="text" class="form-control"
                                                                id="js-flatpickr-edit-{{ $item->idBerita }}"
                                                                name="waktuBerita" placeholder="d-m-Y"
                                                                data-date-format="d-m-Y"
                                                                value="{{ $carbonDate->format('d.m.Y') }}">
                                                        </div>
                                                        <div class="col-lg-8 col-sm-12 col-12">
                                                            <label class="form-label" for="sumberBerita">Sumber
                                                                Berita</label>
                                                            <input type="text" class="form-control" id="sumberBerita"
                                                                name="sumberBerita" placeholder="Sumber Berita Anda.."
                                                                value="{{ $item->sumberBerita }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus -->
                            <div class="modal fade" id="deletModal{{ $item->idBerita }}" tabindex="-1"
                                aria-labelledby="deletModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #537188"
                                            data-bs-theme="dark">
                                            <h1 class="modal-title fs-5" id="deletModalLabel">Hapus Berita</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('berita.destroy', $item->idBerita) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-body mt-3">
                                                Apakah Anda ingin menghapus berita <strong>"{{ $item->judulBerita }}"
                                                    ?</strong>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Hapus Berita</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    var dataId = {{ $item->idBerita }};

                                    ClassicEditor.create(document.querySelector('#js-ckeditor5-classic-edit-' + dataId))
                                        .then(editor => {
                                            console.log(editor);
                                        })
                                        .catch(error => {
                                            console.error(error);
                                        });

                                    $('#js-flatpickr-edit-' + dataId).flatpickr({
                                        dateFormat: "d-m-Y H:i",
                                        theme: "red",
                                        minDate: "today",
                                        defaultDate: new Date(),
                                        enableTime: true,
                                    });

                                });
                            </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Insert-->
    <div class="modal fade" id="modalInsert" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalInsertLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-light" style="background-color: #537188" data-bs-theme="dark">
                    <h1 class="modal-title fs-5" id="modalInsertLabel">Insert Berita</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('berita.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label" for="judulBerita">Judul Berita</label>
                            <input type="text" class="form-control" id="judulBerita" name="judulBerita"
                                placeholder="Judul Berita Anda..">
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="gambarBerita">Gambar Berita</label>
                            <input class="form-control" type="file" name="gambar" id="gambarBerita"
                                accept="image/*">
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="isiBerita">Isi Berita</label>
                            <textarea id="js-ckeditor5-classic" class="form-control" name="isiBerita"></textarea>

                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div class="col-lg-4 col-sm-12 col-12 px-0 mb-sm-0 mb-4">
                                    <label class="form-label" for="waktuBerita">Tanggal Berita</label>
                                    <input type="text" class="form-control js-flatpickr" id="waktuBerita"
                                        name="waktuBerita" placeholder="d-m-Y" data-date-format="d-m-Y">
                                </div>
                                <div class="col-lg-8 col-sm-12 col-12 px-0 ps-lg-3 ps-0">
                                    <label class="form-label" for="sumberBerita">Sumber Berita</label>
                                    <input type="text" class="form-control" id="sumberBerita" name="sumberBerita"
                                        placeholder="Sumber Berita Anda..">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            var tableBerita = $('#tabelBerita').DataTable({
                dom: "<'row mb-2 py-2'<'col-12 col-sm-12 col-md-6 py-2'l><'col-12 col-sm-12 col-md-6 py-2 d-flex justify-content-end gap-4'fB>>" +
                    "<'row my-2 '<'col-12 col-sm-12 overvlow-x-auto'tr>>" +
                    "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                responsive: true,
                autoWidth: false,
                columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                }, {
                    targets: 2,
                    width: "15%"
                }, {
                    targets: 1,
                    width: "10%"
                }, {
                    targets: 5,
                    width: "10%"
                }, {
                    targets: 6,
                    width: "7%"
                }],
                fixedColumns: true,
                lengthMenu: [10, 25],
                buttons: [{
                    text: '<i class="fa fa-plus"></i> Tambah Berita',
                    className: 'btn btn-alt-success',
                    action: function() {
                        $('#modalInsert').modal('show');
                    }
                }]
            });


            // var beritaData = {!! json_encode($berita) !!}; // Mengambil data dari Blade ke JavaScript

            // beritaData.forEach(function(berita) {
            //     var dataId = berita.idBerita;

            //     ClassicEditor.create(document.querySelector('#js-ckeditor5-classic-edit-' + dataId))
            //         .then(editor => {
            //             console.log(editor);
            //         })
            //         .catch(error => {
            //             console.error(error);
            //         });
            // });
        });
    </script>
@endsection
