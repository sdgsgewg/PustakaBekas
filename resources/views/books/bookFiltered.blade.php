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

    @if ($booksByCategory->isNotEmpty() && $booksByCategory->flatten()->isNotEmpty())
        <div class="container">
            <div class="row">
                @foreach ($categories as $category)
                    @if (isset($booksByCategory[$category->id]))
                        <!-- Display Category Name -->
                        <div class="col-md-12 mb-3 d-flex align-items-center category-header">
                            <h2 class="category-title">{{ $category->name }}</h2>
                        </div>

                        <!-- Iterate through Genres within Category -->
                        @foreach ($booksByCategory[$category->id] as $genreId => $booksInGenre)
                            @if ($booksInGenre->isNotEmpty())
                                <!-- Check if books exist for this genre -->
                                @php
                                    $genre = $genres->firstWhere('id', $genreId);
                                @endphp

                                @if ($genre)
                                    <!-- Display Genre Name -->
                                    <div class="col-md-12 mt-2 mb-2">
                                        <h4>{{ $genre->name }}</h4>
                                    </div>

                                    <!-- Carousel for Books in Each Genre -->
                                    <div id="carouselExample{{ $category->id }}{{ $genre->id }}" class="carousel mb-4"
                                        data-book-amount="{{ $booksInGenre->count() }}">

                                        <div class="carousel-inner">
                                            @foreach ($booksInGenre as $index => $book)
                                                <div class="carousel-item @if ($index === 0) active @endif">
                                                    @include('component.card', ['book' => $book])
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Carousel Controls -->
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselExample{{ $category->id }}{{ $genre->id }}"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>

                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#carouselExample{{ $category->id }}{{ $genre->id }}"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <div class="d-flex flex-column align-items-center">
            <div class="img-no-book">
                <img src="{{ asset('img/noBook.png') }}" alt="">
            </div>
            <h5 class="mt-1">No book found</h5>
        </div>
    @endif

    <script src="{{ asset('js/books/card-slider.js') }}?v={{ time() }}"></script>

    <script>
        var routeGetGenresByCategory = '{{ route('bookFilter.getGenresByCategory', ':slug') }}';
        var oldGenreSlugs = @json(old('genre', request()->genre));
        var oldCategorySlug = "{{ request('category') }}";
    </script>
    <script src="{{ asset('js/books/filter.js') }}"></script>

@endsection
