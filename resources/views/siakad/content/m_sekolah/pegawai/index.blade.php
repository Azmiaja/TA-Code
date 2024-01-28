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
                                <a class="link-fx" href="javascript:void(0)">{{ $title }}</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                {{ $title2 }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-6 text-end">
                    <button class="btn btn-sm btn-alt-success" id="tambah-Pegawai" title="Tambah Pegawai"><i
                            class="fa fa-plus mx-2"></i>Tambah
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Table Pegawai</h3>
            </div>
            <div class="block-content block-content-full">
                <table id="tabelPegawai" style="width: 100%;" class="table table-bordered table-striped table-vcenter">
                    <thead class="fw-bold">
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- content --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalPegawai" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal-tambahUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <!-- Modal Title -->
                        <h3 class="block-title" id="modal-title-pegawai"></h3>
                        <div class="block-options">
                            <!-- Close Button -->
                            <button type="button" id="btn-close" onclick="clearPegawaiForm()" class="btn-block-option"
                                data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <!-- Form -->
                        <!-- ID -->
                        <input type="text" hidden id="for-id-pegawai">
                        <!-- NIP -->
                        <div class="mb-4">
                            <label class="form-label" for="nip">NIP</label>
                            <input type="text" class="form-control nip-pegawai" id="nip" name="nip"
                                placeholder="Masukan NIP ">
                        </div>
                        <!-- Nama Pegawai -->
                        <div class="mb-4">
                            <label class="form-label" for="namaPegawai">Nama Pegawai</label>
                            <input type="text" class="form-control nama-pegawai" id="namaPegawai" name="namaPegawai"
                                placeholder="Masukan Nama Pegawai">
                        </div>
                        <!-- Tempat & Tanggal Lahir -->
                        <div class="mb-4">
                            <div class="row m-0">
                                <!-- Tempat Lahir -->
                                <div class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="tempatLahir">Tempat Lahir</label>
                                    <input type="text" class="form-control tempat-lahir" id="tempatLahir"
                                        name="tempatLahir" placeholder="Masukan Tampat Lahir Pegawai">
                                </div>
                                <!-- Tanggal Lahir -->
                                <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                    <label class="form-label" for="tanggalLahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control tanggal-lahir" id="tanggalLahir"
                                        name="tanggalLahir">
                                </div>
                            </div>
                        </div>
                        <!-- Alamat -->
                        <div class="mb-4">
                            <label class="form-label" for="alamat">Alamat</label>
                            <textarea id="alamat" class="form-control alamat-pegawai" name="alamat" placeholder="Masukan Alamat"></textarea>
                        </div>
                        <!-- Jenis Kelamin, Agama, Jenis Pegawai -->
                        <div class="mb-4">
                            <div class="row m-0">
                                <!-- Jenis Kelamin -->
                                <div
                                    class="col-lg-4 col-md-6 col-sm-12 col-12 px-0 pe-lg-1 pe-md-1 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="jenisKelamin">Jenis Kelamin</label>
                                    <select name="jenisKelamin" id="jenisKelamin" class="form-select jenis-kelamin">
                                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <!-- Agama -->
                                <div
                                    class="col-lg-4 col-md-6 col-sm-12 col-12 px-0 px-lg-1 ps-md-1 ps-0 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="agama">Agama</label>
                                    <select name="agama" id="agama" class="form-select pilih-agama">
                                        <option value="" selected>-- Pilih Agama --</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                                <!-- Jenis Pegawai -->
                                <div class="col-lg-4 col-md-12 col-sm-12 col-12 px-0 ps-lg-1 ps-0">
                                    <label class="form-label" for="jenisPegawai">Jenis Pegawai</label>
                                    <select name="jenisPegawai" id="jenisPegawai" class="form-select jenis-pegawai">
                                        <option value="" selected>-- Pilih Jenis Pegawai --</option>
                                        <option value="Guru">Guru</option>
                                        <option value="TU">Tata Usaha</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- No Handphone & Status -->
                        <div class="mb-4">
                            <div class="row m-0">
                                <!-- No Handphone -->
                                <div class="col-lg-6 col-sm-12 col-12 px-0 pe-lg-2 pe-0 mb-lg-0 mb-sm-4 mb-4">
                                    <label class="form-label" for="noHP">No Handphone</label>
                                    <input type="number" name="noHp" id="noHP" class="form-control no-hp"
                                        placeholder="Masukan Nomor Handphone">
                                </div>
                                <!-- Status -->
                                <div class="col-lg-6 col-sm-12 col-12 px-0 ps-lg-2 ps-0">
                                    <label class="form-label" for="status">Status</label>
                                    <select name="status" id="status" class="form-select pilih-status">
                                        <option value="" selected>-- Pilih Status --</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 text-end" id="bt-form-pegawai">
                            <!-- Form Buttons -->
                        </div>
                        <div class="block-content block-content-full bg-body">
                            <!-- Additional Content (if any) -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            // clear form siswa
            function clearPegawaiForm() {
                $('.nip-pegawai').val('');
                $('.nama-pegawai').val('');
                $('.tempat-lahir').val('');
                $('.tanggal-lahir').val('');
                $('.alamat-pegawai').val('');
                $('.jenis-kelamin').val('');
                $('.pilih-agama').val('');
                $('.no-hp').val('');
                $('.pilih-status').val('');
                $('.jenis-pegawai').val('');
                $("#for-id-pegawai").val('');
            }
            $(document).ready(function() {
                // tabel pegawai
                $('#tabelPegawai').DataTable({
                    ajax: "{{ url('pegawai/get-data') }}",
                    columns: [{
                            data: 'nomor',
                            nama: 'nomor'
                        }, {
                            data: 'nip',
                            name: 'nip'
                        }, {
                            data: 'namaPegawai',
                            name: 'namaPegawai'
                        }, {
                            data: 'jenisKelamin',
                            name: 'jenisKelamin'
                        }, {
                            data: 'status',
                            name: 'status',
                            className: 'text-center',
                            render: function(data, type, row) {
                                var statusClass = row.status === 'Aktif' ?
                                    'bg-success-light text-success' : 'bg-danger-light text-danger';
                                return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${statusClass}">${row.status}</span>`;
                            }
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editPegawai" value="' +
                                    data.idPegawai + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusPegawai" title="Delete" value="' +
                                    data.idPegawai + '" data-nama-pegawai="' + data.namaPegawai + '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    responsive: true,
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25, 50, 100],
                });

                // show modal tambah
                $(document).on('click', '#tambah-Pegawai', function(e) {
                    e.preventDefault();
                    $("#modalPegawai").modal("show");
                    $("#modal-title-pegawai").text('Tambah Pegawai');
                    $("#bt-form-pegawai").html(`<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"
                                id="btn-tbhSubmitPegawai">Simpan</button>`);
                });

                // submit form pegawai
                $(document).ready(function() {
                    $(document).on('click', '#btn-tbhSubmitPegawai', function(e) {
                        e.preventDefault();

                        var data = {
                            'nip': $('#nip').val(),
                            'namaPegawai': $('#namaPegawai').val(),
                            'tempatLahir': $('#tempatLahir').val(),
                            'tanggalLahir': $('#tanggalLahir').val(),
                            'jenisKelamin': $('#jenisKelamin').val(),
                            'agama': $('#agama').val(),
                            'alamat': $('#alamat').val(),
                            'jenisPegawai': $('#jenisPegawai').val(),
                            'noHp': $('#noHP').val(),
                            'status': $('#status').val(),
                        };
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: "POST",
                            url: "{{ route('pegawai.store') }}",
                            data: data,
                            dataType: "json",
                            success: function(response) {
                                $(".btn-block-option").click();
                                $('#tabelPegawai').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                });

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
                });

                // show edit modal
                $(document).on('click', '#action-editPegawai', function(e) {
                    e.preventDefault();
                    $("#modalPegawai").modal("show");
                    $("#modal-title-pegawai").text('Edit Pegawai');
                    $("#bt-form-pegawai").html(`
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-submitEdtPegawai">Simpan</button>
                    `);

                    var id = $(this).val();

                    $.ajax({
                        type: "GET",
                        url: "{{ url('pegawai/edit') }}/" + id,
                        success: function(response) {
                            // console.log(response.data.idPegawai);
                            $('#for-id-pegawai').val(response.data.idPegawai);
                            $('#nip').val(response.data.nip);
                            $('#namaPegawai').val(response.data.namaPegawai);
                            $('#tempatLahir').val(response.data.tempatLahir);
                            $('#tanggalLahir').val(response.data.tanggalLahir);
                            $('#alamat').val(response.data.alamat);
                            $('#jenisKelamin').val(response.data.jenisKelamin);
                            $('#agama').val(response.data.agama);
                            $('#noHP').val(response.data.noHp);
                            $('#status').val(response.data.status);
                            $('#jenisPegawai').val(response.data.jenisPegawai);
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

                // submit edit data pegawai
                $(document).on('click', '#btn-submitEdtPegawai', function(e) {
                    e.preventDefault();
                    var id = $("#for-id-pegawai").val();
                    // console.log(id);

                    var data = {
                        'nip': $('#nip').val(),
                        'namaPegawai': $('#namaPegawai').val(),
                        'tempatLahir': $('#tempatLahir').val(),
                        'tanggalLahir': $('#tanggalLahir').val(),
                        'alamat': $('#alamat').val(),
                        'jenisKelamin': $('#jenisKelamin').val(),
                        'agama': $('#agama').val(),
                        'noHp': $('#noHP').val(),
                        'status': $('#status').val(),
                        'jenisPegawai': $('#jenisPegawai').val(),
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "PUT",
                        url: "{{ url('pegawai/update') }}/" + id,
                        dataType: "json",
                        data: data,
                        success: function(response) {
                            $(".btn-block-option").click();
                            $('#tabelPegawai').DataTable().ajax.reload();
                            Swal.fire({
                                icon: response.status,
                                title: response.status,
                                text: response.message,
                            });
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

                // delete data pegawai
                $(document).on('click', '#action-hapusPegawai', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-pegawai');

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
                                type: 'DELETE',
                                url: "{{ url('pegawai/destroy') }}/" + id,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });

                                    $('#tabelPegawai').DataTable().ajax.reload();
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
