@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/trade/style.css') }}?v={{ time() }}">
@endsection

@section('container')
    <div class="row justify-content-center mt-4">
        <div class="col-11 col-md-10 d-flex flex-column">
            @include('component.modals.book.tradeStatusModal')

            <div class="title mb-2">
                <h1>{{ $title }}</h1>
            </div>
            <div>
                <ul class="nav nav-underline nav-fill">
                    @foreach ($allStatus as $s)
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-status="{{ $s }}">{{ $s }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <hr class="mt-0 mb-3">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="content-section mt-2" id="haveTrade">
                @foreach ($trades as $trade)
                    <div class="trade-card" data-status="{{ $trade->trade_status }}">
                        @include('component.trade.tradeCard', ['trade' => $trade])
                    </div>
                @endforeach
            </div>

            <div class="content-section mt-2" id="noTrade" style="display: none;">
                <div class="d-flex flex-column align-items-center">
                    <div class="img-no-trade">
                        <img src="{{ secure_asset('img/noTrade.png') }}" alt="">
                    </div>
                    <h5 class="mt-1">You don't have any trades yet</h5>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="{{ secure_asset('js/trade/script.js') }}?v={{ time() }}"></script>
@endsection
