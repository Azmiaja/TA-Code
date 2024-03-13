@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="col-6 text-end">
        </div>
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Periode</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-success" id="tambah-periode"><i class="fa fa-plus mx-2"></i>Tambah
                        Periode Baru</button>
                </div>
            </div>
            <div class="block-content block-content-full p-0">
                <div class="table-responsive m-md-0 m-4 p-md-4 p-0">
                    <table id="tabelPeriode"
                        class="table w-100 table-bordered table-vcenter align-middle">
                        <thead class="align-middle bg-body-light">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 25%;">Semester</th>
                                <th style="width: 25%;">Tanggal Mulai</th>
                                <th style="width: 25%;">Tanggal Selesai</th>
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

        @include('siakad.content.m_sekolah.akademik.periode.modal')

    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                const btnInsert = $('#tambah-periode');
                const tabel = $('#tabelPeriode');
                const modal = $('#modalPeriode');
                const method = $('#method');
                const form = $('#form-periode');

                tabel.DataTable({
                    ajax: "{{ url('get-data/periode') }}",
                    columns: [{
                        data: 'nomor',
                        name: 'nomor',
                        className: 'text-center'
                    }, {
                        data: 'semester',
                        name: 'semester',
                        className: 'text-center'
                    }, {
                        data: 'tanggalMulai',
                        name: 'tanggalMulai',
                        className: 'text-center'
                    }, {
                        data: 'tanggalSelesai',
                        nema: 'tanggalSelesai',
                        className: 'text-center'
                    }, {
                        data: null,
                        className: 'text-center',
                        searchable: false,
                        render: function(data, type, row) {
                            return '<div class="btn-group">' +
                                '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editPeriode" value="' +
                                data.idPeriode + '">' +
                                '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusPeriode" title="Delete" value="' +
                                data.idPeriode + '" data-semester="' + data.semester + '" data-mulai="' + data
                                .tanggalMulai + '" data-selesai="' + data.tanggalSelesai + '">' +
                                '<i class="fa fa-fw fa-times"></i></button>' +
                                '</div>';
                        }
                    }],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25],
                });

                function modalUpdate(title, button) {
                    $('#modal-title').text(title);
                    $('#btn-form').html(button);
                }

                btnInsert.click(function(e) {
                    e.preventDefault();

                    modal.modal('show');
                    modalUpdate('Tambah Periode Baru',
                        `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-tambah" id="btn-tambahPeriode">Simpan</button>`
                    );
                    form.attr('action', '{{ route('periode.store') }}');
                });

                // STORE DATA
                form.submit(function(e) {
                    e.preventDefault();
                    var data = new FormData(form[0]);
                    $.ajax({
                        type: "POST",
                        url: form.attr('action'),
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
                            modal.modal('hide');
                            tabel.DataTable().ajax.reload();
                        },
                    });
                });

                // EDIT MODAL SHOW
                $(document).on('click', '#action-editPeriode', function(e) {
                    e.preventDefault();
                    modal.modal('show');
                    modalUpdate('Edit Periode',
                        `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary btn-tambah" id="btn-editPeriode">Simpan</button>`
                    );
                    method.val('PUT');
                    var idPeriode = $(this).val();
                    form.attr('action', `{{ url('periode/update/${idPeriode}') }}`);
                    $.ajax({
                        type: "GET",
                        url: `{{ url('periode/edit/${idPeriode}') }}`,
                        success: function(response) {
                            $('#semester').val(response.periode.semester);
                            $('#tanggalMulai').val(response.periode.tanggalMulai);
                            $('#tanggalSelesai').val(response.periode.tanggalSelesai);
                        },
                    });
                });

                // UPDATE
                $(document).on('click', '#btn-editPeriode', function(e) {
                    e.preventDefault();
                    var data = new FormData(form[0]);
                    $.ajax({
                        type: "POST",
                        url: form.attr('action'),
                        dataType: "json",
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            modal.modal('hide');
                            tabel.DataTable().ajax.reload();
                        },
                    });
                });

                //DELETE
                //AJAX UNTUK DELETE DATA
                $(document).on('click', '#action-hapusPeriode', function(e) {
                    e.preventDefault();
                    var idPeriode = $(this).val();
                    var smt = $(this).data('semester');
                    var mulai = $(this).data('mulai');
                    var selesai = $(this).data('selesai');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus data <b>Semester ${smt}</b><br><b>${mulai}/${selesai}</b><br>`,
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'DELETE',
                                url: `{{ url('periode/destroy/${idPeriode}') }}`,
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
