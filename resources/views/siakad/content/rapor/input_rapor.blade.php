@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    @if ($periode)
        <div class="content">
            <div class="row justify-content-end mb-4 g-4">
                <div class="col-md-3 mb-md-0 mb-3">
                    <label for="periode_aktif" class="form-label fw-bold">Periode Aktif</label>
                    <input type="text" readonly data-id="{{ $periode->idPeriode }}"
                        value="{{ $periode->semester }} {{ $periode->tahun }}" data-smt="{{ $periode->semester }}"
                        data-tahun="{{ $periode->tahun }}" class="form-control form-control-alt fw-semibold border-secondary"
                        id="periode_id">
                </div>
                <div class="col-md-3 mb-md-0 mb-3">
                    <label for="kelas_diampu" class="form-label fw-bold">Kelas</label>
                    <input type="text" readonly data-nama="{{ $kelas->namaKelas }}" data-fase="{{ $kelas->fase }}"
                        data-id="{{ $kelas->idKelas }}"
                        value="Kelas {{ $kelas->namaKelas }} ({{ $kelas_nama[$kelas->namaKelas - 1] ?? '' }})"
                        class="form-control form-control-alt fw-semibold border-secondary" id="kelas_diampu">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Isi Rapor Siswa</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div id="loading_spinner" class="text-center" style="display: none">
                                <div class="spinner-border text-primary" role="status"></div>
                            </div>
                            <div class="table-responsive" id="tb_isi_siswa">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal insert --}}
        <div class="modal fade" id="modal_rapor" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
            aria-labelledby="modalMapeltLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-transparent mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Kelola Rapor</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content fs-sm form-container">
                            <form id="fr_rapor" action="{{ route('store.input.rapor') }}" method="POST">
                                @csrf
                                @method('post')
                                <div id="loading_spinner_2" class="text-center" style="display: none">
                                    <div class="spinner-border text-primary" role="status"></div>
                                </div>
                                <div id="form_rapor"></div>
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
                var periode = $('#periode_id').data('id');
                var periode_smt = $('#periode_id').data('smt');
                var kelas = $('#kelas_diampu').data('nama');
                var kelas_id = $('#kelas_diampu').data('id');

                function getTbSiswa() {
                    $('#loading_spinner').show();
                    $('#tb_isi_siswa').empty();
                    var tb_siswa;
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get-siswa.rapor') }}",
                        data: {
                            idPeriode: periode,
                            namaKelas: kelas
                        },
                        dataType: "json",
                        success: function(data) {
                            tb_siswa = `<table class="table table-striped w-100 table-bordered">
                                    <thead class="text-center table-light">
                                        <tr class="rounded">
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Nama Siswa</th>
                                            <th>L/P</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="align-middle">`;

                            $.each(data, function(i, siswa) {
                                if (siswa) {
                                    var lp = siswa.jenisKelamin == 'Laki-Laki' ? 'L' : 'P';
                                    tb_siswa += `<tr>
                                            <td style="width: 15px; min-width: 15px; text-align: center;">${i+1}</td>
                                            <td style="width: 30px; min-width: 30px;" class="text-center">${siswa.nis}</td>
                                            <td class="w-100">${siswa.namaSiswa}</td>
                                            <td style="width: 30px; min-width: 30px;" class="text-center fw-medium">${lp}</td>
                                            <td style="width: 110px; min-width: 110px; text-align: center">
                                                <button type="button" class="btn btn-sm btn-dark" id="btn_isi_rapor" data-id="${siswa.idSiswa}" data-nama="${siswa.namaSiswa}">Isi Rapor
                                                </button>
                                            </td>
                                        </tr>`;
                                }
                            });

                            tb_siswa += `<tbody></tbody>`;

                        },
                        complete: function() {
                            $('#loading_spinner').hide();
                            $('#tb_isi_siswa').append(tb_siswa);
                        }
                    });
                }

                function getForm(idSiswa) {
                    $('#modal_rapor').modal('show');
                    $('#loading_spinner_2').show();
                    $('#form_rapor').empty();
                    var form;
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get-form.input.rapor') }}",
                        data: {
                            idPeriode: periode,
                            namaKelas: kelas,
                            idSiswa: idSiswa
                        },
                        dataType: "json",
                        success: function(data) {
                            var siswa = data.siswa;
                            form = `<div class="mb-3">
                                    <label for="siswa" class="form-label fw-semibold">Nama Siswa</label>
                                    <input type="text" class="form-control form-control-alt" id="siswa" name="siswa" readonly value="${siswa.namaSiswa}" />
                                    <input type="hidden" name="idSiswa" value="${siswa.idSiswa}" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Ekstrakulikuler</label>
                                    <div class="mb-3 ms-3">
                                        <label for="wajib" class="form-label fw-semibold">Wajib</label>
                                        <select class="form-select" name="ideks[]" id="wajib" required>
                                            <option value="">Pilih Ekstrakulikuler</option>`;

                            var eks_wajib = data.ekstra.filter(function(item) {
                                return item.status == 'wajib';
                            });
                            if (eks_wajib) {
                                $.each(eks_wajib, function(ex, wajib) {
                                    var kegiatan = data.kegiatan.find(function(iten) {
                                        return iten.idEks == wajib.idEks;
                                    });
                                    if (kegiatan) {
                                        form +=
                                            `<option selected data-id="${kegiatan.idKegiatan}" data-dsc="${kegiatan.deskripsi}" value="${wajib.idEks}" data-id-siswa="${siswa.idSiswa}" data-predikat="${kegiatan.predikat}">${wajib.ekstra}</option>`;
                                    } else {
                                        form += `<option value="${wajib.idEks}">${wajib.ekstra}</option>`;
                                    }
                                });
                            }
                            form += `</select>
                                </div>
                                <div class="ms-3" id="dscWajib"></div>
                                </div>
                                <div class="mb-3 ms-3">
                                    <label for="pilihan" class="form-label fw-semibold">Pilihan</label>
                                    <div class="mb-3">`;

                            // ekstra pilihan
                            var eks_pilihan = data.ekstra.filter(function(item) {
                                return item.status == 'pilihan';
                            });
                            if (eks_pilihan) {
                                $.each(eks_pilihan, function(ey, pilihan) {
                                    var kegiatan = data.kegiatan.find(function(iten) {
                                        return iten.idEks == pilihan.idEks;
                                    });
                                    form +=
                                        `<div class="form-check form-check-inline">
                                            <input class="form-check-input ekstra-checkbox" name="ideks[]" ${kegiatan ? 'checked' : ''} type="checkbox" data-id-siswa="${siswa.idSiswa}" data-nama="${pilihan.ekstra}" data-dsc="${kegiatan ? kegiatan.deskripsi : ''}" data-predikat="${kegiatan ? kegiatan.predikat : ''}" data-id="${kegiatan ? kegiatan.idKegiatan : ''}" value="${pilihan.idEks}" id="ekstra2_${pilihan.idEks}">
                                            <label class="form-check-label" for="ekstra2_${pilihan.idEks}">
                                                ${pilihan.ekstra}
                                            </label>
                                        </div>`;
                                });

                                form += `</div><div id="textarea_container"></div>`;
                            }

                            var catatan = data.catatan;
                            var keterangan = data.keterangan;
                            form += `</div>
                            <hr class="border border-secondary border-2 opacity-25">
                                <div id="dscPilihan"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="catatan" class="form-label fw-semibold">Catatan Guru</label>
                                    <div class="${catatan ? 'd-flex' : ''}">
                                        <textarea row="3" style="resize: none;" class="form-control" placeholder="Tuliskan catatan untuk siswa" name="catatan" id="catatan">${catatan ? catatan.catatan_guru : '' }</textarea>
                                        <button type="button" data-id-siswa="${catatan ? siswa.idSiswa : ''}" class="btn btn-alt-danger ms-2 ${catatan ? '' : 'd-none'}" id="hapus_catatan" value="${catatan ? catatan.idCtGuru : ''}" title="Hapus catatan">X</button>
                                    </div>
                                </div>`;


                            if (periode_smt == 'Genap') {
                                form += `<div class="mb-3">
                                    <label for="naik_tidak" class="form-label fw-semibold">Kenaikan Kelas</label>
                                    <div class="${keterangan ? 'd-flex' : ''}">
                                        <div class="w-100">
                                            <select class="form-select" name="naik_tidak" id="naik_tidak" required>
                                                <option value="">Pilih Keterangan</option>   
                                                <option ${keterangan ? (keterangan.keterangan == 'Ya' ? 'selected' : '') : ''}      value="Ya">Ya</option>    
                                                <option ${keterangan ? (keterangan.keterangan == 'Tidak' ? 'selected' : '') : ''}       value="Tidak">Tidak</option>    
                                            </select>
                                            <textarea row="3" style="resize: none;" class="form-control mt-2" placeholder="Tuliskandeskripsi kenaikan kelas untuk siswa" name="naik_tidak_desk" id="naik_tidak">${keterangan ? keterangan.deskripsi : '' }</textarea>
                                        </div>
                                        <button type="button" id="hapus_ketNaikTdak" title="Hapus Keterangan" class="btn btn-alt-danger ms-2 ${keterangan ? '' : 'd-none'}" data-id-siswa="${keterangan ? siswa.idSiswa : ''}" value="${keterangan ? (keterangan.idNK ?? '') : ''}">X</button>
                                        </div>
                                </div>`;
                            }

                            form += `<input type="hidden" value="${periode}" name="idPeriode" />
                            <input type="hidden" value="${kelas_id}" name="idKelas" />
                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>`;

                        },
                        complete: function() {
                            $('#loading_spinner_2').hide();
                            $('#form_rapor').append(form);
                            $('#wajib').trigger('change');
                            $('#pilihan').trigger('change');
                            $('.ekstra-checkbox').trigger('change');
                        }
                    });
                }

                function dscWajib(idEks, name, deskripsi, predikat, idKg, idSiswa) {
                    $('#dscWajib').empty();

                    var form = `<div class="mb-3 ${deskripsi ? 'd-flex' : ''}">
                    <div class="w-100">
                        <select class="form-select" name="predikat_${idEks}" required>
                            <option value="">Pilih Predikat</option>
                            <option value="3" ${predikat === 3 ? 'selected' : ''}>Sangat Berkembang</option>
                            <option value="2" ${predikat === 2 ? 'selected' : ''}>Berkembang</option>
                            <option value="1" ${predikat === 1 ? 'selected' : ''}>Cukup Berkembang</option>
                            <option value="0" ${predikat === 0 ? 'selected' : ''}>Mulai Berkembang</option>
            
                        </select>
                        <textarea row="3" style="resize: none;" class="form-control mt-2" placeholder="Deskripsikan perkembangan siswa dalam ekskul ${name}" name="ekstra_${idEks}">${deskripsi ?? ''}</textarea>
                    </div>
                    <button class="btn btn-alt-danger ms-2 ${deskripsi ? '' : 'd-none'}" type="button" value="${idKg}" data-id-siswa="${idSiswa}" data-nama="${name}" title="Hapus ekskul ${name}" id="hapus_ekstra">X</button>
                    </div>`;

                    $('#dscWajib').html(form);
                }

                function textArea(idEks, nama, deskripsi, predikat, idKg, idSiswa) {
                    // $('#textarea_container').empty();
                    var form = `<div class="mb-3" id="tx_ekstra_${idEks}">
                                <label for="ekstra_${idEks}" class="form-label">${nama}</label>
                                <div class="${deskripsi ? 'd-flex' : ''}">
                                    <div class="w-100">
                                        <select class="form-select" name="predikat_${idEks}" required>
                                            <option value="">Pilih Predikat</option>
                                            <option value="3" ${predikat === 3 ? 'selected' : ''}>Sangat Berkembang</option>
                                            <option value="2" ${predikat === 2 ? 'selected' : ''}>Berkembang</option>
                                            <option value="1" ${predikat === 1 ? 'selected' : ''}>Cukup Berkembang</option>
                                            <option value="0" ${predikat === 0 ? 'selected' : ''}>Mulai Berkembang</option>
                                        
                                        </select>
                                        <textarea row="3" style="resize: none;" class="form-control mt-2" placeholder="Deskripsikan perkembangan siswa dalam ekskul ${nama}" id="ekstra_${idEks}" name="ekstra_${idEks}">${deskripsi ?? ''}</textarea>
                                    </div>
                                    <button class="btn btn-alt-danger ms-2 ${deskripsi ? '' : 'd-none'}" type="button" data-nama="${nama}" value="${idKg}" data-id-siswa="${idSiswa}" title="Hapus ekskul ${nama}" id="hapus_ekstra">X</button>
                                </div>
                            </div>`;

                    $('#textarea_container').append(form);
                }

                $(document).ready(function() {
                    getTbSiswa();

                    $(document).on('click', '#btn_isi_rapor', function(e) {
                        e.preventDefault();
                        getForm($(this).data('id'));
                    });

                    $(document).on('change', '#wajib', function(e) {
                        e.preventDefault();
                        var wajib = $(this).find('option:selected').val();
                        var wajib_nm = $(this).find('option:selected').text().trim();
                        var wajib_dsc = $(this).find('option:selected').data('dsc');
                        var idKegiatan = $(this).find('option:selected').data('id');
                        var predikat = $(this).find('option:selected').data('predikat');
                        var idSiswa = $(this).find('option:selected').data('id-siswa');
                        if (wajib) {
                            dscWajib(wajib, wajib_nm, wajib_dsc, predikat, idKegiatan, idSiswa);
                        } else {
                            $('#dscWajib').empty();
                        }
                    });

                    $(document).on('change', '.ekstra-checkbox', function(e) {
                        e.preventDefault();

                        var idEks = $(this).val();
                        var dsc = $(this).data('dsc');
                        var nama = $(this).data('nama');
                        var idKegiatan = $(this).data('id');
                        var predikat = $(this).data('predikat');
                        var idSiswa = $(this).data('id-siswa');

                        if ($(this).is(':checked')) {
                            textArea(idEks, nama, dsc, predikat, idKegiatan, idSiswa);
                            // console.log('berhasil');
                        } else {
                            $('#tx_ekstra_' + idEks).remove();
                            // console.log('gagal');
                        }

                    });

                    insertOrUpdateData($('#fr_rapor'), function() {
                        $('#modal_rapor').modal('hide');
                    });

                    // hapus ekstra
                    $(document).on('click', '#hapus_ekstra', function(e) {
                        e.preventDefault();
                        var id = $(this).val();
                        var nama = $(this).data('nama');
                        var idSiswa = $(this).data('id-siswa');

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            html: `Menghapus ekstrakulikuler <b>${nama}</b> dari rapor siswa.`,
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
                                    url: `{{ url('guru/rapor-siswa/delete/ekstrakulikuler/${id}') }}`,
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
                                            getForm(idSiswa);
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

                    // hapus catatan
                    $(document).on('click', '#hapus_catatan', function(e) {
                        e.preventDefault();

                        var id = $(this).val();
                        var siswa = $(this).data('id-siswa');

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            html: `Menghapus catatan guru dari rapor siswa.`,
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
                                    url: `{{ url('guru/rapor-siswa/destroy/catatan-guru/${id}') }}`,
                                    dataType: 'json',
                                    success: function(response) {
                                        Swal.fire({
                                            icon: response.status,
                                            title: response.title,
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        getForm(siswa);
                                    },
                                });
                            }
                        });
                    });

                    // hapus keterangan naik/tidak
                    $(document).on('click', '#hapus_ketNaikTdak', function(e) {
                        e.preventDefault();

                        var id = $(this).val();
                        var siswa = $(this).data('id-siswa');

                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            html: `Menghapus keterangan kenaikan kelas dari rapor siswa.`,
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
                                    url: `{{ url('guru/rapor-siswa/delete/keterangan-naik-tidak/${id}') }}`,
                                    dataType: 'json',
                                    success: function(response) {
                                        Swal.fire({
                                            icon: response.status,
                                            title: response.title,
                                            text: response.message,
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                        getForm(siswa);
                                    },
                                });
                            }
                        });
                    });

                });
            </script>
        @endpush
    @endif
@endsection
