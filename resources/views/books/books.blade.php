@extends('layouts.main')

@section('container')

    <link rel="stylesheet" href="{{ asset('css/books/style.css') }}">

    <h1 class="mb-4 text-center">{{ $title }}</h1>

    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <form action="/books">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('genre'))
                    <input type="hidden" name="genre" value="{{ request('genre') }}">
                @endif
                @if (request('seller'))
                    <input type="hidden" name="seller" value="{{ request('seller') }}">
                @endif
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search.." name="search"
                        value="{{ request('search') }}" autocomplete="off">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    @if ($books->count())
        <div class="container">
            <div class="row">
                @foreach ($categories as $category)
                    @if ($category->books->count())
                        <div class="col-md-12 mb-3">
                            <h2>{{ $category->name }}</h2>
                        </div>

                        <div id="carouselExample{{ $category->id }}" class="carousel mb-5">

                            <div class="carousel-inner">
                                @foreach ($category->books as $index => $book)
                                    <div class="carousel-item @if ($index === 0) active @endif">

                                        <div class="card d-flex flex-column">
                                            <div class="img-wrapper">
                                                @if ($book->image)
                                                    <img src="{{ asset('storage/' . $book->image) }}"
                                                        alt="{{ $book->category->name }}">
                                                @else
                                                    <img src="{{ '../../img/' . $book->category->name . '.jpg' }}"
                                                        alt="{{ $book->category->name }}">
                                                @endif
                                            </div>

                                            <div class="card-body">
                                                <div>
                                                    <h5 class="card-title">{{ $book->title }}</h5>
                                                    <p>
                                                        <small class="text-body-secondary">
                                                            By. <a
                                                                href="{{ route('books.index', ['seller' => $book->seller->username]) }}"
                                                                class="text-decoration-none">
                                                                {{ $book->seller->name }}</a>
                                                        </small>
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ route('books.show', ['book' => $book->slug]) }}"
                                                        class="btn btn-primary">View
                                                        details</a>

                                                    <form action="{{ route('carts.store', ['book' => $book->slug]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary d-flex">
                                                            <i class="bi bi-cart-plus"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            @if ($category->books->count() > 1)
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExample{{ $category->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>

                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExample{{ $category->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif

                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No book found.</p>
    @endif

    {{-- <div class="d-flex justify-content-end mt-5">
        {{ $books->links() }}
    </div> --}}

    <script src="{{ asset('js/books/card-slider.js') }}"></script>

@endsection
