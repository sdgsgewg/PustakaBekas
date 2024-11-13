@extends('layouts.main')

@section('container')

    @include('component.books.bookHeader')

    <div class="row justify-content-center mt-5">
        <div class="col-11">
            @if ($booksByCategory->isNotEmpty() && $booksByCategory->flatten()->isNotEmpty())
                @foreach ($categories as $category)
                    @if (isset($booksByCategory[$category->id]))
                        <!-- Display Category Name -->
                        <div class="d-flex align-items-center category-header mb-3">
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
                                    <div class="my-4">
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

                                        @include('component.books.carousel-control')
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @else
                @include('books.noBook')
            @endif
        </div>
    </div>

    @include('component.books.book-script')

@endsection
