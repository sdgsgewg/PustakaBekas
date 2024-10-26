<div class="card d-flex flex-column">
    <div class="img-wrapper">
        @if ($book->image)
            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->category->name }}">
        @else
            <img src="{{ '../../img/' . $book->category->name . '.jpg' }}" alt="{{ $book->category->name }}">
        @endif
    </div>

    <div class="card-body">
        <div>
            <h5 class="card-title">{{ $book->title }}</h5>
            <p>
                <small class="text-body-secondary">
                    By. <a href="{{ route('books.index', ['seller' => $book->seller->username]) }}"
                        class="text-decoration-none">
                        {{ $book->seller->name }}</a>
                </small>
            </p>
        </div>
        <div class="d-flex justify-content-between">
            <a href="{{ route('books.show', ['book' => $book->slug]) }}" class="btn btn-primary">View
                details</a>

            @if (auth()->check() && auth()->user()->id !== $book->seller->id)
                <form action="{{ route('carts.store', ['book' => $book->slug]) }}" method="POST" class="d-inline">
                    @csrf
                    <button type={{ $book->stock > 0 ? 'submit' : 'button' }}
                        class="btn {{ $book->stock > 0 ? 'btn-primary' : 'btn-secondary' }} d-flex">
                        <i class="bi bi-cart-plus"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if ($book->stock == 0)
        <div class="notAvailable d-flex flex-column justify-content-center">
            <p class="text-center fw-bold m-0">Out of stock</p>
        </div>
    @endif

</div>
