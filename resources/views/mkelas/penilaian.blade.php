@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title periode --}}
                    <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-alt">
                            <li class="breadcrumb-item">
                                <a class="link-fx" href="javascript:void(0)">{{ $title }}</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                {{ $title2 }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-6 text-end">
                    {{-- ================================== BUTTON AKTIVITAS TAMBAH DATA ======================================== --}}
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-alt-success dropdown-toggle"
                            id="dropdown-align-alt-primary" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-plus mx-2"></i>Tambah Data
                        </button>
                        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-align-alt-primary">
                            <a class="dropdown-item" id="btn-tambahKelasGuru" href="javascript:void(0)">Tambah Kategori
                                Nilai</a>
                            <a class="dropdown-item" id="btn-tambahKelasSiswa" href="javascript:void(0)">Tambah Nilai
                                Siswa</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header border-bottom border-2 border-alt-secondary block-header-default">
                <h3 class="block-title">Data Nilai Siswa</h3>
            </div>
            <div class="row p-0 m-0">
                <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active data-kelas-tab" id="data-kelas-1-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" data-nama-kelas="1" role="tab" aria-controls="data-kelas"
                            aria-selected="true">Kelas
                            1</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link data-kelas-tab" id="data-kelas-2-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" data-nama-kelas="2"
                            aria-selected="false">Kelas
                            2</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link  data-kelas-tab" id="data-kelas-3-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" data-nama-kelas="3" role="tab" aria-controls="data-kelas"
                            aria-selected="true">Kelas
                            3</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link data-kelas-tab" id="data-kelas-4-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" data-nama-kelas="4"
                            aria-selected="false">Kelas
                            4</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link  data-kelas-tab" id="data-kelas-5-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" data-nama-kelas="5" role="tab" aria-controls="data-kelas"
                            aria-selected="true">Kelas
                            5</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link data-kelas-tab" id="data-kelas-6-tab" data-bs-toggle="tab"
                            data-bs-target="#data-kelas" role="tab" aria-controls="data-kelas" data-nama-kelas="6"
                            aria-selected="false">Kelas
                            6</button>
                    </li>
                    <li class="nav-item ms-auto">
                        <div class="row pt-1 m-0 text-end">
                            <div class="col p-0 align-self-center">
                                {{-- ATUR PERIODE --}}
                                <select class="form-select form-select-sm" id="periode" name="semester">
                                    @foreach ($periode as $item)
                                        @php
                                            $today = now();
                                            $startDate = \Carbon\Carbon::parse($item->tanggalMulai);
                                            $endDate = \Carbon\Carbon::parse($item->tanggalSelesai);
                                            $selected = $today >= $startDate && $today <= $endDate ? 'selected' : '';
                                        @endphp

                                        <option value="{{ $item->idPeriode }}" {{ $selected }}>
                                            {{ $item->semester }}/{{ \Carbon\Carbon::parse($item->tanggalMulai)->format('Y') }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <label class="col-auto col-form-label" for="semester">Periode</label>
                        </div>
                    </li>
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade show active" id="data-kelas" role="tabpanel"
                        aria-labelledby="data-kelas-tab" tabindex="0">
                        <table id="tabelPengajar" style="width: 100%"
                            class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th>Nama Siswa</th>
                                    <th>Mapel</th>
                                    <th>Semester</th>
                                    <th>Nilai 1</th>
                                    <th>Nilai 2</th>
                                    <th>Nilai 3</th>
                                    <th>Nilai 4</th>
                                    <th class="text-center" style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Content --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
