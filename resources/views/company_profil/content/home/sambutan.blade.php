@extends('company_profil/layouts/app')
@section('app')
    <div class="row my-2 g-3">
        <div class="col-xxl-9 col-lg-8 col-12">
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
                <h3 class="p-0 m-0 mb-1 fw-bold">SAMBUTAN KEPALA SEKOLAH</h3>
                <div class="col-4 bg-city p-0">
                    <div class="line-lv1"></div>
                </div>
                <div class="col-8 bg-gray p-0">
                    <div class="line-lv2"></div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <article class="ck-content">
                        {!! $sambutan !!}
                    </article>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 col-12">
            {{-- Garis Judul --}}
            <div class="row mx-0 p-0 mb-3" style="margin-top: 6px;">
                <h5 class="p-0 m-0 mb-1">BERITA TERBARU</h5>
                <div class="col-4 bg-city p-0">
                    <div class="line-lv1"></div>
                </div>
                <div class="col-8 bg-gray p-0">
                    <div class="line-lv2"></div>
                </div>
            </div>
            <div class="row m-0 mb-3">
                <div class="col-12 p-0">
                    <div class="row g-3">
                        {{-- Konten Berita --}}
                        @foreach ($beritaTerbaru as $bTree)
                            <div class="col-md-12">
                                <div class="d-flex block block-rounded shadow-sm p-2 m-0 position-relative">
                                    <div class="ratio" style="max-width: 6rem; height: 6rem;">
                                        <img src="{{ $bTree['gambar'] }}" alt="Berita" class="rounded"
                                            style="width: 100%; height: 100%; object-fit: cover">
                                    </div>
                                    <div class="block-content w-100 align-items-center px-0 ms-2">
                                        <h6 class="my-0 fst-normal text-dark mb-1">
                                            {{ $bTree['judul'] }}
                                        </h6>
                                        <div class="fw-semibold text-dark fs-sm text-wrap">
                                            <a class="link-effect link-primary d-lg-none d-md-inline"
                                                href="#">{{ $bTree['penulis'] }}</a>
                                            <span class="">
                                                {{ $bTree['tanggal'] }} &bull;</span>
                                            <span class="text-muted">
                                                {{ $bTree['waktu'] }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('baca_berita', ['slug' => $bTree['slug']]) }}"
                                        class="stretched-link"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
                <h5 class="p-0 m-0 mb-1">PESAN</h5>
                <div class="col-4 bg-city p-0">
                    <div class="line-lv1"></div>
                </div>
                <div class="col-8 bg-gray p-0">
                    <div class="line-lv2"></div>
                </div>
            </div>
            <div class="row m-0 mb-3">
                {{-- Kesan Pesan --}}
                <div class="card bg-with mt-md-0 p-2 shadow-sm border-0 mb-3">
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fa-solid fa-circle-check fs-3 me-3"></i>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                    @push('scripts')
                        <script>
                            $(document).ready(function() {
                                setTimeout(function() {
                                    $(".alert").alert('close');
                                }, 5000);
                            });
                        </script>
                    @endpush
                    <div class="card-body p-2">
                        <form action="{{ route('pesan.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control form-control-alt"
                                    placeholder="Masukkan nama lengkap Anda" id="nama" name="nama"
                                    value="{{ old('nama') }}">
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control form-control-alt"
                                    placeholder="Masukkan alamat email Anda" id="email" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="noHp" class="form-label">No Telepon</label>
                                <input type="number" class="form-control form-control-alt"
                                    placeholder="Masukkan nomor Hp Anda (62..)" id="noHp" value="{{ old('noHp') }}"
                                    name="noHp">
                                @error('noHp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea id="pesan" class="form-control form-control-alt" name="pesan"
                                    placeholder="Tulis pesan atau pertanyaan Anda di sini" style="resize: none;" cols="30" rows="5">{{ old('pesan') }}</textarea>
                                @error('pesan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-alt-primary float-end"><i
                                    class="fa-solid fa-paper-plane me-1"></i>Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
