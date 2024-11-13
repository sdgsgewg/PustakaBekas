@extends('layouts.main')

@section('container')
    <link rel="stylesheet" href="{{ asset('css/home/home.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/books/style.css') }}?v={{ time() }}">

    <div class="row justify-content-center mt-4">
        <div class="col-11">
            <div class="background position-relative overflow-hidden p-3 p-md-5 text-center bg-body-tertiary">
                <div class="text-content col-md-8 mx-auto my-5">
                    <h1 class="display-3 fw-bold">Designed for all book lovers</h1>
                    <h3 class="fw-normal text-muted mb-4">
                        Buy any books you want with PustakaBekas
                    </h3>
                    <div class="d-flex flex-wrap gap-3 justify-content-center lead fw-normal">
                        <a class="icon-link d-flex align-items-center" href="/about">
                            Learn more
                            <svg class="bi ms-2" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                <use xlink:href="#chevron-right"></use>
                            </svg>
                        </a>
                        <a class="icon-link d-flex align-items-center" href="{{ route('books.index') }}">
                            Buy
                            <svg class="bi ms-2" width="1em" height="1em" fill="currentColor" aria-hidden="true">
                                <use xlink:href="#chevron-right"></use>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-11">
            @if ($books->count())
                <div class="title mb-4">
                    <h2>Trending</h2>
                    <hr>
                </div>
                <div class="row d-flex flex-wrap">
                    @foreach ($books->take(6) as $book)
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            @include('component.card')
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center fs-4">No book found.</p>
            @endif
        </div>
    </div>


    <div class="row justify-content-center mt-5">
        <div class="col-11">
            @if ($books->count())
                <div class="title mb-4">
                    <h2>Recently Uploaded Books</h2>
                    <hr>
                </div>
                <div class="row d-flex flex-wrap">
                    @foreach ($books->take(3) as $book)
                        <div class="col-12 col-sm-6 col-lg-4 mb-4">
                            @include('component.card')
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center fs-4">No book found.</p>
            @endif
        </div>
    </div>
@endsection
