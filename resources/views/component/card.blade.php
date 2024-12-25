<style>
    img {
        height: 25vh;
    }
</style>

<div class="card d-flex flex-column h-100 {{ $book->stock > 0 ? '' : 'card-disabled' }}">

    @php
        $genre = $book->genres->first();
    @endphp

    <div class="genre position-absolute px-3 py-2 {{ $book->stock > 0 ? 'cursor-pointer' : 'cursor-not-allowed' }}"
        onclick="{{ $book->stock > 0 ? "window.location.href='" . route('books.genre', ['genre' => $genre->slug]) . "'" : '' }}">
        <span class="text-white text-decoration-none">
            {{ $genre->name }}
        </span>
    </div>

    <div class="img-wrapper h-50">
        @if ($book->image)
            <img src="{{ secure_asset('storage/' . $book->image) }}" alt="{{ $book->category->name }}">
        @else
            <img src="{{ secure_asset('img/' . $book->category->name . '.jpg') }}" alt="{{ $book->category->name }}">
        @endif
    </div>

    <div class="card-body d-flex flex-column h-50">
        <div class="mb-3">
            <h5 class="card-title">{{ $book->title }}</h5>
            <small class="text-body-secondary">
                <a href="{{ $book->stock > 0 ? route('books.seller', ['seller' => $book->seller->username]) : '#' }}"
                    class="text-decoration-none {{ $book->stock > 0 ? '' : 'disabled' }}"
                    tabindex="{{ $book->stock > 0 ? '0' : '-1' }}"
                    aria-disabled="{{ $book->stock > 0 ? 'false' : 'true' }}">
                    {{ $book->seller->name }}</a>
            </small>
            @php
                $averageRating = number_format((float) $book->averageRating() ?: 0, 2);
            @endphp
            @if ($averageRating > 0.0)
                <small class="text-warning fw-bold">| {{ $averageRating }}</small>
            @endif
        </div>
        <div class="d-flex flex-row align-items-center justify-content-between mt-auto">
            <p class="my-auto"> Rp{{ number_format($book->price, 0, ',', '.') }}</p>
            <a href="{{ $book->stock > 0 ? route('books.show', ['book' => $book->slug]) : '#' }}"
                class="btn btn-primary {{ $book->stock > 0 ? '' : 'disabled' }}"
                tabindex="{{ $book->stock > 0 ? '0' : '-1' }}"
                aria-disabled="{{ $book->stock > 0 ? 'false' : 'true' }}">
                Details
            </a>
        </div>
    </div>

    @if ($book->stock == 0)
        <div class="notAvailable d-flex flex-column justify-content-center">
            <p class="text-center fw-bold m-0">Out of stock</p>
        </div>
    @endif

</div>
