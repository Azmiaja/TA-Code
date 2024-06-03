@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Daftar Berita</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-success" data-toggle="block-option" id="insertBerita"><i
                            class="me-2 fa fa-plus"></i><span>Tambah Berita</span></button>
                </div>
            </div>
            <div class="block-content block-content-full p-0">
                <div class="table-responsive p-3">
                    <table id="tabelBerita" class="table w-100 table-hover table-borderless align-middle table-">
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
        </div>
    </div>

    
    <style>
        body {
            /* ckEditor5 */
            --ck-z-default: 100;
            --ck-z-panel: calc(var(--ck-z-default) + 999);
        }
    </style>
    {{-- MOAL --}}
    @include('siakad/content/profil_sekolah/berita/modal-berita')


    @push('scripts')
        <script>
            $(document).ready(function() {


                const modalBerita = $('#modalBerita');
                const formBerita = $('#formBerita');
                const modalTitle = $("#modal-title");
                const btnInsert = $('#insertBerita');
                const judulBerita = $('#judulBerita');
                const waktu = $('#waktu');
                const idBerita = $('#idBerita');
                const imgPrev = document.querySelector('.img-preview');
                const btCloseModal = document.querySelector('.close-berita-modal');
                const btModal = $('#btn-form');
                const tambahBerita = $('#tambahBerita');
                const tabelBerita = $('#tabelBerita');
                const method = $('#method');


                var option = {
                    plugins: [
                        'Alignment',
                        'Essentials',
                        'Autoformat',
                        'BlockQuote',
                        'FontFamily',
                        'FontSize',
                        'FontColor',
                        'Highlight',
                        'Bold',
                        'Italic',
                        'Heading',
                        'Link',
                        'List',
                        'Paragraph',
                        'Image',
                        'ImageCaption',
                        'ImageResize',
                        'ImageStyle',
                        'ImageToolbar',
                        'ImageUpload',
                        // 'CkFinder',
                        'Base64UploadAdapter',
                        'Underline',
                        'Italic',
                        'Link',
                        'List',
                        'MediaEmbed',
                        'Paragraph',
                        'Table',
                        'TableColumnResize',
                        'TableToolbar',
                        'Indent',
                        'GeneralHtmlSupport',
                        // 'CKFinderUploadAdapter'
                    ],
                    toolbar: {
                        items: [
                            'undo', 'redo',
                            '|', 'heading',
                            '|',
                            {
                                label: 'Fonts',
                                withText: true,
                                icon: 'text',
                                items: ['fontfamily', 'fontsize', 'fontcolor']
                            },
                            '|',
                            {
                                label: 'Basic styles',
                                withText: true,
                                icon: 'bold',
                                items: ['bold', 'italic', 'underline', 'alignment', 'highlight', 'indent',
                                    'outdent'
                                ]
                            },
                            '|',
                            {
                                label: 'Insert',
                                withText: true,
                                icon: 'plus',
                                items: ['link', 'uploadImage', 'insertTable', ]
                            },
                            '|',
                            {
                                label: 'List',
                                withText: true,
                                icon: false,
                                items: ['bulletedList', 'numberedList', ]
                            },
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph',
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1',
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2',
                            },
                            {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3',
                            },
                            {
                                model: 'heading4',
                                view: 'h4',
                                title: 'Heading 4',
                                class: 'ck-heading_heading4',
                            },
                        ],
                    },
                    image: {
                        styles: ['alignCenter', 'alignLeft', 'alignRight'],
                        resizeOptions: [{
                                name: 'resizeImage:original',
                                label: 'Default image width',
                                value: null,
                            },
                            {
                                name: 'resizeImage:50',
                                label: '50% page width',
                                value: '50',
                            },
                            {
                                name: 'resizeImage:75',
                                label: '75% page width',
                                value: '75',
                            },
                        ],
                        toolbar: [
                            'imageTextAlternative',
                            'toggleImageCaption',
                            '|',
                            'imageStyle:inline',
                            'imageStyle:wrapText',
                            'imageStyle:breakText',
                            'imageStyle:side',
                            '|',
                            'resizeImage',
                        ],
                    },
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells'],
                    },
                    // ckfinder: {
                    //     uploadUrl: "{{ route('ckberita.upload', ['_token' => csrf_token()]) }}",
                    //     options: {
                    //         resourceType: 'Images'
                    //     }
                    // },
                }
                var myEditor;
                ClassicEditor
                    .create(document.querySelector('textarea#isiBerita'), option)
                    .then(editor => {
                        myEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });

                modalBerita.modal({
                    focus: false
                });


                new AirDatepicker('#waktu', {
                    container: '#modalBerita',
                    autoClose: true,
                    // selectedDates: [new Date()],
                    position: 'bottom center',
                    timepicker: true,
                    timeFormat: 'hh:mm AA',
                });

                formBerita.submit(function(event) {
                    // Pastikan bahwa formulir tidak benar-benar dikirim.
                    event.preventDefault();

                    var data = new FormData(formBerita[0]);
                    var isiBerita = myEditor.getData();
                    if (isiBerita === '<p>&nbsp;</p>') {
                        isiBerita = '';
                    }
                    data.append('isiBerita', isiBerita);

                    $.ajax({
                        type: "POST",
                        url: formBerita.attr('action'),
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
                                modalBerita.modal('hide');
                                tabelBerita.DataTable().ajax.reload();
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


                function formatWaktu(waktu) {
                    return moment(waktu).format('DD/MM/YYYY hh:mm A');
                }


                modalBerita.on('hidden.bs.modal', function() {
                    // Reset form
                    resetForm(formBerita, function() {
                        myEditor.setData('');
                        imgPrev.style.display = 'none';
                    });
                });

                showModalInsert(btnInsert, modalBerita, formBerita, `{{ url('berita/store') }}`, method, modalTitle,
                    btModal,
                    'Tambah Berita', `<button type="submit" class="btn btn-primary">Simpan</button>`);

                $(document).on('click', '#action-editBerita', function(e) {
                    e.preventDefault();

                    modalBerita.modal('show');
                    updateModals(modalTitle, btModal, 'Edit Berita',
                        `<button type="submit" class="btn btn-primary" id="ubahBerita">Simpan</button>`
                    );
                    method.val('PUT');

                    var id = $(this).val();
                    // console.log(idBerita);
                    formBerita.attr('action', '{!! url('berita/update') !!}/' + id);

                    $.ajax({
                        type: "GET",
                        url: `{{ url('berita/edit/${id}') }}`,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            // Set the form fields with the fetched data
                            idBerita.val(response.berita.idBerita);
                            judulBerita.val(response.berita.judulBerita);
                            var formatedWaktu = formatWaktu(response.berita.waktu);
                            waktu.val(formatedWaktu);
                            myEditor.setData(response.berita.isiBerita);
                            if (response.berita.gambar == null) {
                                imgPrev.src = '';
                            } else {
                                var image = response.berita.gambar;
                                if (image && fileExists(`{!! asset('storage/${image}') !!}`)) {
                                    image = `{!! asset('storage/${image}') !!}`; // Tampilkan URL image
                                } else {
                                    image = `{!! asset('assets/media/img/empty-image.jpg') !!}`; // Atur URL imageUrl default
                                }
                                imgPrev.style.display = 'block';
                                imgPrev.src = image;
                            }
                        }
                    });
                });

                $(document).on('click', '#ubahBerita', function(e) {
                    e.preventDefault();

                    var data = new FormData(formBerita[0]);
                    var isiBerita = myEditor.getData();
                    if (isiBerita === '<p>&nbsp;</p>') {
                        isiBerita = '';
                    }
                    data.append('isiBerita', isiBerita);

                    $.ajax({
                        type: 'POST',
                        url: formBerita.attr('action'),
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
                                modalBerita.modal('hide');
                                tabelBerita.DataTable().ajax.reload();
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

                $(document).on('click', '#action-hapusBerita', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-judul');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        html: `Menghapus berita <b>${nama}</b>`,
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
                                url: "{{ url('berita/destroy') }}/" + id,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.status,
                                        title: response.title,
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    tabelBerita.DataTable().ajax.reload();
                                }
                            });
                        }
                    });
                });

                tabelBerita.DataTable({
                    ajax: `{{ url('berita/get-data') }}`,
                    columns: [{
                            data: 'nomor',
                            name: 'nomor',
                            className: 'text-center fw-semibold rounded-start'

                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                var imageUrl = row.gambar;

                                if (imageUrl && fileExists(`{!! asset('storage/${imageUrl}') !!}`)) {
                                    imageUrl = `{!! asset('storage/${imageUrl}') !!}`; // Tampilkan URL imageUrl
                                } else {
                                    imageUrl = `{!! asset('assets/media/img/empty-image.jpg') !!}`; // Atur URL imageUrl default
                                }
                                // console.log(inageUrl);

                                $('.popup-link-berita').magnificPopup({
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
                                    <a href="${imageUrl}" class="popup-link-berita" id="pop-up-${row.idBerita}" title="View Image">
                                            <div class="ratio ratio-16x9">
                                                    <img src="${imageUrl}" style="width: 100%; height: 100%; object-fit: cover;" class="flex-shrink-0 rounded-2">
                                                    </div>
                                                    </a>
                                        </div>`;
                            },
                            searchable: false,
                        },
                        {
                            data: 'judulBerita',
                            name: 'judulBerita',
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
                                    '<button type="button" class="btn btn-sm btn-alt-primary" title="Edit" id="action-editBerita" value="' +
                                    data.idBerita + '">' +
                                    '<i class="fa fa-fw fa-pencil-alt"></i></button>' +
                                    '<button type="button" class="btn btn-sm btn-alt-danger" id="action-hapusBerita" title="Delete" value="' +
                                    data.idBerita + '" data-nama-judul="' + data.judulBerita + '">' +
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

            });
        </script>
    @endpush
@endsection
