@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('css/books/style.css') }}?v={{ time() }}">

    <style>
        .seller-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    </style>
@endsection

@section('container')
    <div class="row justify-content-center mt-4 mb-5">
        <div class="col-11">
            <div class="d-flex flex-column flex-md-row">
                <div class="col-12 col-md-6 col-lg-5 col-xl-4 d-flex flex-row" style="height: 100%;">
                    <div class="seller-photo img-thumbnail rounded-circle overflow-hidden"
                        style="width: 100px; height: 100px;">
                        @if ($seller->image)
                            <img src="{{ secure_asset('storage/' . $seller->image) }}" alt="{{ $seller->name }}"
                                class="rounded-circle">
                        @else
                            <img src="{{ secure_asset('img/' . $seller->gender . ' icon.png') }}" alt="{{ $seller->name }}"
                                class="rounded-circle">
                        @endif
                    </div>

                    <div class="d-flex flex-column ms-3">
                        <h4>{{ $seller->name }}</h4>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-7 col-xl-8 d-flex flex-column gap-1 ps-lg-2 mt-3 mt-md-0">
                    <div class="d-inline-flex">
                        <i class="bi bi-book me-2"></i> Books: {{ $seller->books->count() }}
                    </div>
                    <div class="d-inline-flex">
                        <i class="bi bi-calendar me-2"></i> Date Joined: {{ date_format($seller->created_at, 'j F Y') }}
                    </div>
                    @if ($averageRating > 0.0)
                        <div class="d-inline-flex">
                            <i class="bi bi-star me-2"></i> Rating: <span class="badge bg-warning text-dark shadow-sm ms-2"
                                style="font-size: 0.9rem; font-weight: bold;">
                                {{ $averageRating }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-11">
            @if ($books->count())
                <div class="row d-flex flex-wrap align-items-stretch">
                    @foreach ($books as $book)
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                            @include('component.card')
                        </div>
                    @endforeach
                </div>
                <div class="d-flex align-items-center justify-content-center mt-5">
                    {{ $books->links() }}
                </div>
            @else
                <p class="text-center fs-4">No book found.</p>
            @endif
        </div>
    </div>
@endsection
