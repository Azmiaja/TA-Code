@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            {{-- Page title siswa --}}
            <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Manajemen User</a>
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
                            {{ $error }}
                        @endforeach
                    </ul>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Table Siswa</h3>
            </div>
            <div class="block-content block-content-full">
                <table id="tabelSiswa" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->namaSiswa }}</td>
                                <td>
                                    <span
                                        class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill {{ $item->status === 'Aktif' ? 'bg-success-light text-success' : 'bg-danger-light text-danger' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $item->idSiswa }}"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deletModal{{ $item->idSiswa }}"><i
                                                class="fa fa-trash"></i></a>
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $item->idSiswa }}"><i
                                                class="px-1 fa fa-info"></i></a>
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEdit{{ $item->idSiswa }}" tabindex="-1"
                                data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modalEditLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #537188"
                                            data-bs-theme="dark">
                                            <h1 class="modal-title fs-5" id="modalEditLabel">Edit Siswa</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('siswa.update', $item) }}" enctype="multipart/form-data"
                                            method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="modal-body">
                                                <input type="text" name="idSiswa" hidden
                                                    value="{{ $item->idSiswa }}">
                                                <div class="mb-4">
                                                    <label class="form-label" for="nisn">NISN</label>
                                                    <input type="text" class="form-control" id="nisn" name="nisn"
                                                        placeholder="NISN Siswa.." value="{{ $item->nisn }}">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="namaSiswa">Nama Siswa</label>
                                                    <input type="text" class="form-control" id="namaSiswa"
                                                        name="namaSiswa" placeholder="Nama Siswa.."
                                                        value="{{ $item->namaSiswa }}">
                                                </div>
                                                <div class="mb-4">
                                                    <div class="row m-0">
                                                        <div
                                                            class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                                            <label class="form-label" for="tempatLahir">Tempat
                                                                Lahir</label>
                                                            <input type="text" class="form-control" id="tempatLahir"
                                                                name="tempatLahir" placeholder="Tempat Lahir Siswa.."
                                                                value="{{ $item->tempatLahir }}">
                                                        </div>
                                                        <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                                            <label class="form-label" for="tanggalLahir">Tanggal
                                                                Lahir</label>
                                                            <input type="date" class="form-control flatpickr-input"
                                                                id="tgl-lahir-fltpickr-{{ $item->idSiswa }}"
                                                                name="tanggalLahir" placeholder="Tanggal Lahir Siswa.."
                                                                value="{{ $item->tanggalLahir }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="alamat">Alamat</label>
                                                    <textarea id="alamat" class="form-control" name="alamat" placeholder="Alamat Siswa..">{{ $item->alamat }}</textarea>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="row m-0">
                                                        <div
                                                            class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                                            <label class="form-label" for="jenisKelamin">Jenis
                                                                Kelamin</label>
                                                            <select name="jenisKelamin" id="jenisKelamin"
                                                                class="form-select">
                                                                <option value="" disabled>-- Pilih Jenis
                                                                    Kelamin --</option>
                                                                @foreach (['Laki-Laki', 'Perempuan'] as $gender)
                                                                    <option value="{{ $gender }}"
                                                                        {{ $item->jenisKelamin === $gender ? 'selected' : '' }}>
                                                                        {{ $gender }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div
                                                            class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                                            <label class="form-label" for="agama">Agama</label>
                                                            <select name="agama" id="agama" class="form-select">
                                                                <option value="" selected>-- Pilih Agama --</option>
                                                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghuchu'] as $agama)
                                                                    <option value="{{ $agama }}"
                                                                        {{ $item->agama === $agama ? 'selected' : '' }}>
                                                                        {{ $agama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="row m-0">
                                                        <div
                                                            class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                                            <label class="form-label" for="noHpOrtu">No Handphone Wali</label>
                                                            <input type="number" name="noHpOrtu" id="noHP"
                                                                class="form-control" placeholder="No Hp Siswa.."
                                                                value="{{ $item->noHpOrtu }}">
                                                        </div>
                                                        <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                                            <label class="form-label" for="status">Status</label>
                                                            <select name="status" id="status" class="form-select">
                                                                <option value="" selected>-- Pilih Status --</option>
                                                                @foreach (['Aktif', 'Tidak Aktif'] as $status)
                                                                    <option value="{{ $status }}"
                                                                        {{ $item->status === $status ? 'selected' : '' }}>
                                                                        {{ $status }}
                                                                    </option>
                                                                @endforeach
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
                            <div class="modal fade" id="deletModal{{ $item->idSiswa }}" tabindex="-1"
                                aria-labelledby="deletModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #537188"
                                            data-bs-theme="dark">
                                            <h1 class="modal-title fs-5" id="deletModalLabel">Hapus Berita</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('siswa.destroy', $item->idSiswa) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <div class="modal-body mt-3">
                                                Apakah ingin menghapus data <strong>"{{ $item->namaSiswa }}"
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
                            <!-- Modal Detai -->
                            <div class="modal fade" id="detailModal{{ $item->idSiswa }}" tabindex="-1"
                                aria-labelledby="detailModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header text-light" style="background-color: #537188"
                                            data-bs-theme="dark">
                                            <h1 class="modal-title fs-5" id="detailModalLabel">Detail Siswa</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body mt-3">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p><strong>NISN : </strong>{{ $item->nisn }}</p>
                                                    <p><strong>Nama : </strong>{{ $item->namaSiswa }}</p>
                                                    <p><strong>Tempat Lahir : </strong>{{ $item->tempatLahir }}</p>
                                                    <p><strong>Tanggal Lahir : </strong>{{ $item->tanggalLahir }}</p>
                                                    <p><strong>Alamat : </strong>{{ $item->alamat }}</p>
                                                    <p><strong>Jenis Kelamin : </strong>{{ $item->jenisKelamin }}</p>
                                                    <p><strong>Agama : </strong>{{ $item->agama }}</p>
                                                    <p><strong>No Handphone Wali : </strong>{{ $item->noHpOrtu }}</p>
                                                    <p><strong>Status : </strong>{{ $item->status }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    var dataId = {{ $item->idSiswa }};
                                    $('#tgl-lahir-fltpickr-' + dataId).flatpickr({
                                        dateFormat: "d-m-Y",
                                        theme: "red"
                                    });
                                });
                            </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Insert --}}
    <div class="modal fade" id="modalInsert" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalInsertLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-light" style="background-color: #537188" data-bs-theme="dark">
                    <h1 class="modal-title fs-5" id="modalInsertLabel">Insert Siswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('siswa.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label" for="nisn">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn"
                                placeholder="NISN Siswa..">
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="namaSiswa">Nama Siswa</label>
                            <input type="text" class="form-control" id="namaSiswa" name="namaSiswa"
                                placeholder="Nama Siswa..">
                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="tempatLahir">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempatLahir" name="tempatLahir"
                                        placeholder="Tempat Lahir Siswa..">
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                    <label class="form-label" for="tanggalLahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control flatpickr-input" id="tgl-lahir-fltpickr"
                                        name="tanggalLahir" placeholder="Tanggal Lahir Siswa..">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="alamat">Alamat</label>
                            <textarea id="alamat" class="form-control" name="alamat" placeholder="Alamat Siswa.."></textarea>
                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div
                                    class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="jenisKelamin">Jenis Kelamin</label>
                                    <select name="jenisKelamin" id="jenisKelamin" class="form-select">
                                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div
                                    class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                    <label class="form-label" for="agama">Agama</label>
                                    <select name="agama" id="agama" class="form-select">
                                        <option value="" selected>-- Pilih Agama --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                        <option value="Konghuchu">Konghuchu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="noHpOrtu">No Handphone Wali</label>
                                    <input type="number" name="noHpOrtu" id="noHP" class="form-control"
                                        placeholder="No Hp Siswa..">
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="" selected>-- Pilih Status --</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
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
    </div>

    <script>
        $(document).ready(function() {
            $('#tabelSiswa').DataTable({
                dom: "<'row mb-2 py-2'<'col-12 col-sm-12 col-md-6 py-2'l><'col-12 col-sm-12 col-md-6 py-2 d-flex justify-content-end gap-4'fB>>" +
                    "<'row my-2 '<'col-12 col-sm-12 overvlow-x-auto'tr>>" +
                    "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [{
                    text: '<i class="fa fa-plus"></i> Tambah Siswa',
                    className: 'btn btn-alt-success',
                    action: function() {
                        $('#modalInsert').modal('show');
                    }
                }],
                autoWidth: false,
                columnDefs: [{
                    targets: 0,
                    className: 'text-center',
                    width: "5%"
                },{
                    targets: 4,
                    width: "10%"
                }],
                lengthMenu: [10, 25],
            });
            $('#tgl-lahir-fltpickr').flatpickr({
                dateFormat: "d-m-Y",
                theme: "red"
            });
        });
    </script>
@endsection
