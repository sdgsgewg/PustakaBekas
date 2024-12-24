<script src="{{ secure_asset('js/books/card-slider.js') }}?v={{ time() }}"></script>

<script>
    var oldCategorySlug = "{{ old('category', request()->category) }}";
    var oldGenreSlugs = @json(old('genre', request()->genre, []));
    var routeGetGenresByCategory = '{{ route('bookFilter.getGenresByCategory', ':slug') }}';
</script>
<script src="{{ secure_asset('js/books/filter.js') }}?v={{ time() }}"></script>
