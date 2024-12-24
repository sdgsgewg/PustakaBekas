@extends('layouts.main')

@section('container')
    <div class="row justify-content-center mt-4 mb-5">
        <div class="col-11 col-md-8">
            @include('component.modals.book.tradeStatusModal')

            <h1 class="mt-2 mb-3">{{ $book['title'] }}</h1>
            <div class="mb-3">
                <p>
                    By.
                    <a href="{{ route('books.seller', ['seller' => $book->seller->username]) }}" class="text-decoration-none">
                        {{ $book->seller->name }}</a>
                </p>
            </div>

            <div class="d-flex flex-row" style="max-height: 350px;">
                <div class="col-4 overflow-hidden">
                    @if ($book->image)
                        <img src="{{ secure_asset('storage/' . $book->image) }}" alt="{{ $book->category->name }}"
                            class="img-fluid">
                    @else
                        <img src="{{ secure_asset('img/' . $book->category->name . '.jpg') }}" alt="{{ $book->category->name }}"
                            class="img-fluid">
                    @endif
                </div>
                <div class="col-7 d-flex flex-column ms-5">
                    <p>Category:
                        <a href="{{ route('books.category', ['category' => $book->category->slug]) }}"
                            class="text-decoration-none">{{ $book->category->name }}</a>
                    </p>
                    <p>Genre:
                        @foreach ($book->genres as $genre)
                            @if (!$loop->first)
                                ,
                            @endif
                            <a href="{{ route('books.genre', ['genre' => $genre->slug]) }}"
                                class="text-decoration-none">{{ $genre->name }}</a>
                        @endforeach
                    </p>
                    @php
                        $averageRating = number_format($book->reviews()->avg('rating'), 2);
                    @endphp
                    @if ($averageRating != 0.0)
                        <p>Rating: <span class="text-warning">{{ $averageRating }}</span></p>
                    @endif

                    <div class="d-flex flex-row gap-3 mt-auto">
                        @if (auth()->check() && auth()->user()->id !== $book->seller->id)
                            <form action="{{ route('carts.store', ['book' => $book->slug]) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button type={{ $book->stock > 0 ? 'submit' : 'button' }}
                                    class="btn {{ $book->stock > 0 ? 'btn-success' : 'btn-secondary' }} d-inline-flex">
                                    <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                </button>
                            </form>

                            <button type="button" class="btn btn-primary d-inline-flex" data-bs-toggle="modal"
                                data-bs-target="#proposeTradeModal">
                                <i class="bi bi-arrow-left-right me-2"></i>Trade
                            </button>
                            @include('component.modals.trade.proposeTradeModal')
                        @endif
                    </div>
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
            </article>

            @include('component.books.book-review-section')

            @include('component.books.comments.book-comment-section')
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ secure_asset('js/books/comment.js') }}?v={{ time() }}"></script>
    <script src="{{ secure_asset('js/books/reply.js') }}?v={{ time() }}"></script>
@endsection
