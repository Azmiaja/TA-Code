@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Data Siswa</h3>
                <div class="block-options">

                </div>
            </div>
            <div class="block-content block-content-full p-0">
                <div class="table-responsive m-md-0 m-4 p-md-4 p-0">
                    <div class="row m-0">
                        <div class="col-12 py-3 px-0 text-lg-end text-center">
                            <button class="btn btn-sm btn-alt-danger mb-lg-0 mb-2 mx-1" id="hapus-semua-siswa"
                                title="Tambah Siswa"><i class="fa fa-trash mx-2"></i>Hapus Semua Data Siswa</button>
                            <button class="btn btn-sm btn-alt-success mb-lg-0 mb-2 mx-1" id="tambah-siswa"
                                title="Tambah Siswa"><i class="fa fa-plus mx-2"></i>Tambah Data Siswa</button>
                            <div class="btn-group ms-1" role="group" aria-label="Basic mixed styles example">
                                <button type="button" id="btn_import_siswa" class="btn btn-sm btn-alt-warning">Import from
                                    excel</button>
                                <button type="button" id="btn_export_siswa" class="btn btn-sm btn-alt-primary">Export to
                                    excel</button>
                            </div>
                        </div>

                    </div>
                    <table id="tabelSiswa" class="table table-bordered align-middle w-100">
                        <thead class="bg-body-light align-middle">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 14%;">NIS</th>
                                <th>Nama</th>
                                <th style="width: 18%;">Tempat, Tgl Lahir</th>
                                <th style="width: 16%;">Jenis Kelamin</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Data Siswa --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('siakad/content/m_sekolah/siswa/modal')
    @include('siakad/content/m_sekolah/siswa/import-excel')

    @push('scripts')
        <script>
            $(document).ready(function() {
                const modal = $('#modalSiswa');
                const form = $('#formSiswa');
                const modalTitle = $('#modal-title-siswa');
                const btnInsert = $('#tambah-siswa');
                const btModal = $('#bt-form-siswa');
                const tabel = $('#tabelSiswa');
                const method = $('#method');
                const delAll = $('#hapus-semua-siswa');
                const modalImport = $('#modalSiswaImport');
                const formImport = $('#formSiswaImport');
                const btImport = $('#btn_import_siswa');
                const btExport = $('#btn_export_siswa');

                function updateModal(title, button) {
                    modalTitle.text(title);
                    btModal.html(button);
                }

                function resetForm() {
                    form.trigger('reset');
                }

                modal.on('hidden.bs.modal', function() {
                    // Reset form
                    resetForm()
                });

                delAll.click(function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin ingin menghapus semua data siswa?',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'GET',
                                url: `{{ route('siswa.delete.all') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });
                                    tabel.DataTable().ajax.reload();
                                }
                            });
                        }
                    });
                });


                btnInsert.click(function(e) {
                    e.preventDefault();
                    modal.modal('show');
                    updateModal('Tambah Data Siswa', `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>`)
                });

                form.submit(function(e) {
                    e.preventDefault();

                    var data = new FormData(form[0]);
                    var url = `{{ route('siswa.store') }}`;

                    $.ajax({
                        type: "POST",
                        url: url,
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
                        }
                    });
                });
                // DATATABLES SISWA 
                tabel.DataTable({
                    ajax: "{{ route('siswa.get-data') }}",
                    columns: [{
                            data: 'nomor',
                            name: 'nomor',
                            className: 'text-center'
                        }, {
                            data: 'nis',
                            name: 'nis'
                        }, {
                            data: 'nama',
                            name: 'nama'
                        }, {
                            data: 'ttl',
                            nama: 'ttl',
                        }, {
                            data: 'jenisKelamin',
                            name: 'jenisKelamin',
                            className: 'text-center'
                        }, {
                            data: 'status',
                            className: 'text-center',
                        },
                        {
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editSiswa" value="' +
                                    data.idSiswa + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusSiswa" title="Delete" value="' +
                                    data.idSiswa + '" data-nama-siswa="' + data.namaSiswa +
                                    '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25, 50, 100],
                });

                // AJAX MENAMPILKAN MODAL EDIT
                $(document).on('click', '#action-editSiswa', function(e) {
                    e.preventDefault();
                    var idSiswa = $(this).val();
                    modal.modal('show');
                    updateModal('Edit Data Siswa', `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn-editSiswa">Simpan</button>`);

                    method.val('PUT');
                    form.attr('action', `{{ url('siswa/update/${idSiswa}') }}`);
                    var url = `{{ url('siswa/edit/${idSiswa}') }}`;
                    $.ajax({
                        type: "GET",
                        url: url,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            $('#nisn').val(response.siswa.nisn);
                            $('#nis').val(response.siswa.nis);
                            $('#namaSiswa').val(response.siswa.namaSiswa);
                            $('#namaPanggilan').val(response.siswa.panggilan);
                            $('#tempatLahir').val(response.siswa.tempatLahir);
                            $('#tanggalLahir').val(response.siswa.tanggalLahir);
                            $('#alamat').val(response.siswa.alamat);
                            $('#jenisKelamin').val(response.siswa.jenisKelamin);
                            $('#agama').val(response.siswa.agama);
                            $('#status').val(response.siswa.status);
                            $('#namaAyah').val(response.siswa.namaAyah);
                            $('#pekerjaanAyah').val(response.siswa.pekerjaanAyah);
                            $('#noTlpAyah').val(response.siswa.noTlpAyah);
                            $('#alamatAyah').val(response.siswa.alamatAyah);
                            $('#namaIbu').val(response.siswa.namaIbu);
                            $('#pekerjaanIbu').val(response.siswa.pekerjaanIbu);
                            $('#noTlpIbu').val(response.siswa.noTlpIbu);
                            $('#alamatIbu').val(response.siswa.alamatIbu);
                            $('#namaWali').val(response.siswa.namaWali);
                            $('#pekerjaanWali').val(response.siswa.pekerjaanWali);
                            $('#noTlpWali').val(response.siswa.noTlpWali);
                            $('#alamatWali').val(response.siswa.alamatWali);
                            $('#idSiswa').val(response.siswa.idSiswa);
                        }
                    });
                });

                //AJAX UNTUK UPDATE DATA
                $(document).on('click', '#btn-editSiswa', function(e) {
                    e.preventDefault();
                    var idSiswa = $('#idSiswa').val();
                    var data = new FormData(form[0]);

                    $.ajax({
                        type: "POST",
                        url: form.attr('action'),
                        data: data,
                        dataType: "json",
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
                        html: `Menghapus data <b>${namaSiswa}</b> akan menghapus data <b>User</b>-nya juga`,
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
                                url: `{{ url('siswa/destroy/${idSiswa}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });
                                    tabel.DataTable().ajax.reload();
                                }
                            });
                        }
                    });
                });

                // Import from excel
                btImport.click(function(e) {
                    e.preventDefault();

                    modalImport.modal("show");
                });

                formImport.submit(function(e) {
                    e.preventDefault();

                    var data = new FormData(formImport[0]);
                    var url = formImport.attr('action');

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            modalImport.modal('hide');
                            formImport.trigger('reset');
                            tabel.DataTable().ajax.reload();
                        },
                    });
                });

                btExport.click(function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Export Data Siswa',
                        text: 'Anda ingin mengexport data siswa kedalam excel?',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Export!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route('siswa.export') }}';
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
