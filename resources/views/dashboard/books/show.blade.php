@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="row my-3">
            <div class="col-12 col-lg-10">
                <h1 class="mb-3">{{ $book['title'] }}</h1>

                <a href="{{ route('auth.books.index') }}" class="btn btn-success d-inline-flex"><i
                        class="bi bi-arrow-left me-2"></i> Back</a>

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

                <div class="d-flex flex-row mt-4" style="max-height: 350px;">
                    <div class="col-4 overflow-hidden" style="height: 100%;">
                        @if ($book->image)
                            <img src="{{ secure_asset('storage/' . $book->image) }}" alt="{{ $book->category->name }}"
                                class="img-fluid">
                        @else
                            <img src="{{ secure_asset('img/' . $book->category->name . '.jpg') }}"
                                alt="{{ $book->category->name }}" style="width: 100%; height: 100%; object-fit:cover;">
                        @endif
                    </div>
                    <div class="col-7 d-flex flex-column ms-5">
                        <p>Category: {{ $book->category->name }}</p>
                        <p>Genre:
                            @foreach ($book->genres as $genre)
                                @if (!$loop->first)
                                    ,
                                @endif
                                {{ $genre->name }}
                            @endforeach
                        </p>
                        @php
                            $averageRating = number_format($book->reviews()->avg('rating'), 2);
                        @endphp
                        @if ($averageRating != 0.0)
                            <p>Rating: <span class="text-warning">{{ $averageRating }}</span></p>
                        @endif
                    </div>
                </div>

                <article class="mt-4 fs-6">
                    <hr>
                    <h2 class="mb-3">Description</h2>
                    <p>Author: {{ $book->author }}</p>
                    <p>Stock: {{ $book->stock }}</p>
                    <p>Price: Rp{{ number_format($book->price, 2, ',', '.') }}</p>
                </article>

                <article class="mt-3 fs-6">
                    <hr>
                    <h2>Synopsis</h2>
                    <p>{!! $book->synopsis !!}</p>
                    <hr>
                </article>
            </div>
        </div>
    </div>
@endsection
