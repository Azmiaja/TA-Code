@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"></h3>
                <div class="block-options">
                    <select name="pilih_periode" id="pilih_periode_siswa" class="form-select form-select-sm">
                        @foreach ($periode as $item)
                            <option value="{{ $item->idPeriode }}" {{ $item->status === 'Aktif' ? 'selected' : '' }}>
                                Semester
                                {{ $item->semester }} {{ $item->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="block-content block-content-full p-0">
                <div class="table-responsive m-4 m-md-0 p-md-4 p-0">
                    <div class="row g-3 pb-3 pt-1">
                        <div class="col-md-6 text-md-start text-center">
                            <div class="btn-group" role="group" id="gb_kelas" aria-label="Horizontal Alternate Info">
                                <button type="button" class="btn btn-sm btn-outline-danger btn_kelas active"
                                    value="1">Kelas
                                    1</button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn_kelas" value="2">Kelas
                                    2</button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn_kelas" value="3">Kelas
                                    3</button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn_kelas" value="4">Kelas
                                    4</button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn_kelas" value="5">Kelas
                                    5</button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn_kelas" value="6">Kelas
                                    6</button>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end text-center">
                            <button class="btn btn-sm btn-alt-success" id="btn_tambahKelasSiswa"><i
                                    class="fa fa-plus me-2"></i>Kelola Siswa</button>
                        </div>
                    </div>
                    <table id="tabel_siswaKelas" class="table table-bordered table-vcenter w-100">
                        <thead class="bg-body-light align-middle">
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                {{-- <th style="width: 10%;">Kelas</th> --}}
                                <th style="width: 10%;">Fase</th>
                                <th style="width: 8%;">NIS</th>
                                <th>Nama Siswa</th>
                                <th style="width: 22%;">Semester</th>
                                <th style="width: 10%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- conten --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ==================================== MODAL SISWA ============================================= --}}
    <div class="modal fade" id="modal_kelasSiswa" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal-bagiKelasSiswaLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="title-modal-siswa"></h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <form action="" id="form_siswaKelas" method="post">
                            @csrf
                            <input type="hidden" name="_method" id="method_siswaKelas" value="POST">
                            <input type="text" name="idKelas" class="id-tr-kelas" hidden>
                            <div class="mb-3">
                                <label class="form-label" for="pilih_periode">Periode Semester</label>
                                <select name="pilih_periode" id="pilih_periode" class="form-select" required>
                                    <option value="" disabled selected>Pilih Periode</option>
                                    @foreach ($periode as $item)
                                        <option value="{{ $item->idPeriode }}">
                                            Semester
                                            {{ $item->semester }} {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="idSiswa">Nama Siswa</label>
                                <select name="idSiswa[]" multiple="multiple" id="idSiswa" class="form-select"></select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="idKelas">Kelas</label>
                                <select name="idKelas" id="idKelas" class="form-select"
                                    data-placeholder="Pilih Kelas"></select>
                            </div>

                            <div class="mb-4 text-end" id="cn-btn-siswa">
                                {{-- button submit --}}
                            </div>
                    </div>

                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                const tabelSiswaKelas = $('#tabel_siswaKelas');
                const insertSiswaKelas = $('#btn_tambahKelasSiswa');
                const modalSiswaKelas = $('#modal_kelasSiswa');
                const modalSiswaKelas_title = $('#title-modal-siswa');
                const modalSiswaKelas_btn = $('#cn-btn-siswa');
                const methodlSiswaKelas = $('#method_siswaKelas');
                const formSiswaKelas = $('#form_siswaKelas');


                insertSiswaKelas.click(function() {
                    // $('#idKelas').val(null).change();
                    // $('#idSiswa').val(null).change();
                    $('#pilih_periode').change(function() {
                        var id = $(this).val();
                        getSelectSiswa(id);
                    });
                });

                // selet2 from kelas siswa
                select2('#idKelas', modalSiswaKelas);

                let kelas = $('.btn_kelas.active').val();
                $('.content .block-title').text('Data Siswa Kelas ' + kelas);

                $('#gb_kelas').on('click', '.btn_kelas', function() {
                    $('.btn_kelas').removeClass('active');
                    $(this).addClass('active');
                    let kelas = $('.btn_kelas.active').val();
                    $('.content .block-title').text('Data Siswa Kelas ' + kelas);
                    // getAppKelas();

                    // Muat ulang data tabel
                    tabelSiswaKelas.DataTable().ajax.reload();
                });


                function getSelectSiswa(id) {
                    $.ajax({
                        type: "GET",
                        url: `{{ url('data-kelas/option/siswa') }}`,
                        data: {
                            idPeriode: id
                        },
                        success: function(data) {
                            $('#idSiswa').empty();
                            $.each(data.siswa, function(i, item) {
                                $('#idSiswa').append(
                                    `<option ${i<10 ? 'selected' : ''} value="${item.idSiswa}">${item.nis} - ${item.namaSiswa}</option>`
                                );
                            });
                        },
                    });
                }

                function getAppKelas() {
                    $.ajax({
                        type: "GET",
                        url: `{{ url('data-kelas/get/siswa') }}`,
                        data: {
                            periode_siswa: $('#pilih_periode_siswa').val(),
                            kelas_nama: $('.btn_kelas.active').val(),
                        },
                        success: function(data) {
                            console.log(data);
                        },
                    });
                }


                function getSelectKelas() {
                    $('#idKelas').html('');
                    $.ajax({
                        type: "GET",
                        url: `{{ route('form.kelas') }}`,
                        data: {
                            periode: $('#pilih_periode').val()
                        },
                        success: function(data) {
                            $('#idKelas').prepend(`<option disabled selected>Pilih Kelas</option>`);
                            $.each(data.kelas, function(i, item) {
                                var selected = '';
                                if (item.idKelas === $('#idKelas').val()) {
                                    selected = 'selected';
                                }
                                $('#idKelas').append(
                                    `<option value="${item.idKelas}" ${selected}>Kelas ${item.namaKelas} - ${item.guru.namaPegawai}</option>`
                                );
                            });
                        },
                    });
                }

                $('#pilih_periode').on('change', function() {
                    getSelectKelas();
                });


                // getAppKelas();
                $('#pilih_periode_siswa').on('change', function() {
                    // getAppKelas();
                    tabelSiswaKelas.DataTable().ajax.reload();
                });

                // Siswa
                tabelSiswaKelas.DataTable({
                    processing: true,
                    ajax: {
                        url: "{{ url('data-kelas/get/siswa') }}",
                        data: function(d) {
                            d.kelas_nama = $('.btn_kelas.active').val();
                            d.periode_siswa = $('#pilih_periode_siswa').val();
                        }
                    },
                    columns: [{
                            data: 'nomor',
                            name: 'nomor',
                            className: 'text-center',
                        },
                        {
                            data: 'fase',
                            name: 'fase',
                            className: 'text-center',
                            render: function(data) {
                                var fase = data;
                                if (fase === 'A') {
                                    return '<span class="badge bg-primary">Fase A</span>';
                                } else if (fase === 'B') {
                                    return '<span class="badge bg-success">Fase B</span>';
                                } else if (fase === 'C') {
                                    return '<span class="badge bg-warning">Fase C</span>';
                                }
                                return '<em>null</em>';
                            },
                        },
                        {
                            data: 'nis',
                            name: 'nis'
                        },
                        {
                            data: 'namaSiswa',
                            name: 'namaSiswa'
                        },
                        {
                            data: 'semester',
                            name: 'semester',
                        },
                        {
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row) {
                                // console.log(data);
                                return `<div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-alt-danger" title="Delete" id="action-deleteSiswa" value="${data.idSiswa}" data-kelas="${data.kelas}" data-nama="${data.namaSiswa}"><i class="fa fa-fw fa-times"></i></button>
                                    </div>`;
                                // <button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editSiswa" value="${data.idSiswa}"><i class="fa fa-fw fa-pencil-alt"></i></button>
                            }
                        }
                    ],
                    order: [
                        [3, 'asc']
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [25, 50, 100],
                });

                showModalInsert(
                    insertSiswaKelas,
                    modalSiswaKelas,
                    formSiswaKelas,
                    `{{ route('data-kelas.store.siswa') }}`,
                    methodlSiswaKelas,
                    modalSiswaKelas_title,
                    modalSiswaKelas_btn,
                    'Tambah Siswa Kelas',
                    `<button type="submit" class="btn btn-primary" >Simpan</button>`,
                );


                modalSiswaKelas.on('hidden.bs.modal', function() {
                    resetForm(
                        formSiswaKelas,
                        function() {
                            $('#idSiswa').prop("disabled", false);
                            $('#idKelas').val(null).change();
                            $('#idSiswa').val(null).change();

                        }
                    );
                });

                select2Multiple('#idSiswa', modalSiswaKelas);

                // Store & Update Siswa
                insertOrUpdateData(
                    formSiswaKelas,
                    function() {
                        modalSiswaKelas.modal('hide');
                        tabelSiswaKelas.DataTable().ajax.reload();
                    }
                );

                $(document).on('click', '#action-editSiswa', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    modalSiswaKelas.modal('show');
                    updateModals(
                        modalSiswaKelas_title,
                        modalSiswaKelas_btn,
                        'Ubah Siswa Kelas',
                        `<button type="submit" class="btn btn-primary" >Simpan</button>`,
                    );
                    methodlSiswaKelas.val('PUT');
                    formSiswaKelas.attr('action', `{{ url('data-kelas/update/siswa/${id}') }}`);

                    $('#idSiswa').html('');
                    $('#idSiswa').prop("disabled", true);

                    $.ajax({
                        type: "GET",
                        url: `{{ url('data-kelas/edit/siswa/${id}') }}`,
                        success: function(response) {
                            $('#pilih_periode').val(response.kelas[0].idPeriode).trigger('change');
                            $('#idSiswa').append(
                                `<option selected value="${response.idSiswa}">${response.namaSiswa}</option>`
                            );
                            setTimeout(function() {
                                // $('#idKelas').prepend(`<option selected value="${response.kelas[0].idKelas}">Kelas ${response.kelas[0].namaKelas} - ${response.kelas[0].guru.namaPegawai}</option>`);
                                $('#idKelas').val(response.kelas[0].idKelas).change();
                            }, 500);
                        },
                    });

                });

                $(document).on('click', '#action-deleteSiswa', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama');
                    var kelas = $(this).data('kelas');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus data <strong>${nama}</strong> dari <strong>${kelas}</strong>, ini akan berpengaruh pada data lain yang terkait.`,
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
                                url: `{{ url('data-kelas/destroy/siswa/${id}') }}`,
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
                                        tabelSiswaKelas.DataTable().ajax.reload();

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
