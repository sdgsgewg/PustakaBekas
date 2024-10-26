<div class="row justify-content-center mb-4">
    <div class="col-md-6">
        <form action="/books">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            @if (request('genre'))
                <input type="hidden" name="genre" value="{{ request('genre') }}">
            @endif
            @if (request('seller'))
                <input type="hidden" name="seller" value="{{ request('seller') }}">
            @endif
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Search.." name="search"
                    value="{{ request('search') }}" autocomplete="off">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>
</div>
