@extends('siakad.layouts.app')
@section('siakad')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title berita --}}
                    <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <a class="link-fx" href="javascript:void(0)">{{ $judul }}</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                {{ $sub_judul }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-6 text-end">
                    <button class="btn btn-sm btn-alt-success" id="tambah-siswa" title="Tambah Siswa"><i
                            class="fa fa-plus mx-2"></i>Tambah
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Table Siswa</h3>
            </div>
            <div class="block-content block-content-full">
                <table id="tabelSiswa" style="width: 100%;" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="modalSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalInsertLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="modal-title-siswa">Tambah Siswa</h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" onclick="clearFormSiswa()" class="btn-block-option"
                                data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <input type="text" id="idSiswa" hidden>
                        <div class="mb-4">
                            <label class="form-label" for="nisn">NISN</label>
                            <input type="text" class="form-control add-nisn" id="nisn" name="nisn"
                                placeholder="Masukan NISN Siswa">
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="namaSiswa">Nama Siswa</label>
                            <input type="text" class="form-control add-nama-siswa" id="namaSiswa" name="namaSiswa"
                                placeholder="Masukan Nama Siswa">
                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="tempatLahir">Tempat Lahir</label>
                                    <input type="text" class="form-control add-tempat-lahir" id="tempatLahir"
                                        name="tempatLahir" placeholder="Masukan Tempat Lahir Siswa">
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                    <label class="form-label" for="tanggalLahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control add-tanggal-lahir" id="tanggalLahir"
                                        name="tanggalLahir" placeholder="Tanggal Lahir Siswa">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="alamat">Alamat</label>
                            <textarea id="alamat" class="form-control add-alamat" name="alamat" placeholder="Masukan Alamat Siswa"></textarea>
                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="jenisKelamin">Jenis Kelamin</label>
                                    <select name="jenisKelamin" id="jenisKelamin" class="form-select add-jenis-kelamin">
                                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                    <label class="form-label" for="agama">Agama</label>
                                    <select name="agama" id="agama" class="form-select add-agama">
                                        <option value="" selected>-- Pilih Agama --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="row m-0">
                                <div class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label no-hp" for="noHpOrtu">No Handphone Wali</label>
                                    <input type="number" name="noHpOrtu" id="noHP" class="form-control add-no-hp"
                                        placeholder="Masukan Nomor Handphone Wali">
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" id="status" class="form-select add-status">
                                        <option value="" selected>-- Pilih Status --</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 text-end" id="bt-form-siswa">
                            {{-- Button --}}
                        </div>
                    </div>

                    <div class="block-content block-content-full bg-body">
                        {{-- Additional content if needed --}}
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('scripts')
        <script>
            function clearFormSiswa() {
                $('#nisn').val('');
                $('#namaSiswa').val('');
                $('#tempatLahir').val('');
                $('#tanggalLahir').val('');
                $('#alamat').val('');
                $('#jenisKelamin').val('');
                $('#agama').val('');
                $('#noHpOrtu').val('');
                $('#status').val('');
                $('#idSiswa').val('');
            }
            $(document).ready(function() {
                // DATATABLES SISWA 
                $('#tabelSiswa').DataTable({
                    ajax: "{{ route('siswa.get-data') }}",
                    columns: [{
                            data: 'nomor',
                            name: 'nomor'
                        }, {
                            data: 'nisn',
                            name: 'nisn'
                        }, {
                            data: 'namaSiswa',
                            name: 'namaSiswa'
                        }, {
                            data: 'jenisKelamin',
                            name: 'jenisKelamin'
                        }, {
                            data: 'status',
                            className: 'text-center',
                            render: function(data, type, row) {
                                var statusClass = row.status === 'Aktif' ?
                                    'bg-success-light text-success' : 'bg-danger-light text-danger';

                                return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${statusClass}">
                                ${row.status}
                            </span>`;
                            }
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editSiswa" value="' +
                                    data.idSiswa + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusSiswa" title="Delete" value="' +
                                    data.idSiswa + '" data-nama-siswa="' + data.namaSiswa + '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25, 50, 100],
                    responsive: true,
                });
                $(document).on("click", "#tambah-siswa", function(e) {
                    e.preventDefault();
                    $('#modalSiswa').modal('show');
                    $("#modal-title-siswa").text('Tambah Siswa');
                    $("#bt-form-siswa").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"
                                id="btn-tambahSiswa">Simpan</button>`);
                });
                // AJAX UNTUK STORE DATA
                $(document).on('click', '#btn-tambahSiswa', function(e) {
                    e.preventDefault();
                    var data = {
                        'nisn': $('#nisn').val(),
                        'namaSiswa': $('#namaSiswa').val(),
                        'tempatLahir': $('#tempatLahir').val(),
                        'tanggalLahir': $('#tanggalLahir').val(),
                        'alamat': $('#alamat').val(),
                        'jenisKelamin': $('#jenisKelamin').val(),
                        'agama': $('#agama').val(),
                        'noHpOrtu': $('#noHP').val(),
                        'status': $('#status').val(),
                    }
                    console.log(data);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ url('siswa/store') }}",
                        data: data,
                        dataType: "json",
                        success: function(response) {
                            $("#btn-close").click();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            $('#tabelSiswa').DataTable().ajax.reload();
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
                // AJAX MENAMPILKAN MODAL EDIT
                $(document).on('click', '#action-editSiswa', function(e) {
                    e.preventDefault();
                    var idSiswa = $(this).val();
                    $('#modalSiswa').modal('show');
                    $("#modal-title-siswa").text('Edit Siswa');
                    $("#bt-form-siswa").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"
                                id="btn-editSiswa">Simpan</button>`);
                    $.ajax({
                        type: "GET",
                        url: "{{ url('siswa/edit') }}/" + idSiswa,
                        success: function(response) {
                            $('#nisn').val(response.siswa.nisn);
                            $('#namaSiswa').val(response.siswa.namaSiswa);
                            $('#tempatLahir').val(response.siswa.tempatLahir);
                            $('#tanggalLahir').val(response.siswa.tanggalLahir);
                            $('#alamat').val(response.siswa.alamat);
                            $('#jenisKelamin').val(response.siswa.jenisKelamin);
                            $('#agama').val(response.siswa.agama);
                            $('#noHpOrtu').val(response.siswa.noHpOrtu);
                            $('#status').val(response.siswa.status);
                            $('#idSiswa').val(response.siswa.idSiswa);
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
                //AJAX UNTUK UPDATE DATA
                $(document).on('click', '#btn-editSiswa', function(e) {
                    e.preventDefault();
                    var idSiswa = $('#idSiswa').val();
                    var data = {
                        'nisn': $('#nisn').val(),
                        'namaSiswa': $('#namaSiswa').val(),
                        'tempatLahir': $('#tempatLahir').val(),
                        'tanggalLahir': $('#tanggalLahir').val(),
                        'alamat': $('#alamat').val(),
                        'jenisKelamin': $('#jenisKelamin').val(),
                        'agama': $('#agama').val(),
                        'noHpOrtu': $('#noHP').val(),
                        'status': $('#status').val(),
                    }

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "PUT",
                        url: "{{ url('siswa/update') }}/" + idSiswa,
                        dataType: "json",
                        data: data,
                        success: function(response) {

                            $("#btn-close").click();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            $('#tabelSiswa').DataTable().ajax.reload();
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
                //AJAX UNTUK DELETE DATA
                $(document).on('click', '#action-hapusSiswa', function(e) {
                    e.preventDefault();
                    var idSiswa = $(this).val();
                    var namaSiswa = $(this).data('nama-siswa');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Menghapus data ' + namaSiswa + '',
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
                                url: "{{ url('siswa/destroy') }}/" + idSiswa,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });

                                    // Optionally, you can reload the DataTable or update the UI as needed
                                    $('#tabelSiswa').DataTable().ajax.reload();
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
