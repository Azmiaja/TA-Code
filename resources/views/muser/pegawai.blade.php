@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            {{-- Page title siswa --}}
            <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Manajemen User</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Pegawai
                    </li>
                </ol>
                <div class="content">
                    <div class="row">
                        <div class="col-6 col-lg-3">
                            <a class="block block-rounded block-link-shadow text-center"
                                href="be_pages_ecom_product_edit.html">
                                <div class="block-content block-content-full">
                                    <div class="fs-2 fw-semibold text-success">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                                <div class="block-content py-2 bg-body-light">
                                    <p class="fw-medium fs-sm text-success mb-0">
                                        Tambah Pegawai
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-lg-3">
                            <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                                <div class="block-content block-content-full">
                                    <div class="fs-2 fw-semibold text-danger">1</div>
                                </div>
                                <div class="block-content py-2 bg-body-light">
                                    <p class="fw-medium fs-sm text-danger mb-0">
                                        Admin
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-lg-3">
                            <a class="block block-rounded block-link-shadow text-center">
                                <div class="block-content block-content-full">
                                    <div class="fs-2 fw-semibold text-dark">15</div>
                                </div>
                                <div class="block-content py-2 bg-body-light">
                                    <p class="fw-medium fs-sm text-muted mb-0">
                                        Guru
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-lg-3">
                            <a class="block block-rounded block-link-shadow text-center"
                                href="be_pages_ecom_dashboard.html">
                                <div class="block-content block-content-full">
                                    <div class="fs-2 fw-semibold text-dark">50</div>
                                </div>
                                <div class="block-content py-2 bg-body-light">
                                    <p class="fw-medium fs-sm text-muted mb-0">
                                        Siswa
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
            </nav>

            <div class="block-content block-content-full">
                <table id="tabelPegawai" class="table table-bordered table-striped table-vcenter ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Agama</th>
                            <th>Alamat</th>
                            <th>Jenis Pegawai</th>
                            <th>Mapel Diapu</th>
                            <th>No HP</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#tabelPegawai').DataTable();
        });
    </script>
@endsection
