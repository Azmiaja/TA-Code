@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title title-kelas"></h3>
                <div class="block-options">
                    <select name="pilih_periode" id="pilih_periode" class="form-select form-select-sm">
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
                            <div class="btn-group" role="group" aria-label="Horizontal Alternate Info">
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
                            <button class="btn btn-sm btn-alt-success" id="btn_tambahPengajar"><i
                                    class="fa fa-plus me-2"></i>Kelola Pengajar</button>
                        </div>
                    </div>
                    <table id="tabel_Pengajar" class="table table-striped table-bordered table-vcenter w-100">
                        <thead class="table-light align-middle">
                            <tr>
                                <th style="width: 4%;" class="text-center">No</th>
                                {{-- <th style="width: 10%;">Kelas</th> --}}
                                <th style="width: 8%;">NIP</th>
                                <th style="width: 20%;">Nama Guru</th>
                                <th>Mapel Diampu</th>
                                <th style="width: 18%;">Semester</th>
                                <th style="width: 7%;" class="text-center">Aksi</th>
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
                            <form action="" method="POST" enctype="multipart/form-data" id="form-pengajaran">
                                @csrf
                                <input type="hidden" name="_method" id="method" value="POST">
                                <input type="hidden" name="idPengajaran[]" id="idPengajaran" value="POST">
                                <div class="mb-3">
                                    <label class="form-label" for="idPeriode">Periode Semester</label>
                                    <select name="idPeriode" id="idPeriode" class="form-select" required>
                                        <option value="" selected>Pilih Periode</option>
                                        @foreach ($periode as $item)
                                            <option value="{{ $item->idPeriode }}"> Semester {{ $item->semester }}
                                                {{ $item->tahun }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="idKelas">Kelas</label>
                                    <select name="idKelas" id="idKelas" class="form-select" data-placeholder="Pilih Kelas"
                                        required>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="idPengajaran">Nama Guru</label>
                                    <select name="idPegawai" id="idPegawai" class="form-select"
                                        data-placeholder="Pilih Guru" required>
                                    </select>
                                </div>
                                <div class="mb-3" id="multi_mapel">
                                    <label class="form-label" for="idMapel">Mapel</label>
                                    <select name="idMapel[]" id="idMapel" multiple="multiple" class="form-select"
                                        data-placeholder="Pilih Mapel" required>
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

        {{-- MOdal Hapus Mapel --}}
        <div class="modal fade" id="modal-Mapel-Del" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="modalMapeltLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-transparent mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Info Mapel</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm">
                            <div id="con_mapel"></div>
                        </div>
                        <div class="block-content block-content-full bg-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @push('scripts')
            <script>
                $(document).on('click', '#mapel_btn', function(e) {
                    e.preventDefault();
                    var idMapel = $(this).val();
                    $('#modal-Mapel-Del').modal('show');
                    $('#con_mapel').empty();
                    var html;
                    $.ajax({
                        type: "GET",
                        url: "{{ route('data.mapel.pengajar') }}",
                        data: {
                            idMapel: idMapel,
                            namaKelas: $('.btn_kelas.active').val(),
                            idPeriode: $('#pilih_periode option:selected').val(),
                        },
                        dataType: "json",
                        success: function(data) {
                            html = `
                            <div class="mb-3">
                                    <label for="periode" class="form-label">Semester</label>
                                    <input type="text" class="form-control form-control-alt" id="periode" value="${data.periode.semester} ${data.periode.tahun}" readonly />                            
                                </div>
                                <div class="mb-3">
                                    <label for="guru" class="form-label">Guru Pengajar</label>
                                    <input type="text" readonly class="form-control form-control-alt" id="guru" value="${data.guru.namaPegawai}" />                            
                                </div>
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>                            
                                    <input type="text" readonly class="form-control form-control-alt" id="kelas" value="Kelas ${data.kelas.namaKelas}" />
                                </div>
                                <div class="mb-4">
                                    <label for="mapel" class="form-label">Mapel</label>                            
                                    <input type="text" readonly class="form-control form-control-alt" id="mapel" value="${data.mapel.namaMapel}" />
                                </div>
                                <div class="mb-3 text-end">
                                    <button type="button" value="${data.idPengajaran}" data-mapel="${data.mapel.namaMapel}" data-kelas="${data.kelas.namaKelas}" id="btn_hapus_mapel" class="btn btn-danger">Hapus</button>    
                                </div>`;
                        },
                        complete: function() {
                            $('#con_mapel').append(html);
                        }
                    });
                });

                $(document).on('click', '#btn_hapus_mapel', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var mapel = $(this).data('mapel');
                    var kelas = $(this).data('kelas');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus mapel <b>${mapel}</b> dari <b>Kelas ${kelas}</b>.`,
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
                                url: `{{ url('pengajar/destroy/mapel${id}') }}`,
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
                                        $('#modal-Mapel-Del').modal('hide');
                                        $('#tabel_Pengajar').DataTable().ajax.reload();
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

                    let kelas = $('.btn_kelas').val();
                    $('.content .title-kelas').text('Data Pengajar Kelas ' + kelas);

                    $('.btn_kelas').on('click', function() {
                        $('.btn_kelas').removeClass('active');
                        $(this).addClass('active');
                        let kelas = $(this).val();
                        $('.content .title-kelas').text('Data Pengajar Kelas ' + kelas);

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
                                data: null,
                                name: 'nomor',
                                className: 'text-center align-top',
                                render: function(data, type, row, meta) {
                                    return meta.row + 1;
                                }
                            },
                            {
                                data: 'nipPengajar',
                                name: 'nipPengajar',
                                className: 'align-top'
                            },
                            {
                                data: 'namaPengajar',
                                name: 'namaPengajar',
                                className: 'align-top'
                            },
                            {
                                data: 'mapelDiampu',
                                name: 'mapelDiampu',
                            },
                            {
                                data: 'semester',
                                name: 'semester',
                                className: 'align-top'
                            }, {
                                data: null,
                                className: 'text-center align-top',
                                searchable: false,
                                render: function(data, type, row) {
                                    // console.log(data);
                                    return '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-alt-danger"  id="action-hapusPengajar" title="Delete" value="' +
                                        data.idPengajaran + '" data-nama-pengajar="' + data
                                        .namaPengajar + '" data-kelas="' + data.kelasPengajar + '">' +
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
                        $('#idPegawai').val(null).change();
                        $('#idMapel').val(null).change();
                        // getSelectMapel();
                    });



                    function getSelectKelas(id) {
                        $('#idKelas').empty();
                        $.ajax({
                            type: "GET",
                            url: `{{ route('form.kelas') }}`,
                            data: {
                                periode: id
                            },
                            success: function(data) {
                                $('#idKelas').prepend(
                                `<option value="" disabled selected>Pilih Kelas</option>`);
                                // $('#idKelas').html('');
                                $.each(data.kelas, function(i, item) {
                                    $('#idKelas').append(
                                        `<option value="${item.idKelas}" >Kelas ${item.namaKelas}</option>`
                                    );
                                });
                            },
                        });
                    }

                    function getSelectPegawai(id) {
                        $.ajax({
                            type: "GET",
                            url: `{{ url('pengajar/option/guru') }}`,
                            success: function(data) {
                                $('#idPegawai').empty();
                                // $('#idPegawai').prepend(`<option disabled selected>Pilih Guru</option>`);
                                $.each(data, function(i, item) {
                                    var idKelas = item.kelas[0] ? item.kelas[0].idKelas : '';
                                    var selected = idKelas == id ? 'selected' :
                                        '';
                                    $('#idPegawai').append(
                                        `<option ${selected} value="${item.idPegawai}">${item.nip} - ${item.namaPegawai}</option>`
                                    );
                                });
                            },
                        });
                    }

                    function getSelectMapel(id) {
                        $('#idMapel').empty();
                        $('#idMapel_two').empty();
                        $.ajax({
                            type: "GET",
                            url: `{{ url('pengajar/get-mapel/${id}') }}`,
                            success: function(data) {
                                $.each(data, function(i, item) {
                                    $('#idMapel').append(
                                        `<option ${i<10 ? 'selected' : ''} value="${item.idMapel}">${item.singkatan ?? item.namaMapel}</option>`
                                    );
                                    $('#idMapel_two').append(
                                        `<option value="${item.idMapel}">${item.singkatan ?? item.namaMapel}</option>`
                                    );
                                });
                            },
                        });
                    }

                    // select2('#idKelas', modalPengajar);
                    select2('#idPegawai', modalPengajar);
                    select2Multiple('#idMapel', modalPengajar);
                    select2('#idMapel_two', modalPengajar);

                    // getSelectKelas();



                    modalPengajar.on('hidden.bs.modal', function() {
                        resetForm(formPengajar, function() {
                            $('#idKelas').find('option').not(':first').remove();
                            $('#mapel_two').prop('hidden', true);
                            $('#multi_mapel').prop('hidden', false);
                        });
                        $('#idMapel').empty();
                        $('#idPegawai').empty();
                    });

                    modalPengajar.on('show.bs.modal', function() {
                        var val_periode = $('#pilih_periode option:selected').val();
                        $('#idPeriode option').each(function() {
                            if ($(this).val() === val_periode) {
                                $(this).prop('selected', true);
                            }
                        });

                        $('#idPeriode').trigger('change');
                        // $('#idKelas').trigger('change');
                    });

                    $('#idPeriode').change(function() {
                        var id = $(this).find('option:selected').val();
                        getSelectKelas(id);
                        $('#idKelas').find('option:first').prop('selected', true);
                        // $('#idKelas').find('option').not(':first').remove();
                        $('#idPegawai').empty();
                        $('#idMapel').empty();
                    });

                    $('#idKelas').change(function() {
                        var id = $(this).find('option:selected').val();
                        // console.log(id);
                        getSelectMapel(id);
                        getSelectPegawai(id);
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

                        formPengajar.attr('action', `{{ url('pengajar/update/${id}') }}`);
                        method.val('PUT');
                        $('#idMapel_two').val(null).trigger('change');

                        $('#mapel_two').prop('hidden', false);
                        $('#multi_mapel').prop('hidden', true);
                        // $('#idPeriode').prop('disabled', true);
                        getSelectMapel();
                        $.ajax({
                            type: "GET",
                            url: `{{ url('pengajar/edit/${id}') }}`,
                            success: function(response) {
                                // console.log(response.data);
                                $('#idPeriode').val(response.data.idPeriode).trigger('change');
                                setTimeout(function() {
                                    $('#idKelas').val(response.data.idKelas).trigger('change');
                                }, 500);
                                $('#idPegawai').val(response.data.idPegawai).trigger('change');
                                $('#idMapel_two').val(response.data.idMapel).trigger('change');

                                // $.each(response.data, function(i, item) {
                                //     $('#idMapel').val(item.mapelDiampu).change();
                                // });

                            },
                        });
                    });


                    $(document).on('click', '#action-hapusPengajar', function(e) {
                        e.preventDefault();
                        var id = $(this).val();
                        var idP = $('#pilih_periode option:selected').val();
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
                            confirmButtonText: 'Ya, Hapus!',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "DELETE",
                                    url: `{{ url('pengajar/destroy/${id}/${idP}') }}`,
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
                                            tabelPengajar.DataTable().ajax.reload();

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
