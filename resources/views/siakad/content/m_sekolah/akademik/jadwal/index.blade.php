@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        @canany(['super.admin', 'admin'])
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Jadwal Pelajaran</h3>
                    <div class="block-options">
                        <select name="periode" id="periode" class="form-select form-select-sm">
                            @foreach ($periode as $item)
                                <option value="{{ $item->idPeriode }}">
                                    Semester
                                    {{ $item->semester }} {{ $item->tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="block-content p-0">
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
                                <button class="btn btn-sm btn-alt-success" id="tambah_jadwal"><i
                                        class="fa fa-plus mx-2"></i>Tambah
                                    Jadwal</button>
                            </div>
                        </div>
                        <table id="tabel-JPkelas" class="table table-bordered table-vcenter w-100">
                            <thead class="bg-body-light align-middle">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 10%;">Kelas</th>
                                    <th style="width: 10%;">Hari</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Nama Pengajar</th>
                                    <th>Lama Waktu</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- conten --}}
                            </tbody>
                        </table>

                        <table>

                        </table>
                    </div>
                </div>
            </div>
        @endcanany
    </div>

    {{-- MODAL INSERT --}}
    <div class="modal fade" id="modal_Jadwal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalMapeltLabel" aria-hidden="true">
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
                        <form action="" id="form_jadwal" method="post">
                            @csrf
                            <input type="hidden" name="_method" id="method" value="POST">
                            <input type="hidden" name="idJadwal" id="idJadwal">
                            <div class="mb-3">
                                <label class="form-label" for="idPeriode">Semester</label>
                                <select name="idPeriode" id="idPeriode" class="form-select" data-placeholder="Pilih Periode"
                                    required>
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
                                <label class="form-label" for="idKelas">Kelas</label>
                                <select name="idKelas" id="idKelas" class="form-select" data-placeholder="Pilih Kelas"
                                    required>
                                    <option value="" disabled selected>Pilih Kelas</option>
                                </select>
                            </div>
                            <div class="mb-3" id="map_1">
                                <label class="form-label" for="idPengajaran">Mapel</label>
                                <select name="idPengajaran" id="idPengajaran" class="form-select"
                                    data-placeholder="Pilih Mapel">
                                </select>
                            </div>
                            <div class="row g-3 mb-3">
                                {{-- isian form --}}
                                <div class="col-md-4">
                                    <label class="form-label" for="hari">Hari</label>
                                    <select name="hari" id="hari" class="form-select" required>
                                        <option value="" disabled selected>Pilih Hari</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="jamMulai">Jam Mulai</label>
                                    <input type="text" class="form-control" id="jamMulai" name="jamMulai"
                                        data-timepicker="true" placeholder="Jam Mulai" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="jamSelesai">Jam Selesai</label>
                                    <input type="text" class="form-control" id="jamSelesai" name="jamSelesai"
                                        data-timepicker="true" placeholder="Jam Selesai" required>
                                </div>
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
        @cannot('guru')
            <script>
                $(document).ready(function() {
                    const tabelJadwal = $('#tabel-JPkelas');
                    const btnInsert = $('#tambah_jadwal');
                    const modalJadwal = $('#modal_Jadwal');
                    const modalJadwal_title = $('#title-modal');
                    const modalJadwal_btn = $('#cn-btn');
                    const formJadwal = $('#form_jadwal');
                    const method = $('#method');

                    showModalInsert(btnInsert, modalJadwal, formJadwal, `{{ route('penjadwalan.store') }}`, method,
                        modalJadwal_title, modalJadwal_btn,
                        'Tambah Jadwal', `<button type="submit" class="btn btn-primary">Simpan</button>`);

                    modalJadwal.on('hidden.bs.modal', function() {
                        resetForm(formJadwal, function() {
                            $('#idPengajaran').val(null).change();
                        });
                    });

                    insertOrUpdateData(formJadwal, function() {
                        modalJadwal.modal('hide');
                        tabelJadwal.DataTable().ajax.reload();
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
                                $('#idKelas').append(`<option value="" disabled selected>Pilih Kelas</option>`);
                                $.each(data.kelas, function(i, item) {
                                    $('#idKelas').append(
                                        `<option value="${item.idKelas}">Kelas ${item.namaKelas}</option>`
                                    );
                                });
                            },
                        });
                    }

                    function getPengjar() {
                        $.ajax({
                            type: 'GET',
                            url: "{{ url('penjadwalan/get-form') }}", // You need to define a route for this
                            data: {
                                kelas_id: $('#idKelas').val()
                            },
                            success: function(data) {
                                $('#idPengajaran').empty();
                                $.each(data.pengajaran, function(key, value) {
                                    $('#idPengajaran').append(
                                        `<option value="${value.idPengajaran}">${value.mapel.namaMapel}</option>`
                                    );
                                });
                            }
                        });
                    }

                    function timePicker(input, modal) {
                        new AirDatepicker(input, {
                            container: modal,
                            autoClose: true,
                            timepicker: true,
                            onlyTimepicker: true,
                            timeFormat: 'HH:mm',
                            minuteStep: 15,
                        });
                    }
                    timePicker('#jamMulai', '#modal_Jadwal');
                    timePicker('#jamSelesai', '#modal_Jadwal');

                    select2('#idPengajaran', modalJadwal);

                    $('#idPeriode').on('change', function() {
                        getSelectKelas();
                    });
                    $('#idKelas').change(function() {
                        getPengjar();
                    });

                    $('.btn_kelas').on('click', function() {
                        $('.btn_kelas').removeClass('active');
                        $(this).addClass('active');

                        // Muat ulang data tabel
                        tabelJadwal.DataTable().ajax.reload();
                    });

                    $('#periode').on('change', function() {
                        tabelJadwal.DataTable().ajax.reload();

                    });

                    tabelJadwal.DataTable({
                        processing: true,
                        ajax: {
                            url: "{{ url('penjadwalan/get-data') }}",
                            data: function(d) {
                                d.periode = $('#periode').val();
                                d.kelas_id = $(".btn_kelas.active").val();
                                // console.log(d.kelas_id);
                            }
                        },
                        columns: [{
                                data: null,
                                name: 'nomor',
                                className: 'text-center',
                                render: function(data, type, row, meta) {
                                    return meta.row + 1;
                                }
                            },
                            {
                                data: 'kelasMapel',
                                name: 'kelasMapel',
                            },
                            {
                                data: 'hari',
                                name: 'hari',
                                className: 'text-center',
                                render: function(data) {
                                    var hari = data;
                                    if (hari === 'Senin') {
                                        return '<span class="fs-6 badge bg-primary">Senin</span>';
                                    } else if (hari === 'Selasa') {
                                        return '<span class="fs-6 badge bg-secondary">Selasa</span>';
                                    } else if (hari === 'Rabu') {
                                        return '<span class="fs-6 badge bg-success">Rabu</span>';
                                    } else if (hari === 'Kamis') {
                                        return '<span class="fs-6 badge bg-info">Kamis</span>';
                                    } else if (hari === 'Jumat') {
                                        return '<span class="fs-6 badge bg-warning">Jumat</span>';
                                    } else if (hari === 'Sabtu') {
                                        return '<span class="fs-6 badge bg-danger">Sabtu</span>';
                                    }
                                },
                            },
                            {
                                data: 'mapel',
                                name: 'mapel'
                            },
                            {
                                data: 'guru',
                                name: 'guru',
                            },
                            {
                                data: "waktu",
                                name: "waktu",
                                className: 'text-center'
                            },
                            {
                                data: 'jamMulai',
                                name: 'jamMulai',
                                className: 'text-center',
                            },
                            {
                                data: 'jamSelesai',
                                name: 'jamSelesai',
                                className: 'text-center'
                            },
                            {
                                data: null,
                                className: 'text-center',
                                searchable: false,
                                render: function(data, type, row) {
                                    return '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editJadwal" value="' +
                                        data.idJadwal + '">' +
                                        '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                        '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusJadwal" title="Delete" value="' +
                                        data.idJadwal + '" data-nama-jadwal=" Hari ' + data.hari +
                                        ' Mapel ' + data
                                        .mapel +
                                        '">' +
                                        '<i class="fa fa-fw fa-times"></i></button>' +
                                        '</div>';
                                }
                            }
                        ],
                        order: [
                            [0, 'asc']
                        ],
                        dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'><'col-12 col-sm-12 col-md-6'f>>" +
                            "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                            "<'row mb-2'<'col-12 col-sm-12 col-md-5'><'col-sm-12 col-md-7'>>",
                        lengthMenu: [10, 25],
                    });


                    $(document).on('click', '#action-editJadwal', function(e) {
                        e.preventDefault();
                        var id = $(this).val();
                        modalJadwal.modal('show');
                        updateModals(modalJadwal_title, modalJadwal_btn, 'Ubah Jadwal',
                            `<button type="submit" class="btn btn-primary">Sumpan</button>`);
                        formJadwal.attr('action', `{{ url('penjadwalan/update/${id}') }}`);
                        method.val('PUT');

                        $.ajax({
                            type: "GET",
                            url: `{{ url('penjadwalan/edit/${id}') }}`,
                            success: function(response) {
                                $('#idPeriode').val(response.jadwal.idPeriode).change();
                                setTimeout(function() {
                                    $('#idKelas').val(response.jadwal.idKelas).change();
                                }, 500);
                                $('#idPengajaran').val(response.jadwal.idPengajaran).change();
                                $('#hari').val(response.jadwal.hari);
                                $('#jamMulai').val(response.jadwal.jamMulai);
                                $('#jamSelesai').val(response.jadwal.jamSelesai);
                                // loadDropdownOptionsJadwal();
                            },
                        });

                    });
                    $(document).on('click', '#action-hapusJadwal', function(e) {
                        e.preventDefault();
                        var id = $(this).val();
                        var nama = $(this).data('nama-jadwal');

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            html: `Menghapus jadwal <b>${nama}</b>`,
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
                                    url: "{{ url('penjadwalan/destroy') }}/" + id,
                                    dataType: 'json',
                                    success: function(response) {
                                        Swal.fire({
                                            icon: response.status,
                                            title: response.title,
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        tabelJadwal.DataTable().ajax.reload();
                                    },
                                });
                            }
                        });
                    });




                });
            </script>
        @endcannot
        @can('guru')
            <script>
                $(document).ready(function() {
                    $.ajax({
                        url: '{!! route('get-jadwalP.guru') !!}',
                        type: 'GET',
                        success: function(data) {
                            console.log(data);
                        }
                    });

                    $('#periode').change(function() {
                        $('#tabel-JPSiswa').DataTable().ajax.reload();
                    });

                    $('#tabel-JPSiswa').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{!! route('get-jadwalP.guru') !!}',
                            data: function(d) {
                                d.id_periode = $('#periode').val();
                                d.id_nama = '{{ ucwords(Auth::user()->pegawai->idPegawai) }}';
                                // console.log(d.id_nama);
                            }
                        },
                        columns: [{
                                data: 'waktu',
                                name: 'waktu'
                            },
                            {
                                data: 'senin',
                                name: 'senin'
                            },
                            {
                                data: 'selasa',
                                name: 'selasa'
                            },
                            {
                                data: 'rabu',
                                name: 'rabu'
                            },
                            {
                                data: 'kamis',
                                name: 'kamis'
                            },
                            {
                                data: 'jumat',
                                name: 'jumat'
                            },
                            {
                                data: 'sabtu',
                                name: 'sabtu'
                            },
                        ],
                        dom: 'Bfrtip',
                        buttons: [{
                            extend: 'print',
                            title: '<h2>Jadwal Pelajaran</h2>',
                            className: 'btn-alt-primary',
                            filename: 'Jadwal Pelajaran',
                            exportOptions: {
                                columns: ':visible',
                            },
                            messageTop: null,
                            messageBottom: null,
                            customize: function(win) {
                                $(win.document.body).css('text-align', 'center');
                            },
                        }],
                        paging: false,
                        ordering: true,
                        searching: false,
                        info: false,
                        responsive: true
                    });

                    $('.buttons-print span').append('<i class="fa-solid ms-1 fa-print"></i>');
                });
            </script>
        @endcan
    @endpush
@endsection
