@extends('company_profil/layouts/app')
@section('app')
    <div class="row my-2 g-3">
        <div class="col-xxl-9 col-lg-8 col-12">
            <div class="row m-0 mb-3">
                <div class="card border-0 rounded p-0 mb-3" style="max-height: 500px;">
                    <img src="https://i.pinimg.com/originals/12/97/a4/1297a454d516f4f0952f471f7eafc323.jpg"
                        class="card-img object-fit-cover w-100" height="100%" alt="Cover Berita">
                    {{-- <svg class="bd-placeholder-img bd-placeholder-img-lg card-img" width="100%" height="100%"
                        xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Card image"
                        preserveAspectRatio="xMidYMid slice" focusable="false">
                        <title>Placeholder</title>
                        <rect width="100%" height="100%" fill="#868e96"></rect><text x="50%" y="50%" fill="#dee2e6"
                            dy=".3em">Content Berita</text>
                    </svg> --}}
                </div>
                <nav class="flex-shrink-0 m-0 p-0" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                      <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('berita') }}">Berita</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">
                        Link judul Lorem ipsum dolor, sit amet consectetur adipisicing.
                      </li>
                    </ol>
                  </nav>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-9 col-12">
                    <div class="text-center fs-sm push mb-5">
                        <h3 class="mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam porro distinctio, vero error iste ipsam accusantium omnis officia, dolorum nesciunt dicta vel necessitatibus? A, odio.</h3>
                        <span class="d-inline-block py-2 px-4 bg-body-light rounded">
                            02 Januari 2024
                        </span>
                    </div>
                    <div class="text-justify story">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique nemo tempora dicta consequatur
                            quas modi, eveniet odio provident ut voluptas. At, dicta? Excepturi odio numquam pariatur
                            perspiciatis maxime quibusdam sequi delectus, sit, natus repellendus dolores ipsa aperiam,
                            dignissimos facilis? Labore in dolores facere! Architecto quibusdam iste maxime dolorum, dolorem
                            esse laudantium nesciunt vitae quis dolores suscipit temporibus alias incidunt modi neque minima
                            necessitatibus perferendis commodi consectetur, quia impedit blanditiis quas expedita tempora.
                            Dolorum natus possimus aperiam tenetur mollitia velit doloribus debitis eligendi quasi
                            consequatur aspernatur doloremque autem perferendis ab nulla reprehenderit quaerat dolores
                            cupiditate, iure aut magnam quidem modi omnis fugit. Magnam temporibus dolore recusandae
                            possimus aliquid odit omnis, animi quasi! Soluta saepe illum facere libero, iste, ratione alias
                            aut nemo quasi obcaecati fugiat illo doloribus magni placeat sed. Perferendis accusantium odit
                            eaque minima earum sunt, tempora placeat laborum culpa qui rerum ullam nostrum ratione
                            consequuntur quia voluptatibus. Veniam repellendus velit error, neque labore a libero laborum
                            quas eaque recusandae sequi, ipsam provident esse officiis asperiores eos? Amet voluptate
                            ducimus rem officia dolorem ex eveniet neque perspiciatis, molestias voluptas perferendis autem
                            sed nulla eius deserunt aperiam! Velit dignissimos ipsam nulla quibusdam dolore dolorem,
                            laboriosam distinctio, nihil eveniet vitae libero ut.</p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique nemo tempora dicta consequatur
                            quas modi, eveniet odio provident ut voluptas. At, dicta? Excepturi odio numquam pariatur
                            perspiciatis maxime quibusdam sequi delectus, sit, natus repellendus dolores ipsa aperiam,
                            dignissimos facilis? Labore in dolores facere! Architecto quibusdam iste maxime dolorum, dolorem
                            esse laudantium nesciunt vitae quis dolores suscipit temporibus alias incidunt modi neque minima
                            necessitatibus perferendis commodi consectetur, quia impedit blanditiis quas expedita tempora.
                            Dolorum natus possimus aperiam tenetur mollitia velit doloribus debitis eligendi quasi
                            consequatur aspernatur doloremque autem perferendis ab nulla reprehenderit quaerat dolores
                            cupiditate, iure aut magnam quidem modi omnis fugit. Magnam temporibus dolore recusandae
                            possimus aliquid odit omnis, animi quasi! Soluta saepe illum facere libero, iste, ratione alias
                            aut nemo quasi obcaecati fugiat illo doloribus magni placeat sed. Perferendis accusantium odit
                            eaque minima earum sunt, tempora placeat laborum culpa qui rerum ullam nostrum ratione
                            consequuntur quia voluptatibus. Veniam repellendus velit error, neque labore a libero laborum
                            quas eaque recusandae sequi, ipsam provident esse officiis asperiores eos? Amet voluptate
                            ducimus rem officia dolorem ex eveniet neque perspiciatis, molestias voluptas perferendis autem
                            sed nulla eius deserunt aperiam! Velit dignissimos ipsam nulla quibusdam dolore dolorem,
                            laboriosam distinctio, nihil eveniet vitae libero ut.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 col-12">
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
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
                        <div class="col-md-12">
                            <div class="d-flex rounded shadow-sm p-3 bg-white">
                                <img src="https://i.pinimg.com/originals/87/64/1a/87641ac11458c4259239b791593cf661.jpg"
                                    alt="Berita" class="flex-shrink-0 me-3 object-fit-cover rounded" width="100"
                                    height="100">
                                <div class="w-100 position-relative">
                                    <p class="fw-medium my-0 fst-normal text-dark ellipse-two">Lorem ipsum dolor sit amet
                                        consectetur, adipisicing elit. Nostrum, itaque aliquid quos ratione cumque
                                        blanditiis impedit possimus est atque incidunt.</p>
                                    <small class="ellipse text-justify mb-4">Lorem
                                        ipsum, dolor sit amet
                                        consectetur adipisicing
                                        elit. Ex facilis cumque delectus expedita libero nihil cupiditate blanditiis
                                        quibusdam maiores fuga quae iusto ipsum vel atque praesentium sapiente corporis
                                        vero, neque quas maxime ea et pariatur sint id? Explicabo, dignissimos nostrum! Rem
                                        sunt dignissimos rerum odio, itaque velit iusto dolorem laborum?</small>
                                    <small class="text-gray-dark position-absolute bottom-0"><i
                                            class="fa-solid fa-calendar-day me-1"></i>02 Januari 2024
                                    </small>
                                    <a href="#" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex rounded shadow-sm p-3 bg-white">
                                <img src="https://i.pinimg.com/originals/87/64/1a/87641ac11458c4259239b791593cf661.jpg"
                                    alt="Berita" class="flex-shrink-0 me-3 object-fit-cover rounded" width="100"
                                    height="100">
                                <div class="w-100 position-relative">
                                    <p class="fw-medium my-0 fst-normal text-dark ellipse-two">Lorem ipsum dolor sit amet
                                        consectetur, adipisicing elit. Nostrum, itaque aliquid quos ratione cumque
                                        blanditiis impedit possimus est atque incidunt.</p>
                                    <small class="ellipse text-justify mb-4">Lorem
                                        ipsum, dolor sit amet
                                        consectetur adipisicing
                                        elit. Ex facilis cumque delectus expedita libero nihil cupiditate blanditiis
                                        quibusdam maiores fuga quae iusto ipsum vel atque praesentium sapiente corporis
                                        vero, neque quas maxime ea et pariatur sint id? Explicabo, dignissimos nostrum! Rem
                                        sunt dignissimos rerum odio, itaque velit iusto dolorem laborum?</small>
                                    <small class="text-gray-dark position-absolute bottom-0"><i
                                            class="fa-solid fa-calendar-day me-1"></i>02 Januari 2024
                                    </small>
                                    <a href="#" class="stretched-link"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Garis Judul --}}
            <div class="row m-0 p-0 mb-3">
                <h5 class="p-0 m-0 mb-1">KESAN PESAN</h5>
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
                    <div class="card-body p-2">
                        <form action="#" method="post">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama<span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-alt"
                                    placeholder="Masukkan nama lengkap Anda" id="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-alt"
                                    placeholder="Masukkan alamat email Anda" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="noHp" class="form-label">No Telepon<span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control form-control-alt"
                                    placeholder="Masukkan nomor telepon Anda" id="noHp" required>
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea id="pesan" class="form-control form-control-alt" placeholder="Tulis pesan atau pertanyaan Anda di sini"
                                    cols="30" rows="5"></textarea>
                            </div>
                            <button class="btn btn-alt-primary float-end"><i
                                    class="fa-solid fa-paper-plane me-1"></i>Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
