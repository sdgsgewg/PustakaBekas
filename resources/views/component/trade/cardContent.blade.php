@php
    $targetBook = $trade->book2;
    $offeredBook = $trade->booksOffered->last();
@endphp

{{-- Yang offer trade --}}
<div class="col-12 col-lg-5 d-flex flex-row">
    <div class="img-wrapper col-3 col-lg-3 col-xl-4">
        @if ($offeredBook->image)
            <img src="{{ secure_asset('storage/' . $offeredBook->image) }}" alt="...">
        @else
            <img src="{{ secure_asset('img/' . $offeredBook->category->name) . '.jpg' }}" alt="...">
        @endif
    </div>
    <div class="card-info col-8 col-lg-8 col-xl-7 d-flex flex-column justify-content-between ms-4">
        <div>
            <h5>{{ $offeredBook->title }}</h5>
            <p>x1</p>
        </div>
        <div>
            <p>Rp{{ number_format($offeredBook->price, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

{{-- Icon exchange --}}
<div class="col-12 col-lg-1 my-3 my-lg-0">
    <i class="bi bi-arrow-left-right"></i>
</div>

{{-- Yang terima trade --}}
<div class="col-12 col-lg-5 d-flex flex-row">
    <div class="img-wrapper col-3 col-lg-3 col-xl-4">
        @if ($targetBook->image)
            <img src="{{ secure_asset('storage/' . $targetBook->image) }}" alt="...">
        @else
            <img src="{{ secure_asset('img/' . $targetBook->category->name) . '.jpg' }}" alt="...">
        @endif
    </div>
    <div class="card-info col-8 col-lg-8 col-xl-7 d-flex flex-column justify-content-between ms-4">
        <div>
            <h5>{{ $targetBook->title }}</h5>
            <p>x1</p>
        </div>
        <div>
            <p>Rp{{ number_format($targetBook->price, 0, ',', '.') }}</p>
        </div>
    </div>
</div>
