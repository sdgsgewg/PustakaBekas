<div class="card mb-3">

    <div class="imgBigCard">
        <?php
        $url = '../../img/';
        ?>

        @if ($books[0]->image)
            <img src="{{ asset('storage/' . $books[0]->image) }}" alt="{{ $books[0]->category->name }}"
                style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px 5px 0 0;">
        @else
            <img src="{{ $url . $books[0]->category->name . '.jpg' }}" alt="{{ $books[0]->category->name }}"
                style="width: 100%; height: 100%; object-fit: cover; border-radius: 5px 5px 0 0;">
        @endif
    </div>

    <div class="card-body text-center">
        <h3 class="card-title">
            <a href="{{ route('books.show', ['book' => $books[0]->slug]) }}"
                class="text-decoration-none text-dark text-white">
                {{ $books[0]->title }}
            </a>
        </h3>
        <p>
            <small class="text-body-secondary">
                By.
                <a href="{{ route('books.index', ['seller' => $books[0]->seller->username]) }}"
                    class="text-decoration-none">{{ $books[0]->seller->name }}</a>
                in
                <a href="{{ route('books.index', ['category' => $books[0]->category->slug]) }}"
                    class="text-decoration-none">
                    {{ $books[0]->category->name }}</a>
            </small>
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('books.show', ['book' => $books[0]->slug]) }}" class="btn btn-primary">View
                details</a>

            <form action="{{ route('carts.store', ['book' => $books[0]->slug]) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary d-flex">
                    <i class="bi bi-cart-plus"></i>
                </button>
            </form>
        </div>
    </div>
</div>
