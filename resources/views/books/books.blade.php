@extends('layouts.main')

@section('container')

    <link rel="stylesheet" href="{{ asset('css/books/style.css') }}?v={{ time() }}">

    <h1 class="mb-4 text-center">{{ $title }}</h1>

    @include('component.searchBar')

    @if ($books->count())
        <div class="container">
            <div class="row">
                @foreach ($categories as $category)
                    @php
                        $bookAmount = 0;
                    @endphp
                    @if ($category->books->count())
                        <div class="col-md-12 mb-3">
                            <h2>{{ $category->name }}</h2>
                        </div>

                        @php
                            $bookAmount += $category->books->count();
                        @endphp

                        <div id="carouselExample{{ $category->id }}" class="carousel mb-5"
                            data-book-amount="{{ $bookAmount }}">

                            <div class="carousel-inner">
                                @foreach ($category->books as $index => $book)
                                    <div class="carousel-item @if ($index === 0) active @endif">

                                        @include('component.card')

                                    </div>
                                @endforeach
                            </div>

                            {{-- @if ($category->books->count() >= 3) --}}
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExample{{ $category->id }}" data-bs-slide="prev"
                                style="display: block;">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>

                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExample{{ $category->id }}" data-bs-slide="next"
                                style="display: block;">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                            {{-- @endif --}}

                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No book found.</p>
    @endif

    <script src="{{ asset('js/books/card-slider.js') }}?v={{ time() }}"></script>

@endsection
