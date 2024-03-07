@extends('company_profil/content/tentang_sekolah/index')
@section('tentang')
    <div class="row m-0">
        {{-- Garis Judul --}}
        <div class="row m-0 p-0 mb-3">
            <h3 class="p-0 m-0 mb-1 fw-bold">PROFIL</h3>
            <div class="col-4 bg-city p-0">
                <div class="line-lv1"></div>
            </div>
            <div class="col-8 bg-gray p-0">
                <div class="line-lv2"></div>
            </div>
        </div>
    </div>
    @if ($profilDeskripsi && $profilGambar)
        <div class="row m-0 mb-3">
            <div class="card border-0 rounded p-0 mb-3 ratio ratio-21x9">
                <img src="{{ $profilGambar }}" class="card-img" style="width: 100%; height: 100%; object-fit: cover;" alt="Cover Berita">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="text-justify story">
                    {!! $profilDeskripsi !!}
                </div>
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="text-center story lend">
                    <img src="{{ asset('assets/media/img/error404.svg') }}" class="opacity-25" alt="" srcset="">
                </div>
            </div>
        </div>
    @endif
@endsection
