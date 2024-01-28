@extends('company_profil/layouts/app')
@section('app')
    <div class="row my-1">
        <div class="col-xxl-9 col-lg-8 col-md-8">
            <div class="row p-0">
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade rounded-2">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner rounded-3">
                        <div class="carousel-item active">
                            <img src="https://i.pinimg.com/originals/cf/55/2d/cf552de6e2abbbf8f3c9c5825cd0cedf.jpg"
                                class="d-block w-100" alt="Carousel Image 1">
                        </div>
                        <div class="carousel-item rounded-3">
                            <img src="https://i.pinimg.com/originals/71/cb/d6/71cbd6fd7e5bbbecf40263f73af4a3e1.jpg"
                                class="d-block w-100" alt="Carousel Image 1">
                        </div>
                        <div class="carousel-item rounded-3">
                            <img src="https://i.pinimg.com/originals/12/97/a4/1297a454d516f4f0952f471f7eafc323.jpg"
                                class="d-block w-100" alt="Carousel Image 1">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 col-md-4 border border-dark">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sequi deleniti ab perferendis ullam nesciunt
            reprehenderit alias harum necessitatibus hic dolores aut esse nisi, culpa excepturi cum voluptas quisquam natus
            quas?
        </div>
    </div>
@endsection
