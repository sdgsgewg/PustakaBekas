@extends('layouts.main')

@section('container')

    @include('component.books.bookHeader')

    <div class="row justify-content-center mt-5">
        <div class="col-11">
            @if ($booksByCategory->count())
                @foreach ($categories as $category)
                    @php
                        $bookAmount = 0;
                    @endphp
                    @if ($category->books->count())
                        <div class="d-flex justify-content-between align-items-center category-header mb-3">
                            <h2 class="category-title">{{ $category->name }}</h2>
                            <a href="{{ route('books.category', ['category' => $category->slug]) }}"
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
                                @foreach ($category->books()->latest()->take(6)->get() as $index => $book)
                                    <div class="carousel-item @if ($index === 0) active @endif">
                                        @include('component.card')
                                    </div>
                                @endforeach
                            </div>

                            @include('component.books.carousel-control')

                        </div>
                    @endif
                @endforeach
            @else
                @include('component.books.noBook')
            @endif
        </div>
    </div>

    @include('component.books.book-script')
@endsection
