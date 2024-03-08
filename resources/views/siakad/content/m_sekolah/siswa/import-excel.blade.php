<div class="modal fade" id="modalSiswaImport" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="modalInsertLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-transparent mb-0">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Import Data Siswa</h3>
                    <div class="block-options">
                        <button type="button" id="btn-close" class="btn-block-option" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content fs-sm">
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <h3 class="alert-heading h4 my-2">Penting</h3>
                        <p class="mb-0">
                            Gunakan template ini untuk melakukan import data dengan format excel <a class="alert-link"
                                href="{{ asset('uploads/excel/Template.xlsx') }}">Template.xlsx</a>
                        </p>
                    </div>
                    <div class="row">
                        <form action="{{ route('siswa.import') }}" method="post" enctype="multipart/form-data"
                            id="formSiswaImport">
                            @csrf
                            <div class="col-12 mb-4">
                                <label class="form-label" for="nisn">File Excel</label>
                                <input type="file" class="form-control" id="file" name="file"
                                    accept=".xlsx, .xls">
                            </div>
                            <div class="mb-4 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="block-content block-content-full bg-body">
                    {{-- Additional content if needed --}}
                </div>
            </div>
        </div>
    </div>
</div>
