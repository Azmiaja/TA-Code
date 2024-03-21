@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Daftar Pengajar</h3>
                <div class="block-options">
                    <select name="pilih_periode" id="pilih_periode" class="form-select form-select-sm">
                        @foreach ($periode as $item)
                            @php
                                $today = now();
                                $startDate = \Carbon\Carbon::parse($item->tanggalMulai);
                                $endDate = \Carbon\Carbon::parse($item->tanggalSelesai);

                                $selected = $startDate <= $today && $today <= $endDate ? 'selected' : '';
                            @endphp
                            <option value="{{ $item->idPeriode }}" {{ $selected }}>
                                Semester
                                {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                            </option>
                        @endforeach
                        <option value="">Semua Semester</option>
                    </select>
                </div>
            </div>
            <div class="block-content block-content-full p-0">
                <div class="table-responsive m-4 m-md-0 p-md-4 p-0">
                    <div class="row g-3 pb-3 pt-1">
                        <div class="col-md-6 text-md-start text-center">
                            <div class="btn-group" role="group" aria-label="Horizontal Alternate Info">
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas active"
                                    value="1">Kelas
                                    1</button>
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas" value="2">Kelas
                                    2</button>
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas" value="3">Kelas
                                    3</button>
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas" value="4">Kelas
                                    4</button>
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas" value="5">Kelas
                                    5</button>
                                <button type="button" class="btn btn-sm btn-alt-warning btn_kelas" value="6">Kelas
                                    6</button>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end text-center">
                            <button class="btn btn-sm btn-alt-success" id="btn_tambahPengajar"><i
                                    class="fa fa-plus me-2"></i>Tambah Pengajar</button>
                        </div>
                    </div>
                    <table id="tabel_Pengajar" class="table table-bordered table-vcenter w-100">
                        <thead class="bg-body-light align-middle">
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 10%;">Kelas</th>
                                <th>Nama Guru</th>
                                <th style="width: 12%;">NIP</th>
                                <th>Mapel Diapu</th>
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

        {{-- MODAL INSERT --}}
        <div class="modal fade" id="modal-Pengajar" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
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
                            <form action="POST" enctype="multipart/form-data" id="form-pengajaran">
                                @csrf
                                <input type="hidden" name="_method" id="method" value="POST">
                                <div class="mb-3">
                                    <label class="form-label" for="idPeriode">Periode Semester</label>
                                    <select name="idPeriode" id="idPeriode" class="form-select">
                                        <option value="" selected>Pilih Periode</option>
                                        @foreach ($periode as $item)
                                            @php
                                                $today = now();
                                                $startDate = \Carbon\Carbon::parse($item->tanggalMulai);
                                                $endDate = \Carbon\Carbon::parse($item->tanggalSelesai);

                                                $selected =
                                                    $startDate <= $today && $today <= $endDate ? 'selected' : '';
                                            @endphp
                                            <option value="{{ $item->idPeriode }}">
                                                Semester
                                                {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="idKelas">Kelas</label>
                                    <select name="idKelas" id="idKelas" class="form-select"
                                        data-placeholder="Pilih Kelas">
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="idPengajaran">Nama Pengajar</label>
                                    <select name="idPegawai" id="idPegawai" class="form-select"
                                        data-placeholder="Pilih Guru">
                                    </select>
                                </div>
                                <div class="mb-3" id="multi_mapel">
                                    <label class="form-label" for="idMapel">Mapel</label>
                                    <select name="idMapel[]" id="idMapel" multiple="multiple" class="form-select"
                                        data-placeholder="Pilih Mapel">
                                    </select>
                                </div>
                                <div class="mb-3" id="mapel_two" hidden>
                                    <label class="form-label" for="idMapel_two">Mapel</label>
                                    <select name="idMapel_two" id="idMapel_two" class="form-select"
                                        data-placeholder="Pilih Mapel">
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
        @push('scripts')
            <script>
                $(document).ready(function() {
                    const tabelPengajar = $('#tabel_Pengajar');
                    const btnInsert = $('#btn_tambahPengajar');
                    const modalPengajar = $('#modal-Pengajar');
                    const modalPengajar_title = $('#title-modal');
                    const modalPengajar_btn = $('#cn-btn');
                    const formPengajar = $('#form-pengajaran');
                    const method = $('#method');

                    // FUNGSI PERIODE
                    $('#pilih_periode').change(function() {
                        tabelPengajar.DataTable().ajax.reload();
                    });

                    $('.btn_kelas').on('click', function() {
                        $('.btn_kelas').removeClass('active');
                        $(this).addClass('active');

                        // Muat ulang data tabel
                        tabelPengajar.DataTable().ajax.reload();
                    });

                    tabelPengajar.DataTable({
                        processing: true,
                        ajax: {
                            url: "{{ url('pengajar/get-data') }}",
                            data: function(d) {
                                d.periode = $('#pilih_periode').val();
                                d.namaKelas = $(".btn_kelas.active").val();
                            }
                        },
                        columns: [{
                                data: 'nomor',
                                name: 'nomor',
                                className: 'text-center',
                            },
                            {
                                data: 'kelasPengajar',
                                name: 'kelasPengajar',
                            },
                            {
                                data: 'namaPengajar',
                                name: 'namaPengajar'
                            },
                            {
                                data: 'nipPengajar',
                                name: 'nipPengajar'
                            },
                            {
                                data: 'mapelDiapu',
                                name: 'mapelDiapu'
                            },
                            {
                                data: 'semester',
                                name: 'semester',
                            }, {
                                data: null,
                                className: 'text-center',
                                searchable: false,
                                render: function(data, type, row) {
                                    return '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editPengajar" value="' +
                                        data.idPengajaran + '">' +
                                        '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                        '<button type="button" class="btn btn-sm btn-alt-danger"  id="action-hapusPengajar" title="Delete" value="' +
                                        data.idPengajaran + '" data-nama-pengajar="' + data.guru
                                        .namaPegawai + '" data-kelas="' + data.kelasPengajar + '">' +
                                        '<i class="fa fa-fw fa-times"></i></button>' +
                                        '</div>';
                                }
                            }
                        ],
                        // order: [
                        //     [2, 'asc']
                        // ],
                        dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                            "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                            "<'row mb-2'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                        lengthMenu: [10, 25, 50],
                    });

                    showModalInsert(btnInsert, modalPengajar, formPengajar, `{{ route('pengajar.store') }}`, method,
                        modalPengajar_title,
                        modalPengajar_btn, 'Tambah Pengajar',
                        `<button type="submit" class="btn btn-primary" id="sub">Simpan</button>`);

                    btnInsert.click(function() {
                        $('#idKelas').val(null).change();
                        $('#idPegawai').val(null).change();
                        $('#idMapel').val(null).change();
                    });

                    function getSelectKelas() {
                        $.ajax({
                            type: "GET",
                            url: `{{ route('form.kelas') }}`,
                            data: {
                                periode: $('#idPeriode').val()
                            },
                            success: function(data) {
                                $('#idKelas').empty();
                                $.each(data.kelas, function(i, item) {
                                    $('#idKelas').append(
                                        `<option value="${item.idKelas}">Kelas ${item.namaKelas}</option>`
                                    );
                                });
                            },
                        });
                    }

                    function getSelectPegawai() {
                        $.ajax({
                            type: "GET",
                            url: `{{ route('pegawai.select') }}`,
                            success: function(data) {
                                $('#idPegawai').empty();
                                $.each(data, function(i, item) {
                                    $('#idPegawai').append(
                                        `<option value="${item.idPegawai}">${item.nip} - ${item.namaPegawai}</option>`
                                    );
                                });
                            },
                        });
                    }

                    function getSelectMapel() {
                        $.ajax({
                            type: "GET",
                            url: `{{ route('pengajar.form') }}`,
                            success: function(data) {
                                $('#idMapel').empty();
                                $('#idMapel_two').empty();
                                $.each(data.mapel, function(i, item) {
                                    $('#idMapel').append(
                                        `<option value="${item.idMapel}">${item.namaMapel}</option>`
                                    );
                                    $('#idMapel_two').append(
                                        `<option value="${item.idMapel}">${item.namaMapel}</option>`
                                    );
                                });
                            },
                        });
                    }

                    select2('#idKelas', modalPengajar);
                    select2('#idPegawai', modalPengajar);
                    select2Multiple('#idMapel', modalPengajar);
                    select2('#idMapel_two', modalPengajar);

                    getSelectPegawai();
                    getSelectKelas();

                    modalPengajar.on('show.bs.modal', function() {
                        // $('#idKelas').val(null).trigger('change');
                        // $('#idPegawai').val(null).trigger('change');
                        getSelectMapel();
                        $('#idPeriode').on('change', function() {
                            getSelectKelas();
                        });
                    });

                    modalPengajar.on('hidden.bs.modal', function() {
                        resetForm(formPengajar, function() {
                            $('#idMapel').val(null).change();
                        });
                        $('#mapel_two').prop('hidden', true);
                        $('#multi_mapel').prop('hidden', false);
                    });

                    $('#sub').on('click', function(e) {
                        e.preventDefault();

                        console.log($('#idMapel').val());
                    });

                    insertOrUpdateData(formPengajar, function() {
                        modalPengajar.modal('hide');
                        tabelPengajar.DataTable().ajax.reload();

                    });

                    $(document).on('click', '#action-editPengajar', function(e) {
                        e.preventDefault();
                        var id = $(this).val();
                        modalPengajar.modal('show');
                        updateModals(modalPengajar_title, modalPengajar_btn, 'Ubah Pengajar',
                            `<button type="submit" class="btn btn-primary">Simpan</button>`);

                        $('#idMapel_two').val(null).trigger('change');

                        $('#mapel_two').prop('hidden', false);
                        $('#multi_mapel').prop('hidden', true);

                        formPengajar.attr('action', `{{ url('pengajar/update/${id}') }}`);
                        method.val('PUT');

                        $.ajax({
                            type: "GET",
                            url: `{{ url('pengajar/edit/${id}') }}`,
                            success: function(response) {
                                $('#idPeriode').val(response.data.idPeriode).trigger('change');
                                setTimeout(function() {
                                    $('#idKelas').val(response.data.idKelas).trigger('change');
                                }, 1000);
                                $('#idPegawai').val(response.data.idPegawai).trigger('change');
                                $('#idMapel_two').val(response.data.idMapel).trigger('change');
                            },
                        });
                    });


                    $(document).on('click', '#action-hapusPengajar', function(e) {
                        e.preventDefault();
                        var id = $(this).val();
                        var nama = $(this).data('nama-pengajar');
                        var kelas = $(this).data('kelas');

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            html: `Menghapus pengajar <b>${nama}</b> dari <b>${kelas}</b>`,
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
                                    url: "/pengajar/destroy/" + id,
                                    dataType: 'json',
                                    success: function(response) {
                                        Swal.fire({
                                            icon: response.status,
                                            title: response.title,
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        tabelPengajar.DataTable().ajax.reload();
                                    },
                                });
                            }
                        });
                    });
                });
            </script>
        @endpush
    @endsection
