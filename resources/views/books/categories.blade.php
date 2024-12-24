@extends('layouts.main')

@section('css')
    <style>
        img {
            border-radius: 5px;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endsection

@section('container')
    <div class="row justify-content-center my-4">
        <div class="col-11">
            <h1>{{ $title }}</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-11">
            <div class="row d-flex flex-wrap">
                @foreach ($categories as $category)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4 d-flex align-items-stretch">
                        <a href="{{ route('books.category', ['category' => $category->slug]) }}" class="w-100">
                            <div class="card text-bg-dark h-100" style="width: 100%; height: 300px;">

                                @if ($category->image)
                                    <img src="{{ secure_asset('storage/' . $category->image) }}"
                                        alt="{{ $category->name }}">
                                @else
                                    <img src="{{ secure_asset('img/' . $category->name . '.jpg') }}"
                                        alt="{{ $category->name }}">
                                @endif

                                <div class="card-img-overlay d-flex align-items-center p-0">
                                    <h5 class="card-title text-center flex-fill p-4 fs-3"
                                        style="background-color: rgba(0,0,0,0.7)">
                                        {{ $category->name }}</h5>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
