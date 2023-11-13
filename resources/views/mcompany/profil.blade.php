@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            {{-- Page title pegawai --}}
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
                <h3 class="block-title">Table Profil</h3>
            </div>
            <div class="block-content block-content-full">
                <table id="tabelProfil"
                    class="d-inline table table-responsive table-bordered table-striped table-vcenter desktop tablet-p mobile-p"
                    style="width:100%">
                    <thead class="text-light" style="background-color: #537188">
                        <tr>
                            <th>No</th>
                            <th>Tahun</th>
                            <th>Nama Sekolah</th>
                            <th>Profil</th>
                            <th>Sejarah</th>
                            <th>Visi</th>
                            <th>Misi</th>
                            {{-- <th>Gambar</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profil as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tahun }}</td>
                                <td>{{ $item->namaSekolah }}</td>
                                <td>
                                    <div class="ellipse">{!! $item->deskripsiProfil !!}</div>
                                </td>
                                <td>
                                    <div class="ellipse">{!! $item->deskripsiSejarah !!}</div>
                                </td>
                                <td>{!! $item->visi !!}</td>
                                <td>{!! $item->misi !!}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-warning px-4" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $item->idProfil }}"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>

                            {{-- Modal --}}
                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEdit{{ $item->idProfil }}" data-bs-backdrop="static"
                                data-bs-keyboard="false">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #537188"
                                            data-bs-theme="dark">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Berita</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('profil.update', $item) }}" enctype="multipart/form-data"
                                            method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <input type="text" name="idProfil" value="{{ $item->idProfil }}" hidden>
                                                <div class="mb-4">
                                                    <label class="form-label" for="namaSekolah">Nama Sekolah</label>
                                                    <input type="text" class="form-control" id="namaSekolah"
                                                        name="namaSekolah" placeholder="Nama Sekolah.."
                                                        value="{{ $item->namaSekolah }}">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="deskripsiProfil">Deskripsi Profil</label>
                                                    <textarea id="ck-deskripsi" class="form-control" name="deskripsiProfil">{{ $item->deskripsiProfil }}</textarea>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="deskripsiSejarah">Deskripsi
                                                        Sejarah</label>
                                                    <textarea id="ck-deskripsi" class="form-control" name="deskripsiSejarah">{{ $item->deskripsiSejarah }}</textarea>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="visi">Visi</label>
                                                    <textarea id="ck-deskripsi" class="form-control" name="visi">{{ $item->visi }}</textarea>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="misi">Misi</label>
                                                    <textarea id="ck-deskripsi" class="form-control" name="misi">{{ $item->misi }}</textarea>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="row g-4 m-0">
                                                        <div class="col-lg-4 col-sm-12 col-12 ps-0">
                                                            <label class="form-label" for="tahun">Tahun</label>
                                                            <select class="form-select" id="tahun" name="tahun">
                                                                <option value="{{ $item->tahun }}">{{ $item->tahun }}
                                                                </option>
                                                                @php
                                                                    $currentYear = date('Y');
                                                                @endphp
                                                                @for ($year = 2020; $year <= $currentYear; $year++)
                                                                    <option value="{{ $year }}">
                                                                        {{ $year }}</option>
                                                                @endfor
                                                            </select>
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
                            {{-- <div class="modal fade" id="deletModal{{ $item->idProfil }}" tabindex="-1"
                                aria-labelledby="deletModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #537188"
                                            data-bs-theme="dark">
                                            <h1 class="modal-title fs-5" id="deletModalLabel">Hapus Berita</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('profil.destroy', $item->idProfil) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-body mt-3">
                                                Apakah Anda ingin menghapus profil ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Hapus Profil</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> --}}

                            <script>
                                $(document).ready(function() {
                                    var dataId = {{ $item->idProfil }};

                                    // ClassicEditor.create(document.querySelector('#js-ckeditor5-classic-edit-' + dataId))
                                    document.querySelectorAll('#ck-deskripsi').forEach(function(element) {
                                        ClassicEditor
                                            .create(element)
                                    });
                                    $('#js-flatpickr-edit-' + dataId).flatpickr({
                                        dateFormat: "d-m-Y",
                                        theme: "red",
                                    });

                                });
                            </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Insert-->
        {{-- <div class="modal fade" id="modalInsert" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="modalInsertLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-light" style="background-color: #537188" data-bs-theme="dark">
                        <h1 class="modal-title fs-5" id="modalInsertLabel">Insert Berita</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('profil.store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-4">
                                <label class="form-label" for="namaSekolah">Nama Sekolah</label>
                                <input type="text" class="form-control" id="namaSekolah" name="namaSekolah"
                                    placeholder="Nama Sekolah Anda..">
                            </div>
                            {{-- <div class="mb-4">
                                <label class="form-label" for="gambarProfil">Gambar</label>
                                <input class="form-control" type="file" name="gambar" id="gambarProfil"
                                    accept="image/*">
                            </div> --}}
                            {{-- <div class="mb-4">
                                <label class="form-label" for="deskripsiProfil">Deskripsi Profil</label>
                                <textarea id="deskripsiProfil" class="form-control" name="deskripsiProfil"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="deskripsiSejarah">Deskripsi Sejarah</label>
                                <textarea id="deskripsiSejarah" class="form-control" name="deskripsiSejarah"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="visi">Visi</label>
                                <textarea id="visi" class="form-control" name="visi"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="misi">Misi</label>
                                <textarea id="misi" class="form-control" name="misi"></textarea>
                            </div>
                            <div class="mb-4">
                                <div class="row m-0">
                                    <div class="col-lg-4 col-sm-12 col-12 px-0 mb-sm-0 mb-4">
                                        <label class="form-label" for="tahun">Tahun</label>
                                        <select class="form-select" id="tahun" name="tahun">
                                            <option value="">Pilih Tahun</option>
                                            @php
                                                $currentYear = date('Y');
                                            @endphp
                                            @for ($year = 2020; $year <= $currentYear; $year++)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
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
        </div>  --}}

    @endsection
