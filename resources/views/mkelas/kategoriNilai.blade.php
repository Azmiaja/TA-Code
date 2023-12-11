@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title --}}
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
                    <button class="btn btn-sm btn-alt-success" id="tambah-kategori"><i class="fa fa-plus mx-2"></i>Tambah
                        Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Kategori Nilai</h3>
            </div>
            <div class="block-content block-content-full">
                <table id="tabelPeriode" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Content --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal kaategori --}}
    <div class="modal fade" id="modal-Kategori" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modalMapeltLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
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
                        <form action="POST" enctype="multipart/form-data" id="form-kategori">
                            <input type="text" name="idMapel" id="idMapel" class="id-kategori" hidden>
                            <div class="mb-4">
                                <label class="form-label" for="idPeriode">Periode</label>
                                <select name="idPeriode" id="idPeriode" class="form-select periode-id">
                                    <option value="" disabled selected>-- Pilih Periode --</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="idKelas">Kelas</label>
                                <select name="idKelas" id="idKelas" class="form-select kelas-id">
                                    <option value="" disabled selected>-- Pilih Kelas --</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="idPengajaran">Nama Pengajar</label>
                                <select name="idPengajaran" id="idPengajaran" class="form-select guru-id">
                                    <option value="" disabled selected>-- Pilih Pengajar --</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="idMapel">Mapel</label>
                                <select name="idMapel" id="idMapel" class="form-select mapel-id">
                                    <option value="" disabled selected>-- Pilih Mapel --</option>
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

            });
        </script>
    @endpush
@endsection
