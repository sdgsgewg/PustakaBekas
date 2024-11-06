<!-- Filter Button -->
<button type="button" class="btn btn-primary d-flex align-items-center justify-content-center" data-bs-toggle="modal"
    data-bs-target="#filterModal">
    <i class="bi bi-funnel me-2"></i> Filter
</button>

<!-- Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Books</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="GET" action="{{ route('books.index') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select id="category" class="form-select @error('category') is-invalid @enderror"
                            name="category">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}"
                                    {{ old('category', request()->category) == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="genre" class="form-label">Genre</label>
                        <ul id="genre" class="list-group @error('genre') is-invalid @enderror">
                        </ul>
                        @error('genre')
                            <div class="invalid-feedback">The genre field is required</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="seller" class="form-label">Seller</label>
                        <select id="seller" class="form-select @error('seller') is-invalid @enderror" name="seller">
                            <option value="">Select a seller</option>
                            @foreach ($sellers as $seller)
                                <option value="{{ $seller->username }}"
                                    {{ old('seller', request()->seller) == $seller->username ? 'selected' : '' }}>
                                    {{ $seller->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('seller')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex flex-row-reverse">
                        <button type="submit" class="btn btn-primary">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
