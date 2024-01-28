@extends('siakad/layouts/app')
@section('siakad')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="row p-0">
                <div class="col-6">
                    {{-- Page title berita --}}
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

                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row bg-white py-3 rounded-2">
            <div class="col">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="dd/mm/yyyy">
            </div>
            <div class="col">
                <label for="Semester" class="form-label">Semester</label>
                <select name="Semester" id="Semester" class="form-select">
                    <option value="">Genap 2023/2024</option>
                </select>
            </div>
            <div class="col">
                <label for="kelas" class="form-label">Kelas</label>
                <select name="kelas" id="kelas" class="form-select">
                    <option value="">Kelas 1</option>
                </select>
            </div>
            <div class="col">
                <label for="mapel" class="form-label">Mapel</label>
                <select name="mapel" id="mapel" class="form-select">
                    <option value="">PAI</option>
                </select>
            </div>
        </div>
    </div>
@endsection
