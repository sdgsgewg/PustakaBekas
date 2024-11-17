<div class="card col-12 rounded p-3 mb-4 d-flex flex-column">

    <div class="col-12 mb-2 d-flex justify-content-between">
        <h6 class="fw-bold">
            From {{ $transaction->buyer->name }}
        </h6>
        <h6 class="text-success-emphasis">
            {{ $transaction->transaction_status }}
        </h6>
    </div>

    @php
        $products = 0;
    @endphp

    @foreach ($transaction->books as $book)
        <div class="col-12 mb-3 d-flex flex-row">
            <div class="img-wrapper col-3 col-md-3">
                @if ($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" alt="...">
                @else
                    <img src="{{ asset('img/' . $book->category->name) . '.jpg' }}" alt="...">
                @endif
            </div>
            <div class="card-info col-9 col-md-9 ms-3 d-flex flex-column justify-content-between">
                <div>
                    <h5>{{ $book->title }}</h5>
                    <p class="text-end pe-3">x{{ $book->pivot->quantity }}</p>
                </div>
                <div>
                    <p class="text-end pe-3">Rp{{ number_format($book->price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        @php
            $products += $book->pivot->quantity;
        @endphp
    @endforeach

    <div class="col-12 d-flex flex-row justify-content-end">
        <h5>Total {{ $products }} {{ count($transaction->books) > 1 ? 'products' : 'product' }}:
            <strong>Rp{{ number_format($transaction->grand_total_price, 0, ',', '.') }}</strong>
        </h5>
    </div>

    @php
        $statusLabels = [
            'Not Paid' => 'Awaiting Payment',
            'Pending' => 'Review',
            'Accepted' => 'Process Order',
            'Delivered' => 'Confirm Delivery',
            'Returned' => 'Handle Return',
            'Completed' => 'Finalize',
            'Cancelled' => $transaction->transaction_status === 'Pending' ? 'Decline' : 'Cancel',
        ];
    @endphp

    <div class="col-12 mt-2 d-flex flex-row justify-content-end gap-3">

        @if (in_array($transaction->transaction_status, ['Not Paid', 'Returned', 'Completed', 'Cancelled']))
            <button class="btn btn-primary">View Detail
            </button>
        @elseif ($transaction->transaction_status === 'Delivered')
            @if ($transaction->isReceived)
                @foreach ($transaction->nextStatuses as $status)
                    @if ($status === 'Completed')
                        <form action="{{ route('transactions.updateStatus', ['transaction' => $transaction->id]) }}"
                            method="POST">
                            @csrf
                            <input name="choice" type="hidden" value="{{ $status }}">
                            <button type="submit"
                                class="btn {{ in_array($status, ['Cancelled', 'Returned']) ? 'btn-danger' : 'btn-primary' }}">
                                {{ $statusLabels[$status] ?? $status }}
                            </button>
                        </form>
                    @endif
                @endforeach
            @else
                <button class="btn btn-primary">View Detail
                </button>
            @endif
        @else
            @foreach ($transaction->nextStatuses as $status)
                <form action="{{ route('transactions.updateStatus', ['transaction' => $transaction->id]) }}"
                    method="POST">
                    @csrf
                    <input name="choice" type="hidden" value="{{ $status }}">
                    <button type="submit"
                        class="btn {{ in_array($status, ['Cancelled', 'Returned']) ? 'btn-danger' : 'btn-primary' }}">
                        {{ $statusLabels[$status] ?? $status }}
                    </button>
                </form>
            @endforeach
        @endif

    </div>
</div>
