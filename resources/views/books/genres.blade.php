@extends('layouts.main')

@section('container')
    <style>
        img {
            border-radius: 5px;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <h1 class="mb-5">{{ $title }}</h1>

    <div class="container">
        <div class="row">
            @foreach ($genres as $genre)
                <div class="col-sm-6 col-md-4 mb-3 d-flex align-items-stretch">
                    <a href="{{ route('books.index', ['genre' => $genre->slug]) }}" class="w-100">
                        <div class="card text-bg-dark h-100" style="width: 100%; height: 300px;">

                            @if ($genre->image)
                                <img src="{{ asset('storage/' . $genre->image) }}" alt="{{ $genre->name }}">
                            @else
                                <img src="{{ asset('img/' . $genre->name . '.jpg') }}" alt="{{ $genre->name }}">
                            @endif

                            <div class="card-img-overlay d-flex align-items-center p-0">
                                <h5 class="card-title text-center flex-fill p-4 fs-3"
                                    style="background-color: rgba(0,0,0,0.7)">{{ $genre->name }}</h5>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
