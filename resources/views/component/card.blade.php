<div class="card d-flex flex-column h-100">
    <div class="img-wrapper h-50">
        @if ($book->image)
            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->category->name }}">
        @else
            <img src="{{ '../../img/' . $book->category->name . '.jpg' }}" alt="{{ $book->category->name }}">
        @endif
    </div>

    <div class="card-body d-flex flex-column h-50">
        <div class="mb-3">
            <h5 class="card-title">{{ $book->title }}</h5>
            <small class="text-body-secondary">
                <a href="{{ route('books.seller', ['seller' => $book->seller->username]) }}" class="text-decoration-none">
                    {{ $book->seller->name }}</a>
                |
            </small>
            <small class="text-warning">{{ $book->rating }}</small>
        </div>
        <div class="d-flex flex-row align-items-center justify-content-between mt-auto">
            <p class="my-auto"> Rp{{ number_format($book->price, 0, ',', '.') }}</p>
            <a href="{{ route('books.show', ['book' => $book->slug]) }}" class="btn btn-primary">Details</a>
        </div>
    </div>

    @if ($book->stock == 0)
        <div class="notAvailable d-flex flex-column justify-content-center">
            <p class="text-center fw-bold m-0">Out of stock</p>
        </div>
    @endif

</div>
