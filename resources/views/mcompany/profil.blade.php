@extends('layouts.main')
@section('content')
<div class="bg-body-light">
        <div class="content content-full">
            {{-- Page title pegawai --}}
            <nav class="flex-shrink-0 my-3 mt-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="javascript:void(0)">Manajemen Company</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{ $title2 }}
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        {{ $title2 }}
                    </li>
                </ol>
            </nav>
            <div class="block block-rounded">
                <div class="mb-4">
                    <textarea id="js-ckeditor" name="one-ecom-product-description"></textarea>
                </div>
            </div>
        </div>
    </div>
@endsection
