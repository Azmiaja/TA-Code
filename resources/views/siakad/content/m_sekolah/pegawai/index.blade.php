@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')

    <div class="content">
        <div class="row g-3">
            <div class="col-lg-9 col-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Daftar Pegawai</h3>
                        <div class="block-options">
                            <button class="btn btn-sm btn-alt-success" id="tambah-Pegawai" title="Tambah Pegawai"><i
                                    class="fa fa-plus mx-2"></i>Tambah
                                Data Pegawai</button>
                        </div>
                    </div>
                    <div class="block-content block-content-full p-0">
                        <div class="table-responsive m-md-0 m-4 p-md-4 p-0">
                            <table id="tabelPegawai" class="table w-100 table-bordered align-middle">
                                <thead class="bg-body-light align-middle">
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Kategori</th>
                                        <th style="width: 10%">Aksi</th>
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
            <div class="col-lg-3 col-12">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Daftar Jabatan</h3>
                        <div class="block-options">
                            <button class="btn btn-sm btn-alt-success" id="tambah-Jabatan" title="Tambah Jabatan"><i
                                    class="fa fa-plus mx-2"></i></button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div id="jabatanPegawai"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('siakad/content/m_sekolah/pegawai/modal-pegawai')
    @include('siakad/content/m_sekolah/pegawai/modal-jabatan')


    @push('scripts')
        <script>
            $(document).ready(function() {

                const jabatanP = $('#jabatanPegawai');
                const tabel = $('#tabelPegawai');
                const insertPegawai = $('#tambah-Pegawai');
                const insertJabatan = $('#tambah-Jabatan');
                const modalPegawai = $("#modalPegawai");
                const modalJabatan = $("#modalJabatan");
                const modalTitle = $("#modal-title");
                const btnModalPegawai = $("#bt-form-pegawai");
                const formMethod = $('#method');
                const formPegawai = $('#formPegawai');
                const formJabatan = $('#formJabatan');
                const editPegawai = $('#action-editPegawai');
                const vwJabatan = $("#jabatanView");

                const imgPrev = document.querySelector('.img-preview');
                const idPegawai = document.getElementById("idPegawai");
                const nip = document.getElementById("nip");
                const nama = document.getElementById("namaPegawai");
                const jnKelamin = document.getElementById("jenisKelamin");
                const tpLahir = document.getElementById("tempatLahir");
                const tglLahir = document.getElementById("tanggalLahir");
                const alamat = document.getElementById("alamat");
                const jnPegawai = document.getElementById("jenisPegawai");
                const agama = document.getElementById("agama");
                const idJabatan = document.getElementById("idJabatan");
                const hp = document.getElementById("noHp");
                const status = document.getElementById("status");


                $('#fileButton').click(function() {
                    $('#gambarPegawai').click();
                });

                getJabatanPegawai();

                function getJabatanPegawai() {
                    let urlJabatan = `{{ route('get-jabatan') }}`;
                    // var id = $(this).val();
                    $.ajax({
                        url: urlJabatan,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {

                            jabatanP.html('');
                            // Append data ke select option
                            $.each(data, function(i, item) {
                                var jabatan = item.jabatan ?? null;
                                var idJabatan = item.idJabatan ?? null;
                                jabatanP.append(`<a href="javascript:void(0)" class="block block-rounded block-link-pop border shadow-sm mb-2 p-2" 
                                data-id-jabatan="${idJabatan}" data-name-jabatan="${jabatan}" id="jabatanView">
                                                    <span>
                                                        <i class="text-primary fa-solid fa-paperclip me-2"></i>${jabatan}
                                                    </span>
                                                </a>`);
                            });
                        }
                    });
                }
                const jabatandd = $('#idJabatan');

                function getJabatan(url) {
                    // var id = $(this).val();
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Kosongkan select option
                            jabatandd.find('option').not(':first').remove();

                            // Append data ke select option
                            $.each(data, function(i, item) {
                                jabatandd.append($('<option>', {
                                    value: item.idJabatan,
                                    text: item.jabatan
                                }));
                            });
                        }
                    });
                }

                new AirDatepicker('#tanggalLahir', {
                    container: '#modalPegawai',
                    autoClose: true,
                });


                modalPegawai.on('hidden.bs.modal', function() {
                    // Reset form
                    resetForm(formPegawai, function() {
                        imgPrev.style.display = 'none';

                    })
                });

                // tabel pegawai
                let urlTabelPegawai = `{{ route('pegawai.get-data') }}`;
                tabel.DataTable({
                    ajax: urlTabelPegawai,
                    columns: [{
                            data: 'nomor',
                            nama: 'nomor',
                            className: 'text-center'
                        }, {
                            data: 'nip',
                            name: 'nip'
                        }, {
                            data: 'namaPegawai',
                            name: 'namaPegawai'
                        }, {
                            data: 'jenisKelamin',
                            name: 'jenisKelamin',
                            className: 'text-center',
                        }, {
                            data: 'jenisPegawai',
                            name: 'jenisPegawai',
                            className: 'text-center',
                            render: function(data, type, row) {
                                var statusClass = row.jenisPegawai === 'Guru' ?
                                    'bg-success-light text-success' : 'bg-warning-light text-warning';
                                return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${statusClass}">${row.jenisPegawai}</span>`;
                            }
                        },
                        {
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editPegawai" value="${data.idPegawai}">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-alt-danger" title="Hapus" id="action-hapusPegawai" data-nama-pegawai="${data.namaPegawai}" value="${data.idPegawai}">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>`;
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25],
                });


                // show modal tambah
                insertPegawai.click(function(e) {
                    e.preventDefault();
                    modalPegawai.modal('show');
                    updateModals(modalTitle, btnModalPegawai, 'Tambah Data Pegawai',
                        `<button type="submit" class="btn btn-primary" id="btn-tbhSubmitPegawai">Simpan</button>`
                    );
                    formPegawai.attr('action', '{{ route('pegawai.store') }}');
                    formMethod.val('POST');
                    getJabatan(`{{ route('get-jabatan.options') }}`);
                });

                insertJabatan.click(function(e) {
                    e.preventDefault();
                    modalJabatan.modal('show');
                    updateModals($('#modal-title-jabatan'), $('#bt-form-jabatan'), 'Tambah Data Jabatan',
                        `<button type="submit" class="btn btn-primary" id="btn-tbhSubmitJabatan">Simpan</button>`
                    );
                    formJabatan.attr('action', '{{ route('jabatan.store') }}');
                    formMethod.val('POST');
                    formJabatan.trigger('reset');
                    $('#jabatan').prop('readonly', false);
                });

                // submit form pegawai
                insertOrUpdateData(formPegawai, function() {
                    modalPegawai.modal('hide');
                    tabel.DataTable().ajax.reload();
                });

                // submit form jabatan
                insertOrUpdateData(formJabatan, function() {
                    modalJabatan.modal('hide');
                    getJabatanPegawai();
                });


                $(document).on('click', '#jabatanView', function(e) {
                    e.preventDefault();

                    var id = $(this).data('id-jabatan');
                    var name = $(this).data('name-jabatan');

                    modalJabatan.modal('show');
                    updateModals($('#modal-title-jabatan'), $('#bt-form-jabatan'), 'Data Jabatan',
                        `<button type="button" class="btn btn-danger" id="btn-hapusJabatan">Hapus</button>`
                    );
                    $('#jabatan').prop('readonly', true);
                    $('#jabatan').val(name);
                    $('#idJ').val(id);
                });

                // show edit modal
                $(document).on('click', '#action-editPegawai', function(e) {
                    e.preventDefault();

                    modalPegawai.modal('show');
                    updateModals(modalTitle, btnModalPegawai, 'Ubah Data Pegawai',
                        `<button type="submit" class="btn btn-primary">Simpan</button>`
                    );
                    formMethod.val('PUT');

                    getJabatan(`{{ route('get-jabatan.options.edit') }}`);

                    var id = $(this).val();
                    // console.log(id);
                    formPegawai.attr('action', `{{ url('pegawai/update/${id}') }}`);

                    var url = `{{ url('pegawai/edit/${id}') }}`;

                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function(response) {
                            // console.log(response.data.idPegawai);
                            $(idPegawai).val(response.data.idPegawai);
                            $(nip).val(response.data.nip);
                            $(namaPegawai).val(response.data.namaPegawai);
                            $(tpLahir).val(response.data.tempatLahir);
                            $(tglLahir).val(moment(response.data.tanggalLahir).format('DD/MM/YYYY'));
                            $(alamat).val(response.data.alamat);
                            $(jnKelamin).val(response.data.jenisKelamin);
                            $(agama).val(response.data.agama);
                            $(hp).val(response.data.noHp);
                            $(status).val(response.data.status);
                            $(jnPegawai).val(response.data.jenisPegawai);
                            $(idJabatan).val(response.data.idJabatan);

                            if (response.data.gambar == null) {
                                imgPrev.src = '';
                            } else {
                                var image = `{{ asset('storage/${response.data.gambar}') }}`;
                                imgPrev.style.display = 'block';
                                imgPrev.src = image;
                            }
                        },
                    });
                });

                // delete data pegawai
                $(document).on('click', '#action-hapusPegawai', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-pegawai');
                    var url = `{{ url('pegawai/destroy/${id}') }}`;

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus pegawai <b>${nama}</b> akan menghapus data lain yang terkait.`,
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
                                url: url,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    tabel.DataTable().ajax.reload();
                                },
                            });
                        }
                    });
                });

                // delete data jabatan
                $(document).on('click', '#btn-hapusJabatan', function(e) {
                    e.preventDefault();

                    var id = $('#idJ').val();
                    var nama = $('#jabatan').val();
                    var url = `{{ url('jabatan/destroy/${id}') }}`;

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus data <strong>${nama}</strong>`,
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
                                url: url,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });

                                    modalJabatan.modal('hide');
                                    getJabatanPegawai();
                                },
                            });
                        }
                    });
                });

            });
        </script>
    @endpush
@endsection
