@extends('layouts.main')

@section('container')

    @include('component.books.bookHeader')

    <div class="row justify-content-center mt-5">
        <div class="col-11">
            @if ($books->count())
                <div class="row d-flex flex-wrap align-items-stretch">
                    @foreach ($books as $book)
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                            @include('component.card')
                        </div>
                    @endforeach
                </div>
                <div class="d-flex align-items-center justify-content-center mt-5">
                    {{ $books->links() }}
                </div>
            @else
                @include('component.books.noBook')
            @endif
        </div>
    </div>

    @include('component.books.book-script')
@endsection
