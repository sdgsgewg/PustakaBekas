@extends('layouts.main')

@section('container')
    @include('component.books.bookHeader')

    <div class="row justify-content-center mt-5">
        <div class="col-11">
            <!-- Display Category Name -->
            <div class="d-flex align-items-center category-header mb-3">
                <h2 class="category-title">{{ $category->name }}</h2>
            </div>

            <!-- Iterate through each genre within this category -->
            @foreach ($category->genres as $genre)
                <!-- Check if there are books for this genre -->
                @php
                    // Get the books that belong to this genre within the current category
                    $booksInGenre = $category->books->filter(function ($book) use ($genre) {
                        return $book->genres->contains($genre);
                    });
                @endphp

                @if ($booksInGenre->count() > 0)
                    <!-- Display Genre Name -->
                    <div class="d-flex justify-content-between align-items-center my-4">
                        <h4>{{ $genre->name }}</h4>
                        @if ($booksInGenre->count() > 6)
                            <a href="{{ route('books.genre', ['genre' => $genre->slug]) }}"
                                class="d-flex align-items-center view-all-link btn">
                                View All <i class="bi bi-arrow-right-circle ms-2"></i>
                            </a>
                        @endif
                    </div>

                    <!-- Carousel for Books in Each Genre -->
                    <div id="carouselExample{{ $category->id }}{{ $genre->id }}" class="carousel mb-5"
                        data-book-amount="{{ $booksInGenre->count() }}">

                        <div class="carousel-inner">
                            @foreach ($booksInGenre->take(6) as $index => $book)
                                <div class="carousel-item @if ($index === 0) active @endif">
                                    @include('component.card', ['book' => $book])
                                </div>
                            @endforeach
                        </div>

                        @include('component.books.carousel-control')
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    @include('component.books.book-script')
@endsection
