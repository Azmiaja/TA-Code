@extends('company_profil/content/tentang_sekolah/index')
@section('tentang')
    <div class="row m-0">
        {{-- Garis Judul --}}
        <div class="row m-0 p-0 mb-3">
            <h3 class="p-0 m-0 mb-1 fw-bold">KEUANGAN</h3>
            <div class="col-4 bg-city p-0">
                <div class="line-lv1"></div>
            </div>
            <div class="col-8 bg-gray p-0">
                <div class="line-lv2"></div>
            </div>
        </div>
    </div>
    @if ($keuanganDeskripsi && $keuanganGambar)
        <div class="row m-0 mb-3">
            <div class="text-center rounded p-0 mb-3 ratio ratio-16x9">
                <img src="{{ $keuanganGambar }}" class="" style="width: 100%; height: 100%; object-fit: contain" alt="Cover Berita">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <article class="ck-content">
                    {!! $keuanganDeskripsi !!}
                </article>
            </div>
        </div>
    @endif
@endsection
