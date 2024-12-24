@extends('layouts.main')

@section('container')
    <div class="row justify-content-center mt-4">
        <div class="col-11">
            <div class="d-flex flex-row" style="height: 150px;">
                <div class="col-4 d-flex flex-row" style="height: 100%;">
                    <div class="align-items-start img-thumbnail rounded-circle overflow-hidden"
                        style="width: 100px; height: 100px;">
                        @if ($seller->image)
                            <img src="{{ secure_asset('storage/' . $seller->image) }}" alt="{{ $seller->name }}" class="rounded-circle">
                        @else
                            <img src="{{ secure_asset('img/' . $seller->gender . ' icon.png') }}" alt="{{ $seller->name }}" class="rounded-circle">
                        @endif
                    </div>
                    <div class="d-flex flex-column ms-3">
                        <h4>{{ $seller->name }}</h4>
                    </div>
                </div>
                <div class="col-7 d-flex flex-column gap-1 ms-2">
                    <div class="d-inline-flex">
                        <i class="bi bi-book me-2"></i> Books: {{ $seller->books->count() }}
                    </div>
                    <div class="d-inline-flex">
                        <i class="bi bi-calendar me-2"></i> Date Joined: {{ date_format($seller->created_at, 'j F Y') }}
                    </div>
                    @if ($averageRating > 0.0)
                        <div class="d-inline-flex">
                            <i class="bi bi-star me-2"></i> Rating: <span
                                class="text-warning ms-1">{{ $averageRating }}</span>
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
