@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Daftar Pesan Masuk</h3>
                {{-- <div class="block-options">
                    <button class="btn btn-sm btn-alt-success" data-toggle="block-option" id="insertBerita"><i
                            class="me-2 fa fa-plus"></i><span>Tambah</span></button>
                </div> --}}
            </div>
            <div class="block-content block-content-full p-0">
                <div class="table-responsive p-3">
                    <table id="tabelPesan" class="table w-100 table-bordered border-dark table-stripped">
                        <thead class="bg-gray-light align-middle">
                            <tr class="text-center fw-medium fs-sm">
                                <th style="width: 5%">No</th>
                                <th style="width: 14%">Waktu</th>
                                <th style="width: 20%">Nama Pengirim</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th style="width: 27%">Pesan</th>
                                <th style="width: 7%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- content --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                const tabel = $('#tabelPesan');

                let urlTabel = `{{ route('pesan.get-data') }}`;
                tabel.DataTable({
                    ajax: urlTabel,
                    columns: [{
                            data: 'nomor',
                            nama: 'nomor',
                            className: 'text-center'
                        }, {
                            data: 'waktu',
                            name: 'waktu',
                        }, {
                            data: 'namaPengirim',
                            name: 'namaPengirim'
                        }, {
                            data: 'email',
                            name: 'email'
                        }, {
                            data: 'telp',
                            name: 'telp',
                        }, {
                            data: 'pesan',
                            name: 'pesan',
                        },
                        {
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-alt-danger" title="Hapus" id="action-hapusPegawai" data-nama-pesan="${data.namaPengirim}" value="${data.idPesan}">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>`;
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25, 50],
                });

                $(document).on('click', '#action-hapusPegawai', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-pesan');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Menghapus pesan dari ${nama}`,
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "DELETE",
                                url: `{{ url('pesan/destroy/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });
                                    tabel.DataTable().ajax.reload();
                                },
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
