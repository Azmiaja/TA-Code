@extends('siakad.layouts.app')
@section('siakad')
    @push('style')
        <style>
            .ellipse {
                display: -webkit-box;
                -webkit-line-clamp: 10;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: normal;
            }
        </style>
    @endpush
    @include('siakad/layouts/partials/hero')
    <div class="content">
        {{-- Profil --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Profil Sekolah</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-warning" data-toggle="block-option" value="{{ $profil->idProfil }}"
                        id="bt-edit-profil"><i class="fa-regular fa-pen-to-square me-2"></i><span>Edit
                            Data</span></button>
                </div>
            </div>
            <div class="block-content p-0">
                <div class="row m-0 p-4">
                    <div class="col-md-4 col-12 p-0">
                        <a href="#" class="popup-link" id="pop-up-profil" title="View Image">
                            <img id="img-Profil" alt="ProfilSekolah"
                                class="flex-shrink-0 w-100 me-3 img-fluid object-fit-cover rounded"
                                style="border: 2px dashed #dfe3ea;">
                        </a>
                    </div>
                    <div class="col-md-8 col-12">
                        <div id="deskripsi" class="ellipse m-0"></div>
                        {{-- <a class="fs-sm fw-bold p-0 m-0" href="#">Selengkapnya...</a> --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Sejarah --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Sejarah Sekolah</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-warning" data-toggle="block-option" value="{{ $profil->idProfil }}"
                        id="bt-edit-sejarah"><i class="fa-regular fa-pen-to-square me-2"></i><span>Edit
                            Data</span></button>
                </div>
            </div>
            <div class="block-content  p-0">
                <div class="row m-0 p-4">
                    <div class="col-md-4 col-12 p-0">
                        <a href="#" class="popup-link" id="pop-up-sejarah" title="View Image">
                            <img id="img-Sejarah" alt="SejarahSekolah"
                                class="flex-shrink-0 w-100 me-3 img-fluid object-fit-cover rounded"
                                style="border: 2px dashed #dfe3ea;">
                        </a>
                    </div>
                    <div class="col-md-8 col-12">
                        <div id="deskripsiSejarah" class="ellipse m-0"></div>
                        {{-- <a class="fs-sm fw-bold p-0 m-0" href="#">Selengkapnya...</a> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- Struktur Organisasi --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Organisasi Sekolah</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-warning" data-toggle="block-option" value="{{ $profil->idProfil }}"
                        id="bt-edit-organisasi"><i class="fa-regular fa-pen-to-square me-2"></i><span>Edit
                            Data</span></button>
                </div>
            </div>
            <div class="block-content  p-0">
                <div class="row m-0 p-4">
                    <div class="col-md-4 col-12 p-0">
                        <a href="#" class="popup-link" id="pop-up-organisasi" title="View Image">
                            <img id="img-Organisasi" alt="OrganisasiSekolah"
                                class="flex-shrink-0 w-100 me-3 img-fluid object-fit-cover rounded"
                                style="border: 2px dashed #dfe3ea;">
                        </a>
                    </div>
                    <div class="col-md-8 col-12">
                        <div id="deskripsiOrganisasi" class="ellipse m-0"></div>
                        {{-- <a class="fs-sm fw-bold p-0 m-0" href="#">Selengkapnya...</a> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- Keuangan --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Keuangan Sekolah</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-warning" data-toggle="block-option" value="{{ $profil->idProfil }}"
                        id="bt-edit-keuangan"><i class="fa-regular fa-pen-to-square me-2"></i><span>Edit
                            Data</span></button>
                </div>
            </div>
            <div class="block-content  p-0">
                <div class="row m-0 p-4">
                    <div class="col-md-4 col-12 p-0">
                        <a href="#" class="popup-link" id="pop-up-keuangan" title="View Image">
                            <img id="img-Keuangan" alt="KeuanganSekolah"
                                class="flex-shrink-0 w-100 me-3 img-fluid object-fit-cover rounded"
                                style="border: 2px dashed #dfe3ea;">
                        </a>
                    </div>
                    <div class="col-md-8 col-12">
                        <div id="deskripsiKeuangan" class="ellipse m-0"></div>
                        {{-- <a class="fs-sm fw-bold p-0 m-0" href="#">Selengkapnya...</a> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- Visi Misi --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Visi dan Misi Sekolah</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-warning" data-toggle="block-option" value="{{ $profil->idProfil }}"
                        id="bt-edit-visimisi"><i class="fa-regular fa-pen-to-square me-2"></i><span>Edit
                            Data</span></button>
                </div>
            </div>
            <div class="block-content  p-0">
                <di class="row m-0 p-4">
                    <label for="" class="form-label text-center">Visi</label>
                    <div class="col-12 p-2 mb-3 rounded" style="border: 2px dashed #dfe3ea;">
                        <div id="deskripsiVisi" class="ellipse m-0 p-1"></div>
                    </div>
                    <label for="" class="form-label text-center">Misi</label>
                    <div class="col-12 p-2 rounded" style="border: 2px dashed #dfe3ea;">
                        <div id="deskripsiMisi" class="ellipse m-0 p-1"></div>
                    </div>
                    {{-- <a class="fs-sm fw-bold p-0 m-0" href="#">Selengkapnya...</a> --}}
            </div>
        </div>

        {{-- Visi Misi --}}
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Sambutan Kepala Sekolah</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-warning" data-toggle="block-option" value="{{ $profil->idProfil }}"
                        id="bt-edit-sambutan"><i class="fa-regular fa-pen-to-square me-2"></i><span>Edit
                            Data</span></button>
                </div>
            </div>
            <div class="block-content  p-0">
                <di class="row m-0 p-4">
                    <div class="col-12 p-2 mb-3 rounded" style="border: 2px dashed #dfe3ea;">
                        <div id="sambutan" class="ellipse m-0 p-1"></div>
                    </div>
            </div>
        </div>
    </div>

    @include('siakad/content/profil_sekolah/sekolah/modal')
    </div>


    @push('scripts')
        <script>
            $(document).ready(function() {
                const modalProfilSekolah = $('#modalProfilSekolah');
                const formProfilSekolah = $('#formProfilSekolah');
                const formVisiMisi = $('#formVisiMisi');
                const formSambutan = $('#formSambutan');
                const modalTitle = $("#modal-title");
                const modalTitleVM = $("#modal-title-vm");
                const modalTitleSambutan = $("#modal-title-sambutan");
                const imgPrev = document.querySelector('.img-preview');
                const btCloseModal = document.querySelector('.close-berita-modal');
                const popUpSjr = document.getElementById('pop-up-sejarah');
                const popUpPp = document.getElementById('pop-up-profil');
                const popUpOrg = document.getElementById('pop-up-organisasi');
                const popUpKeu = document.getElementById('pop-up-keuangan');
                const btModal = $('#btn-form');
                const method = $('#method');
                const methodVM = $('#methodVM');
                const methodSambutan = $('#methodSambutan');
                const id = $('#idProfilSekolah');
                const imgProfil = document.getElementById('img-Profil');
                const deskProfil = document.getElementById('deskripsi');
                const imgSejarah = document.getElementById('img-Sejarah');
                const deskSejarah = document.getElementById('deskripsiSejarah');
                const imgOrganisasi = document.getElementById('img-Organisasi');
                const deskOrganisasi = document.getElementById('deskripsiOrganisasi');
                const imgKeuangan = document.getElementById('img-Keuangan');
                const deskKeuangan = document.getElementById('deskripsiKeuangan');
                const deskVisi = document.getElementById('deskripsiVisi');
                const deskMisi = document.getElementById('deskripsiMisi');
                const sambutanSS = document.getElementById('sambutan');

                const modalVM = $('#modalVisiMisi');
                const modalSambutan = $('#modalSambutan');
                const bodyModal = $('#body-modal');
                const delVM = $('#hapusDataVisiMisi');

                function updateModal(title, button) {
                    modalTitle.text(title);
                    btModal.html(button);
                }

                function resetForm() {
                    imgPrev.style.display = 'none';
                    formProfilSekolah.trigger('reset');
                    myEditor.setData('');
                    visiEditor.setData('');
                    misiEditor.setData('');
                    sambutanKep.setData('');
                }

                modalProfilSekolah.on('hidden.bs.modal', function() {
                    // Reset form
                    resetForm()
                });

                modalVM.on('hidden.bs.modal', function() {
                    // Reset form
                    resetForm()
                });
                modalSambutan.on('hidden.bs.modal', function() {
                    // Reset form
                    resetForm()
                });

                fetchProfilData();

                function fetchProfilData() {
                    // Lakukan AJAX request ke endpoint yang telah dibuat
                    var url = '{!! url('profil/get-data') !!}';
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            // Update gambar dan sasaran dengan data yang diterima dari server
                            imgProfil.src = data.image ?? null;
                            deskProfil.innerHTML = data.deskripsi ?? null;
                            popUpPp.href = data.image ?? null;

                            imgSejarah.src = data.imageSejarah ?? null;
                            popUpSjr.href = data.imageSejarah ?? null;
                            deskSejarah.innerHTML = data.deskripsiSejarah ?? null;

                            imgOrganisasi.src = data.imageOrganisasi ?? null;
                            popUpOrg.href = data.imageOrganisasi ?? null;
                            deskOrganisasi.innerHTML = data.deskripsiOrganisasi ?? null;

                            imgKeuangan.src = data.imageKeuangan ?? null;
                            popUpKeu.href = data.imageKeuangan ?? null;
                            deskKeuangan.innerHTML = data.deskripsiKeuangan ?? null;

                            deskVisi.innerHTML = data.visi ?? null;
                            deskMisi.innerHTML = data.misi ?? null;

                            sambutanSS.innerHTML = data.sambutanKepsek ?? null;

                        });
                }

                $('.popup-link').magnificPopup({
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });

                function simpanPerubahan() {
                    var data = new FormData(formProfilSekolah[0]);
                    var deskripsi = myEditor.getData();
                    data.append('isiProfilSekolah', deskripsi);

                    $.ajax({
                        type: 'POST',
                        url: formProfilSekolah.attr('action'),
                        data: data,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });

                            modalProfilSekolah.modal('hide');
                            resetForm();
                            fetchProfilData();
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;
                            // Handle errors as needed
                        }
                    });
                }

                function hapusData(name, url) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Menghapus data ${name}`,
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                type: "DELETE",
                                url: url,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    resetForm();
                                    modalProfilSekolah.modal('hide');
                                    fetchProfilData();
                                },
                            });
                        }
                    });
                }

                var myEditor;
                ClassicEditor
                    .create(document.querySelector('#isiProfilSekolah'), {
                        // ckfinder: {
                        //     uploadUrl: "{{ route('ckberita.upload', ['_token' => csrf_token()]) }}",
                        // }
                    })
                    .then(editor => {
                        myEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });

                var visiEditor;
                ClassicEditor
                    .create(document.querySelector('#isiVisi'), {
                        // ckfinder: {
                        //     uploadUrl: "{{ route('ckberita.upload', ['_token' => csrf_token()]) }}",
                        // }
                    })
                    .then(editor => {
                        visiEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
                var sambutanKep;
                ClassicEditor
                    .create(document.querySelector('#sambutanKepsek'), {
                        // ckfinder: {
                        //     uploadUrl: "{{ route('ckberita.upload', ['_token' => csrf_token()]) }}",
                        // }
                    })
                    .then(editor => {
                        sambutanKep = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
                var misiEditor;
                ClassicEditor
                    .create(document.querySelector('#isiMisi'), {
                        // ckfinder: {
                        //     uploadUrl: "{{ route('ckberita.upload', ['_token' => csrf_token()]) }}",
                        // }
                    })
                    .then(editor => {
                        misiEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });


                // Fungsi Show Modal Profil
                $(document).on('click', '#bt-edit-profil', function(e) {
                    e.preventDefault();

                    modalProfilSekolah.modal('show');
                    updateModal('Edit Data Profil',
                        `<button type="button" class="btn btn-danger me-2" id="hapusProfil">Hapus</button><button type="submit" class="btn btn-primary" id="ubahDataProfil">Simpan</button>`
                    );
                    method.val('PUT');

                    var idProfil = $(this).val();
                    $('#hapusProfil').val(idProfil);

                    // console.log(idProfil);
                    formProfilSekolah.attr('action', '{!! url('profil/update') !!}/' + idProfil);

                    $.ajax({
                        type: "GET",
                        url: "{{ url('profil/edit') }}/" + idProfil,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            // Set the form fields with the fetched data
                            id.val(response.profil.idProfil);
                            myEditor.setData(response.profil.deskripsi);
                            var image =
                                `{{ asset('storage/${response.profil.gambar}') }}`;
                            imgPrev.style.display = 'block';
                            imgPrev.src = image;
                        }
                    });
                });

                // Fungsi Show Modal Sejarah
                $(document).on('click', '#bt-edit-sejarah', function(e) {
                    e.preventDefault();

                    modalProfilSekolah.modal('show');
                    updateModal('Edit Data Sejarah',
                        `<button type="button" class="btn btn-danger me-2" id="hapusSejarah">Hapus</button><button type="submit" class="btn btn-primary" id="ubahDataSejarah">Simpan</button>`
                    );
                    method.val('PUT');

                    var idProfil = $(this).val();
                    $('#hapusSejarah').val(idProfil);
                    // console.log(idProfil);
                    formProfilSekolah.attr('action', '{!! url('profil-sejarah/update') !!}/' + idProfil);

                    $.ajax({
                        type: "GET",
                        url: "{{ url('profil/edit') }}/" + idProfil,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            // Set the form fields with the fetched data
                            id.val(response.profil.idProfil);
                            myEditor.setData(response.profil.sejarahText);
                            var image =
                                `{{ asset('storage/${response.profil.sejarahImg}') }}`;
                            imgPrev.style.display = 'block';
                            imgPrev.src = image;
                        }
                    });
                });

                // Fungsi Show Modal Struktur Organisasi
                $(document).on('click', '#bt-edit-organisasi', function(e) {
                    e.preventDefault();

                    modalProfilSekolah.modal('show');
                    updateModal('Edit Data Struktur Organisai',
                        `<button type="button" class="btn btn-danger me-2" id="hapusOrg">Hapus</button><button type="submit" class="btn btn-primary" id="ubahDataOrganisai">Simpan</button>`
                    );
                    method.val('PUT');

                    var idProfil = $(this).val();
                    $('#hapusOrg').val(idProfil);
                    // console.log(idProfil);
                    formProfilSekolah.attr('action', '{!! url('profil-organisai/update') !!}/' + idProfil);

                    $.ajax({
                        type: "GET",
                        url: "{{ url('profil/edit') }}/" + idProfil,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            // Set the form fields with the fetched data
                            id.val(response.profil.idProfil);
                            myEditor.setData(response.profil.strukturOrgText);
                            var image =
                                `{{ asset('storage/${response.profil.strukturOrgImg}') }}`;
                            imgPrev.style.display = 'block';
                            imgPrev.src = image;
                        }
                    });
                });

                // Fungsi Show Modal Keuangan
                $(document).on('click', '#bt-edit-keuangan', function(e) {
                    e.preventDefault();

                    modalProfilSekolah.modal('show');
                    updateModal('Edit Data Keuangan',
                        `<button type="button" class="btn btn-danger me-2" id="hapusKeu">Hapus</button><button type="submit" class="btn btn-primary" id="ubahDataKeuangan">Simpan</button>`
                    );
                    method.val('PUT');

                    var idProfil = $(this).val();
                    $('#hapusKeu').val(idProfil);
                    // console.log(idProfil);
                    formProfilSekolah.attr('action', '{!! url('profil-keuangan/update') !!}/' + idProfil);

                    $.ajax({
                        type: "GET",
                        url: "{{ url('profil/edit') }}/" + idProfil,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            // Set the form fields with the fetched data
                            id.val(response.profil.idProfil);
                            myEditor.setData(response.profil.keuanganText);
                            var image =
                                `{{ asset('storage/${response.profil.keuanganImg}') }}`;
                            imgPrev.style.display = 'block';
                            imgPrev.src = image;
                        }
                    });
                });

                // Fungsi Show Modal Visi Misi
                $(document).on('click', '#bt-edit-visimisi', function(e) {
                    e.preventDefault();

                    modalVM.modal('show');
                    modalTitleVM.text('Edit Data Visi Misi');

                    methodVM.val('PUT');

                    var idProfil = $(this).val();
                    // console.log(idProfil);
                    formVisiMisi.attr('action', '{!! url('profil-visimisi/update') !!}/' + idProfil);

                    $.ajax({
                        type: "GET",
                        url: "{{ url('profil/edit') }}/" + idProfil,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            // Set the form fields with the fetched data
                            id.val(response.profil.idProfil);
                            visiEditor.setData(response.profil.visi);
                            misiEditor.setData(response.profil.misi);
                        }
                    });
                });

                // Fungsi Show Modal Sambutan
                $(document).on('click', '#bt-edit-sambutan', function(e) {
                    e.preventDefault();

                    modalSambutan.modal('show');
                    modalTitleSambutan.text('Edit Data Sambutan');

                    methodSambutan.val('PUT');

                    var idProfil = $(this).val();
                    // console.log(idProfil);
                    formSambutan.attr('action', `{{ url('profil-sambutan/update/${idProfil}') }}`);

                    $.ajax({
                        type: "GET",
                        url: `{{ url('profil/edit/${idProfil}') }}`,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            // Set the form fields with the fetched data
                            id.val(response.profil.idProfil);
                            sambutanKep.setData(response.profil.sambutanKepsek);
                        }
                    });
                });

                // Fungsi Edit Profil
                $(document).on('click', '#ubahDataProfil', function(e) {
                    e.preventDefault();

                    simpanPerubahan();
                });

                // Fungsi Edit Sejarah
                $(document).on('click', '#ubahDataSejarah', function(e) {
                    e.preventDefault();

                    simpanPerubahan();
                });

                // Fungsi Edit Struktur Organisasi
                $(document).on('click', '#ubahDataOrganisai', function(e) {
                    e.preventDefault();

                    simpanPerubahan();
                });

                // Fungsi Edit Keuangan
                $(document).on('click', '#ubahDataKeuangan', function(e) {
                    e.preventDefault();

                    simpanPerubahan();
                });

                // Fungsi Edit visi misi
                $(document).on('click', '#ubahDataVisiMisi', function(e) {
                    e.preventDefault();

                    var data = new FormData(formVisiMisi[0]);
                    var visi = visiEditor.getData();
                    var misi = misiEditor.getData();
                    data.append('isiVisi', visi);
                    data.append('isiMisi', misi);

                    $.ajax({
                        type: 'POST',
                        url: formVisiMisi.attr('action'),
                        data: data,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });

                            modalVM.modal('hide');
                            resetForm();
                            fetchProfilData();
                        },
                    });
                });

                // Fungsi Edit sambutan
                $(document).on('click', '#ubahDataSambutan', function(e) {
                    e.preventDefault();

                    var data = new FormData(formSambutan[0]);
                    var dataSambutan = sambutanKep.getData();
                    data.append('sambutanKepsek', dataSambutan);

                    $.ajax({
                        type: 'POST',
                        url: formSambutan.attr('action'),
                        data: data,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                            modalSambutan.modal('hide');
                            resetForm();
                            fetchProfilData();
                        },
                    });
                });

                // Fungsi hapus Visi Misi
                $(document).on('click', '#hapusDataVisiMisi', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Menghapus data Visi dan Misi',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            resetForm();

                            var data = new FormData(formProfilSekolah[0]);
                            var visi = visiEditor.getData();
                            var misi = misiEditor.getData();
                            data.append('isiVisi', visi);
                            data.append('isiMisi', misi);

                            $.ajax({
                                type: 'POST',
                                url: formVisiMisi.attr('action'),
                                data: data,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });

                                    modalVM.modal('hide');
                                    resetForm();
                                    fetchProfilData();
                                },
                            });
                        }
                    });
                });
                $(document).on('click', '#hapusDataSambutan', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Menghapus Sambutan Kepala Sekolah',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            resetForm();

                            var data = new FormData($('#formSambutan')[0]);
                            var sam = sambutanKep.getData();
                            data.append('sambutanKepsek', sam);

                            $.ajax({
                                type: 'POST',
                                url: $('#formSambutan').attr('action'),
                                data: data,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });

                                    modalSambutan.modal('hide');
                                    resetForm();
                                    fetchProfilData();
                                },
                            });
                        }
                    });
                });

                // Fungsi hapus Profil
                $(document).on('click', '#hapusProfil', function(e) {
                    e.preventDefault();

                    var id = $(this).val();
                    var url = `{{ url('profil/delete/${id}') }}`;
                    var name = 'Profil Sekolah';
                    hapusData(name, url);
                });

                // Fungsi hapus Sejarah
                $(document).on('click', '#hapusSejarah', function(e) {
                    e.preventDefault();

                    var id = $(this).val();
                    var url = `{{ url('profil-sejarah/delete/${id}') }}`;
                    var name = 'Sejarah Sekolah';
                    hapusData(name, url);
                });

                // Fungsi hapus Struktur Organisasi
                $(document).on('click', '#hapusOrg', function(e) {
                    e.preventDefault();

                    var id = $(this).val();
                    var url = `{{ url('profil-organisasi/delete/${id}') }}`;
                    var name = 'Struktur Organisasi Sekolah';
                    hapusData(name, url);
                });

                // Fungsi hapus Keuangan
                $(document).on('click', '#hapusKeu', function(e) {
                    e.preventDefault();

                    var id = $(this).val();
                    var url = `{{ url('profil-keuangan/delete/${id}') }}`;
                    var name = 'Laporan Keuangan Sekolah';
                    hapusData(name, url);
                });
            });
        </script>
    @endpush
@endsection
