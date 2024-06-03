@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        @php
            $kelas = ['Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam'];
        @endphp
        <div class="row g-3 mb-4 justify-content-end">
            <div class="col-md-3">
                <label for="kelas_name" class="form-label text-uppercase fw-bold fs-sm">Kelas</label>
                <select class="form-select form-select-lg fw-medium" name="" id="kelas_name">
                    @foreach ($klsPengajaran as $item)
                        <option value="{{ $item->kelas->namaKelas }}" data-pegawai="{{ $item->idPegawai }}"
                            data-periode="{{ $item->kelas->periode->idPeriode }}" data-kls_id="{{ $item->kelas->idKelas }}">
                            Kelas {{ $item->kelas->namaKelas }}
                            ({{ $kelas[$item->kelas->namaKelas - 1] ?? '' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="mapel_id" class="form-label text-uppercase fw-bold fs-sm">Mata Pelajaran</label>
                <select class="form-select form-select-lg fw-medium" name="" id="mapel_id">
                </select>
            </div>
            <div class="col-md-3">
                <label for="periode_id" class="form-label text-uppercase fw-bold fs-sm">Semester</label>
                <select class="form-select form-select-lg fw-medium" name="" id="periode_id">
                </select>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-7">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Tujuan Pembelajaran</h3>
                        <div class="block-options">
                            <button id="btn_klTP" class="btn btn-sm btn-alt-success">Kelola TP</button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="table-responsive pb-2">
                            <table id="tp_nilai"
                                class="table w-100 align-middle table-stripped table-bordered caption-top">
                                <thead class="table-light align-middle">
                                    <tr>
                                        {{-- <th width="5%" class="text-center ">NO</th> --}}
                                        <th width="10%" class="text-center ">Kode TP</th>
                                        <th class="text-center ">Tujuan Pembelajaran (TP)</th>
                                        <th width="5%" class="text-center ">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Lingkup Materi</h3>
                        <div class="block-options">
                            <button id="btn_klLM" class="btn btn-sm btn-alt-success">Kelola LM</button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="table-responsive pb-2">
                            <table id="lm_nilai"
                                class="table w-100 align-middle table-stripped table-bordered caption-top">
                                <thead class="table-light align-middle">
                                    <tr>
                                        {{-- <th width="5%" class="text-center ">NO</th> --}}
                                        <th width="10%" class="text-center ">Kode LM</th>
                                        <th class="text-center ">Lingkup Materi (LM)</th>
                                        <th width="5%" class="text-center ">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL LM --}}
    <div class="modal fade" id="modal_LM" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalMapeltLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Tambah Lingkup Materi</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <form action="" id="form_LM" method="post">
                            @csrf
                            {{-- @method('post') --}}
                            <input type="hidden" name="_method" id="method_lm" value="POST">
                            <div class="mb-3">
                                <label for="mapel" class="form-label">Mapel</label>
                                <input type="text" class="form-control form-control-alt" readonly name=""
                                    id="mapel_name">
                                <input type="hidden" class="form-control" readonly name="idMapel" id="mapel">
                            </div>
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control form-control-alt" readonly name="kelas"
                                    id="kelas" />
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <input type="text" class="form-control form-control-alt" readonly id="semester">
                                <input type="hidden" class="form-control form-control-alt" readonly name="periode"
                                    id="periode_LM">
                            </div>
                            <div class="mb-3">
                                <label for="kodeLM" class="form-label">Kode LM</label>
                                <input type="text" class="form-control" maxlength="4" name="kode"
                                    id="kodeLM" aria-describedby="helpId" placeholder="LM" />
                                <small id="kode-lm" class="form-text text-muted"><span class="fw-bold">Catatan:
                                    </span>Contoh kode LM1, LM2, LM3, dst.</small>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsiLM" class="form-label">Lingkup Materi</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsiLM" rows="2" style="resize: none"></textarea>
                                <small id="catatan_lm" class="form-text text-muted"><span
                                        class="fw-bold    ">Catatan:</span> Tuliskan lingkup materi
                                    pelajaran yang Anda ajarkan. Contoh: Penjumlahan Bersusun</small>
                            </div>
                            <div class="mb-4 text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL TP --}}
    <div class="modal fade" id="modal_TP" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalMapeltLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Tambah Tujuan Pembelajaran</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        {{-- FORM --}}
                        <form action="" id="form_TP" method="post">
                            @csrf
                            {{-- @method('post') --}}
                            <input type="hidden" name="_method" id="method" value="POST">
                            <input type="hidden" name="idTP" id="idTP">
                            <div class="mb-3">
                                <label for="mapel_tp" class="form-label">Mapel</label>
                                <input type="text" class="form-control form-control-alt" readonly name=""
                                    id="mapel_name_tp">
                                <input type="hidden" class="form-control" readonly name="idMapel" id="mapel_tp">
                            </div>
                            <div class="mb-3">
                                <label for="kelas_tp" class="form-label">Kelas</label>
                                <input type="text" class="form-control form-control-alt" readonly name="kelas"
                                    id="kelas_tp" />
                            </div>
                            <div class="mb-3">
                                <label for="semester_tp" class="form-label">Semester</label>
                                <input type="text" class="form-control form-control-alt" readonly id="semester_tp">
                                <input type="hidden" class="form-control form-control-alt" readonly name="periode"
                                    id="periode_TP">
                            </div>
                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode TP</label>
                                <input type="text" class="form-control" maxlength="4" name="kodeTP"
                                    id="kode" aria-describedby="helpId" placeholder="TP" />
                                <small id="kode-tp" class="form-text text-muted"><span class="fw-bold">Catatan:
                                    </span>Contoh: TP1, TP2, TP3, ...</small>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi_TP" class="form-label">Tujuan Pembelajaran</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi_TP" rows="2" style="resize: none"></textarea>
                                <small id="catatan_lm" class="form-text text-muted"><span class="fw-bold">Catatan:</span>
                                    Tuliskan tujuan pembelajaran
                                    pelajaran yang Anda ajarkan. Untuk panduan penulisan klik <a href="javascript:void(0)"
                                        class="fw-bold link-primary" id="info_tp">di sini.</a></small>
                            </div>
                            <div class="mb-4 text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <div class="block-content block-content-full bg-body">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function getPeriode() {
            $('#periode_id').empty();
            var periode = {!! json_encode($periode) !!};
            var selected = periode.status === 'Aktif' ? (periode.semester === 'Genap' || 'Ganjil' ? 'selected' : '') : '';
            $('#periode_id').append(`
                <option value="ganjil" ${periode.semester === 'Ganjil' ? 'selected' : ''}>Ganjil</option>
                <option value="genap" ${periode.semester === 'Genap' ? 'selected' : ''}>Genap</option>
            `);
        }

        function getMapel(kelas) {
            $('#mapel_id').empty();
            let option = '';
            $.ajax({
                url: `{{ route('get.mapel.gurupengajar') }}`,
                type: 'GET',
                data: {
                    kelas: kelas,
                },
                success: function(data) {
                    // console.log(data);
                    $.each(data.mapel, function(i, item) {
                        let selectedAttr = (i === 0) ? 'selected' : '';
                        option +=
                            `<option value="${item.mapel.idMapel}" ${selectedAttr}>${item.mapel.singkatan ?? item.mapel.namaMapel}</option>`;
                    });
                },
                complete: function() {
                    $('#mapel_id').html(option);
                    $('#mapel_id').trigger('change');
                    getPeriode();
                    $('#periode_id').trigger('change');
                }
            });
        }


        $(document).ready(function() {
            // getPeriode();
            $('#tp_nilai').DataTable({
                processing: true,
                ajax: {
                    url: `{{ route('get.tp-data') }}`,
                    type: 'GET',
                    data: function(d) {
                        d.idMapel = $('#mapel_id option:selected').val();
                        d.kelas = $('#kelas_name option:selected').val();
                        d.periode = $('#periode_id option:selected').val();
                    }
                },
                columns: [{
                    data: 'kode',
                    name: 'kode',
                    className: 'text-center'
                }, {
                    data: 'tp',
                    name: 'tp',
                }, {
                    data: null,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<div class="btn-group">
                                    <button class="btn btn-alt-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        #
                                    </button>
                                    <ul class="dropdown-menu fs-sm">
                                        <li><span class="dropdown-header fw-semibold">Aksi ${data.kode}</span></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><button class="dropdown-item" value="${data.idTP}" id="ubah_TP" type="button">Ubah</button></li>
                                        <li><button class="dropdown-item" type="button" id="delete_TP"
                                        data-kode="${data.kode}" value="${data.idTP}">Hapus</button></li>
                                    </ul>
                                </div>`;
                    }
                }],
                // lengthMenu: [10, 25],
                paging: false,
                ordering: false,
                searching: false,
                info: false,
            });
            $('#lm_nilai').DataTable({
                processing: true,
                ajax: {
                    url: `{{ route('get.lm-data') }}`,
                    type: 'GET',
                    data: function(d) {
                        d.idMapel = $('#mapel_id option:selected').val();
                        d.kelas = $('#kelas_name option:selected').val();
                        d.periode = $('#periode_id option:selected').val();
                    }
                },
                columns: [{
                    data: 'kode',
                    name: 'kode',
                    className: 'text-center'
                }, {
                    data: 'lm',
                    name: 'lm'
                }, {
                    data: null,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `<div class="btn-group">
                                    <button class="btn btn-alt-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        #
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end fs-sm">
                                        <li><span class="dropdown-header fw-semibold">Aksi ${data.kode}</span></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><button class="dropdown-item" type="button" value="${data.idLM}" id="ubah_LM">Ubah</button></li>
                                        <li><button class="dropdown-item" type="button" id="delete_LM"
                                        data-lm="${data.lm}" value="${data.idLM}">Hapus</button></li>
                                    </ul>
                                </div>`;
                    }
                }],
                // lengthMenu: [10, 25],
                paging: false,
                ordering: false,
                searching: false,
                info: false,
            });

            var kelasG = $('#kelas_name option:selected').val();
            getMapel(kelasG);

            $('#mapel_id, #periode_id').change(function() {
                $('#tp_nilai').DataTable().ajax.reload();
                $('#lm_nilai').DataTable().ajax.reload();
            });

            $('#kelas_name').change(function() {
                getMapel($(this).find('option:selected').val());
                // $('#tp_nilai').DataTable().ajax.reload();
                // $('#lm_nilai').DataTable().ajax.reload();
            });



            $('#btn_klLM').click(function(e) {
                e.preventDefault();
                $('#modal_LM').modal('show');
                var mapel = $('#mapel_id option:selected').text();
                var id = $('#mapel_id option:selected').val();
                var kelas = $('#kelas_name option:selected').val();
                var periode = $('#periode_id option:selected').val();
                var periodeTX = $('#periode_id option:selected').text();
                $('#modal_LM').find('#periode_LM').val(periode);
                $('#modal_LM').find('#semester').val(periodeTX);
                $('#modal_LM').find('#kelas').val(kelas);
                $('#modal_LM').find('#mapel_name').val(mapel);
                $('#modal_LM').find('#mapel').val(id);
                $('#form_LM').attr('action', "{{ route('store.data-lm') }}");
            });

            $('#modal_LM').on('hidden.bs.modal', function() {
                $('#form_LM').trigger('reset');
            });

            // insert LM
            insertOrUpdateData($('#form_LM'), function() {
                $('#modal_LM').modal('hide');
                $('#lm_nilai').DataTable().ajax.reload();
            });

            $(document).on('click', '#delete_LM', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var nama = $(this).data('lm');
                var url = `{{ url('guru/kategori-penilaian/delete-lingkup-materi/${id}') }}`;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    html: `Menghapus lingkup materi <b>${nama}</b>.`,
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
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                $('#lm_nilai').DataTable().ajax.reload();
                            },
                        });
                    }
                });
            });

            $('#btn_klTP').click(function(e) {
                e.preventDefault();
                $('#modal_TP').modal('show');
                var mapel = $('#mapel_id option:selected').text();
                var id = $('#mapel_id option:selected').val();
                var kelas = $('#kelas_name option:selected').val();
                var periode = $('#periode_id option:selected').val();
                var periodeTX = $('#periode_id option:selected').text();
                $('#modal_TP').find('#periode_TP').val(periode);
                $('#modal_TP').find('#semester_tp').val(periodeTX);
                $('#modal_TP').find('#kelas_tp').val(kelas);
                $('#modal_TP').find('#mapel_name_tp').val(mapel);
                $('#modal_TP').find('#mapel_tp').val(id);
                $('#form_TP').attr('action', "{{ route('store.data-tp') }}");
            });

            // insert TP
            insertOrUpdateData($('#form_TP'), function() {
                $('#modal_TP').modal('hide');
                $('#tp_nilai').DataTable().ajax.reload();
            });
            $('#modal_TP').on('hidden.bs.modal', function() {
                $('#form_TP').trigger('reset');
            });

            $(document).on('click', '#delete_TP', function(e) {
                e.preventDefault();
                var id = $(this).val();
                var nama = $(this).data('kode');
                var mapel = $('#mapel_id option:selected').text();
                var url = `{{ url('guru/kategori-penilaian/delete-tujuan-pembelajaran/${id}') }}`;

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    html: `Menghapus Tujuan Pembelajaran <b>${nama}</b> dari mapel <b>${mapel}</b>.`,
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
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                $('#tp_nilai').DataTable().ajax.reload();
                            },
                        });
                    }
                });
            });


            $(document).on('click', '#info_tp', function(e) {
                e.preventDefault();
                Swal.fire({
                    html: `<div class="row m-0">
                                <h5>CONTOH PENULISAN TUJUAN PEMBELAJARAN UNTUK DI APLIKASI RAPOR</h5>
                                <div class="col-12 text-start">
                                    <span class="fs-sm fw-bold">MATA PELAJARAN</span><span class="fs-sm fw-bold"> : IPA</span></br>
                                    <span class="fs-sm fw-bold">KELAS</span><span class="fs-sm fw-bold"> : 1 (SATU)</span>
                                    <table class="table table-bordered border-dark fs-sm align-middle mt-3">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap">NO</th>
                                                <th>TUJUAN PEMBELAJARAN PADA MODUL AJAR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    1
                                                </td>
                                                <td class="text-start">
                                                    Setelah mengamati lingkungan sekitar, siswa dapat menyebutkan jenis tanaman berdasarkan tempat tinggalnya dengan benar.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 mb-3">
                                    <i class="fa-solid fa-down-long display-4 text-primary"></i>    
                                </div>
                                <div class="col-12">
                                    <table class="table table-bordered border-dark fs-sm align-middle">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap">NO</th>
                                                <th>TUJUAN PEMBELAJARAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    1
                                                </td>
                                                <td class="text-start">
                                                    menyebutkan jenis tanaman berdasarkan tempat tinggalnya
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>    
                                </div>
                                <div class="col-12 text-start border border-dark rounded-2">
                                    <span class="h4 fw-bold text-muted">Penting:</span></br>
                                    <p class="fs-6 mt-2 mb-0">Tuliskan unsur Behaviour  (B) nya saja (unsur A, C, dan D nya dihilangkan).</p></br>
                                    <p class="fs-6">Tulis dengan huruf kecil semua (kecuali kata tertantu) dan tanpa tanda titik (.)</p>
                                </div>
                            </div>`,
                    showConfirmButton: false,
                });
            });

            $(document).on('click', '#ubah_TP', function(e) {
                e.preventDefault();

                $('#modal_TP').modal('show');
                $('#method').val('PUT');
                var id = $(this).val();
                $('#form_TP').attr('action',
                    `{{ url('guru/kategori-penilaian/update-tujuan-pembelajaran/${id}') }}`);

                $.ajax({
                    url: `{{ url('guru/kategori-penilaian/get-tp/${id}') }}`,
                    type: 'GET',
                    success: function(response) {
                        if (response.status == 'success') {
                            var mapel = $('#mapel_id option:selected').text();
                            var id = $('#mapel_id option:selected').val();
                            // console.log(response);
                            $('#mapel_name_tp').val(mapel);
                            $('#mapel_tp').val(id);
                            $('#kelas_tp').val(response.data.kelas);
                            $('#kode').val(response.data.kodeTP);
                            $('#idTP').val(response.data.idTP);
                            $('#deskripsi_TP').val(response.data.deskripsi);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Data TP tidak ditemukan!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    },
                });
            });

            $(document).on('click', '#ubah_LM', function(e) {
                e.preventDefault();

                $('#modal_LM').modal('show');
                $('#method_lm').val('PUT');
                var id = $(this).val();
                $('#form_LM').attr('action',
                    `{{ url('guru/kategori-penilaian/update-lingkup-materi/${id}') }}`);

                $.ajax({
                    url: `{{ url('guru/kategori-penilaian/get-lm/${id}') }}`,
                    type: 'GET',
                    success: function(response) {
                        if (response.status == 'success') {
                            var mapel = $('#mapel_id option:selected').text();
                            var id = $('#mapel_id option:selected').val();
                            // console.log(response);
                            $('#mapel_name').val(mapel);
                            $('#mapel').val(id);
                            $('#kelas').val(response.data.kelas);
                            $('#kodeLM').val(response.data.kodeLM);
                            $('#deskripsiLM').val(response.data.deskripsi);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Data LM tidak ditemukan!',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    },
                });
            });
        });
    </script>
@endsection
