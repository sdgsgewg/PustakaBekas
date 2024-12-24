<div class="card my-3 d-flex flex-row">

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
            <div class="d-flex justify-content-end align-items-end">
                <p class="qty d-flex flex-column justify-content-center m-0" data-book-id="{{ $book->id }}"
                    data-qty="{{ $book->pivot->quantity }}">
                    x{{ $book->pivot->quantity }}
                </p>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal-{{ $book->id }}" tabindex="-1"
        aria-labelledby="deleteModalLabel-{{ $book->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel-{{ $book->id }}">
                        Confirm Deletion
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove book "{{ $book->title }}" from the
                    cart?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('carts.destroy', ['cart' => $cart->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="btn btn-primary">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="maxQtyModal-{{ $book->id }}" tabindex="-1"
        aria-labelledby="maxQtyModalLabel-{{ $book->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="maxQtyModalLabel-{{ $book->id }}">
                        Quantity Limit Reached
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You have reached the maximum allowed quantity for "{{ $book->title }}"
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

</div>
