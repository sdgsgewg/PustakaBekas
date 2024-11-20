@extends('layouts.main')

@section('container')
    @include('component.books.bookHeader')

    <div class="row justify-content-center mt-5">
        <div class="col-11">
            <div class="d-flex align-items-center category-header mb-3">
                <h2 class="category-title">{{ $genre->category->name }}</h2>
            </div>
            <div class="my-4">
                <h4>{{ $genre->name }}</h4>
            </div>
            <div class="row d-flex flex-wrap">
                @foreach ($books as $book)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mb-4">
                        @include('component.card', ['book' => $book])
                    </div>
                @endforeach
            </div>
            <div class="d-flex align-items-center justify-content-center mt-5">
                {{ $books->links() }}
            </div>
        </div>
    </div>

    @include('component.books.book-script')
@endsection
