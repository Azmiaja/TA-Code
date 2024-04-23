@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    @push('style')
        <style>
            #tabel-JPSiswa caption {
                font-family: 'Times New Roman', Times, serif;
            }
        </style>
    @endpush
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Jadwal Pelajaran</h3>
                <div class="block-options">
                    <select name="periode" id="periode" class="form-select form-select-sm">
                        <option value="{{ $periode->idPeriode }}">
                            Semester
                            {{ $periode->semester }} {{ $periode->tahun }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <div class="row p-0 m-0">
                        <div class="col text-end p-1">
                            <button class="btn btn-primary" id="btn_print_jadwal">
                                <i class="fa fa-print me-2"></i>Cetak</button>
                        </div>
                    </div>
                    <table id="tabel-JPSiswa" class="table table-bordered w-100 caption-top border-dark">
                        <caption class="h3 text-uppercase text-center pt-0 text-dark">
                            Jadwal Pelajaran Kelas {{ $kelas->namaKelas }}<br>
                            SD Negeri Lemahbang<br>
                            Tahun Pelajaran {{ $periode->tahun }}
                        </caption>
                        <thead class="table-light text-center align-middle fw-bold border-dark">
                            <tr>
                                <th class="fs-5" width="14%">Waktu</th>
                                <th class="fs-5" width="14%">Senin</th>
                                <th class="fs-5" width="14%">Selasa</th>
                                <th class="fs-5" width="14%">Rabu</th>
                                <th class="fs-5" width="14%">Kamis</th>
                                <th class="fs-5" width="14%">Jumat</th>
                                <th class="fs-5" width="14%">Sabtu</th>
                            </tr>
                        </thead>
                        <tbody class="text-uppercase">
                            {{-- conten --}}
                            <script>
                                $(document).ready(function() {
                                    $('#tabel-JPSiswa').DataTable({
                                        processing: true,
                                        ajax: {
                                            url: `{!! route('get-jadwal.siswa') !!}`,
                                            type: 'GET',
                                            data: function(d) {
                                                d.idPeriode = $('#periode').val();
                                                d.kelas = {!! json_encode($kelas->namaKelas) !!};
                                            }
                                        },
                                        columns: [{
                                                data: 'waktu',
                                                name: 'waktu',
                                                className: 'text-center px-0 fw-semibold text-nowrap'
                                            },
                                            {
                                                data: 'Senin',
                                                name: 'Senin',
                                                className: 'text-center px-0 fw-semibold'
                                            },
                                            {
                                                data: 'Selasa',
                                                name: 'Selasa',
                                                className: 'text-center px-0 fw-semibold'
                                            },
                                            {
                                                data: 'Rabu',
                                                name: 'Rabu',
                                                className: 'text-center px-0 fw-semibold'
                                            },
                                            {
                                                data: 'Kamis',
                                                name: 'Kamis',
                                                className: 'text-center px-0 fw-semibold'
                                            },
                                            {
                                                data: 'Jumat',
                                                name: 'Jumat',
                                                className: 'text-center px-0 fw-semibold'
                                            },
                                            {
                                                data: 'Sabtu',
                                                name: 'Sabtu',
                                                className: 'text-center px-0 fw-semibold'
                                            },
                                        ],
                                        dom: "<'row my-0 '<'col-12 col-sm-12 col-md-7'><'col-12 col-sm-12 col-md-5 text-md-end'B>>" +
                                            "<'row my-0 '<'col-12 col-sm-12'tr>>" +
                                            "<'row mb-0'<'col-12 col-sm-12 col-md-5'><'col-sm-12 col-md-7'>>",
                                        buttons: [{
                                            extend: 'print',
                                            title: function() {
                                                return '<h3 style="margin-bottom: 3rem; font-family: Times New Roman, Times, serif;">JADWAL PELAJARAN KELAS ' +
                                                    {!! json_encode($kelas->namaKelas) !!} + '<br>' + 'SD NEGERI LEMAHBANG' + '<br>' +
                                                    'TAHUN PELAJARAN ' + {!! json_encode($periode->tahun) !!} + '</h3>';
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
                                                    'font-size': '12pt'
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
                                });
                            </script>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
