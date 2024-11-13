<script src="{{ asset('js/books/card-slider.js') }}?v={{ time() }}"></script>

<script>
    var routeGetGenresByCategory = '{{ route('bookFilter.getGenresByCategory', ':slug') }}';
    var oldGenreSlugs = @json(old('genre', $bookGenres ?? [])); // Assuming old('genre') contains genre slugs
    var oldCategorySlug = "{{ old('category') }}"; // Using category slug
</script>
<script src="{{ asset('js/books/filter.js') }}?v={{ time() }}"></script>
