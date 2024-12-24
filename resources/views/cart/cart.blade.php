@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/cart/style.css') }}?v={{ time() }}">
@endsection

@section('container')
    <div class="row justify-content-center mt-4">
        <div class="col-11 col-md-10 col-lg-8 d-flex flex-column">
            <h1>{{ $title }}</h1>
            <hr class="mb-4">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (count($cartItems) > 0)
                @foreach ($cartItems as $sellerId => $sellerGroup)
                    <div class="seller-section">
                        <div class="sellerBox d-flex flex-row gap-3">
                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="checkSeller" class="checkbox check-seller"
                                    data-seller-id="{{ $sellerId }}">
                            </div>
                            <div class="div">
                                <a href="{{ route('books.seller', ['seller' => $sellerGroup['seller_username']]) }}"
                                    class="text-decoration-none fs-3">
                                    {{ $sellerGroup['seller_name'] }} &rsaquo;</a>
                            </div>
                        </div>
                        @foreach ($sellerGroup['items'] as $book)
                            <div class="cartItem d-flex flex-row gap-3">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" name="checkBook" class="checkbox check-book"
                                        data-seller-id="{{ $sellerId }}" data-book-id="{{ $book->id }}"
                                        data-book-stock="{{ $book->stock }}"
                                        {{ $book->pivot->isChecked ? 'checked' : '' }}>
                                </div>
                                @include('component.cart.cartItem')
                                @include('component.modals.cart.removeModal')
                                @include('component.modals.cart.maxQtyModal')
                            </div>
                        @endforeach
                    </div>
                    <hr>
                @endforeach
                <a id="checkout-button" class="btn btn-primary rounded-pill py-2 mt-3 text-decoration-none text-light"
                    data-checkout-url="{{ route('carts.checkout') }}">
                    Checkout
                </a>
                @include('component.modals.cart.checkoutNoticeModal')
            @else
                <div class="d-flex flex-column align-items-center">
                    <div class="img-no-order">
                        <img src="{{ secure_asset('img/emptyCart.png') }}" alt="">
                    </div>
                    <h5 class="mt-1">Your cart is empty</h5>
                </div>
            @endif

        </div>
    </div>
@endsection

@section('js')
    <script>
        const qtyURL = "{{ route('carts.updateQuantity') }}";
        const checkURL = "{{ route('carts.updateIsChecked') }}";
    </script>

    <script src="{{ secure_asset('js/cart/quantity.js') }}?v={{ time() }}"></script>
    <script src="{{ secure_asset('js/cart/isChecked.js') }}?v={{ time() }}"></script>
    <script src="{{ secure_asset('js/cart/checkoutButton.js') }}?v={{ time() }}"></script>
    <script src="{{ secure_asset('js/cleanModalBackdrops.js') }}?v={{ time() }}"></script>
@endsection
