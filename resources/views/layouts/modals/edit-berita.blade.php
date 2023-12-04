{{-- <form action="{{ route('berita.update', $berita) }}" id="update-berita" enctype="multipart/form-data" method="post">
    @csrf
    @method('put') --}}
<form enctype="multipart/form-data" id="update-berita-form">
    @csrf
    @method('put')
    <input type="text" name="idBerita" id="idBerita" value="{{ $berita->idBerita }}" hidden>
    <div class="mb-4">
        <label class="form-label" for="judulBerita">Judul Berita</label>
        <input type="text" class="form-control" id="judulBerita" name="judulBerita" placeholder="Judul Berita Anda.."
            value="">
    </div>
    <div class="mb-4">
        <label class="form-label" for="gambarBerita">Gambar
            Berita</label>
        <div class="row ms-1 mb-2 p-0">
            <div class="col-auto border rounded-2">
                <div class="m-3">
                    <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->gambar }}" height="150">
                </div>
            </div>
        </div>
        <input class="form-control" type="file" name="gambar" id="gambarBerita" accept="image/*">
    </div>
    <div class="mb-4">
        <label class="form-label" for="isiBerita">Isi Berita</label>
        <textarea id="js-ckeditor5-classic-edit-{{ $berita->idBerita }}" class="form-control isiBerita" name="isiBerita">{{ $berita->isiBerita }}</textarea>
    </div>
    <div class="mb-4">
        <div class="row m-0">
            <div class="col-lg-4 col-sm-12 col-12 px-0 mb-sm-0 mb-4">
                <label class="form-label" for="waktuBerita">Tanggal
                    Berita</label>
                @php
                    $carbonDate = \Carbon\Carbon::parse($berita->waktuBerita);
                @endphp
                <input type="text" class="form-control waktuBerita" id="js-flatpickr-edit-{{ $berita->idBerita }}"
                    name="waktuBerita" placeholder="d-m-Y" data-date-format="d-m-Y"
                    value="{{ $carbonDate->format('d.m.Y H:i') }}">
            </div>
            <div class="col-lg-8 col-sm-12 col-12 px-0 ps-lg-3 ps-0">
                <label class="form-label" for="sumberBerita">Sumber
                    Berita</label>
                <input type="text" class="form-control" id="sumberBerita" name="sumberBerita"
                    placeholder="Sumber Berita Anda.." value="{{ $berita->sumberBerita }}">
            </div>
        </div>
    </div>
    <div class="mb-4 text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" id="update-berita" data-bs-dismiss="modal">Simpan</button>
    </div>

</form>
