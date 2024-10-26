@extends('layouts.main')

@section('container')
    <link rel="stylesheet" href="{{ asset('css/home/home.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/books/style.css') }}?v={{ time() }}">

    <div class="background position-relative overflow-hidden p-3 p-md-2 m-md-3 text-center bg-body-tertiary">
        <div class="text-content col-md-8 p-lg-5 mx-auto my-5">
            <h1 class="display-3 fw-bold">Designed for all book lovers</h1>
            <h3 class="fw-normal text-muted mb-3">
                Buy any books you want with PustakaBekas
            </h3>
            <div class="d-flex gap-3 justify-content-center lead fw-normal">
                <a class="icon-link" href="/about">
                    Learn more
                    <svg class="bi">
                        <use xlink:href="#chevron-right" />
                    </svg>
                </a>
                <a class="icon-link" href="{{ route('books.index') }}">
                    Buy
                    <svg class="bi">
                        <use xlink:href="#chevron-right" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    @if ($books->count())
        <div class="container-fluid mt-5">
            <div class="row px-md-3 px-lg-5">
                <div class="title mb-4">
                    <h2>Trending</h2>
                    <hr>
                </div>
                @foreach ($books->take(6) as $book)
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                        @include('component.card')
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No book found.</p>
    @endif

    @if ($books->count())
        <div class="container-fluid mt-5">
            <div class="row px-md-3 px-lg-5">
                <div class="title mb-4">
                    <h2>Recently Uploaded Books</h2>
                    <hr>
                </div>
                @foreach ($books->take(3) as $book)
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                        @include('component.card')
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No book found.</p>
    @endif
@endsection
