@extends('layouts.main')

@section('container')
    <main>
        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary">
            <div class="col-md-6 p-lg-5 mx-auto my-5">
                <h1 class="display-3 fw-bold">Designed for all book lovers</h1>
                <h3 class="fw-normal text-muted mb-3">
                    Buy any books you want with PustakaBekas
                </h3>
                <div class="d-flex gap-3 justify-content-center lead fw-normal">
                    <a class="icon-link" href="/about">
                        Learn more
                        <svg class="bi">
                            <use xlink:href="#chevron-right" />
                        </svg>
                    </a>
                    <a class="icon-link" href="{{ route('books.index') }}">
                        Buy
                        <svg class="bi">
                            <use xlink:href="#chevron-right" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="product-device shadow-sm d-none d-md-block"></div>
            <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
        </div>

        <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
            @foreach ($books->take(2) as $book)
                <div
                    class="{{ $loop->odd ? 'text-bg-dark' : 'bg-body-tertiary' }} me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden d-flex flex-column justify-content-between">
                    <div class="my-3 py-3">
                        <h2 class="display-5">{{ $book->title }}</h2>
                        <p class="lead">{{ Str::limit($book->description, 20, '...') }}</p>
                    </div>
                    <div class="{{ $loop->odd ? 'bg-body-tertiary' : 'bg-dark' }} shadow-sm mx-auto"
                        style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
                        <img src="{{ asset('img/' . $book->category->name . '.jpg') }}" alt=""
                            style="height:100%; width:100%; object-fit: cover; border-radius: 21px 21px 0 0;">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
            @foreach ($books->skip(2)->take(2) as $book)
                <div
                    class="{{ $loop->odd ? 'bg-body-tertiary' : 'text-bg-primary' }} me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden d-flex flex-column justify-content-between">
                    <div class="my-3 py-3">
                        <h2 class="display-5">{{ $book->title }}</h2>
                        <p class="lead">{{ Str::limit($book->description, 20, '...') }}</p>
                    </div>
                    <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
                        <img src="{{ asset('img/' . $book->category->name . '.jpg') }}" alt=""
                            style="height:100%; width:100%; object-fit: cover; border-radius: 21px 21px 0 0;">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
            @foreach ($books->skip(4)->take(2) as $book)
                <div
                    class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden d-flex flex-column justify-content-between">
                    <div class="my-3 p-3">
                        <h2 class="display-5">{{ $book->title }}</h2>
                        <p class="lead">{{ Str::limit($book->description, 20, '...') }}</p>
                    </div>
                    <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
                        <img src="{{ asset('img/' . $book->category->name . '.jpg') }}" alt=""
                            style="height:100%; width:100%; object-fit: cover; border-radius: 21px 21px 0 0;">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-md-flex flex-md-equal w-100 my-md-3 ps-md-3">
            @foreach ($books->skip(6)->take(2) as $book)
                <div
                    class="bg-body-tertiary me-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden d-flex flex-column justify-content-between">
                    <div class="my-3 p-3">
                        <h2 class="display-5">{{ $book->title }}</h2>
                        <p class="lead">{{ Str::limit($book->description, 20, '...') }}</p>
                    </div>
                    <div class="bg-dark shadow-sm mx-auto" style="width: 80%; height: 300px; border-radius: 21px 21px 0 0;">
                        <img src="{{ asset('img/' . $book->category->name . '.jpg') }}" alt=""
                            style="height:100%; width:100%; object-fit: cover; border-radius: 21px 21px 0 0;">
                    </div>
                </div>
            @endforeach
        </div>

    </main>
@endsection
