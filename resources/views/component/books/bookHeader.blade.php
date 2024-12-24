<link rel="stylesheet" href="{{ secure_asset('css/books/style.css') }}?v={{ time() }}">

<div class="row justify-content-center mt-4 mb-3">
    <div class="col-11">
        <h1 class="text-center">{{ $title }}</h1>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-11 d-flex flex-row justify-content-center">
        <div class="col-7 col-md-7">
            @include('component.searchBar')
        </div>
        <div class="col-1 ms-3">
            @include('component.filter')
        </div>
    </div>
</div>
