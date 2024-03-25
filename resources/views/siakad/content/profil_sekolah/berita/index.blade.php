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
                        <thead class="bg-gray-light align-middle">
                            <tr class="text-center fw-medium fs-sm">
                                <th style="width: 5%">No</th>
                                <th style="min-width: 23%">Gambar</th>
                                <th>Judul</th>
                                <th style="width: 16%;">Tanggal</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

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

                var myEditor;
                ClassicEditor
                    .create(document.querySelector('#isiBerita'), {
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

                new AirDatepicker('#waktu', {
                    container: '#modalBerita',
                    autoClose: true,
                    // selectedDates: [new Date()],
                    position: 'bottom center',
                    timepicker: true,
                    timeFormat: 'hh:mm AA',
                });

                judulBerita.on('input', function() {
                    var judulBeritaValue = $(this).val();
                    if (judulBeritaValue.length > 225) {
                        $('#judulBeritaError').text('Judul tidak boleh lebih dari 225 karakter.');
                    } else {
                        $('#judulBeritaError').text('');
                    }
                });

                waktu.on('input', function() {
                    var inputValue = $(this).val();
                    var numericValue = inputValue.replace(/\D/g, ''); // Menghilangkan karakter non-angka
                    $(this).val(numericValue);
                });

                formBerita.submit(function(event) {
                    // Pastikan bahwa formulir tidak benar-benar dikirim.
                    event.preventDefault();

                    var judulBeritaValue = $('#judulBerita').val();
                    if (judulBeritaValue.length > 225) {
                        $('#judulBeritaError').text('Judul tidak boleh lebih dari 225 karakter.');
                        return false; // Formulir tidak dikirim
                    }

                    var data = new FormData(formBerita[0]);
                    var isiBerita = myEditor.getData();
                    data.append('isiBerita', isiBerita);

                    $.ajax({
                        type: "POST",
                        url: formBerita.attr('action'),
                        data: data,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                            modalBerita.modal('hide');
                            tabelBerita.DataTable().ajax.reload();
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
                        $('#judulBeritaError').text('');
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
                                var image = `{{ asset('storage/${response.berita.gambar}') }}`;
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
                    data.append('isiBerita', isiBerita);

                    $.ajax({
                        type: 'POST',
                        url: formBerita.attr('action'),
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

                            modalBerita.modal('hide');
                            tabelBerita.DataTable().ajax.reload();
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
                            className: 'text-center fw-medium rounded-start'

                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                var imageUrl = `{{ asset('storage/${row.gambar}') }}`;
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
                                    <a href="${imageUrl ?? '#'}" class="popup-link-berita" id="pop-up-${row.idBerita}" title="View Image">
                                            <div class="ratio ratio-16x9">
                                                    <img src="${imageUrl ?? null}" style="width: 100%; height: 100%; object-fit: cover;" class="flex-shrink-0 rounded-2">
                                                    </div>
                                                    </a>
                                        </div>`;
                            },
                            searchable: false,
                        },
                        {
                            data: 'judulBerita',
                            name: 'judulBerita',
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
