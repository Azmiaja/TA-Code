@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            {{-- Page title pegawai --}}
            <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Manajemen Company</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{ $title2 }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="content">
        {{-- Alert --}}
@if (session('success') || $errors->any())
    <div class="alert alert-{{ session('success') ? 'success' : 'warning' }} alert-dismissible fade show"
        role="alert">
        @if (session('success'))
            {{ session('success') }}
        @else
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="block block-rounded">
    <div class="block-header block-header-default">
        <h3 class="block-title">Table Visi Misi Sekolah</h3>
    </div>
    <div class="block-content block-content-full">
        <table id="tabelVisimisi"
            class="d-inline table table-responsive table-bordered table-striped table-vcenter desktop tablet-p mobile-p"
            style="width:800px">
            <thead class="text-light" style="background-color: #537188">
                <tr>
                    <th>No</th>
                    {{-- <th>Tanggal Berita</th> --}}
                    {{-- <th>Judul Berita</th> --}}
                    <th>Visi Misi </th>
                    <th>Gambar</th>
                    {{-- <th>Sumber Berita</th> --}}
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        var tableVisimisi = $('#tabelVisimisi').DataTable({
            dom: "<'row mb-2 py-2'<'col-12 col-sm-12 col-md-6 py-2'l><'col-12 col-sm-12 col-md-6 py-2 d-flex justify-content-end gap-4'fB>>" +
                "<'row my-2 '<'col-12 col-sm-12 overvlow-x-auto'tr>>" +
                "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            responsive: true,
            autoWidth: false,
            columnDefs: [{
                targets: 0,
                className: 'text-center'
            }, {
                targets: 2,
                width: "15%"
            }, {
                targets: 1,
                width: "10%"
            }, {
                targets: 5,
                width: "10%"
            }, {
                targets: 6,
                width: "7%"
            }],
            fixedColumns: true,
            lengthMenu: [10, 25],
            buttons: [{
                text: '<i class="fa fa-plus"></i> Tambah Visi Misi',
                className: 'btn btn-alt-success',
                action: function() {
                    $('#modalInsert').modal('show');
                }
            }]
        });
    });
</script>
@endsection
