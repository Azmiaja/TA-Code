<form action="{{ route('berita.destroy', $data->idBerita) }}"
    method="POST">
    @csrf
    @method('delete')
    <div class="mb-4 text-center fs-sm">
        Apakah Anda ingin menghapus berita
        <strong>"{{ $data->judulBerita }}"
            ?</strong>
    </div>
    <div class="mb-4 text-center">
        <button type="button" class="btn btn-sm btn-secondary"
            data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-sm btn-danger"
            data-bs-dismiss="modal">Hapus</button>
    </div>
</form>