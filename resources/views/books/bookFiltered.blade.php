@extends('layouts.main')

@section('container')

    <link rel="stylesheet" href="{{ asset('css/books/style.css') }}?v={{ time() }}">

    <h1 class="title mb-4 text-center">{{ $title }}</h1>

    @include('component.searchBar')

    @if ($books->count())
        @include('component.bigCard')

        <div class="container">
            <div class="row">
                @foreach ($books->skip(1) as $book)
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                        @include('component.card')
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
