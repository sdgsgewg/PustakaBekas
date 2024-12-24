@extends('layouts.main')

@section('container')
    <div class="row justify-content-center mt-4">
        <div class="col-11">
            <div class="card d-flex flex-column overflow-hidden">
                @if (in_array($trade->trade_status, ['Declined', 'Cancelled']))
                    <div class="card-header fw-bold bg-danger">{{ 'Trade ' . $trade->trade_status }}</div>
                @elseif (in_array($trade->trade_status, ['Pending', 'Accepted', 'In Progress']))
                    <div class="card-header fw-bold bg-warning text-dark">{{ 'Trade ' . $trade->trade_status }}
                    </div>
                @else
                    <div class="card-header fw-bold bg-success">{{ 'Trade ' . $trade->trade_status }}</div>
                @endif

                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold">Delivery Address</h6>
                    <div class="d-flex">
                        <div>
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        @if (Auth::id() === $trade->user_1_id)
                            <div class="d-flex flex-column ms-3">
                                <div class="d-flex gap-3">
                                    <p class="m-0 mb-1">
                                        {{ $trade->user2->name }} <span
                                            class="text-secondary">{{ $trade->user2->phoneNumber }}</span>
                                    </p>
                                </div>
                                <div>
                                    {{ $trade->user2->address }}
                                </div>
                            </div>
                        @else
                            <div class="d-flex flex-column ms-3">
                                <div class="d-flex gap-3">
                                    <p class="m-0 mb-1">
                                        {{ $trade->user1->name }} <span
                                            class="text-secondary">{{ $trade->user1->phoneNumber }}</span>
                                    </p>
                                </div>
                                <div>
                                    {{ $trade->user1->address }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-11">
            @include('component.trade.tradeDetailCard')
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-11">
            <div class="card d-flex flex-column">
                <div class="card-header d-flex justify-content-between">
                    <p class="fw-bold m-0">Order Number</p>
                    <p class="m-0">{{ $trade->order_number }}</p>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <p>Order Time</p>
                            <p>
                                {{ \Carbon\Carbon::parse($trade->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                            </p>
                        </div>
                        @if ($trade->payment_time !== null)
                            <div class="d-flex justify-content-between">
                                <p>Payment Time</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($trade->payment_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        @endif
                        @if ($trade->shipping_time !== null)
                            <div class="d-flex justify-content-between">
                                <p>Shipping Time</p>
                                <p>
                                    {{ \Carbon\Carbon::parse($trade->shipping_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        @endif
                        @if ($trade->completion_time !== null)
                            <div class="d-flex justify-content-between">
                                <p class="m-0">Completion Time</p>
                                <p class="m-0">
                                    {{ \Carbon\Carbon::parse($trade->completion_time)->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
