@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            {{-- Page title home --}}
            <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Page</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{ $title2 }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="be_pages_ecom_product_edit.html">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-success">
                            {{ $jumlahPegawaiAktif }}
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-success mb-0">
                            Pegawai Aktif
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-danger">{{ $pegawai }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-danger mb-0">
                            Jumlah Pegawai
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark">{{ $siswa }}</div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            Jumlah Siswa
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a class="block block-rounded block-link-shadow text-center" href="be_pages_ecom_dashboard.html">
                    <div class="block-content block-content-full">
                        <div class="fs-2 fw-semibold text-dark"></div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="fw-medium fs-sm text-muted mb-0">
                            Tata Usaha
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
