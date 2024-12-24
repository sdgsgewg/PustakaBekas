@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex flex-column justify-content-between align-items-start gap-2 pt-3 pb-3 mb-3 border-bottom">
        <h1 class="h2">Create New Book</h1>

        <a href="{{ route('auth.books.index') }}" class="btn btn-success d-inline-flex"><i class="bi bi-arrow-left me-2"></i>
            Cancel</a>
    </div>

    <div class="col-lg-8">
        <form method="POST" action="{{ route('auth.books.index') }}" class="mb-5" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" required autofocus value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    required value="{{ old('slug') }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select id="category" class="form-select @error('category_id') is-invalid @enderror" name="category_id"
                    required>
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <ul id="genre" class="list-group @error('genre_id') is-invalid @enderror">
                </ul>
                @error('genre_id')
                    <div class="invalid-feedback">The genre field is required</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control @error('author') is-invalid @enderror" id="author"
                    name="author" required value="{{ old('author') }}">
                @error('author')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                    name="price" required value="{{ old('price') }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="text" class="form-control @error('stock') is-invalid @enderror" id="stock"
                    name="stock" required value="{{ old('stock') }}">
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Book Image</label>
                <img class="img-preview img-fluid mb-3 col-sm-5">
                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                    name="image" onchange="previewImage()">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="synopsis" class="form-label">Synopsis</label>
                @error('synopsis')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input id="synopsis" type="hidden" name="synopsis" value="{{ old('synopsis') }}">
                <trix-editor input="synopsis"></trix-editor>
            </div>

            <button type="submit" class="btn btn-primary">Create Book</button>
        </form>
    </div>
@endsection

@section('js')
    <script>
        const value = "book";
    </script>
    <script src="{{ secure_asset('js/script.js') }}"></script>

    <script>
        const routeGetGenresByCategory = '{{ route('auth.books.getGenresByCategory', ':id') }}';
        let oldGenreId = @json(array_map('intval', old('genre_id', $bookGenres ?? []))); // Use an empty array as default
        const oldCategoryId = "{{ old('category_id') }}";
        console.log(routeGetGenresByCategory.replace(":id", oldCategoryId));
    </script>
    <script src="{{ secure_asset('js/books/script.js') }}"></script>
@endsection
