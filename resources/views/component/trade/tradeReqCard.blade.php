<div class="card col-12 rounded p-3 mb-4 d-flex flex-column">

    <div class="col-12 mb-2 d-flex justify-content-between">
        <h6>
            From <span class="fw-bold">{{ $trade->user1->name }}</span>
        </h6>
        <h6 class="text-success-emphasis">
            {{ $trade->trade_status }}
        </h6>
    </div>

    <div class="col-12 mb-3 d-flex flex-column flex-lg-row justify-content-between">
        @include('component.trade.cardContent')
    </div>

    @php
        $statusLabels = [
            'Pending' => 'Propose',
            'Accepted' => $trade->trade_status === 'Pending' ? 'Accept' : 'Process Order',
            'Declined' => 'Decline',
            'In Progress' => 'Confirm Delivery',
            'Completed' => 'Finalize',
            'Cancelled' => 'Cancel',
        ];
    @endphp

    <div class="col-12 mt-2 d-flex flex-row justify-content-end gap-3">

        @if (in_array($trade->trade_status, ['Declined', 'Completed', 'Cancelled']))
            <a href="{{ route('trades.show', ['trade' => $trade]) }}" class="btn btn-primary">View
                Detail
            </a>
        @elseif ($trade->trade_status === 'In Progress')
            @if ($trade->isReceived)
                @foreach ($trade->nextStatuses as $status)
                    @if ($status === 'Completed')
                        <form action="{{ route('trades.updateStatus', ['trade' => $trade->id]) }}" method="POST">
                            @csrf
                            <input name="choice" type="hidden" value="{{ $status }}">
                            <button type="submit"
                                class="btn {{ $status == 'Cancelled' ? 'btn-danger' : 'btn-primary' }}">
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
                <form action="{{ route('trades.updateStatus', ['trade' => $trade->id]) }}" method="POST">
                    @csrf
                    <input name="choice" type="hidden" value="{{ $status }}">
                    <button type="submit"
                        class="btn {{ isset($status) && in_array($status, ['Declined', 'Cancelled']) ? 'btn-danger' : 'btn-primary' }}">
                        {{ $statusLabels[$status] ?? $status }}
                    </button>
                </form>
            @endforeach
        @endif

    </div>
</div>
