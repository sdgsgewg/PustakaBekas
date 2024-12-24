@php
    $products = 0;
@endphp

@foreach ($transaction->books as $book)
    <div class="col-12 mb-3 d-flex flex-row">
        <div class="img-wrapper col-2 col-lg-2">
            @if ($book->image)
                <img src="{{ secure_asset('storage/' . $book->image) }}" alt="...">
            @else
                <img src="{{ secure_asset('img/' . $book->category->name) . '.jpg' }}" alt="...">
            @endif
        </div>
        <div class="card-info col-10 col-lg-10 ps-4 d-flex flex-column justify-content-between">
            <div>
                <h5>{{ $book->title }}</h5>
                <p class="text-end">x{{ $book->pivot->quantity }}</p>
            </div>
            <div>
                <p class="text-end">Rp{{ number_format($book->price, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    @php
        $products += $book->pivot->quantity;
    @endphp
@endforeach

<div class="col-12 d-flex flex-row justify-content-end">
    <h5>Total {{ $products }} {{ count($transaction->books) > 1 ? 'products' : 'product' }}:
        <strong>Rp{{ number_format($transaction->grand_total_price, 0, ',', '.') }}</strong>
    </h5>
</div>
