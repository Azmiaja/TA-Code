@extends('layouts.main')
@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            {{-- Page title home --}}
            <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Page</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{ $title2 }}
                    </li>
                </ol>
            </nav>
            {{-- End Page title home --}}
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <div class="row m-0">
                        {{-- End Sambutan --}}
                        <div class="col-lg-5 col-sm-12 p-0 mb-lg-0 mb-sm-3 mb-3">
                            <div class="card border-0 me-lg-2 me-sm-0 me-0 shadow-sm bg-white">
                                <div class="row g-0">
                                    <div class="col-md-4 col-4 p-3">
                                        <img src="{{ 'assets' }}/media/img/karakter-pd.png"
                                            class="img-fluid rounded-start" alt="karakter">
                                    </div>
                                    <div class="col-md-8 col-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Selamat Datang 'Syahrul Nur</h5>
                                            <p class="card-text">Ayo mulai hari ini dengan basmallah</p>
                                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins
                                                    ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Sambutan --}}
                        {{-- Calendar --}}
                        <div class="col-lg-7 col-sm-12 p-0">
                            <div class="card border-0 ms-lg-2 ms-sm-0 ms-0 shadow-sm bg-white">
                                <div class="row g-0">
                                    <div class="col-lg-9 col-sm-9 col-8 p-3">
                                        <div id="js-calendar"></div>
                                    </div>
                                    <div class="col-lg-3 col-3 py-3 pe-3 ps-1">
                                        <form class="js-form-add-event push">
                                            <div class="input-group">
                                                <input type="text" class="js-add-event form-control"
                                                    placeholder="Add Event..">
                                                <span class="input-group-text">
                                                    <i class="fa fa-fw fa-plus-circle"></i>
                                                </span>
                                            </div>
                                        </form>
                                        <ul id="js-events" class="list list-events">
                                            <li>
                                                <div class="js-event p-2 fs-sm fw-medium rounded bg-info-light text-info">
                                                    Codename X</div>
                                            </li>
                                            <li>
                                                <div
                                                    class="js-event p-2 fs-sm fw-medium rounded bg-success-light text-success">
                                                    Weekend Adventure</div>
                                            </li>
                                            <li>
                                                <div class="js-event p-2 fs-sm fw-medium rounded bg-info-light text-info">
                                                    Project Mars</div>
                                            </li>
                                            <li>
                                                <div
                                                    class="js-event p-2 fs-sm fw-medium rounded bg-warning-light text-warning">
                                                    Meeting</div>
                                            </li>
                                            <li>
                                                <div
                                                    class="js-event p-2 fs-sm fw-medium rounded bg-success-light text-success">
                                                    Walk the dog</div>
                                            </li>
                                            <li>
                                                <div class="js-event p-2 fs-sm fw-medium rounded bg-info-light text-info">
                                                    AI
                                                    schedule</div>
                                            </li>
                                            <li>
                                                <div
                                                    class="js-event p-2 fs-sm fw-medium rounded bg-success-light text-success">
                                                    Cinema</div>
                                            </li>
                                            <li>
                                                <div
                                                    class="js-event p-2 fs-sm fw-medium rounded bg-danger-light text-danger">
                                                    Project X</div>
                                            </li>
                                            <li>
                                                <div
                                                    class="js-event p-2 fs-sm fw-medium rounded bg-warning-light text-warning">
                                                    Skype Meeting</div>
                                            </li>
                                        </ul>
                                        <div class="text-center">
                                            <p class="fs-sm text-muted">
                                                <i class="fa fa-arrows-alt"></i> Drag and drop events on the calendar
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- End Calendar --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
