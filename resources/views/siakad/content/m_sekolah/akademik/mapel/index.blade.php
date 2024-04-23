@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Daftar Mata pelajaran</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-success" id="tambah-mapel"><i class="fa fa-plus mx-2"></i>Tambah
                        Mata Pelajaran</button>
                </div>
            </div>
            <div class="block-content block-content-full p-0">
                <div class="table-responsive m-md-0 m-4 p-md-4 p-0">
                    <table id="tabelMapel" class="table w-100 table-bordered table-vcenter align-middle">
                        <thead class="align-middle bg-body-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Mata Pelajaran</th>
                                <th style="width: 10%;">KKM</th>
                                <th style="width: 15%;">Singkatan</th>
                                <th style="width: 35%;">Deskripsi</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Content --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MODAL INSERT --}}
        <div class="modal fade" id="modal-Mapel" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="modalMapeltLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
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
                            <form methos="POST" id="form-mapel">
                                @csrf
                                <input type="hidden" name="_method" id="method" value="POST">
                                <input type="text" name="idMapel" id="idMapel" class="id-mapel" hidden>
                                <div class="mb-3">
                                    <label class="form-label" for="namaMapel">Mata Pelajaran</label>
                                    <input type="text" class="form-control" id="namaMapel" name="namaMapel"
                                        placeholder="Masukan mata pelajaran" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="singkatan">Singkatan</label>
                                    <input type="text" class="form-control" id="singkatan" name="singkatan"
                                        placeholder="Masukan nama singkatan mapel">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="kkm">KKM</label>
                                    <input type="number" class="form-control" id="kkm" name="kkm"
                                        placeholder="Masukan Kriteria Ketuntasan Minimal (KKM)" required
                                        inputmode="numeric">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="deskripsiMapel">Deskripsi</label>
                                    <textarea class="form-control" placeholder="Masukan deskripsi dari mata pelajaran" id="deskripsiMapel"
                                        name="deskripsiMapel" style="resize: none"></textarea>
                                </div>
                                <div class="mb-4 text-end" id="cn-btn">
                                    {{-- conten button --}}
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

    <script>
        $(document).ready(function() {
            const tabelMapel = $('#tabelMapel');
            tabelMapel.DataTable({
                ajax: "{{ url('mapel/get-data') }}",
                columns: [{
                    data: 'nomor',
                    name: 'nomor',
                    className: 'text-center'
                }, {
                    data: 'mapel',
                    name: 'mapel'
                }, {
                    data: 'kkm',
                    name: 'kkm',
                    className: 'text-center'
                }, {
                    data: 'singkatan',
                    name: 'singkatan',
                    className: 'text-center',
                    render: function(data) {
                        return data ?? '-';
                    }
                }, {
                    data: 'deskripsi',
                    name: 'deskripsi',
                }, {
                    data: null,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return '<div class="btn-group">' +
                            '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editMapel" value="' +
                            data.idMapel + '">' +
                            '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                            '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusMapel" title="Delete" value="' +
                            data.idMapel + '" data-nama-mapel="' + data.mapel + '">' +
                            '<i class="fa fa-fw fa-times"></i></button>' +
                            '</div>';
                    }
                }],
                dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                    "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                    "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                lengthMenu: [25, 50],
            });

            showModalInsert($('#tambah-mapel'), $('#modal-Mapel'), $('#form-mapel'), `{{ route('mapel.store') }}`,
                $('#method'), $('#title-modal'), $('#cn-btn'), 'Tambah Mata Pelajaran',
                `<button type="submit" class="btn btn-primary">Simpan</button>`);

            $('#modal-Mapel').on('hidden.bs.modal', function() {
                resetForm($('#form-mapel'), function() {});
            });

            insertOrUpdateData($('#form-mapel'), function() {
                $('#modal-Mapel').modal('hide');
                tabelMapel.DataTable().ajax.reload();
            });


            $(document).on('click', '#action-editMapel', function(e) {
                e.preventDefault();
                var id = $(this).val();
                $("#modal-Mapel").modal('show');
                updateModals($("#title-modal"), $("#cn-btn"), 'Ubah Mata Pelajaran',
                    `<button type="submit" class="btn btn-primary">Simpan</button>`);

                $('#form-mapel').attr('action', `{{ url('mapel/update/${id}') }}`);
                $('#method').val('PUT');

                $.ajax({
                    type: "GET",
                    url: `{{ url('mapel/edit/${id}') }}`,
                    success: function(response) {
                        $('#namaMapel').val(response.data.namaMapel);
                        $('#deskripsiMapel').val(response.data.deskripsiMapel);
                        $('#kkm').val(response.data.kkm);
                        $('#singkatan').val(response.data.singkatan);
                    },
                });
            });

            $(document).on('click', '#action-hapusMapel', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var nama = $(this).data('nama-mapel');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    html: `Menghapus mapel <b>${nama}</b> akan berdampak pada data lain yang terkait.`,
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: `{{ url('/mapel/destroy/${id}') }}`,
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    tabelMapel.DataTable().ajax.reload();
                                } else {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            },
                        });
                    }
                });
            });
        });
    </script>
@endsection
