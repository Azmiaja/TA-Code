@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Daftar Ekstrakulikuler</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-success" id="tambah-ekstra"><i class="fa fa-plus mx-2"></i>Tambah
                        Ekstrakulikuler</button>
                </div>
            </div>
            <div class="block-content block-content-full p-0">
                <div class="table-responsive m-md-0 m-4 p-md-4 p-0">
                    <table id="tabel_ekstra" class="table w-100 table-bordered table-vcenter align-middle">
                        <thead class="align-middle bg-body-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Ekstrakulikuler</th>
                                <th style="width: 15%;">Predikat</th>
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
        <div class="modal fade" id="modal-Ekstra" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="modalEkstratLabel" aria-hidden="true">
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
                            <form methos="POST" id="form_ekstra">
                                @csrf
                                <input type="hidden" name="_method" id="method" value="POST">
                                <input type="text" name="idEks" id="idEks" class="id-mapel" hidden>
                                <div class="mb-3">
                                    <label class="form-label" for="ekstra">Nama Ekstrakulikuler</label>
                                    <input type="text" class="form-control" id="ekstra" name="ekstra"
                                        placeholder="Masukan nama ekstrakulikuler" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="predikat">Predikat</label>
                                    <select name="status" class="form-select" id="predikat">
                                        <option value="" selected>Pilih Predikat</option>
                                        <option value="wajib">Wajib</option>
                                        <option value="pilihan">Pilihan</option>
                                    </select>
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tabel_ekstra').DataTable({
                    ajax: "{{ url('ekstra/get-data') }}",
                    columns: [{
                        data: 'nomor',
                        name: 'nomor',
                        className: 'text-center'
                    }, {
                        data: 'ekstra',
                        name: 'ekstra'
                    }, {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        render: function(data, type, row) {
                            var statusClass = row.status === 'wajib' ?
                                'bg-success-light text-success' :
                                'bg-warning-light text-warning';
                            return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill text-uppercase ${statusClass}">${row.status}</span>`;
                        }
                    }, {
                        data: null,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return '<div class="btn-group">' +
                                '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editEkstra" value="' +
                                data.idEks + '">' +
                                '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusEkstra" title="Delete" value="' +
                                data.idEks + '" data-nama-ekstra="' + data.ekstra + '">' +
                                '<i class="fa fa-fw fa-times"></i></button>' +
                                '</div>';
                        }
                    }],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 20],
                });

                showModalInsert($('#tambah-ekstra'), $('#modal-Ekstra'), $('#form_ekstra'),
                    `{{ route('storeEkstra') }}`,
                    $('#method'), $('#title-modal'), $('#cn-btn'), 'Tambah Ekstrakulikuler',
                    `<button type="submit" class="btn btn-primary">Simpan</button>`);

                insertOrUpdateData($('#form_ekstra'), function() {
                    $('#modal-Ekstra').modal('hide');
                    $('#tabel_ekstra').DataTable().ajax.reload();
                });

                $(document).on('click', '#action-editEkstra', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    $("#modal-Ekstra").modal('show');
                    updateModals($("#title-modal"), $("#cn-btn"), 'Ubah Ekstrakulikuler',
                        `<button type="submit" class="btn btn-primary">Simpan</button>`);

                    $('#form_ekstra').attr('action', `{{ url('ekstra/update/${id}') }}`);
                    $('#method').val('PUT');

                    $.ajax({
                        type: "GET",
                        url: `{{ url('ekstra/edit/${id}') }}`,
                        success: function(response) {
                            $('#ekstra').val(response.data.ekstra);
                            $('#predikat').val(response.data.status);
                        },
                    });
                });

                $(document).on('click', '#action-hapusEkstra', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-ekstra');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus ekstrakulikuler <b>${nama}</b> akan berdampak pada data lain yang terkait.`,
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
                                url: `{{ url('ekstra/destroy/${id}') }}`,
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
                                        $('#tabel_ekstra').DataTable().ajax.reload();
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
    @endpush
@endsection
