<div class="card col-12 rounded p-3 pb-2 d-flex flex-column">
    @include('component.modals.sendFeedbackStatusModal')

    <div class="col-12 mb-2">
        @if (Auth::id() === $trade->user_1_id)
            <a href="{{ route('books.seller', ['seller' => $trade->user2->username]) }}"
                class="text-decoration-none color-inherit fw-bold fs-6">
                {{ $trade->user2->name }}</a>
        @else
            <a href="{{ route('books.seller', ['seller' => $trade->user1->username]) }}"
                class="text-decoration-none color-inherit fw-bold fs-6">
                {{ $trade->user1->name }}</a>
        @endif
    </div>

    @php
        $products = 0;
        if (Auth::id() === $trade->user_1_id) {
            $book = $trade->book2;
        } else {
            $book = $trade->booksOffered->last();
        }
    @endphp

    <div class="col-12 mb-3 d-flex flex-row">
        <div class="img-wrapper col-2 col-lg-2">
            @if ($book->image)
                <img src="{{ secure_asset('storage/' . $book->image) }}" alt="...">
            @else
                <img src="{{ secure_asset('img/' . $book->category->name) . '.jpg' }}" alt="...">
            @endif
        </div>
        <div class="card-info col-10 col-lg-10 ps-4 d-flex flex-column justify-content-between">
            <div>
                <h5>{{ $book->title }}</h5>
                <p>x1</p>
                <p>Rp{{ number_format($book->price, 0, ',', '.') }}</p>
            </div>

            @php
                $userRating = $book->reviewByUser(Auth::id());
            @endphp

            @if (!$userRating || !$userRating->isRated)
                <div class="col-12 d-flex flex-row-reverse">
                    @if ($trade->trade_status === 'Completed')
                        <button class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#sendFeedbackModal-{{ $book->id }}">
                            Send Feedback
                        </button>
                        @include('component.modals.sendFeedbackModal', ['book' => $book])
                    @endif
                </div>
            @endif

        </div>
    </div>

</div>
