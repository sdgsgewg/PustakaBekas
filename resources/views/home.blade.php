@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/home/home.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ secure_asset('css/books/style.css') }}?v={{ time() }}">
@endsection

@section('container')
    <div class="row justify-content-center mt-4">
        <div class="col-11">
            <div class="background position-relative overflow-hidden p-3 p-md-5 text-center bg-body-tertiary">
                <div class="text-content col-md-8 mx-auto my-5">
                    <h1 class="display-3 fw-bold">Designed for All Book Lovers</h1>
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
            <div class="title mb-4">
                <h2>Trending</h2>
                <hr>
            </div>
            @if ($trendingBooks->isNotEmpty())
                <div class="row d-flex flex-wrap">
                    @foreach ($trendingBooks as $book)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
                            @include('component.card', ['book' => $book])
                        </div>
                    @endforeach
                </div>
            @else
                @include('component.books.noBook')
            @endif
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-11">
            <div class="title mb-4">
                <h2>Recently Uploaded Books</h2>
                <hr>
            </div>
            @if ($latestBooks->count())
                <div class="row d-flex flex-wrap">
                    @foreach ($latestBooks as $book)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
                            @include('component.card')
                        </div>
                    @endforeach
                </div>
            @else
                @include('component.books.noBook')
            @endif
        </div>
    </div>
@endsection
