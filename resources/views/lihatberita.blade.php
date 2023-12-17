@extends('layouts.landing')
@section('landing')

    <main>
        <div class="container-fluid">
            <div class="row p-0">
                <div class="col-lg p-0">
                    <div class="card text-bg-dark rounded-0 border-0">
                        <img src="{{ Storage::url($berita->gambar) }}" class="object-fit-cover"
                            height="500px" alt="Background-Judul">
                        <div class="card-img-overlay">
                            <div class="container h-100">
                                <div class="row align-items-center gap-1 h-100">
                                    <div class="col-auto tanggal-r my-auto">
                                        <div class="d-inline text-light">
                                            <h3 class="fw-bold mt-2 lh-1">
                                                {{ date('d', strtotime($berita->waktuBerita)) }}</h3>
                                            <p class="lead text-uppercase lh-1 fs-6 text-center ">
                                                {{ date('M', strtotime($berita->waktuBerita)) }}</p>
                                        </div>
                                    </div>
                                    <div class="col-auto tanggal-r p-0 my-auto">
                                        <div class="d-flex" style="height: 50px;">
                                            <div class="vr border  border-2 border-light"></div>
                                        </div>
                                    </div>
                                    <div class="col my-auto">
                                        <h1 class="fw-bold text-light">{{ $berita->judulBerita }}</h1>
                                        <a href="#" class="nav-link text-light fs-5 p-0">
                                            <p class="fw-medium">BY SD NEGERI LEMAHBANG</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container pb-3 my-2">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                    aria-label="breadcrumb">
                    <ol class="breadcrumb mt-3">
                        <li class="breadcrumb-item"><a href="{{ route('landingpage') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $berita->judulBerita }}</li>
                    </ol>
                </nav>
            </div>
            <div class="container py-3" style="max-width: 860px;">
                <div class="fs-6 mb-5 lead">
                    {!! $berita->isiBerita !!}
                </div>
                <a href="{{ $berita->sumberBerita }}" class="text-body-secondary my-2">{{ $berita->sumberBerita }}</a>
                <p class="text-body-secondary my-2">{{ \Carbon\Carbon::parse($berita->waktuBerita)->format('d-m-Y') }}</p>
            </div>
        </div>
    </main>
@endsection
