@extends('siakad.layouts.app')
@section('siakad')
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Daftar Berita</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-success" data-toggle="block-option" id="insertBerita"><i
                            class="me-2 fa fa-plus"></i><span>Tambah</span></button>
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
                const id = $('#idBerita');
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

                $('form[name=formBerita]').submit(function(event) {
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
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                            modalBerita.modal('hide');
                            resetForm();
                            tabelBerita.DataTable().ajax.reload();
                        },
                    });
                });


                function resetForm() {
                    myEditor.setData('');
                    imgPrev.style.display = 'none';
                    formBerita.trigger('reset');
                    myEditor.setData('');
                    $('#judulBeritaError').text('');
                }


                function updateModal(title, button) {
                    modalTitle.text(title);
                    btModal.html(button);
                }

                function formatWaktu(waktu) {
                    return moment(waktu).format('DD/MM/YYYY hh:mm A');
                }


                modalBerita.on('hidden.bs.modal', function() {
                    // Reset form
                    resetForm()
                });

                btnInsert.click(() => {
                    modalBerita.modal('show');
                    formBerita.attr('action', '{!! url('berita/store') !!}');
                    updateModal('Tambah Berita',
                        `<button type="button" class="btn btn-secondary me-2 close-berita-modal" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary" id="tambahBerita">Simpan</button>`
                    );
                    method.val('POST');
                });

                $(document).on('click', '#action-editBerita', function(e) {
                    e.preventDefault();

                    modalBerita.modal('show');
                    updateModal('Edit Berita',
                        `<button type="button" class="btn btn-secondary me-2 close-berita-modal" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary" id="ubahBerita">Simpan</button>`
                    );
                    method.val('PUT');

                    var slug = $(this).val();
                    // console.log(idBerita);
                    formBerita.attr('action', '{!! url('berita/update') !!}/' + slug);

                    $.ajax({
                        type: "GET",
                        url: `{{ url('berita/edit/${slug}') }}`,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            console.log(response);
                            // Set the form fields with the fetched data
                            id.val(response.berita.idBerita);
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
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });

                            modalBerita.modal('hide');
                            resetForm();
                            tabelBerita.DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;
                            // Handle errors as needed
                        }
                    });
                });

                $(document).on('click', '#action-hapusBerita', function(e) {
                    e.preventDefault();
                    var id = $(this).val();
                    var nama = $(this).data('nama-judul');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Menghapus data ' + nama + '',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: "DELETE",
                                url: "{{ url('berita/destroy') }}/" + id,
                                dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus!',
                                        text: response.message,
                                    });
                                    $('#tabelBerita').DataTable().ajax.reload();
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Data gagal dihapus.',
                                    });
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

                                return `<div class="rounded-2 p-1" style="border: 2px dashed #dfe3ea; overflow:hidden;">
                                    <a href="${imageUrl ?? '#'}" class="popup-link-berita" id="pop-up-${row.idBerita}" title="View Image">
                                            <div class="ratio ratio-16x9">
                                                    <img src="${imageUrl ?? null}" class="object-fit-cover flex-shrink-0 rounded-2">
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
