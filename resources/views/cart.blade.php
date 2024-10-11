@extends('layouts.main')

@section('container')
    <div class="row justify-content-center">
        <div class="col-md-8 d-flex flex-column">
            <h1 class="mb-4">{{ $title }}</h1>

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show col-md-12" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($carts->count())
                @foreach ($carts as $cart)
                    @foreach ($cart->books as $book)
                        <div class="card mb-3 d-flex h-100">
                            <div class="row g-0 flex-fill">
                                <div class="col-md-4">
                                    @if ($book->image)
                                        <img src="{{ asset('storage/' . $book->image) }}"
                                            class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="...">
                                    @else
                                        <img src="{{ asset('img/' . $book->genre->name) . '.jpg' }}"
                                            class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="...">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body d-flex flex-column justify-content-between h-100">
                                        <h5 class="card-title">{{ $book->title }}</h5>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button class="btn btn-primary d-flex justify-content-center align-items-center"
                                                style="width: 2rem; height: 2rem;">
                                                <p style="margin: 0;">-</p>
                                            </button>
                                            <p class="d-flex flex-column justify-content-center" style="margin: 0;">
                                                {{ $book->pivot->quantity }}
                                            </p>
                                            <button class="btn btn-primary d-flex justify-content-center align-items-center"
                                                style="width: 2rem; height: 2rem;">
                                                <p style="margin: 0;">+</p>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @else
                <p class="text-center">Your cart is empty</p>
            @endif
        </div>
    </div>
@endsection
