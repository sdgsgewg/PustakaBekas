@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/transaction/style.css') }}?v={{ time() }}">
@endsection

@section('container')
    <div class="row justify-content-center mt-4">
        <div class="col-11 col-md-10 d-flex flex-column">
            @include('component.transaction.transaction-header')

            <div class="content-section mt-2" id="haveOrder">
                @foreach ($transactions as $transaction)
                    <div class="transaction-card" data-status="{{ $transaction->transaction_status }}"
                        data-created-at="{{ $transaction->created_at->timestamp }}">
                        @include('component.transaction.orderCard', ['transaction' => $transaction])
                    </div>
                @endforeach
            </div>

            @include('component.transaction.noOrder')

        </div>
    </div>
@endsection

@section('js')
    <script src="{{ secure_asset('js/transaction/script.js') }}?v={{ time() }}"></script>
@endsection
