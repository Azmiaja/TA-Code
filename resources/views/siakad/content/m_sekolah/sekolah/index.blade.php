@extends('siakad/layouts/app')
@section('siakad')
    @push('style')
        <style>
            .table tbody th {
                width: 20%;
                background-color: #eaedf1;
                ;
            }

            .table tbody td {
                width: 70%;
            }
        </style>
    @endpush
    @include('siakad/layouts/partials/hero')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Data Informasi Sekolah</h3>
                <div class="block-options">
                    <button class="btn btn-sm btn-alt-warning" data-toggle="block-option" id="updateData">
                        <i class="fa-solid fa-pen-to-square me-2"></i><span>Edit Data Sekolah</span></button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="row g-3">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">Nama Sekolah</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7" id="nama_sekolah"></div>
                        </div>
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">NPSN</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7" id="npsn"></div>
                        </div>
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">Alamat</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7 overflow-hidden" style="word-wrap: break-word;" id="alamat"></div>
                        </div>
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">Desa</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7" id="desa"></div>
                        </div>
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">Kecamatan</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7" id="kecamatan"></div>
                        </div>
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">Kabupaten</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7" id="kabupaten"></div>
                        </div>
                        <div class="d-flex flex-row py-2">
                            <div class="col-4 fw-semibold">Provinsi</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7" id="provinsi"></div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-6 col-12">
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">Kode Pos</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7" id="kode_pos"></div>
                        </div>
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">Telepon</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7" id="telepon"></div>
                        </div>
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">Website</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7 overflow-hidden" style="word-wrap: break-word;" id="website"></div>
                        </div>
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">Email</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7 overflow-hidden" style="word-wrap: break-word;" id="email"></div>
                        </div>
                        <div class="d-flex flex-row mb-3 py-2">
                            <div class="col-4 fw-semibold">Maps Link</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7 overflow-hidden" style="word-wrap: break-word;" id="maps_link"></div>
                        </div>
                        <div class="d-flex flex-row py-2">
                            <div class="col-4 fw-semibold">Slogan</div>
                            <div class="col-1 fw-semibold">:</div>
                            <div class="col-7 overflow-hidden" style="word-wrap: break-word;" id="slogan"></div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-12">
                        <div class="row g-3">
                            <div class="col-lg-12 col-sm-6 col-12">
                                <div>
                                    <figure class="figure w-100">
                                        <figcaption class="fw-semibold mb-2">Logo Sekolah</figcaption>
                                        <div class="ratio ratio-1x1 rounded p-1" style="border: 2px dashed #dfe3ea;">
                                            <img src="" id="logo" class="figure-img img-fluid rounded"
                                                alt="Logo">
                                        </div>
                                    </figure>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-6 col-12">
                                <div>
                                    <figure class="figure w-100">
                                        <figcaption class="fw-semibold mb-2">Maps Embed</figcaption>
                                        <div id="maps_embed" style="border: 2px dashed #dfe3ea;" class="rounded p-1"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('siakad/content/m_sekolah/sekolah/modal')
    @push('style')
        <style>
            #maps_embed {
                width: 100%;
                display: flex
            }

            #maps_embed iframe {
                width: 100%;
                height: 15rem;
                border-radius: .375rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                const tbl_namsklh = document.getElementById('nama_sekolah');
                const tbl_npsn = document.getElementById('npsn');
                const tbl_alamat = document.getElementById('alamat');
                const tbl_desa = document.getElementById('desa');
                const tbl_kec = document.getElementById('kecamatan');
                const tbl_kab = document.getElementById('kabupaten');
                const tbl_prov = document.getElementById('provinsi');
                const tbl_kdpos = document.getElementById('kode_pos');
                const tbl_telp = document.getElementById('telepon');
                const tbl_web = document.getElementById('website');
                const tbl_email = document.getElementById('email');
                const tbl_slogan = document.getElementById('slogan');
                const tbl_logo = document.getElementById('logo');
                const tbl_mlink = document.getElementById('maps_link');
                const tbl_membed = document.getElementById('maps_embed');

                const modalSekolah = $("#modalSekolah");
                const formSekolah = $("#formSekolah");

                const idSekolah = $("#idSekolah");
                const nama = $("#fm_namaSekolah");
                const npsn = $("#fm_npsn");
                const alamat = $("#fm_alamat");
                const desa = $("#fm_desa");
                const kecamatan = $("#fm_kecamatan");
                const kabupaten = $("#fm_kabupaten");
                const prov = $("#fm_provinsi");
                const kd_pos = $("#fm_kodePos");
                const telp = $("#fm_telp");
                const web = $("#fm_website");
                const email = $("#fm_email");
                const slogan = $("#fm_slogan");
                const mp_link = $("#fm_mapsLink");
                const mp_embed = $("#fm_mapsEmbed");
                const logo = $("#logoSekolah");
                const imgPrev = document.querySelector('.img-preview');


                $('#fileButton').click(function() {
                    $('#logoSekolah').click();
                });

                fetchDataSekolah();

                function fetchDataSekolah() {
                    // Lakukan AJAX request ke endpoint yang telah dibuat
                    var url = '{!! url('sekolah/get-data') !!}';
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            tbl_namsklh.innerHTML = data.namaSekolah ?? '<em><u>null<u></em>';
                            tbl_npsn.innerHTML = data.npsn ?? '<em><u>null<u></em>';
                            tbl_alamat.innerHTML = data.alamat ?? '<em><u>null<u></em>';
                            tbl_desa.innerHTML = data.desa ?? '<em><u>null<u></em>';
                            tbl_kec.innerHTML = data.kec ?? '<em><u>null<u></em>';
                            tbl_kab.innerHTML = data.kab ?? '<em><u>null<u></em>';
                            tbl_prov.innerHTML = data.prov ?? '<em><u>null<u></em>';
                            tbl_kdpos.innerHTML = data.kd_pos ?? '<em><u>null<u></em>';
                            tbl_telp.innerHTML = data.telp ?? '<em><u>null<u></em>';
                            tbl_web.innerHTML = data.web ?? '<em><u>null<u></em>';
                            tbl_email.innerHTML = data.email ?? '<em><u>null<u></em>';
                            tbl_slogan.innerHTML = data.slogan ?? '<em><u>null<u></em>';
                            tbl_logo.src = data.logo;
                            tbl_mlink.innerHTML = data.mapsLink ?? '<em><u>null<u></em>';
                            $(tbl_membed).html(data.mapsEmbed ?? '<iframe></iframe>');

                            $('#updateData').val(data.idSekolah);
                        });
                }

                modalSekolah.on('hidden.bs.modal', function() {
                    imgPrev.style.display = 'none';
                    formSekolah.trigger('reset');
                });

                $(document).on('click', '#updateData', function(e) {
                    e.preventDefault();

                    modalSekolah.modal('show');
                    $('#modal-title').text('Ubah Data Sekolah');

                    var id = $(this).val();
                    formSekolah.attr('action', `{{ url('sekolah/update/${id}') }}`);

                    $.ajax({
                        type: "GET",
                        url: `{!! url('sekolah/get-data') !!}`,
                        headers: {
                            "Cache-Control": "no-cache, no-store, must-revalidate",
                            "Pragma": "no-cache"
                        },
                        success: function(response) {
                            // Set the form fields with the fetched data
                            // console.log(response);
                            idSekolah.val(response.idSekolah);
                            nama.val(response.namaSekolah);
                            alamat.val(response.alamat);
                            desa.val(response.desa);
                            kecamatan.val(response.kec);
                            npsn.val(response.npsn);
                            kabupaten.val(response.kab);
                            prov.val(response.prov);
                            kd_pos.val(response.kd_pos);
                            telp.val(response.telp);
                            web.val(response.web);
                            email.val(response.email);
                            slogan.val(response.slogan);
                            mp_link.val(response.mapsLink);
                            mp_embed.val(response.mapsEmbed);
                            // var image =
                            //     `{{ asset('storage/${response.profil.gambar}') }}`;
                            imgPrev.style.display = 'block';
                            imgPrev.src = response.logo;
                        }
                    });
                });

                formSekolah.submit(function(e) {
                    e.preventDefault();

                    var data = new FormData(formSekolah[0]);

                    $.ajax({
                        type: 'POST',
                        url: formSekolah.attr('action'),
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

                            modalSekolah.modal('hide');
                            fetchDataSekolah();
                        },
                    });
                });



            });
        </script>
    @endpush
@endsection
