@extends('layouts.main')

@section('container')

    <link rel="stylesheet" href="{{ asset('css/cart/style.css') }}">

    <div class="row justify-content-center">
        <div class="col-md-8 d-flex flex-column">
            <h1>{{ $title }}</h1>
            <hr class="mb-4">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
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
                                <a href="{{ route('books.index', ['seller' => $sellerGroup['seller_username']]) }}"
                                    class="text-decoration-none fs-3">
                                    {{ $sellerGroup['seller_name'] }} &rsaquo;</a>
                            </div>
                        </div>
                        @foreach ($sellerGroup['items'] as $book)
                            <div class="cartItem d-flex flex-row gap-3">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" name="checkBook" class="checkbox check-book"
                                        data-seller-id="{{ $sellerId }}" data-book-id="{{ $book->id }}"
                                        {{ $book->pivot->isChecked ? 'checked' : '' }}>
                                </div>
                                <div class="card my-2 d-flex flex-row">

                                    <div class="col-4">
                                        <div class="img-wrapper col-md-4">
                                            @if ($book->image)
                                                <img src="{{ asset('storage/' . $book->image) }}" class="rounded-start"
                                                    alt="...">
                                            @else
                                                <img src="{{ asset('img/' . $book->category->name) . '.jpg' }}"
                                                    class="rounded-start" alt="...">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="card-body d-flex flex-column justify-content-between h-100">
                                            <h5 class="card-title">{{ $book->title }}</h5>
                                            <div class="d-flex justify-content-end gap-2">
                                                <form
                                                    action="{{ $book->pivot->quantity > 1 ? route('carts.update', ['cart' => $cart->id]) : '' }}"
                                                    method="{{ $book->pivot->quantity > 1 ? 'POST' : '' }}">

                                                    @if ($book->pivot->quantity > 1)
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                        <input type="hidden" name="quantity"
                                                            value="{{ $book->pivot->quantity - 1 }}">
                                                    @endif

                                                    <button
                                                        class="btn btn-primary d-flex justify-content-center align-items-center"
                                                        style="width: 2rem; height: 2rem;"
                                                        type="{{ $book->pivot->quantity > 1 ? 'submit' : 'button' }}"
                                                        data-bs-toggle="{{ $book->pivot->quantity > 1 ? '' : 'modal' }}"
                                                        data-bs-target="{{ $book->pivot->quantity > 1 ? '' : '#deleteModal-' . $book->id }}">
                                                        <p style="margin: 0;">-</p>
                                                    </button>
                                                </form>

                                                <p class="qty d-flex flex-column justify-content-center" style="margin: 0;">
                                                    {{ $book->pivot->quantity }}
                                                </p>

                                                <form
                                                    action="{{ $book->pivot->quantity < $book->stock ? route('carts.update', ['cart' => $cart->id]) : '' }}"
                                                    method="{{ $book->pivot->quantity < $book->stock ? 'POST' : '' }}">

                                                    @if ($book->pivot->quantity < $book->stock)
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                        <input type="hidden" name="quantity"
                                                            value="{{ $book->pivot->quantity + 1 }}">
                                                    @endif

                                                    <button
                                                        class="btn btn-primary d-flex justify-content-center align-items-center"
                                                        style="width: 2rem; height: 2rem;"
                                                        type="{{ $book->pivot->quantity < $book->stock ? 'submit' : 'button' }}"
                                                        data-bs-toggle="{{ $book->pivot->quantity < $book->stock ? '' : 'modal' }}"
                                                        data-bs-target="{{ $book->pivot->quantity < $book->stock ? '' : '#addModal-' . $book->id }}">
                                                        <p style="margin: 0;">+</p>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="deleteModal-{{ $book->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel-{{ $book->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="deleteModalLabel-{{ $book->id }}">
                                                        Confirm Deletion
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to remove book "{{ $book->title }}" from the
                                                    cart?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('carts.destroy', ['cart' => $cart->id]) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                        <button type="submit" class="btn btn-primary">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="addModal-{{ $book->id }}" tabindex="-1"
                                        aria-labelledby="addModalLabel-{{ $book->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="addModalLabel-{{ $book->id }}">
                                                        Quantity Limit Reached
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    You have reached the maximum allowed quantity for "{{ $book->title }}"
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                        data-bs-dismiss="modal">OK</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                @endforeach
                <a href="{{ $hasSelectedItems ? route('carts.checkout') : '#' }}"
                    class="btn {{ $hasSelectedItems ? 'btn-primary' : 'btn-secondary' }} rounded-pill py-2 mt-3 text-decoration-none text-light">
                    Checkout
                </a>
            @else
                <p class="text-center">Your cart is empty</p>
            @endif

        </div>
    </div>

    <script src="{{ asset('js/cart/quantity.js') }}"></script>
    <script src="{{ asset('js/cart/isChecked.js') }}"></script>
@endsection
