@extends('layouts.main')

@section('container')
    <div class="row justify-content-center mt-4">
        <div class="col-11">
            <div class="d-flex flex-row" style="height: 150px;">
                <div class="col-4 d-flex flex-row" style="height: 100%;">
                    <div class="align-items-start img-thumbnail rounded-circle overflow-hidden"
                        style="width: 100px; height: 100px;">
                        @if ($seller->image)
                            <img src="{{ asset('storage/' . $seller->image) }}" alt="{{ $seller->name }}"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="{{ asset('img/male icon.png') }}" alt="{{ $seller->name }}"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>
                    <div class="ms-3">
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
                    {{-- <div class="d-inline-flex">
                        <i class="bi bi-star me-2"></i> Rating
                    </div> --}}
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
