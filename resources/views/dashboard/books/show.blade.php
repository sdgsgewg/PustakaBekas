@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-8">
                <h1 class="mb-3">{{ $book['title'] }}</h1>

                <a href="{{ route('auth.books.index') }}" class="btn btn-success d-inline-flex"><i class="bi bi-arrow-left me-2"></i> Back to my books</a>

                <a href="{{ route('auth.books.edit', ['book' => $book->slug]) }}" class="btn btn-warning d-inline-flex"><i class="bi bi-pencil-square me-2"></i>
                    Edit</a>

                <form action="{{ route('auth.books.destroy', ['book' => $book->slug]) }}" method="POST" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger d-inline-flex" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-x-circle icon me-2"></i> Delete
                    </button>
                </form>

                <?php
                $url = '../../img/';
                // $url = 'https://api.unsplash.com/search/photos';
                ?>

                @if ($book->image)
                    <div style="max-height: 350px; overflow: hidden">
                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->genre->name }}" width="1200"
                            height="600" class="img-fluid mt-3">
                    </div>
                @else
                    <img src="{{ $url . $book->genre->name . '.jpg' }}" alt="{{ $book->genre->name }}" width="1200"
                        height="600" class="img-fluid mt-3">
                @endif

                <article class="my-3 fs-5">
                    {!! $book->description !!}
                </article>

            </div>
        </div>
    </div>
@endsection
