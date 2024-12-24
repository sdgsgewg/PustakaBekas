<form action="{{ route('books.filter') }}" method="get" onsubmit="return validateSearch(this)">
    @if (request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
    @endif
    @if (request('genre'))
        <input type="hidden" name="genre"
            value="{{ is_array(request('genre')) ? implode(',', request('genre')) : request('genre') }}">
    @endif
    @if (request('seller'))
        <input type="hidden" name="seller" value="{{ request('seller') }}">
    @endif
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search.." name="search" value="{{ request('search') }}"
            autocomplete="off">
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
</form>

<script>
    function validateSearch(form) {
        const searchInput = form.search.value.trim(); // Get the search input and trim whitespace
        if (!searchInput) {
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>
