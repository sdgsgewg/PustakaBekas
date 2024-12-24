<div class="card my-2 d-flex flex-row">

    <div class="col-4">
        <div class="img-wrapper col-md-4">
            @if ($book->image)
                <img src="{{ secure_asset('storage/' . $book->image) }}" class="rounded-start" alt="...">
            @else
                <img src="{{ secure_asset('img/' . $book->category->name) . '.jpg' }}" class="rounded-start" alt="...">
            @endif
        </div>
    </div>

    <div class="col-8">
        <div class="card-body d-flex flex-row justify-content-between h-100">
            <div class="d-flex flex-column justify-content-between">
                <div class="book-title">
                    <h5>{{ $book->title }}</h5>
                </div>
                <div class="book-price">
                    <p class="mb-0">Rp{{ number_format($book->price, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-end gap-2">
                <button class="btn btn-primary btn-decrement d-flex justify-content-center align-items-center">
                    -
                </button>

                <p class="qty d-flex flex-column justify-content-center m-0" data-book-id="{{ $book->id }}" data-book-stock="{{ $book->stock }}"
                    data-qty="{{ $book->pivot->quantity }}">
                    {{ $book->pivot->quantity }}
                </p>

                <button class="btn btn-primary btn-increment d-flex justify-content-center align-items-center">
                    +
                </button>
            </div>
        </div>
    </div>

</div>
