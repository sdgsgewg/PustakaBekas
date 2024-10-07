@extends('layouts.main')

@section('container')

    <h1 class="mb-4 text-center">{{ $title }}</h1>
    
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <form action="/books">
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
        <div class="card mb-3">

            <div style="width: 100%; height: 400px;">

                @if ($books[0]->image)
                    <div style="max-height: 400px; overflow: hidden">
                        <img src="{{ asset('storage/' . $books[0]->image) }}" alt="{{ $books[0]->genre->name }}"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px 5px 0 0;">
                    </div>
                @else
                    <img src="{{ asset('img/' . $books[0]->genre->name . '.jpg') }}" alt="{{ $books[0]->genre->name }}"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px 5px 0 0;">
                @endif
            </div>

            <div class="card-body text-center">
                <h3 class="card-title">
                    <a href="{{ route('books.show', ['book' => $books[0]->slug]) }}" class="text-decoration-none text-dark text-white">
                        {{ $books[0]->title }}
                    </a>
                </h3>
                <p>
                    <small class="text-body-secondary">
                        By.
                        <a href="{{ route('books.index', ['seller' => $books[0]->seller->username]) }}"
                            class="text-decoration-none">{{ $books[0]->seller->name }}</a>
                        in
                        <a href="{{ route('books.index', ['genre' => $books[0]->genre->slug]) }}" class="text-decoration-none">
                            {{ $books[0]->genre->name }}</a>
                    </small>
                </p>
                <a href="{{ route('books.show', ['book' => $books[0]->slug]) }}" class="text-decoration-none btn btn-primary">View details</a>
            </div>
        </div>

        <div class="container">
            <div class="row">
                @foreach ($books->skip(1) as $book)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="position-absolute px-3 py-2"
                                style="background-color: rgba(0, 0, 0, 0.6); border-radius: 5px 0 0 0">
                                <a href="{{ route('books.index', ['book' => $book->genre->slug]) }}"
                                    class="text-white text-decoration-none">
                                    {{ $book->genre->name }}
                                </a>
                            </div>

                            <div style="width: 100%; height: 200px;">
                                @if ($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}"
                                        alt="{{ $book->genre->name }}"
                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px 5px 0 0;">
                                @else
                                    <img src="{{ asset('img/' . $book->genre->name . '.jpg') }}"
                                        alt="{{ $book->genre->name }}"
                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px 5px 0 0;">
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $book->title }}</h5>
                                <p>
                                    <small class="text-body-secondary">
                                        By.
                                        <a href="{{ route('books.index', ['seller' => $book->seller->username]) }}"
                                            class="text-decoration-none">{{ $book->seller->name }}</a>
                                    </small>
                                </p>
                                <div class="mt-auto">
                                    <a href="{{ route('books.show', ['book' => $book->slug]) }}" class="btn btn-primary">View details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No book found.</p>
    @endif

    <div class="d-flex justify-content-end mt-5">
        {{ $books->links() }}
    </div>

@endsection
