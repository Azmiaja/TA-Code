@extends('company_profil/content/tentang_sekolah/index')
@section('tentang')
    <div class="row m-0 mb-3">
        {{-- Garis Judul --}}
        <div class="row m-0 p-0">
            <h3 class="p-0 m-0 mb-1 fw-bold">SEJARAH</h3>
            <div class="col-4 bg-city p-0">
                <div class="line-lv1"></div>
            </div>
            <div class="col-8 bg-gray p-0">
                <div class="line-lv2"></div>
            </div>
        </div>
    </div>
    @if ($sejarahDeskripsi && $sejarahGambar)
        <div class="row m-0 mb-3">
            <div class="card border-0 rounded p-0 mb-3 ratio ratio-21x9">
                <img src="{{ $sejarahGambar }}" class="card-img" style="width: 100%; height: 100%; object-fit: cover" alt="Cover Berita">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <article class="ck-content">
                    {!! $sejarahDeskripsi !!}
                </article>
            </div>
        </div>
    @endif
@endsection
