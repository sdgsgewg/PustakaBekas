<div class="card col-12 rounded p-3 d-flex flex-column">
    @include('component.modals.sendFeedbackStatusModal')

    <div class="col-12 mb-2">
        <a href="{{ route('books.seller', ['seller' => $transaction->seller->username]) }}"
            class="text-decoration-none color-inherit fw-bold fs-6">
            {{ $transaction->seller->name }}</a>
    </div>

    @php
        $products = 0;
    @endphp

    @foreach ($transaction->books as $book)
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
                    <p>x{{ $book->pivot->quantity }}</p>
                </div>
                <div>
                    <p>Rp{{ number_format($book->price, 0, ',', '.') }}</p>
                </div>

                @php
                    $userRating = $book->reviewByUser(Auth::id());
                    $isSeller = Auth::id() === $transaction->seller->id; // Check if the current user is the seller
                @endphp

                @if (!$isSeller && (!$userRating || !$userRating->isRated))
                    <div class="col-12 d-flex flex-row-reverse mt-2">
                        @if ($transaction->transaction_status === 'Completed')
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
    @endforeach

    <hr>

    <div class="col-12 d-flex flex-column text-secondary">
        <div class="d-flex flex-row justify-content-between">
            <p>Subtotal for Product</p>
            <p>
                Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
            </p>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <p>Shipping Fee</p>
            <p>
                Rp{{ number_format($transaction->shipping_fee, 0, ',', '.') }}
            </p>
        </div>
        <div class="d-flex flex-row justify-content-between">
            <p class="m-0">Service Fee</p>
            <p class="m-0">
                Rp{{ number_format($transaction->service_fee, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <hr>

    <div class="col-12 d-flex flex-row justify-content-end">
        <h5 class="m-0 py-1">Total Order:
            <strong>Rp{{ number_format($transaction->grand_total_price, 0, ',', '.') }}</strong>
        </h5>
    </div>

</div>
