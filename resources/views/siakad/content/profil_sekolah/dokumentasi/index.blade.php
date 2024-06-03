@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="block block-rounded">
            <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="tabs-foto" data-bs-toggle="tab" data-bs-target="#daftarFoto"
                        role="tab" aria-controls="daftarFoto" aria-selected="true">Foto</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tabs-video" data-bs-toggle="tab" data-bs-target="#daftarVideo"
                        role="tab" aria-controls="daftarVideo" aria-selected="false">Video</button>
                </li>
                <li class="nav-item ms-auto">
                    <div class="nav-link p-1 me-3">
                        <button class="btn btn-sm btn-alt-success" data-toggle="block-option" id="insertFoto"><i
                                class="me-2 fa fa-plus"></i><span>Tambah Dokumentasi</span></button>
                    </div>
                </li>
            </ul>
            <div class="block-content tab-content overflow-hidden p-0">
                <div class="tab-pane fade fade-left show active" id="daftarFoto" role="tabpanel" aria-labelledby="tabs-foto"
                    tabindex="0">
                    <div class="table-responsive  m-md-0 m-4 p-md-4 p-0">
                        <table id="tabelFoto" class="table w-100 table-hover table-borderless align-middle">
                            <thead class="table-primary align-middle">
                                <tr class="text-center fw-medium fs-sm">
                                    <th width="4%">No</th>
                                    <th width="15%">Gambar</th>
                                    <th>Judul</th>
                                    <th width="18%">Tanggal</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade fade-left" id="daftarVideo" role="tabpanel" aria-labelledby="tabs-video"
                    tabindex="0">
                    <div class="table-responsive  m-md-0 m-4 p-md-4 p-0">
                        <table id="tabelVideo" class="table w-100 table-hover table-borderless align-middle table-">
                            <thead class="table-primary align-middle">
                                <tr class="text-center fw-medium fs-sm">
                                    <th width="4%">No</th>
                                    <th width="15%">Video</th>
                                    <th>Judul</th>
                                    <th width="18%">Tanggal</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- MOAL --}}
    @include('siakad/content/profil_sekolah/dokumentasi/modal')

    @push('scripts')
        <script>
            $(document).ready(function() {
                const btInsertFoto = $('#insertFoto');
                const tableFoto = $('#tabelFoto');
                const tableVideo = $('#tabelVideo');
                const waktu = $('#waktu');
                const modalDocFoto = $('#modalDokumentasi');
                const method = $('#method');
                const modalTitle = $("#modal-title");
                const btModal = $('#btn-form');
                const formDock = $('#formDokumentasi');
                const tabVideo = $('#daftarVideo');
                const tabFoto = $('#daftarFoto');

                const id = $('#idDokumentasi');
                const judulDokumentasi = $('#judulDokumentasi');
                const kategori = $('#kategoriMedia');
                const gambarDock = $('#gambarDokumentasi');
                const vidDock = $('#linkVideo');

                const imgPrev = document.querySelector('.img-preview');
                const kt = document.getElementById('kategoriMedia');

                new AirDatepicker('#waktu', {
                    container: '#modalDokumentasi',
                    autoClose: true,
                    // selectedDates: [new Date()],
                    position: 'bottom center',
                    timepicker: true,
                    timeFormat: 'hh:mm AA',
                });

                $(document).on('click', '#tabs-video', function() {
                    tableVideo.DataTable().draw();
                    tableVideo.DataTable().columns.adjust().responsive.recalc();
                });

                modalDocFoto.on('hidden.bs.modal', function() {
                    // Reset form
                    resetForm()
                });

                judulDokumentasi.on('input', function() {
                    var judulDokumentasiValue = $(this).val();
                    if (judulDokumentasiValue.length > 225) {
                        $('#judulDokumentasiError').text('Judul tidak boleh lebih dari 225 karakter.');
                    } else {
                        $('#judulDokumentasiError').text('');
                    }
                });

                waktu.on('input', function() {
                    var inputValue = $(this).val();
                    var numericValue = inputValue.replace(/\D/g, ''); // Menghilangkan karakter non-angka
                    $(this).val(numericValue);
                });

                function updateModal(title, button) {
                    modalTitle.text(title);
                    btModal.html(button);
                }

                function formatWaktu(waktu) {
                    return moment(waktu).format('DD/MM/YYYY hh:mm A');
                }

                function resetForm() {
                    imgPrev.style.display = 'none';
                    formDock.trigger('reset');
                    $('#judulDokumentasiError').text('');
                    kt.disabled = false;
                }

                btInsertFoto.click(() => {
                    modalDocFoto.modal('show');
                    formDock.attr('action', '{{ route('dock.store') }}');
                    updateModal('Tambah Data',
                        `<button type="button" class="btn btn-secondary me-2 close-berita-modal" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary" id="addFoto">Simpan</button>`
                    );
                    method.val('POST');
                    disabledInput();
                });


                $('form[name=formDokumentasi]').submit(function(e) {
                    // Pastikan bahwa formulir tidak benar-benar dikirim.
                    e.preventDefault();

                    var data = new FormData(formDock[0]);
                    // console.log($('#waktu').val());

                    $.ajax({
                        type: "POST",
                        url: formDock.attr('action'),
                        data: data,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                modalDocFoto.modal('hide');
                                resetForm();
                                tableFoto.DataTable().ajax.reload();
                                tableVideo.DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        },
                    });
                });

                $(document).on('click', '#action-editFoto', function(e) {
                    e.preventDefault();

                    modalDocFoto.modal('show');
                    updateModal('Edit Data',
                        `<button type="button" class="btn btn-secondary me-2 close-berita-modal" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary" id="ubahFoto">Simpan</button>`
                    );
                    method.val('PUT');
                    kt.disabled = true;
                    // gambarDokumentasi.disabled = false;

                    var idDock = $(this).val();
                    // console.log(idDock);
                    formDock.attr('action', `{{ url('dock/update/${idDock}') }}`);
                    var url = `{{ url('dock/edit/${idDock}') }}`;

                    $.ajax({
                        type: "GET",
                        url: url,
                        success: function(response) {
                            // Set the form fields with the fetched data
                            id.val(response.dock.idDokumentasi);
                            judulDokumentasi.val(response.dock.judul);;
                            kategori.val(response.dock.kategoriMedia);

                            if (response.dock.kategoriMedia === 'Video') {
                                // Enable videoLink and disable gambarDokumentasi
                                videoLink.disabled = false;
                                gambarDokumentasi.disabled = true;
                                imgPrev.style.display = 'none';
                                vidDock.val(`https://youtu.be/${response.dock.media}`);
                            } else {
                                // Enable gambarDokumentasi and disable videoLink
                                videoLink.disabled = true;
                                gambarDokumentasi.disabled = false;
                                imgPrev.style.display = 'block';
                                var image = response.dock.media;
                                if (image && fileExists(`{!! asset('storage/${image}') !!}`)) {
                                    image = `{!! asset('storage/${image}') !!}`; // Tampilkan URL image
                                } else {
                                    image = `{!! asset('assets/media/img/empty-image.jpg') !!}`; // Atur URL imageUrl default
                                }
                                imgPrev.src = image;
                            }
                            var formatedWaktu = formatWaktu(response.dock.waktu);
                            waktu.val(formatedWaktu);
                        }
                    });
                });

                $(document).on('click', '#ubahFoto', function(e) {
                    e.preventDefault();

                    var data = new FormData(formDock[0]);

                    $.ajax({
                        type: 'POST',
                        url: formDock.attr('action'),
                        data: data,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                modalDocFoto.modal('hide');
                                resetForm();
                                tableFoto.DataTable().ajax.reload();
                                tableVideo.DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: response.status,
                                    title: response.title,
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        },
                    });
                });

                $(document).on('click', '#action-hapusFoto', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-judul');
                    var url = `{{ url('dock/destroy/${id}') }}`;

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus dokumentasi <b>${nama}</b>`,
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
                                    tableFoto.DataTable().ajax.reload();
                                    tableVideo.DataTable().ajax.reload();
                                },
                            });
                        }
                    });
                });

                tableFoto.DataTable({
                    ajax: "{{ route('dock.get-data') }}",
                    columns: [{
                            data: 'nomor',
                            name: 'nomor',
                            className: 'text-center fw-semibold rounded-start'

                        },
                        {
                            data: 'media',
                            render: function(data, type, row) {
                                var image = row.media;
                                if (image && fileExists(`{!! asset('storage/${image}') !!}`)) {
                                    image = `{!! asset('storage/${image}') !!}`; // Tampilkan URL image
                                } else {
                                    image = `{!! asset('assets/media/img/empty-image.jpg') !!}`; // Atur URL imageUrl default
                                }

                                $('.popup-link-foto').magnificPopup({
                                    type: 'image',
                                    mainClass: 'mfp-with-zoom',
                                    gallery: {
                                        enabled: true,
                                        navigateByImgClick: true,
                                    },
                                    zoom: {
                                        enabled: true,
                                    }
                                });

                                return `<div class="rounded-2" style="border: 2px dashed #dfe3ea; overflow:hidden;">
                                    <a href="${image ?? '#'}" class="popup-link-foto" id="pop-up-${row.idDokumentasi}" title="View Image">
                                            <div class="ratio ratio-16x9">
                                                    <img src="${image}" class="object-fit-cover flex-shrink-0 rounded">
                                                    </div>
                                                    </a>
                                        </div>`;

                            },
                            searchable: false,
                        },
                        {
                            data: 'judul',
                            name: 'judul',
                            className: 'fw-semibold align-top'
                        },
                        {
                            data: 'waktu',
                            name: 'waktu',
                        },

                        {
                            data: null,
                            className: 'rounded-end',
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editFoto" value="' +
                                    data.idDokumentasi + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusFoto" title="Delete" value="' +
                                    data.idDokumentasi + '" data-nama-judul="' + data.judul + '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25],
                });

                tableVideo.DataTable({
                    ajax: "{{ route('dock.get-data.video') }}",
                    columns: [{
                            data: 'nomor',
                            name: 'nomor',
                            className: 'text-center fw-semibold rounded-start',
                            width: '5%',

                        },
                        {
                            data: 'media',
                            render: function(data, type, row) {

                                $('.popup-link-video').magnificPopup({
                                    type: 'iframe',
                                    mainClass: 'mfp-with-zoom',
                                    zoom: {
                                        enabled: true,
                                    }
                                });

                                return `<div class="rounded-2 position-relative" style="border: 2px dashed #dfe3ea; overflow:hidden;">
                                            <div class="ratio ratio-16x9">
                                                <iframe width="560" height="315"
                                                src="https://www.youtube.com/embed/${row.media}?controls=0&showinfo=0&modestbranding=1">
                                                </iframe>
                                            </div>
                                            <a href="https://www.youtube.com/watch?v=${row.media}" class="popup-link-video btn btn-sm m-2 btn-alt-info d position-absolute bottom-0 end-0" id="pop-up-${row.idDokumentasi}" title="View Video">View</a>
                                        </div>`;
                            },
                            searchable: false,
                        },
                        {
                            data: 'judul',
                            name: 'judul',
                            className: 'fw-semibold align-top'
                        },
                        {
                            data: 'waktu',
                            name: 'waktu',
                        },

                        {
                            data: null,
                            className: 'rounded-end',
                            render: function(data, type, row) {
                                return '<div class="btn-group">' +
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editFoto" value="' +
                                    data.idDokumentasi + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusFoto" title="Delete" value="' +
                                    data.idDokumentasi + '" data-nama-judul="' + data.judul + '">' +
                                    '<i class="fa fa-fw fa-times"></i></button>' +
                                    '</div>';
                            }
                        }
                    ],
                    dom: "<'row mb-2 '<'col-12 col-sm-12 col-md-6'l><'col-12 col-sm-12 col-md-6'f>>" +
                        "<'row my-2 '<'col-12 col-sm-12'tr>>" +
                        "<'row'<'col-12 col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    lengthMenu: [10, 25],
                    columnDefs: [{
                        width: '5%',
                        targets: 0
                    }],
                });

            });
        </script>
    @endpush
@endsection
