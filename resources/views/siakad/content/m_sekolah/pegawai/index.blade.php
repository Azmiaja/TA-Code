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
                        <p class="fs-sm text-center mb-2 fw-bold border-bottom">Guru</p>
                        <div id="jabatanPegawai_1"></div>
                        <p class="fs-sm text-center mb-2 fw-bold border-bottom">Tendik</p>
                        <div id="jabatanPegawai_2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Image --}}
    <div class="modal fade" id="modal_fotoPegawai" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal-modal_fotoPegawai" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="title-modal">Ubah Foto Pegawai</h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <form action="" method="POST" id="form_editFotoPegawai" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="mb-2 text-center">
                                    <div class="ratio mx-auto mb-2 rounded-circle border border-5"
                                        style="width: 200px; height: 200px;">
                                        <img src="" id="gambar_pegawai" class="img-preview d-block rounded-circle"
                                            style="width: 100%; height: 100%; object-fit: cover;" alt="">
                                    </div>
                                    <span class="text-danger error-text gambar_error"></span>
                                </div>
                                <div class="mb-4 text-center">
                                    <input type="file" class="form-control d-none" name="gambar"
                                        accept=".jpg,.jpeg,.png,.svg" id="gambarPegawai" onchange="prevImg()">
                                    <button type="button" id="fileButton" class="btn btn-primary">Pilih
                                        File</button>
                                    <button type="submit" class="btn btn-alt-primary">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="block-content block-content-full bg-body">
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

                const modalFoto = $('#modal_fotoPegawai');
                const formFoto = $('#form_editFotoPegawai');

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
                // const image = document.getElementById("gambar_pegawai");
                const jenisPegawai = $('#jenisPegawai');


                $('#fileButton').click(function() {
                    $('#gambarPegawai').click();
                });

                getJabatanPegawai();

                function getJabatanPegawai() {
                    let urlJabatan = `{{ route('get-jabatan') }}`;
                    const jabatanGuru = $("#jabatanPegawai_1");
                    const jabatanTendik = $("#jabatanPegawai_2");
                    // var id = $(this).val();
                    $.ajax({
                        url: urlJabatan,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            jabatanGuru.html('');
                            jabatanTendik.html('');
                            // Append data ke select option
                            $.each(data.guru, function(i, item) {
                                var jabatan = item.jabatan ?? null;
                                var idJabatan = item.idJabatan ?? null;
                                // var jenis = item.jesnis ?? null;
                                jabatanGuru.append(`<a href="javascript:void(0)" class="block block-rounded block-link-pop border shadow-sm mb-2 p-2" 
                                data-id-jabatan="${idJabatan}" data-name-jabatan="${jabatan}" id="jabatanView">
                                                    <span>
                                                        <i class="text-primary fa-solid fa-paperclip me-2"></i>${jabatan}
                                                    </span>
                                                </a>`);
                            });
                            $.each(data.tendik, function(i, item) {
                                var jabatan = item.jabatan ?? null;
                                var idJabatan = item.idJabatan ?? null;
                                var jenis = item.jesnis ?? null;
                                jabatanTendik.append(`<a href="javascript:void(0)" class="block block-rounded block-link-pop border shadow-sm mb-2 p-2" 
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

                function getJabatan() {
                    // var id = $(this).val();
                    $.ajax({
                        url: `{{ route('get-jabatan.options') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Kosongkan select option
                            jabatandd.find('option').not(':first').remove();

                            $.each(data.jabatan2, function(i, item) {
                                // Tambahkan filter berdasarkan jenisPegawai
                                if ((jenisPegawai.val() === 'Guru' && item.jenis === 'Guru') ||
                                    (jenisPegawai.val() === 'Tendik' && item.jenis === 'Tendik')) {
                                    var option = $('<option>', {
                                        value: item.idJabatan,
                                        text: item.jabatan
                                    });
                                    jabatandd.append(option);
                                }
                            });
                        }
                    });
                }

                function getJabatanEdit(id) {
                    // var id = $(this).val();
                    $.ajax({
                        url: `{{ route('get-jabatan.options') }}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Kosongkan select option
                            jabatandd.find('option').not(':first').remove();

                            // Perulangan untuk jabatan1
                            $.each(data.jabatan1, function(i, item) {
                                // Tambahkan filter berdasarkan jenisPegawai
                                if ((jenisPegawai.val() === 'Guru' && item.jenis === 'Guru') ||
                                    (jenisPegawai.val() === 'Tendik' && item.jenis === 'Tendik')) {
                                    var option =
                                        `<option value="${item.idJabatan}" ${item.idJabatan !== id ? 'hidden' : ''} ${item.idJabatan === id ? 'selected' : ''}>${item.jabatan}</option>`;
                                    jabatandd.append(option);
                                }
                            });

                            // Lakukan perulangan untuk jabatan2 hanya jika ada jabatan yang sesuai
                            $.each(data.jabatan2, function(i, jabatan) {
                                if ((jenisPegawai.val() === 'Guru' && jabatan.jenis === 'Guru') ||
                                    (jenisPegawai.val() === 'Tendik' && jabatan.jenis === 'Tendik')
                                ) {
                                    var option =
                                        `<option value="${jabatan.idJabatan}">${jabatan.jabatan}</option>`;
                                    jabatandd.append(option);
                                }
                            });
                        }
                    });
                }

                $(document).on('click', '#action-editGambarPegawai', function(e) {
                    e.preventDefault();

                    const id = $(this).val();
                    // const foto = $(this).data('foto');
                    let gambar = $(this).data('foto');
                    // Tampilkan modal
                    modalFoto.modal('show');

                    // Set action form
                    formFoto.attr('action', `{{ url('pegawai/ubah-image/${id}') }}`);

                    if (gambar && fileExists(`{!! asset('storage/${gambar}') !!}`)) {
                        gambar = `{!! asset('storage/${gambar}') !!}`; // Tampilkan URL gambar
                    } else {
                        gambar = '{!! asset('assets/media/avatars/avatar1.jpg') !!}'; // Atur URL gambar default
                    }
                    // console.log(gambar);

                    imgPrev.src = gambar;
                });





                formFoto.submit(function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $(document).find('span.error-text').text('');
                        },
                        success: function(data) {
                            if (data.status == 0) {
                                $('span.error-text').text(data.error);
                            } else {
                                Swal.fire({
                                    icon: data.status,
                                    title: 'Sukses',
                                    text: data.msg,
                                    showConfirmButton: false,
                                    timer: 1300
                                });
                                modalFoto.modal('hide');
                                tabel.DataTable().ajax.reload();

                            }
                        }
                    });
                });

                modalFoto.on('hidden.bs.modal', function() {
                    formFoto.trigger('reset');
                    $('span.error-text').text('');
                });


                new AirDatepicker('#tanggalLahir', {
                    container: '#modalPegawai',
                    autoClose: true,
                });

                modalPegawai.on('hidden.bs.modal', function() {
                    // Reset form
                    resetForm(formPegawai, function() {
                        imgPrev.style.display = 'none';
                    });
                    jabatandd.val(null).trigger('change');
                    jabatandd.find('option').not(':first').remove();
                });
                modalJabatan.on('hidden.bs.modal', function() {
                    $('.kategori-jabatan').prop('hidden', false);
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
                                    'bg-success-light text-success' :
                                    'bg-warning-light text-warning';
                                return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${statusClass}">${row.jenisPegawai}</span>`;
                            }
                        },
                        {
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-alt-secondary" title="Ubah Gambar" id="action-editGambarPegawai" value="${data.idPegawai}" data-foto="${data.gambar}">
                                            <i class="fa-regular fa-image"></i>
                                        </button>
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
                    jenisPegawai.change(function() {
                        jabatandd.val(null).change();
                        getJabatan();
                    });
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
                    var name_jenis = $(this).data('name-jenis');

                    modalJabatan.modal('show');
                    $('.kategori-jabatan').prop('hidden', true);
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
                            $(tglLahir).val(moment(response.data.tanggalLahir).format(
                                'DD/MM/YYYY'));
                            $(alamat).val(response.data.alamat);
                            $(jnKelamin).val(response.data.jenisKelamin);
                            $(agama).val(response.data.agama);
                            $(hp).val(response.data.noHp);
                            $(status).val(response.data.status);

                            // var idJ = response.data.idJabatan;
                            $(jnPegawai).val(response.data.jenisPegawai).trigger('change');
                            getJabatanEdit(response.data.idJabatan);
                            $(jnPegawai).change(function() {
                                getJabatanEdit(response.data.idJabatan);
                            });
                            // $(idJabatan).val(response.data.idJabatan);
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
                        confirmButtonText: 'Ya, Hapus!',
                        reverseButtons: true,

                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'DELETE',
                                url: url,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status == 'success') {
                                        Swal.fire({
                                            icon: response.status,
                                            title: response.title,
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        tabel.DataTable().ajax.reload();

                                    } else {
                                        Swal.fire({
                                            icon: response.status,
                                            title: response.title,
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });

                                    }
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
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'DELETE',
                                url: url,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status == 'success') {
                                        Swal.fire({
                                            icon: response.status,
                                            title: response.title,
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });

                                        modalJabatan.modal('hide');
                                        getJabatanPegawai();

                                    } else {
                                        Swal.fire({
                                            icon: response.status,
                                            title: response.title,
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 2000
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
