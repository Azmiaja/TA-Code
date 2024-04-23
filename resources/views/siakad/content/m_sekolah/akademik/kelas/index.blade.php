@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Daftar Kelas</h3>
                <div class="block-options">
                    <select name="pilih_periode" id="pilih_periode_guru" class="form-select form-select-sm">
                        @foreach ($periode as $item)
                            <option value="{{ $item->idPeriode }}" {{ $item->status === 'Aktif' ? 'selected' : '' }}>
                                Semester
                                {{ $item->semester }} {{ $item->tahun }}
                            </option>
                        @endforeach
                        {{-- <option value="">-</option> --}}
                    </select>
                </div>
            </div>
            <div class="block-content p-0">
                <div class="table-responsive m-4 m-md-0 p-md-4 p-0">
                    <div class="row pb-3 pt-1">
                        <div class="col-md text-md-end text-center">
                            <button class="btn btn-sm btn-alt-success" id="btn_tambahKelasGuru"><i
                                    class="fa fa-plus me-2"></i>Kelola Kelas</button>
                        </div>
                    </div>
                    <table id="tabel_waliKelas" class="table table-bordered table-vcenter w-100">
                        <thead class="bg-body-light align-middle">
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 10%;">Kelas</th>
                                <th style="width: 10%;">Fase</th>
                                <th>Nama Guru</th>
                                <th style="width: 12%;">NIP</th>
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

    {{-- ==================================== MODAL GURU ============================================= --}}
    <div class="modal fade" id="modal_kelasGuru" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal-bagiKelasGuruLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title" id="title-modal"></h3>
                        <div class="block-options">
                            <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <form action="" id="form_waliKelas" method="post">
                            @csrf
                            <input type="hidden" name="_method" id="method_waliKelas" value="POST">
                            <input type="text" name="idKelas" class="id-kelas" hidden>
                            <div class="mb-3">
                                <label class="form-label" for="periode">Perode</label>
                                <select id="idPeriode" name="idPeriode" class="form-select" required>
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
                                <label class="form-label" for="idPegawai">Nama Guru</label>
                                <select name="idPegawai" id="idPegawai" class="form-select" required
                                    data-placeholder="Pilih Guru"></select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="namaKelas">Kelas</label>
                                <select name="namaKelas" id="namaKelas" class="form-select" data-placeholder="Pilih Kelas"
                                    required>
                                    <option value="" disabled selected>Pilih Kelas</option>
                                </select>
                            </div>
                            <div class="mb-4 text-end" id="bt_modalGuru">
                                {{-- button submit --}}
                            </div>
                        </form>
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
                const insertWaliKelas = $('#btn_tambahKelasGuru');
                const modalWaliKelas = $('#modal_kelasGuru');
                const modalWaliKelas_btn = $('#bt_modalGuru');
                const modalWaliKelas_title = $('#title-modal');
                const methodlWaliKelas = $('#method_waliKelas');
                const formWaliKelas = $('#form_waliKelas');
                const tabelWaliKelas = $('#tabel_waliKelas');

                // Panggil fungsi untuk mendapatkan daftar kelas yang sudah ada saat halaman dimuat
                $('#pilih_periode_guru').on('change', function() {
                    tabelWaliKelas.DataTable().ajax.reload();
                });
                // Guru
                tabelWaliKelas.DataTable({
                    processing: true,
                    ajax: {
                        url: "{{ url('data-kelas/get/guru') }}",
                        data: function(d) {
                            d.periode_guru = $('#pilih_periode_guru').val();
                        }
                    },
                    columns: [{
                            data: 'nomor',
                            name: 'nomor',
                            className: 'text-center',
                        },
                        {
                            data: 'kelas',
                            name: 'kelas',
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
                            data: 'namaGuru',
                            name: 'namaGuru'
                        },
                        {
                            data: 'nip',
                            name: 'nip'
                        },
                        {
                            data: 'semester',
                            name: 'semester',
                        },
                        {
                            data: null,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    // '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editGuru" value="' +
                                    // data.idKelas + '">' +
                                    // '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusGuru" title="Delete" value="' +
                                    data.idKelas + '" data-nama-guru="' + data.namaGuru +
                                    '" data-nama-kelas="Kelas ' + data.namaKelas + '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    order: [
                        [1, 'asc']
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [6, 35, 50],
                });

                // Show Modal Insert Wali Kelas
                showModalInsert(
                    insertWaliKelas,
                    modalWaliKelas,
                    formWaliKelas,
                    `{{ route('data-kelas.store.guru') }}`,
                    methodlWaliKelas,
                    modalWaliKelas_title,
                    modalWaliKelas_btn,
                    'Tambah Wali Kelas',
                    `<button type="submit" class="btn btn-primary" >Simpan</button>`,
                );

                insertWaliKelas.click(function() {
                    $('#idPegawai').val(null).change();
                });


                // Store & Update Guru
                insertOrUpdateData(
                    formWaliKelas,
                    function() {
                        modalWaliKelas.modal('hide');
                        tabelWaliKelas.DataTable().ajax.reload();
                    }
                );

                $(document).on('click', '#action-editGuru', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    modalWaliKelas.modal('show');
                    updateModals(
                        modalWaliKelas_title,
                        modalWaliKelas_btn,
                        'Ubah Wali Kelas',
                        `<button type="submit" class="btn btn-primary" >Simpan</button>`,
                    );
                    formWaliKelas.attr('action', `{{ url('data-kelas/update/guru/${id}') }}`);
                    methodlWaliKelas.val('PUT');

                    if ($('#pilih_periode_guru').val() === '') {
                        $('#idPeriode').prop('disabled', false);
                    } else {
                        $('#idPeriode').prop('disabled', true);
                    }
                    $('#idPegawai').val(null).change();

                    $.ajax({
                        type: "GET",
                        url: `{{ url('data-kelas/edit/guru/${id}') }}`,
                        success: function(response) {
                            $('#idPeriode').val(response.kelas.idPeriode).trigger('change');
                            if ($('#pilih_periode_guru').val() !== '') {
                                setTimeout(() => {
                                    $('#namaKelas').append(
                                        `<option selected value="${response.kelas.namaKelas}">Kelas ${response.kelas.namaKelas}</option>`
                                    );
                                }, 500);
                            } else {
                                $('#namaKelas').find('option').not(':first').remove();
                                $('#namaKelas').val(response.kelas.namaKelas).trigger('change');
                            }
                            setTimeout(() => {
                                $('#idPegawai').prepend(
                                    `<option value="${response.kelas.idPegawai}" selected>${response.kelas.guru.nip} - ${response.kelas.guru.namaPegawai}</option>`
                                );
                            }, 500);
                        },
                    });
                });

                $(document).on('click', '#action-hapusGuru', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-guru');
                    var kelas = $(this).data('nama-kelas');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus data <strong>${kelas}</strong> dengan wali kelas <b>${nama}</b> akan berpengaruh pada data lain yang terkait.`,
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
                                url: `{{ url('data-kelas/destroy/guru/${id}') }}`,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    tabelWaliKelas.DataTable().ajax.reload();
                                },
                            });
                        }
                    });
                });

                // Modal Guru Reset Form
                modalWaliKelas.on('hidden.bs.modal', function() {
                    resetForm(
                        formWaliKelas,
                        function() {
                            $('#idPegawai').val(null).change();
                            $('#idPeriode').prop('disabled', false);
                            $('#namaKelas').find('option').not(':first').remove();
                        }
                    );
                });

                $('#idPeriode').change(function() {
                    var idPeriode = $(this).val();
                    getSelectPegawai(idPeriode);
                    getKelasNama(idPeriode);
                });


                function getSelectPegawai(id) {
                    $.ajax({
                        type: 'GET',
                        url: `{{ url('data-kelas/option/guru/${id}') }}`,
                        success: function(data) {
                            $('#idPegawai').html('');
                            $('#idPegawai').prepend(`<option disabled selected>Pilih Guru</option>`);
                            $.each(data, function(i, item) {
                                $('#idPegawai').append(
                                    `<option value="${item.idPegawai}">${item.nip} - ${item.namaPegawai}</option>`
                                );
                            });
                        },
                    });
                }

                function getKelasNama(id) {
                    $.ajax({
                        type: 'GET',
                        url: `{{ url('/get-existing-classes/${id}') }}`,
                        success: function(data) {
                            $('#namaKelas').find('option').not(':first').remove();

                            for (var i = 1; i <= 6; i++) {
                                if (!data.includes(i
                                        .toString()
                                    )) { // Memeriksa apakah nilai tidak ada dalam data yang diperoleh
                                    $('#namaKelas').append('<option value="' + i + '">Kelas ' + i +
                                        '</option>'); // Menambahkan opsi kelas
                                }
                            }
                        },
                    });
                }

                // Select2 from wali kelas
                select2(
                    '#idPegawai',
                    modalWaliKelas,
                );




            });
        </script>
    @endpush
@endsection
