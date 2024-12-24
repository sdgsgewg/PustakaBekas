@extends('dashboard.layouts.main')

@section('container')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Books</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show col-12 col-lg-10" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive small col-12 col-lg-10">
        <a href="{{ route('auth.books.create') }}" class="btn btn-primary mb-3">Create New Book</a>

        @if ($books->count())
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->category->name }}</td>
                            <td>
                                @foreach ($book->genres as $genre)
                                    <span class="badge text-bg-secondary">{{ $genre->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('auth.books.show', ['book' => $book->slug]) }}" class="badge bg-info">
                                    <i class="bi bi-eye icon"></i>
                                </a>

                                <a href="{{ route('auth.books.edit', ['book' => $book->slug]) }}" class="badge bg-warning">
                                    <i class="bi bi-pencil-square icon"></i>
                                </a>

                                <button type="button" class="badge bg-danger border-0" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal-{{ $book->id }}">
                                    <i class="bi bi-x-circle icon"></i>
                                </button>

                                <div class="modal fade" id="deleteModal-{{ $book->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel-{{ $book->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="deleteModalLabel-{{ $book->id }}">
                                                    Confirm Deletion</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete the book "{{ $book->title }}"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('auth.books.destroy', ['book' => $book->slug]) }}"
                                                    method="POST" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <tbody>
                <tr>
                    <td class="col-lg-8">
                        <p class="text-center">No book found.</p>
                    </td>
                </tr>
            </tbody>
        @endif
    </div>
@endsection


@section('js')
    <script src="{{ secure_asset('js/script.js') }}"></script>
@endsection
