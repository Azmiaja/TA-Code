@extends('company_profil/content/tentang_sekolah/index')
@section('tentang')
    <div class="row m-0 mb-3">
        {{-- Garis Judul --}}
        <div class="row m-0 p-0">
            <h3 class="p-0 m-0 mb-1 fw-bold">VISI DAN MISI</h3>
            <div class="col-4 bg-city p-0">
                <div class="line-lv1"></div>
            </div>
            <div class="col-8 bg-gray p-0">
                <div class="line-lv2"></div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 p-0">
            @if ($visiDeskripsi && $misiDeskripsi)
                <div class="row m-0 mb-3">
                    <h3 class="fw-bold m-0 mb-3 text-center">VISI</h3>
                    <article class="ck-content">
                        {!! $visiDeskripsi !!}
                    </article>
                </div>
                <div class="row m-0 mb-3">
                    <h3 class="fw-bold m-0 mb-3 text-center">MISI</h3>
                    <article class="ck-content">
                        {!! $misiDeskripsi !!}
                    </article>
                </div>
            @endif
        </div>
    </div>
@endsection
