@extends('layouts.main')

@section('container')
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <h1 class="mb-3">{{ $book['title'] }}</h1>
                <p>
                    By.
                    <a href="{{ route('books.index', ['seller' => $book->seller->username]) }}"
                        class="text-decoration-none">{{ $book->seller->name }}</a>
                    in
                    <a href="{{ route('books.index', ['genre' => $book->genre->slug ]) }}" class="text-decoration-none">
                        {{ $book->genre->name }}</a>
                </p>

                @if ($book->image)
                    <div style="max-height: 350px; overflow:hidden">
                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->genre->name }}"
                            class="img-fluid">
                    </div>
                @else
                    <img src="{{ asset('img/' . $book->genre->name . '.jpg') }}" alt="{{ $book->genre->name }}" width="1200"
                        height="400" class="img-fluid">
                @endif

                <article class="my-3 fs-5">
                    {!! $book->description !!}
                </article>

                <a href="{{ route('books.index') }}" class="d-block mt-3">&laquo; Back to all books</a>
            </div>
        </div>
    </div>
@endsection
