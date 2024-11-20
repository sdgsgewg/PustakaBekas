@extends('layouts.main')

@section('container')
    <link rel="stylesheet" href="{{ asset('css/transaction/style.css') }}?v={{ time() }}">

    <div class="row justify-content-center mt-4">
        <div class="col-11 col-md-10 d-flex flex-column">
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

            <div class="content-section mt-2" id="haveOrder">
                @foreach ($transactions as $transaction)
                    <div class="transaction-card" data-status="{{ $transaction->transaction_status }}"
                        data-created-at="{{ $transaction->created_at->timestamp }}">
                        @include('component.transaction.orderCard', ['transaction' => $transaction])
                    </div>
                @endforeach
            </div>

            <div class="content-section mt-2" id="noOrder" style="display: none;">
                <div class="d-flex flex-column align-items-center">
                    <div class="img-no-order">
                        <img src="{{ asset('img/noOrder.png') }}" alt="">
                    </div>
                    <h5 class="mt-1">You don't have any orders yet</h5>
                </div>
            </div>

        </div>
    </div>

    <script src="{{ asset('js/transaction/script.js') }}?v={{ time() }}"></script>
@endsection
