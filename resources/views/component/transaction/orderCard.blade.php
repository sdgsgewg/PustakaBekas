<div class="card col-12 rounded p-3 mb-4 d-flex flex-column">

    <div class="col-12 mb-2 d-flex justify-content-between">
        <h6 class="fw-bold">
            {{ $transaction->seller->name }}
        </h6>
        <h6 class="text-success-emphasis">
            {{ $transaction->transaction_status }}
        </h6>
    </div>

    @include('component.transaction.cardContent')

    @php
        $statusLabels = [
            'Not Paid' => 'Awaiting Payment',
            'Pending' => 'Review',
            'Accepted' => 'Process Order',
            'Delivered' => 'Confirm Delivery',
            'Returned' => 'Handle Return',
            'Completed' => 'Confirm Receipt',
            'Cancelled' => $transaction->transaction_status === 'Pending' ? 'Decline' : 'Cancel',
        ];
    @endphp

    <div class="col-12 mt-2 d-flex flex-row justify-content-end gap-3">

        @if (in_array($transaction->transaction_status, [
                'Not Paid',
                'Pending',
                'Accepted',
                'Returned',
                'Completed',
                'Cancelled',
            ]))
            <div class="col-12 mt-2 d-flex flex-row justify-content-end">
                <a href="{{ route('transactions.show', ['transaction' => $transaction]) }}" class="btn btn-primary">View
                    Detail
                </a>
            </div>
        @elseif ($transaction->transaction_status === 'Delivered')
            @if (!$transaction->isReceived)
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
                <a href="{{ route('transactions.show', ['transaction' => $transaction]) }}" class="btn btn-primary">View
                    Detail
                </a>
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
