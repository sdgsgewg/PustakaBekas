<div class="card col-12 rounded p-3 mb-4 d-flex flex-column">
    <div class="col-12 mb-2 d-flex justify-content-between">
        <h6>To <span class="fw-bold">{{ $trade->user2->name }}</span></h6>
        <h6 class="text-success-emphasis">{{ $trade->trade_status }}</h6>
    </div>

    <div class="col-12 mb-3 d-flex flex-column flex-lg-row-reverse justify-content-between">
        @include('component.trade.cardContent')
    </div>

    @php
        $statusLabels = [
            'Pending' => 'Propose New Trade',
            'Accepted' => 'Process Order',
            'Declined' => 'Decline',
            'In Progress' => 'Confirm Delivery',
            'Completed' => 'Confirm Receipt',
            'Cancelled' => $trade->trade_status === 'Pending' ? 'Decline' : 'Cancel',
        ];
    @endphp

    <div class="col-12 mt-2 d-flex flex-row justify-content-end gap-3">

        @if (in_array($trade->trade_status, ['Pending', 'Accepted', 'Completed', 'Cancelled']))
            <div class="col-12 mt-2 d-flex flex-row justify-content-end">
                <a href="{{ route('trades.show', ['trade' => $trade]) }}" class="btn btn-primary">View
                    Detail
                </a>
            </div>
        @elseif ($trade->trade_status === 'In Progress')
            @if (!$trade->isReceived)
                @foreach ($trade->nextStatuses as $status)
                    @if ($status === 'Completed')
                        <form action="{{ route('trades.updateStatus', ['trade' => $trade->id]) }}" method="POST">
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
                <a href="{{ route('trades.show', ['trade' => $trade]) }}" class="btn btn-primary">View
                    Detail
                </a>
            @endif
        @else
            @foreach ($trade->nextStatuses as $status)
                @if ($status === 'Pending')
                    <button type="button" class="btn {{ $status === 'Cancelled' ? 'btn-danger' : 'btn-primary' }}"
                        data-bs-toggle="modal" data-bs-target="#proposeTradeModal">
                        {{ $statusLabels[$status] ?? $status }}
                    </button>
                    @include('component.modals.trade.proposeNewTradeModal', [
                        'book' => $trade->book2,
                        'books' => $trade->tradeable_books,
                        'trade' => $trade,
                    ])
                @else
                    <form action="{{ route('trades.updateStatus', ['trade' => $trade->id]) }}" method="POST">
                        @csrf
                        <input name="choice" type="hidden" value="{{ $status }}">
                        <button type="submit"
                            class="btn {{ $status === 'Cancelled' ? 'btn-danger' : 'btn-primary' }}">
                            {{ $statusLabels[$status] ?? $status }}
                        </button>
                    </form>
                @endif
            @endforeach
        @endif

    </div>
</div>
