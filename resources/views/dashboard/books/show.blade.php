@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-8">
                <h1 class="mb-3">{{ $book['title'] }}</h1>

                <a href="{{ route('auth.books.index') }}" class="btn btn-success d-inline-flex"><i
                        class="bi bi-arrow-left me-2"></i> Back to my books</a>

                <a href="{{ route('auth.books.edit', ['book' => $book->slug]) }}" class="btn btn-warning d-inline-flex"><i
                        class="bi bi-pencil-square me-2"></i>
                    Edit</a>

                <form action="{{ route('auth.books.destroy', ['book' => $book->slug]) }}" method="POST" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger d-inline-flex" onclick="return confirm('Are you sure?')">
                        <i class="bi bi-x-circle icon me-2"></i> Delete
                    </button>
                </form>

                @if ($book->image)
                    <div class="mt-4" style="max-height: 350px; overflow:hidden">
                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->category->name }}"
                            class="img-fluid">
                    </div>
                @else
                    <img src="{{ asset('img/' . $book->category->name . '.jpg') }}" alt="{{ $book->category->name }}"
                        width="1200" height="400" class="img-fluid mt-4">
                @endif

                <article class="my-3 fs-5">
                    <p>Category: {{ $book->category->name }}</p>
                    <p>Genre: 
                        @foreach ($book->genres as $genre)
                            @if (!$loop->first)
                                ,
                            @endif
                            {{ $genre->name }}
                        @endforeach
                    </p>
                    <p>Author: {{ $book->author }}</p>
                    <p>Stock: {{ $book->stock }}</p>
                    <p>Price: Rp{{ number_format($book->price, 2, ',', '.') }}</p>
                    <hr>
                    <h2>Synopsis</h2>
                    <p>{!! $book->synopsis !!}</p>
                    <hr>
                </article>

            </div>
        </div>
    </div>
@endsection
