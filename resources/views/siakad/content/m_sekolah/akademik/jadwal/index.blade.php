@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <style>
        @media print {
            table {
                page-break-inside: avoid;
                width: 100%;
                color: #000;
                font-size: 12pt;

            }

            table thead,
            table tbody,
            table tfoot {
                color: #000;
            }

            body {
                background-color: #fff;
                font-family: 'Times New Roman', Times, serif;
                font-size: 12pt;
                width: 100%;
                color: #000;
            }
        }
    </style>
    <div class="content">
        @canany(['super.admin', 'admin'])
            <div class="row g-3">
                <div class="col-lg-9 col-12">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Jadwal Pelajaran</h3>
                            <div class="block-options">
                                <select name="periode" id="periode" class="form-select form-select-sm">
                                    @foreach ($periode as $item)
                                        <option value="{{ $item->idPeriode }}" data-tahun="{{ $item->tahun }}"
                                            {{ $item->status === 'Aktif' ? 'selected' : '' }}>
                                            Semester
                                            {{ $item->semester }} {{ $item->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="block-content p-0">
                            <div class="table-responsive m-4 m-md-0 p-md-4 p-0">
                                <div class="row g-3 pt-1">
                                    <div class="col-md-7 col-12 text-md-start text-center">
                                        <div class="btn-group" role="group" aria-label="Horizontal Alternate Info">
                                            <button type="button" class="btn btn-sm btn-outline-danger btn_kelas active"
                                                value="1">Kelas
                                                1</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn_kelas"
                                                value="2">Kelas
                                                2</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn_kelas"
                                                value="3">Kelas
                                                3</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn_kelas"
                                                value="4">Kelas
                                                4</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn_kelas"
                                                value="5">Kelas
                                                5</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger btn_kelas"
                                                value="6">Kelas
                                                6</button>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-12 text-md-end text-center">
                                        <button class="btn btn-sm btn-alt-success" id="tambah_jadwal" title="Kelola Jadwal"><i
                                                class="fa fa-plus mx-2"></i>Kelola
                                            Jadwal</button>
                                    </div>
                                    <div class="col-12 text-md-end text-center">
                                        <button class="btn btn-sm btn-primary" id="btn_print_jadwal">
                                            <i class="fa fa-print me-2"></i>Cetak</button>
                                    </div>
                                </div>
                                <table id="tabel-JPSiswa" class="table table-bordered border-dark w-100 align-middle">
                                    <thead class="table-light border-dark align-middle">
                                        <tr>
                                            <th width="14%">Waktu</th>
                                            <th width="14%">Senin</th>
                                            <th width="14%">Selasa</th>
                                            <th width="14%">Rabu</th>
                                            <th width="14%">Kamis</th>
                                            <th width="14%">Jumat</th>
                                            <th width="14%">Sabtu</th>
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
                <div class="col-lg-3 col-12">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Jam Pelajaran</h3>
                            <div class="block-options">
                                <button class="btn btn-sm btn-alt-success" title="Kelola Jam Pelajaran" id="atur_jam">
                                    <i class="fa fa-plus mx-2"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <div id="container_jam">
                                <div class="row">
                                    {{-- Konten --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <select name="idPeriode" id="idPeriode" class="form-select"
                                            data-placeholder="Pilih Periode" required>
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
                                        <select name="idKelas" id="idKelas" class="form-select"
                                            data-placeholder="Pilih Kelas" required>
                                            <option value="" disabled selected>Pilih Kelas</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="map_1">
                                        <label class="form-label" for="idPengajaran">Mapel</label>
                                        <select name="idPengajaran" id="idPengajaran" class="form-select"
                                            data-placeholder="Pilih Mapel">
                                            <option value="" disabled selected>Pilih Mapel</option>
                                        </select>
                                    </div>
                                    <div class="row g-3 mb-4">
                                        {{-- isian form --}}
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <label class="form-label" for="jamMulai">Jam Ke</label>
                                            <select class="form-select" id="idjamKe" name="idjamKe" data-timepicker="true"
                                                required>
                                                <option value="" selected>Pilih Jam</option>
                                            </select>
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

            {{-- Modal Atur Jam --}}
            <div class="modal fade" id="modal_jam_Jadwal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                aria-labelledby="modalMapeltLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title" id="title-modal_jam"></h3>
                                <div class="block-options">
                                    <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                {{-- FORM --}}
                                <form action="" id="form_jam_jadwal" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" id="method_jam" value="POST">
                                    <div class="row g-2 mb-4">
                                        <div class="col-md-4">
                                            <label for="jamKe" class="form-label">Jam Ke</label>
                                            <input type="number" class="form-control" id="jamKe" name="jamKe"
                                                placeholder="Jam Ke" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="jamMulai" class="form-label">Jam Mulai</label>
                                            <input type="time" class="form-control" id="jamMulai" name="jamMulai"
                                                required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="jamSelesai" class="form-label">Jam Selesai</label>
                                            <input type="time" class="form-control" id="jamSelesai" name="jamSelesai"
                                                required>
                                        </div>
                                    </div>
                                    <div class="mb-4 text-end" id="cn-btn_jam">
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
                                <h3 class="block-title">Info Jadwal</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content fs-sm">
                                <div class="row" id="con_mapel"></div>
                            </div>
                            <div class="block-content block-content-full bg-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcanany
    </div>



    @push('scripts')
        <script>
            $(document).on('click', '#hapus_jadwal', function(e) {
                e.preventDefault();
                var id = $(this).data('id-jadwal');
                console.log(id);
                $('#modal-Mapel-Del').modal('show');
                $('#con_mapel').empty();
                var html;
                $.ajax({
                    type: "GET",
                    url: "{{ route('data.mapel.jadwal') }}",
                    data: {
                        idJadwal: id,
                        namaKelas: $('.btn_kelas.active').val(),
                        idPeriode: $('#periode option:selected').val(),
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        html = `
                            <div class="mb-3">
                                    <label for="periode" class="form-label">Semester</label>
                                    <input type="text" class="form-control form-control-alt" id="periode" value="${data.periode.semester} ${data.periode.tahun}" readonly />                            
                                </div>
                                <div class="mb-3">
                                    <label for="guru" class="form-label">Guru Pengajar</label>
                                    <input type="text" readonly class="form-control form-control-alt" id="guru" value="${data.pengajaran.guru.namaPegawai}" />                            
                                </div>
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>                            
                                    <input type="text" readonly class="form-control form-control-alt" id="kelas" value="Kelas ${data.kelas.namaKelas}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="hari" class="form-label">Hari</label>                            
                                    <input type="text" readonly class="form-control form-control-alt" id="hari" value="${data.hari}" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="waktu" class="form-label">Waktu</label>                            
                                    <input type="text" readonly class="form-control form-control-alt" id="waktu" value="${data.jamke.jamMulai} - ${data.jamke.jamSelesai}" />
                                </div>
                                <div class="mb-4">
                                    <label for="mapel" class="form-label">Mapel</label>                            
                                    <input type="text" readonly class="form-control form-control-alt" id="mapel" value="${data.pengajaran.mapel.namaMapel}" />
                                </div>
                                <div class="mb-3 text-end">
                                    <button type="button" value="${data.idJadwal}" data-mapel="${data.pengajaran.mapel.namaMapel}" data-kelas="${data.kelas.namaKelas}" data-jam="${data.jamke.jamKe}" id="btn_hapus_mapel" class="btn btn-danger">Hapus</button>    
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
                var jam = $(this).data('jam');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    html: `Menghapus jadwal jam ke <b>-${jam}</b> mapel <b>${mapel}</b> dari <b>Kelas ${kelas}</b>.`,
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
                            url: `{{ url('jadwal/mapel/destroy/${id}') }}`,
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
                                    $('#tabel-JPSiswa').DataTable().ajax.reload();
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
                const tabelJadwal = $('#tabel-JPkelas1');
                const btnInsert = $('#tambah_jadwal');
                const modalJadwal = $('#modal_Jadwal');
                const modalJadwal_title = $('#title-modal');
                const modalJadwal_btn = $('#cn-btn');
                const formJadwal = $('#form_jadwal');
                const method = $('#method');

                const tabelViewJadwal = $('#tabel-JPSiswa');
                tabelViewJadwal.DataTable({
                    processing: true,
                    ajax: {
                        url: '{!! route('get-jadwal.siswa') !!}',
                        data: function(d) {
                            d.idPeriode = $('#periode').val();
                            d.kelas = $(".btn_kelas.active").val();
                            //     // console.log(d.kelas_id);
                        }
                    },
                    columns: [{
                            data: 'waktu',
                            name: 'waktu',
                            className: 'text-center fs-sm px-0 text-nowrap'
                        },
                        {
                            data: 'Senin',
                            name: 'Senin',
                            className: 'text-center fs-sm px-0'
                        },
                        {
                            data: 'Selasa',
                            name: 'Selasa',
                            className: 'text-center fs-sm px-0'
                        },
                        {
                            data: 'Rabu',
                            name: 'Rabu',
                            className: 'text-center fs-sm px-0'
                        },
                        {
                            data: 'Kamis',
                            name: 'Kamis',
                            className: 'text-center fs-sm px-0'
                        },
                        {
                            data: 'Jumat',
                            name: 'Jumat',
                            className: 'text-center fs-sm px-0'
                        },
                        {
                            data: 'Sabtu',
                            name: 'Sabtu',
                            className: 'text-center fs-sm px-0'
                        },
                    ],
                    dom: "<'row my-0 '<'col-12 col-sm-12 col-md-7'><'col-12 col-sm-12 col-md-5 text-md-end'B>>" +
                        "<'row my-0 '<'col-12 col-sm-12'tr>>" +
                        "<'row mb-0'<'col-12 col-sm-12 col-md-5'><'col-sm-12 col-md-7'>>",
                    buttons: [{
                        extend: 'print',
                        title: function() {
                            let periode = $('#periode option:selected').data('tahun');
                            let kelas = $(".btn_kelas.active").val();
                            return '<h3 style="margin-bottom: 3rem; font-family: Times New Roman, Times, serif;">JADWAL PELAJARAN KELAS ' +
                                kelas + '<br>' + 'SD NEGERI LEMAHBANG' +
                                '<br>' +
                                'TAHUN PELAJARAN ' + periode + '</h3>';
                        },
                        className: 'd-none',
                        exportOptions: {
                            columns: ':visible'
                        },
                        messageTop: null,
                        messageBottom: null,
                        customize: function(win) {
                            $(win.document.body).css('text-align', 'center');
                            $(win.document.body).find('table').css({
                                'text-transform': 'uppercase',
                                'font-size': '12pt',
                                'border-color': '#000'
                            });
                            $(win.document.body).find('th').css('font-size', '1.25rem').width(
                                '14%');
                        }

                    }],
                    paging: false,
                    ordering: true,
                    searching: false,
                    info: false,
                });

                $('#btn_print_jadwal').on('click', function() {
                    $('.buttons-print').click();
                })
                $('.buttons-print').prop('hidden', true);

                fatchDataJam();

                function fatchDataJam() {
                    $.ajax({
                        type: "GET",
                        url: `{{ url('penjadwalan/get-jam') }}`,
                        success: function(data) {
                            $('#container_jam div').empty();
                            let data_jam = '';
                            $.each(data, function(i, item) {
                                data_jam += `
                                    <div class="col-lg-12 col-md-4">
                                        <a href="javascript:void(0)" id="action_jamKe" class="block block-rounded block-link-pop shadow-sm mb-2" 
                                        data-id="${item.idjamKe}" data-name="${item.jamKe}" id="jabatanView">
                                            <div class="input-group">
                                                <span class="input-group-text">${item.jamKe}</span>
                                                <spam class="form-control text-center">${item.jamMulai} - ${item.jamSelesai}</spam>
                                            </div>
                                        </a>
                                    </div>
                                    `;
                            });
                            $('#container_jam div').append(data_jam);
                        },
                    });
                }

                showModalInsert(btnInsert, modalJadwal, formJadwal, `{{ route('penjadwalan.store') }}`, method,
                    modalJadwal_title, modalJadwal_btn,
                    'Kelola Jadwal', `<button type="submit" class="btn btn-primary">Simpan</button>`);

                // Kelola JAm
                showModalInsert($('#atur_jam'), $('#modal_jam_Jadwal'), $('#form_jam_jadwal'),
                    `{{ route('penjadawalan.store.jam') }}`, $('#method_jam'),
                    $('#title-modal_jam'), $('#cn-btn_jam'),
                    'Kelola Jam Pelajaran', `<button type="submit" class="btn btn-primary">Simpan</button>`);

                insertOrUpdateData($('#form_jam_jadwal'), function() {
                    $('#modal_jam_Jadwal').modal('hide');
                    fatchDataJam();
                });

                $('#container_jam').on('click', '#action_jamKe', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    var jam = $(this).data('nama');


                    $('#modal_jam_Jadwal').modal('show');
                    $('#form_jam_jadwal').attr('action', `{{ url('penjadwalan/update/jam/${id}') }}`);
                    $('#method_jam').val('PUT');
                    updateModals($('#title-modal_jam'), $('#cn-btn_jam'),
                        'Kelola Jam Pelajaran',
                        `<button type="button" id="delete_jam" class="btn btn-danger me-2">Hapus</button><button type="submit" class="btn btn-primary">Simpan</button>`
                    );

                    $.ajax({
                        type: "GET",
                        url: `{{ url('penjadwalan/jam/${id}') }}`,
                        success: function(item) {
                            $('#jamKe').val(item.jamKe);
                            $('#jamMulai').val(item.jamMulai);
                            $('#jamSelesai').val(item.jamSelesai);
                            $('#delete_jam').val(item.idjamKe);
                        },
                    });
                });

                $('#modal_jam_Jadwal').on('click', '#delete_jam', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var jam = $('#jamKe').val();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus jam pelajaran ke <b>${jam}</b>`,
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
                                url: "{{ url('penjadwalan/destroy/jam') }}/" + id,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    $('#modal_jam_Jadwal').modal('hide');
                                    fatchDataJam();
                                },
                            });
                        }
                    });
                });

                $('#modal_jam_Jadwal').on('hidden.bs.modal', function() {
                    resetForm($('#form_jam_jadwal'), function() {});
                });

                function getJamKe() {
                    $.ajax({
                        type: "GET",
                        url: `{{ url('penjadwalan/get-jam') }}`,
                        success: function(data) {
                            $('#idjamKe').find('option').not(':first').remove();
                            $.each(data, function(i, item) {
                                $('#idjamKe').append(`
                                        <option value="${item.idjamKe}">Jam ke -${item.jamKe}</option>
                                    `);
                            });
                        },
                    });
                }

                modalJadwal.on('show.bs.modal', function() {
                    getJamKe();
                    var val_periode = $('#periode option:selected').val();
                    $('#idPeriode option').each(function() {
                        if ($(this).val() === val_periode) {
                            $(this).prop('selected', true);
                        }
                    });

                    $('#idPeriode').trigger('change');
                });
                $('#idPeriode').on('change', function() {
                    getSelectKelas();
                    $('#idKelas').find('option:first').prop('selected', true);
                    $('#idKelas').find('option').not(':first').remove();
                });
                $('#idKelas').change(function() {
                    getPengjar();
                });

                modalJadwal.on('hidden.bs.modal', function() {
                    resetForm(formJadwal, function() {
                        $('#idPengajaran').val(null).change();
                        $('#idKelas').find('option').not(':first').remove();
                    });
                });

                insertOrUpdateData(formJadwal, function() {
                    modalJadwal.modal('hide');
                    tabelViewJadwal.DataTable().ajax.reload();
                });


                function getSelectKelas() {
                    $.ajax({
                        type: "GET",
                        url: `{{ route('form.kelas') }}`,
                        data: {
                            periode: $('#idPeriode').val()
                        },
                        success: function(data) {
                            $('#idKelas').find('option').not(':first').remove();
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
                            $('#idPengajaran').find('option').not(':first').remove();
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
                // timePicker('#jamMulai', '#modal_Jadwal');
                // timePicker('#jamSelesai', '#modal_Jadwal');

                select2('#idPengajaran', modalJadwal);

                $('.btn_kelas').on('click', function() {
                    $('.btn_kelas').removeClass('active');
                    $(this).addClass('active');
                    // Muat ulang data tabel
                    tabelViewJadwal.DataTable().ajax.reload();
                });

                $('#periode').on('change', function() {
                    tabelViewJadwal.DataTable().ajax.reload();
                });
            });
        </script>
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
