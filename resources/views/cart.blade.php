@extends('layouts.main')

@section('container')

    <link rel="stylesheet" href="{{ asset('css/cart/cart.css') }}">

    <div class="row justify-content-center">
        <div class="col-md-8 d-flex flex-column">
            <h1 class="mb-4">{{ $title }}</h1>

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @php
                $cartItems = $carts->sum(fn($cart) => $cart->books->count());
            @endphp

            @if ($carts->count() && $cartItems)
                @foreach ($carts as $cart)
                    @foreach ($cart->books as $book)
                        <div class="card mb-3 d-flex flex-row">
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
                                        <form action="{{ route('carts.update', ['cart' => $cart->id]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <input type="hidden" name="quantity" value="{{ $book->pivot->quantity - 1 }}">
                                            <button class="btn btn-primary d-flex justify-content-center align-items-center"
                                                style="width: 2rem; height: 2rem;">
                                                <p style="margin: 0;">-</p>
                                            </button>
                                        </form>

                                        <p class="qty d-flex flex-column justify-content-center" style="margin: 0;">
                                            {{ $book->pivot->quantity }}
                                        </p>

                                        <form action="{{ route('carts.update', ['cart' => $cart->id]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <input type="hidden" name="quantity" value="{{ $book->pivot->quantity + 1 }}">
                                            <button class="btn btn-primary d-flex justify-content-center align-items-center"
                                                style="width: 2rem; height: 2rem;">
                                                <p style="margin: 0;">+</p>
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>

                        </div>
                    @endforeach
                @endforeach
                <a href="{{ route('carts.checkout') }}"
                    class="btn btn-primary rounded-pill py-2 mt-3 text-decoration-none text-light">
                    Checkout
                </a>
            @else
                <p class="text-center">Your cart is empty</p>
            @endif
        </div>
    </div>
@endsection
