@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex flex-column justify-content-between align-items-start gap-2 pt-3 pb-3 mb-3 border-bottom">
        <h1 class="h2">Edit Book</h1>

        <a href="{{ route('auth.books.index') }}" class="btn btn-success d-inline-flex"><i class="bi bi-arrow-left me-2"></i>
            Cancel</a>
    </div>

    <div class="col-lg-8">
        <form method="POST" action="{{ route('auth.books.update', ['book' => $book->slug]) }}" class="mb-5"
            enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    name="title" required autofocus value="{{ old('title', $book->title) }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    required value="{{ old('slug', $book->slug) }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select id="category" class="form-select @error('category_id') is-invalid @enderror" name="category_id"
                    required>
                    @foreach ($categories as $category)
                        @if (old('category_id', $book->category_id) == $category->id)
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
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
                    name="author" required value="{{ old('author', $book->author) }}">
                @error('author')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                    name="price" required value="{{ old('price', $book->price) }}">
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="text" class="form-control @error('stock') is-invalid @enderror" id="stock"
                    name="stock" required value="{{ old('stock', $book->stock) }}">
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Book Image</label>
                <input type="hidden" name="oldImage" value="{{ $book->image }}">
                @if ($book->image)
                    <img src="{{ secure_asset('storage/' . $book->image) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
                @else
                    <img class="img-preview img-fluid mb-3 col-sm-5">
                @endif
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
                <input id="synopsis" type="hidden" name="synopsis" value="{{ old('synopsis', $book->synopsis) }}">
                <trix-editor input="synopsis"></trix-editor>
            </div>

            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>

    </div>
@endsection

@section('js')
    <script>
        const value = "book";
    </script>
    <script src="{{ secure_asset('js/script.js') }}"></script>

    <script>
        var routeGetGenresByCategory = '{{ route('auth.books.getGenresByCategory', ':id') }}';
        var oldGenreId = @json(array_map('intval', old('genre_id', $bookGenres)));
        var oldCategoryId = "{{ old('category_id', $book->category_id) }}";
    </script>
    <script src="{{ secure_asset('js/books/script.js') }}"></script>
@endsection
