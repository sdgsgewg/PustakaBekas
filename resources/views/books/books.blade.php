@extends('layouts.main')

@section('container')

    <link rel="stylesheet" href="{{ asset('css/books/style.css') }}?v={{ time() }}">

    <div class="d-flex flex-column row justify-content-center mb-4">

        <h1 class="mb-4 text-center">{{ $title }}</h1>

        <div class="col-12 d-flex flex-row justify-content-center gap-3 mb-4">
            @include('component.searchBar')
            @include('component.filter')
        </div>

    </div>

    @if ($booksByCategory->count())
        <div class="container">
            <div class="row">
                @foreach ($categories as $category)
                    @php
                        $bookAmount = 0;
                    @endphp
                    @if ($category->books->count())
                        <div class="col-md-12 mb-3 d-flex justify-content-between align-items-center category-header">
                            <h2 class="category-title">{{ $category->name }}</h2>
                            <a href="{{ route('books.index', ['category' => $category->slug]) }}"
                                class="d-flex align-items-center view-all-link btn btn-primary">
                                View All <i class="bi bi-arrow-right-circle ms-2"></i>
                            </a>
                        </div>

                        @php
                            $bookAmount += $category->books->count();
                        @endphp

                        <div id="carouselExample{{ $category->id }}" class="carousel mb-5"
                            data-book-amount="{{ $bookAmount }}">

                            <div class="carousel-inner">
                                @foreach ($category->books->take(6) as $index => $book)
                                    <div class="carousel-item @if ($index === 0) active @endif">

                                        @include('component.card')

                                    </div>
                                @endforeach
                            </div>

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

                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No book found.</p>
    @endif

    <script src="{{ asset('js/books/card-slider.js') }}?v={{ time() }}"></script>

    <script>
        var routeGetGenresByCategory = '{{ route('bookFilter.getGenresByCategory', ':slug') }}';
        var oldGenreSlugs = @json(old('genre', $bookGenres ?? [])); // Assuming old('genre') contains genre slugs
        var oldCategorySlug = "{{ old('category') }}"; // Using category slug
    </script>
    <script src="{{ asset('js/books/filter.js') }}"></script>

@endsection
